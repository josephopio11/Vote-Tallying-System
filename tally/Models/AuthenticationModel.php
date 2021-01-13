<?php
namespace Tally\Models;

use CodeIgniter\Model;

class AuthenticationModel extends Model {

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ["user_id","company_id","firstname","lastname","email","phone","password","avatar","identityNumber","status","created_at","updated_at","deleted_at"];
    protected $useTimestamps = true;
    protected $length = 30 * DAY; //rememberme lenght

    //--------------------------------------------------------------------

    public function getToken($remember_token, $whoisID) 
    {
        return $this->db->table('c4_auth_token')
                        ->where(['token' => $remember_token, 'table' => $this->table, 'whoisID' => $whoisID, 'expires >' => date('Y-m-d')])
                        ->get()->getRowArray();
    }

    //--------------------------------------------------------------------

    public function deleteToken($id) 
    {
        return $this->db->table('c4_auth_token')->delete($id);
    }

    //--------------------------------------------------------------------

    public function saveToken($whoisID, $token) 
    {
        $data = [
            'whoisID' => $whoisID,
            'token' => $token,
            'expires' => date('Y-m-d H:i:s', time() + $this->length),
            'table' => $this->table, 
            'userAgent' => (string) \Config\Services::request()->getUserAgent(),
            'ip_address' => \Config\Services::request()->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('c4_auth_token')->insert($data);
    }

    //--------------------------------------------------------------------

    public function saveAttempt($email, $whoisID, bool $success = false, $message = '', $type = 'login') 
    {
        $data = [
            'email' => $email,
            'whoisID' => $whoisID,
            'success' => $success,
            'attemp_type' => $type,
            'message' => $message,
            'userAgent' => (string) \Config\Services::request()->getUserAgent(),
            'ip_address' => \Config\Services::request()->getIPAddress(),
            'table' => $this->table, 
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->table('c4_auth_attempt')->insert($data);
    }
    
    //--------------------------------------------------------------------

    public function countLoginAttempt($email) 
    {
        return $this->db->table('c4_auth_attempt')
                ->where('email', $email)
                ->where('attemp_type', $this->table . '_login')
                ->where('created_at >', date('Y-m-d H:i:s', time() - (1 * MINUTE)))
                ->countAllResults();
    }

    //--------------------------------------------------------------------

    public function countForgotPasswordAttempt($email) 
    {
        return $this->db->table('c4_auth_attempt')
                ->where('email', $email)
                ->where('attemp_type', 'forgotPassword')
                ->where('created_at >', date('Y-m-d H:i:s', time() - (1 * MINUTE)))
                ->countAllResults();
    }

    //--------------------------------------------------------------------

    public function saveLoginAttempt($email, $whoisID, bool $success = false, $message = '') 
    {
        return $this->saveAttempt($email, $whoisID, $success, $message, $this->table . '_login');
    }

    //--------------------------------------------------------------------

    public function getAuthCode($code, $whoisID, $used = true) 
    {
        $codeData = $this->db->table('c4_auth_code')
                        ->where(['code' => $code, 'table' => $this->table, 'whoisID' => $whoisID, 'expires >' => date('Y-m-d H:i:s'), 'is_used' => '0'])
                        ->get()->getRowArray();

        if (!empty($codeData) && $used === true) {

            $this->db->table('c4_auth_code')->where('c4_auth_code_id ', $codeData['c4_auth_code_id'])->update([
                'is_used' => '1',
                'used_at' => date('Y-m-d H:i:s'),
                'used_ip' => \Config\Services::request()->getIPAddress(),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return $codeData;
    }

    //--------------------------------------------------------------------

    public function saveAuthCode($code, $whoisID) 
    {
        $data = [
            'whoisID' => $whoisID,
            'code' => $code,
            'expires' => date('Y-m-d H:i:s', time() + $this->length),
            'userAgent' => (string) \Config\Services::request()->getUserAgent(),
            'ip_address' => \Config\Services::request()->getIPAddress(),
            'table' => $this->table, 
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('c4_auth_code')->insert($data);
    }

    //--------------------------------------------------------------------

    public function deleteExperidData() 
    {
        //%20 percentage to delete experidData 
        if (rand(1, 100) < 21) 
        {
            $this->db->table('c4_auth_token')->where('expires <', date('Y-m-d H:i:s'))->delete();
            $this->db->table('c4_auth_code')->where('expires <', date('Y-m-d H:i:s'))->delete();
            $this->db->table('c4_auth_attempt')->where('created_at <', date('Y-m-d H:i:s', time() - $this->length))->delete();
        }
    }

    //--------------------------------------------------------------------
    
    public function getCompany($company_id) 
    {
        $builder = $this->db->table('company');
        $builder->where('company_id', $company_id);
        $builder->where('status', 1);
        $builder->where('deleted_at', NULL);
        
        return $builder->get()->getRowArray();
    }
}
