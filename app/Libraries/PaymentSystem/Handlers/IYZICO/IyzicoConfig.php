<?php
namespace App\Libraries\PaymentSystem\Handlers\IYZICO;

use CodeIgniter\Config\BaseConfig;

class IyzicoConfig extends BaseConfig {

    public $URL = 'https://sandbox-api.iyzipay.com';
    public $API_KEY = 'sandbox-WxQyoCCvThUpMlUqRtTPnydMm7t7Nx8g';
    public $SECRET_KEY  = 'sandbox-hdZ4Kv1Xr0q7RoX8iLqblOT6YCf4ZDzE';
    public $paymentMethod  = 'IYZICO';
    public $use3d  = false;

}