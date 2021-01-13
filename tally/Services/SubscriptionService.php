<?php
/**
 * Subscription Service
 * 
 *  
 * subscription_status : 'in_trial','trial_expired','in_subscribe','subscribe_expired'
 */

namespace Tally\Services;

use CodeIgniter\Config\BaseService;
use Tally\Models\SubscriptionModel;
use Tally\Config\SubscriptionConfig;

class SubscriptionService extends BaseService
{

    protected $c4_subscription_id;
    protected $company_id;
    protected $errorCode;
    protected $errorString;

    //--------------------------------------------------------------------

    public function __construct()
    {
        $this->session = session();

        $this->company_id = $_SESSION['company_id'];
    }

    //--------------------------------------------------------------------

    /**
     * Check subscription_status in session
     * This method called from Authication Filter each on each view.
     */

    public function isSubscriber(): bool
    {
        return $this->getStatus() === 'in_subscribe';
    }

    //--------------------------------------------------------------------
    
    public function hasPermission(): bool
    {
        return in_array($this->getStatus(), ['in_trial', 'in_subscribe']);
    }
    
    //--------------------------------------------------------------------
    
    public function check(): bool
    {

        if (empty($this->company_id))
        {
            log_message('alert', 'SUBSCRIPTION: There is no company_id');
            $this->setError('system_error');
            return false;
        }

        $subscriptionModel = new SubscriptionModel();

        $subscriptionData = $subscriptionModel->where(['company_id' => $this->company_id])->first();

        if (empty($subscriptionData))
        {
            $subscriptionData = $this->startTrail();
            log_message('notice', 'SUBSCRIPTION: New Subscription Started company_id: ' . $this->company_id);
        }
        
        $this->c4_subscription_id     = $subscriptionData['c4_subscription_id'];
        $subscription_status = $subscriptionData['subscription_status'];
        $due_date            = $subscriptionData['due_date'];
        
        $this->session->set('tallyDueDate', $due_date);
        $this->session->set('tallyStatus', $subscription_status);

        if ($subscription_status === 'in_trial')
        {
            if ($due_date < date('Y-m-d'))
            {
                //Change status in_trial to trial_expired
                $this->updateStatus('trial_expired');
            }
        }
        elseif ($subscription_status === 'in_subscribe')
        {
            if ($due_date < date('Y-m-d'))
            {
                //Change status in_subscribe to subscribe_expired
                $this->updateStatus('subscribe_expired');
            }         
        }        

        return $this->hasPermission();
    }

    //--------------------------------------------------------------------

    public function updateStatus($subscriptionStatus, $duration = null): bool
    {
        if (!in_array($subscriptionStatus, ['in_trial', 'trial_expired', 'in_subscribe', 'subscribe_expired']))
        {
            log_message('alert', 'SUBSCRIPTION: not_allowed_status :' . $subscriptionStatus);
            return $this->setError('not_allowed_status');
        }

        $ubdateData['subscription_status'] = $subscriptionStatus;

        if ($subscriptionStatus === 'in_trial' && empty($duration))
        {
            $subscriptionConfig = new SubscriptionConfig();
            $duration           = $subscriptionConfig->trail_period;
        }

        if (!empty($duration))
        {
            $due_date = $this->getDueDate();

            if ($due_date < date('Y-m-d'))
            {
                //Start calcultaion from now
                $newDueDate = date('Y-m-d', strtotime("+{$duration}"));
            }
            else
            {
                //Start calcultaion from $due_date
                $newDueDate = date('Y-m-d', strtotime("$due_date +{$duration}"));
            }

            if ($subscriptionStatus === 'in_trial')
            {
                $ubdateData['trial_end_date'] = $newDueDate;
            }
            elseif ($subscriptionStatus === 'in_subscribe')
            {
                $ubdateData['subscription_end_date'] = $newDueDate;
            }

            $ubdateData['due_date'] = $newDueDate;
            
            $this->session->set('tallyDueDate', $newDueDate);
        }

        $ubdateData['company_id'] = $this->company_id;
        $ubdateData['c4_subscription_id'] = $this->c4_subscription_id;

        $subscriptionModel = new SubscriptionModel();

        if (!empty($this->c4_subscription_id))
        {
            $subscriptionModel->update($this->c4_subscription_id, $ubdateData);
        }
        else
        {
            $subscriptionModel->where('company_id', $this->company_id);
            $subscriptionModel->set($ubdateData);
            $subscriptionModel->update();
        }

        log_message('info', 'SUBSCRIPTION: subscription status changed  ' . $subscriptionStatus);

        $this->session->set('tallyStatus', $subscriptionStatus);

        return true;
    }

