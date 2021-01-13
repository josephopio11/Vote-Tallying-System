<?php
namespace Voters\Config;

use CodeIgniter\Config\BaseConfig;

class Authentication extends BaseConfig
{

    public $newUserStatus = 1; //1 Active 2 Passive

    public $disableLogin = false;    
    public $disableLoginReason = 'Login disabled for some reason. Please try again later.';
    
    public $disableRegister = false;
    public $disableRegisterReason = 'Register new user disabled. Please try again later.';


}
