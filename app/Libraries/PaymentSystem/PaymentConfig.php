<?php

namespace App\Libraries\PaymentSystem;

use CodeIgniter\Config\BaseConfig;

class PaymentConfig extends BaseConfig
{

    public $handlers        = [
        'PAYUTR' => \App\Libraries\PaymentSystem\Handlers\PAYUTR\Payutr::class,
        'IYZICO' => \App\Libraries\PaymentSystem\Handlers\IYZICO\Iyzico::class,
    ];

    public $defaultMethod   = 'IYZICO';
    public $defaultCurrency = 'USD';

}
