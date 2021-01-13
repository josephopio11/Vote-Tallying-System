<?php
/**
 * Basic Authication Service
 * 
 *   * 
 */

namespace Agents\Services;

use CodeIgniter\Config\BaseService;
use Agents\Models\AuthenticationModel;

class AuthenticationService extends BaseService
{

    protected $memberData;
    protected $rememberTime = 30 * DAY;

    //--------------------------------------------------------------------

    public function __construct()
    {
        $this->session = session();
    }

    //--------------------------------------------------------------------

    /**
     * Check Member is Logged
     * Firstly check Session primary key is exist
     * Secondly check user_remember token from cookie and database
     * 
     * @return bool
     * 
     */
    public function isLoggedIn(): bool 
    {
         

        if ($this->session->has('user_id') && is_numeric($this->session->get('user_id')))
        {
            return true;
        }
        
        //Check RememberMe Cookie Data
        helper('cookie');

        $token = get_cookie('user_remember', true);
        $id = get_cookie('user_id', true);

        if (!empty($id) && is_numeric($id) && !empty($token)) 
        {
            $userAgent = (string) \Config\Services::request()->getUserAgent();

            $authModel = new AuthenticationModel();
            $tokenData = $authModel->getToken($token, $id);

            if (!empty($tokenData) && ($userAgent === $tokenData['userAgent']))
            {
                //Delete Old Token New One Will Create on set_login()
                $authModel->deleteToken($tokenData['c4_auth_token_id']);

                return $this->set_login($authModel->find($id), true, 'rememberLogin');
            } 
            else 
            {
                delete_cookie('user_id');
                delete_cookie('user_remember');
            }
        }

        return FALSE;
    }

    //--------------------------------------------------------------------
    /**
     *
     * Set login with data
     *
     * @param type $data
     * @param type $remember
     * @param type $message
     * @return bool
     *
     */
    public function set_login($memberData, $remember = false, $message = ''): bool
    {
        if (empty($memberData) || !isset($memberData['user_id']))
        {
            return false;
        }

        $authModel = new AuthenticationModel();

        $id = $memberData['user_id'] ?? null;
        $email = $memberData['email'] ?? null;

        // =========== set session ===========
        
        $this->session->set('user_id', $id);
        $this->session->set('user_firstname', $memberData['firstname'] ?? null);
        $this->session->set('user_lastname', $memberData['lastname'] ?? null);
        $this->session->set('user_email', $email ?? null);
        $authModel->saveLoginAttempt($email, $id, 1, $message);

        if ($remember)
        {
            helper('cookie');

            $token = md5(random_bytes(32)) . ':' . md5(random_bytes(32));

            set_cookie('user_id', $id, $this->rememberTime);
            set_cookie('user_remember', $token, $this->rememberTime);

            $authModel->saveToken($id, $token);
        }

        return true;
    }

    //--------------------------------------------------------------------

    public function logout(): bool 
    {
        $this->session->remove('user_id');
        $this->session->remove('user_firstname');
        $this->session->remove('user_lastname');
        $this->session->remove('user_email');

        //delete Cookies
        helper('cookie');

        set_cookie('user_id', '', -3600);
        set_cookie("user_remember", '', -3600);

        return true;
    }

    //--------------------------------------------------------------------
    
    public function getId()
    {
        return $this->session->get('user_id');
    }

    //--------------------------------------------------------------------

    public function getFirstName()
    {
        return $this->session->get('user_firstname');
    }
    
    //--------------------------------------------------------------------
    
    public function getLastName()
    {
        return $this->session->get('user_lastname');
    }
    
    //--------------------------------------------------------------------
    
    public function getFullName()
    {
        return $this->session->get('user_firstname') . ' ' . $this->session->get('user_lastname');
    }

    //--------------------------------------------------------------------
    
    public function getEmail()
    {
        return $this->session->get('user_email');
    }

    

    //--------------------------------------------------------------------

    public function getMemberData()
    {
        if (!empty($this->memberData))
        {
            return $this->memberData;
        }

        $authModel = new AuthenticationModel();

        return $this->memberData = $authModel->find($this->getId());
    }

    //--------------------------------------------------------------------

    public function getAllData()
    {

        helper(['Agents\\c4_country', 'Agents\\c4_zone']);

        $return = [
            'id'             => $this->getId(),
            'name'           => $this->getFirstName(),
            'surname'        => $this->getLastName(),
            'fullName'       => $this->getFullName(),
            'email'          => $this->getEmail(),
        ];

        $memberData = $this->getMemberData();

        $return['country_id'] = 215; // Default Country Turkey
        if (isset($memberData['country_id']) && !empty($memberData['country_id']))
        {
            $return['country_id'] = $memberData['country_id'];
        }

        $countryData = getC4_country($return['country_id']);
        $return['country_code'] = $countryData['iso_code_2'] ?? 'TR';
        $return['country_name'] = $countryData['name'] ?? 'Turkey';
        unset($countryData);

        $return['zone_id'] = 3354; // Default Zone Istanbul
        if (isset($memberData['zone_id']) && !empty($memberData['zone_id']))
        {
            $return['zone_id'] = $memberData['zone_id'];
        }

        $zoneData    = getC4_zone($return['zone_id']);
        $return['city_name'] = $zoneData['name'] ?? 'Istanbul';
        $return['city_code'] = $zoneData['name'] ?? 'IST';
        unset($zoneData);

        $return['address'] = 'No Address Data'; // Default
        if (isset($memberData['address']) && !empty($memberData['address']))
        {
            $return['address'] = $memberData['address'];
        }

        $return['phone'] = '900000000000'; // Default
        if (isset($memberData['phone']) && !empty($memberData['phone']))
        {
            $return['phone'] = $memberData['phone'];
        }

        $return['identityNumber'] = '11111111111'; // Default
        if (isset($memberData['identityNumber']) && !empty($memberData['identityNumber']))
        {
            $return['identityNumber'] = $memberData['identityNumber'];
        }

        $return['zipcode'] = '11111'; // Default
        if (isset($memberData['zipcode']) && !empty($memberData['zipcode']))
        {
            $return['zipcode'] = $memberData['zipcode'];
        }

        return $return;
    }

}