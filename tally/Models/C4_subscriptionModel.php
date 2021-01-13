<?php

namespace Tally\Models;

use CodeIgniter\Model;

class C4_subscriptionModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_subscription';
    protected $primaryKey     = 'c4_subscription_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_subscription_id","company_id","subscription_status","due_date","plan_duration","trail_start_date","trial_end_date","subscription_start_date","subscription_end_date","created_at","updated_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = '';
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeDelete   = ['beforeDelete'];
    protected $afterDelete    = ['afterDelete'];
    protected $afterFind      = ['afterFind'];

    //--------------------------------------------------------------------

    /**
     * Return DB fields which ones are allowed
     * @return array
     */
    public function getAllowedFields(): array
    {

        return $this->allowedFields;
    }

    //--------------------------------------------------------------------

    protected function beforeInsert(array $data)
    {
        
        // staticDBField
        $data['data']['company_id'] = $_SESSION['company_id'];
        
        if (function_exists('c4_subscription_beforeInsert'))
        {
            return c4_subscription_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_subscription_afterInsert'))
        {
            c4_subscription_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        // staticDBField
        $data['data']['company_id'] = $_SESSION['company_id'];
        $this->where('company_id', $_SESSION['company_id']);
        
        if (function_exists('c4_subscription_beforeUpdate'))
        {
            return c4_subscription_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_subscription_afterUpdate'))
        {
            c4_subscription_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        // staticDBField
        $this->where('company_id', $_SESSION['company_id']);
        
        if (function_exists('c4_subscription_beforeDelete'))
        {
            return c4_subscription_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_subscription_afterDelete'))
        {
            c4_subscription_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_subscription_afterFind'))
        {
            return c4_subscription_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}