    //--------------------------------------------------------------------

    public function getStatus()
    {
        if (!$this->session->has('tallyStatus'))
        {
            $this->check();
        }

        return $this->session->get('tallyStatus');
    }

    //--------------------------------------------------------------------
    
    public function getDueDate()
    {
        if (!$this->session->has('tallyDueDate'))
        {
            $this->check();
        }

        return $this->session->get('tallyDueDate');
    }

    //--------------------------------------------------------------------

    private function startTrail()
    {
        $subscriptionConfig = new SubscriptionConfig();
        $trail_period = $subscriptionConfig->trail_period;
        $due_date = date('Y-m-d', strtotime("+{$trail_period}"));

        $subscriptionData['company_id']          = $this->company_id;
        $subscriptionData['subscription_status'] = 'in_trial';
        $subscriptionData['due_date']            = $due_date;
        $subscriptionData['trail_start_date']    = date('Y-m-d');
        $subscriptionData['trial_end_date']      = $due_date;
        $subscriptionData['plan_duration']       = $trail_period;

        $subscriptionModel = new SubscriptionModel();
        $subscriptionModel->save($subscriptionData);

        $subscriptionData['c4_subscription_id'] = $subscriptionModel->getInsertID();

        $this->session->set('tallyDueDate', $due_date);
        $this->session->set('tallyStatus', 'in_trial');
        $this->c4_subscription_id = $subscriptionData['c4_subscription_id'];

        return $subscriptionData;
    }

    //--------------------------------------------------------------------

    private function setError($error_code) : bool
    {
        $errorList['system_error'] = 'System Error. There is no company_id';
        $errorList['not_allowed_status'] = 'Subscription Status is not in allowed list';
        $errorList['trial_expired']     = 'Your Trail Time Ended';
        $errorList['subscribe_expired'] = 'Your Subscription Time Ended';

        $this->errorCode   = $error_code;
        $this->errorString = $errorList[$error_code] ?? 'You Have No Permission';
        
        return false;
    }

    //--------------------------------------------------------------------

    public function getErrorString()
    {
        return $this->errorString;
    }

    //--------------------------------------------------------------------

    public function getRemainigDay()
    {
        $due_date = $this->getDueDate();
        $datediff = strtotime($due_date) - strtotime(date('Y-m-d'));

        return round($datediff / (60 * 60 * 24));
    }
    
    //--------------------------------------------------------------------

    /**
     * 
     * in_trial, trial_expired, in_subscribe, subscribe_expired
     * @return string
     */
    public function getRemainingString()
    {
        $subscriptionStatus = $this->getStatus();
        $remainigDay        = $this->getRemainigDay();

        if ($subscriptionStatus === 'in_trial')
        {
            return lang('subscribe.in_trial', [$remainigDay]);
        }
        elseif ($subscriptionStatus === 'trial_expired')
        {
            return lang('subscribe.trial_expired');
        }
        elseif ($subscriptionStatus === 'in_subscribe')
        {
            return lang('subscribe.in_subscribe', [$remainigDay]);
        }
        elseif ($subscriptionStatus === 'subscribe_expired')
        {
            return lang('subscribe.subscribe_expired');
        }
    }

    //--------------------------------------------------------------------

    public function getPage()
    {
        return tally_url('subscription/index');
    }

    //--------------------------------------------------------------------
}
