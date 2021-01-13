<?php
namespace Agents\Config;

use CodeIgniter\Config\BaseConfig;

class ReCaptchaConfig extends BaseConfig {

    public $enable = false;
    public $reCaptchaSiteKey = '';
    public $reCaptchaSecretKey  = '';
    public $reCaptchaUrl      = 'https://www.google.com/recaptcha/api/siteverify';

}
