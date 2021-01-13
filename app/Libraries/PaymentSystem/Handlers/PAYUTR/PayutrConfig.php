<?php

namespace App\Libraries\PaymentSystem\Handlers\PAYUTR;

use CodeIgniter\Config\BaseConfig;

class PayutrConfig extends BaseConfig
{

    public $URL           = "https://secure.payu.com.tr/order/alu/v3";
    public $paymentMethod = 'PAYUTR';
    public $use3d         = false;
    public $MERCHANT      = 'OPU_TEST';
    public $SECRET_KEY    = 'SECRET_KEY';
    
//    For 3D Test
//    public $MERCHANT   = 'PALJZXGV';
//    public $SECRET_KEY = 'f*%J7z6_#|5]s7V4[g3]';

}
