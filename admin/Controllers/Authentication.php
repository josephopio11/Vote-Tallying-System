<?php
namespace Admin\Controllers; 

use CodeIgniter\API\ResponseTrait;
use Admin\Models\AuthenticationModel;
use Admin\Controllers\BaseController;

class Authentication extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper('Admin\email');
    }

    //--------------------------------------------------------------------
    /**
     * Show Login Page
     * 
     */
    public function index() 
    {
        $this->_render('login');
    }

    //--------------------------------------------------------------------
    /**
     * Display Login Page or login action 
     * 
     */
    public function login() 
    {
    
        $authConfig = new \Admin\Config\Authentication();
               
        // show login page if there is no request
        if (!$this->request->isAJAX()) 
        {
            if ($authConfig->disableLogin)
            {
                $this->_render('loginDisabled');
            }
            else
            {
                $this->_render('login');
            }
            return;
        }

        if ($authConfig->disableLogin)
        {
            return $this->fail(['error' => $authConfig->disableLoginReason], 401, lang('auth.error_validation_form'));
        }

        if (!$this->validate([
                    'email' => ['label' => lang('auth.email'), 'rules' => "required|valid_email"],
                    'password' => ['label' => lang('auth.password'), 'rules' => "required|min_length[6]|max_length[16]"],
                ])) {
            return $this->fail($this->validator->getErrors(), 400, lang('home.error_validation_form'));
        }

        
        $authService = \Admin\Config\Services::auth();
        $authenticationModel   = new AuthenticationModel();

        $email = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        $password = $this->request->getPost('password');
        $goBack = $this->request->getPost('goBack');
        $remember = $this->request->getPost('rememberMe', FILTER_SANITIZE_NUMBER_INT);
                
        //Count Login attempts in 1 minute
        $countMinuteAttempt = $authenticationModel->countLoginAttempt($email);
        
        if($countMinuteAttempt >= 5)
        {
            return $this->fail(lang('auth.errorWaitForNewRequest'), 400, lang('auth.errorWaitForNewRequest'));
        }

        //Find Member By Email
        $memberData = $authenticationModel->where('email', $email)->first();
        if (empty($memberData)) 
        {
            $authenticationModel->saveLoginAttempt($email, 0, 0, 'errorPasswordNotMatch');
            return $this->fail(['error' => lang('auth.errorMailNotFound')], 401, lang('auth.errorMailNotFound'));
        }

        $id = $memberData['admin_id'];

        //Check Password Hash
        if (password_verify($password, $memberData['password']) === false) 
        {
            $authenticationModel->saveLoginAttempt($email, $id, 0, 'errorPasswordNotMatch');
            return $this->fail(['error' => lang('auth.errorPasswordNotMatch')], 401, lang('auth.errorPasswordNotMatch'));
        }

        //check Status
        if (intval($memberData['status']) != 1)
        {
            $authenticationModel->saveLoginAttempt($email, $id, 0, 'errorAccountOnHold');
            return $this->fail(['error' => lang('auth.errorAccountOnHold')], 401, lang('auth.errorAccountOnHold'));
        }
        

        // Delete Experid Data
        $authenticationModel->deleteExperidData();
        
        // Set admin  as Logined
        if ($authService->set_login($memberData, intval($remember), 'std'))
        {

            $goBack = empty($goBack) ? admin_url('home/index') : site_url($goBack);

            return $this->respond(['redirectURL' => $goBack, 'messages' => [lang('auth.welcome')]], 202);
        }
    }

    
    //--------------------------------------------------------------------
    
    public function register()
    {

        $authConfig = new \Admin\Config\Authentication();
        $authService = \Admin\Config\Services::auth();

        if ($authService->isLoggedIn())
        {
            $authService->logout();
            //return $this->fail(['error' => 'Logout First!'], 400, lang('home.error_validation_form'));
        }

        // show the register page
        if (!$this->request->isAJAX())
        {
            if ($authConfig->disableRegister)
            {
                $this->_render('registerDisabled');
            }
            else
            {
                $this->_render('register');
            }
            return;
           
        }

        if ($authConfig->disableRegister)
        {
            return $this->fail(['error' => $authConfig->disableRegisterReason], 401, lang('auth.error_validation_form'));
        }

        if (!$this->validate([
                    'firstname'  => ['label' => lang('auth.firstname'), 'rules' => "required|alpha_space_turkish"],
                    'lastname'   => ['label' => lang('auth.lastname'), 'rules' => "required|alpha_turkish"],
                    'c4_country_id' => ['country_id' => lang('auth.country'), 'rules' => "required|is_natural_no_zero"],
                    'c4_zone_id'    => ['zone_id' => lang('auth.zone'), 'rules' => "required|is_natural_no_zero"],
                    'email'      => ['label' => lang('auth.email'), 'rules' => "required|valid_email|is_unique[admin.email]"],
                    'phone'      => ['label' => lang('auth.phone'), 'rules' => "required|numeric|min_length[10]|max_length[17]"]
                ]))
        {
            return $this->fail($this->validator->getErrors(), 400, lang('home.error_validation_form'));
        }

        
        $email      = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        $firstname  = $this->request->getPost('firstname', FILTER_SANITIZE_STRING);
        $lastname   = $this->request->getPost('lastname', FILTER_SANITIZE_STRING);
        $country_id = $this->request->getPost('c4_country_id', FILTER_SANITIZE_NUMBER_INT);
        $zone_id    = $this->request->getPost('c4_zone_id', FILTER_SANITIZE_NUMBER_INT);
        $phone      = $this->request->getPost('phone', FILTER_SANITIZE_NUMBER_INT);
        $password   = bin2hex(random_bytes(3)); //Generate Random Password


        $authenticationModel    = new AuthenticationModel();
        
        $memberData['firstname']  = $firstname;
        $memberData['lastname']   = $lastname;
        $memberData['email']      = $email;
        $memberData['phone']      = $phone;
        $memberData['password']   = password_hash($password, PASSWORD_DEFAULT);
        $memberData['status']     = $authConfig->newUserStatus;
        
        
        //$memberData['country_id'] = $country_id;
        //$memberData['zone_id']    = $zone_id;

        $authenticationModel->save($memberData);

        $renderData = [
            'FIRSTNAME' => $memberData['firstname'],
            'LASTNAME'  => $memberData['lastname'],
            'PASSWORD'  => $password,
            'LINK'      => admin_url('auth/login'),
        ];

        sendEmailTemplate('mailNewRegister', $email, $renderData);
        
        return $this->respond(['redirectURL' => admin_url('auth/login'), 'waitTime' => 5000, 'messages' => [lang('auth.yourPasswordWillSent')]], 202);

    }
    //--------------------------------------------------------------------
    /**
     * Display forgot
     */
    public function forgot() 
    {
        helper('email');
         
        // show the login page
        if (!$this->request->isAJAX()) 
        {
            helper('form');
            $this->_render('forgot');
            return;
        }

        // Validate Forgot Email
        if (!$this->validate([
                    'email' => ['label' => lang('auth.email'), 'rules' => "required|valid_email"],
                ])) {
            return $this->fail($this->validator->getErrors(), 400, lang('home.error_validation_form'));
        }
        
        $authenticationModel = new AuthenticationModel();
        
        $email = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);

        //Count Forgot Email Sended in 1 minute
        $countForgotMinuteAttempt = $authenticationModel->countForgotPasswordAttempt($email);

        if($countForgotMinuteAttempt > 0)
        {
            return $this->fail(lang('auth.errorWaitForNewRequest'), 400, lang('auth.errorWaitForNewRequest'));
        }

        //Find member data
        $memberData = $authenticationModel->where('email', $email)->first();
        if (empty($memberData)) 
        {
            $authenticationModel->saveAttempt($email, '', 0, 'errorMailNotFound', 'forgotPassword');
            return $this->fail(['error' => lang('auth.errorMailNotFound')], 401, lang('auth.errorMailNotFound'));
        }

        //check  Status
        if ($memberData['status'] != '1') 
        {
            $authenticationModel->saveAttempt($email, '', 0, 'errorAccountOnHold', 'forgotPassword');
            return $this->fail(['error' => lang('auth.errorAccountOnHold')], 401, lang('auth.errorAccountOnHold'));
        }

        //Create And Save the Code        

        $code = bin2hex(random_bytes(3)); //substr(md5(random_bytes(100)), 0, 6);    
        $authenticationModel->saveAuthCode($code, $memberData['admin_id']);

        $authenticationModel->saveAttempt($email, $memberData['admin_id'], 1, 'resetMailSended', 'forgotPassword');

        //Send Mail Template
        $renderData = [
            'FIRSTNAME' => $memberData['firstname'],
            'LASTNAME' => $memberData['lastname'],
            'CODE' => $code,
            'LINK' => admin_url('auth/resetpassword') . "?code=$code&id=" . $memberData['admin_id']
        ];

        sendEmailTemplate('mailResetPassword', $email, $renderData);

        return $this->respond(['messages' => lang('auth.resetMailSended')]);
    }

    //--------------------------------------------------------------------

    public function logout() 
    {

        $authService = \Admin\Config\Services::auth();
        $authService->logout();

        $this->_render('login', ['messages' => lang('auth.loggedOut')]);
    }

    //--------------------------------------------------------------------

    /**
     * Check code and id and change Password
     * Show ResetPassword status page
     * This page a link sended on email. 
     * 
     */
    public function resetpassword() 
    {

        helper('email');

        $validation = \Config\Services::validation();

        $validation->setRules([
            'code' => ['label' => lang('auth.code'), 'rules' => "required|alpha_numeric"],
            'id'   => ['label' => lang('auth.id'), 'rules' => "required|numeric"],
        ]);

        if ($validation->run($this->request->getGet()) === false)
        {
            $this->_render('resetpassword', ['errors' => $validation->getErrors()]);
            return;
        }

        $authenticationModel = new AuthenticationModel();
        $code = $this->request->getGet('code', FILTER_SANITIZE_STRING);
        $id = $this->request->getGet('id', FILTER_SANITIZE_NUMBER_INT);
 
        // find The Code Data        
        $codeData = $authenticationModel->getAuthCode($code, $id);

        if (empty($codeData)) 
        {
            $authenticationModel->saveAttempt('', $id, 0, "id: $id code $code",  'resetpassword');
            $this->_render('resetpassword', ['errors' => ['expired' => lang('auth.expiredCode')]]);
            return;
        }

        // find Member 
        $memberData = $authenticationModel->find($id);

        $email = $memberData['email'];
        $new_password = bin2hex(random_bytes(3)); //generate new Password

        //Update  Password
        $authenticationModel->update($id, ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);
        
        $authenticationModel->saveAttempt($email, $id, 1, 'resetpassword', "resetpassword");

        //Send Email
        $renderData = [
            'FIRSTNAME' => $memberData['firstname'],
            'LASTNAME' => $memberData['lastname'],
            'PASSWORD' => $new_password,
            'LINK' => admin_url('auth/login'),
        ];

        sendEmailTemplate('mailNewPassword', $email, $renderData);

        $this->_render('resetpassword', ['message' => ['passwordChanged' => lang('auth.passwordChanged')]]);
    } 

    //--------------------------------------------------------------------    

     private function _render($page, $data=[]) 
     {
        helper('form');

        $site_url = site_url();
        
        
        if ($this->request->isAJAX())
        {
            try
            {
                echo admin_view('authentication/' . $page, $data);
            }
            catch (\Exception $e)
            {
                log_message('alert', '[ERROR] {exception}', ['exception' => $e]);
                return $this->fail($e->getMessage(), 400, $e->getMessage());
            }
        }
        else
        {
            try
            {
                echo admin_view('themes/' . $this->theme . '/authencationHeader', $data);
                echo admin_view('authentication/' . $page, $data);
                echo admin_view('themes/' . $this->theme . '/authencationFooter', $data);
            }
            catch (\Exception $e)
            {
                log_message('alert', '[ERROR] {exception}', ['exception' => $e]);
                throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
            }
        }
       
    }

    //--------------------------------------------------------------------
}
