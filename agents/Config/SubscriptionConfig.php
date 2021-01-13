<?php
namespace Agents\Config;

use CodeIgniter\Config\BaseConfig;

class SubscriptionConfig extends BaseConfig
{
    public $trail_period = '1 days';

    public $plans_data = [
        1 => ['plan_id' => 1, 'lang' => 'en', 'duration' => '1 month', 'name' => '1 Mount Subscription', 'unit_price' => 30, 'currency' => 'USD', 'vat_rate' => 0],
        2 => ['plan_id' => 2, 'lang' => 'en', 'duration' => '12 months', 'name' => '1 Year Subscription', 'unit_price' => 300, 'currency' => 'USD', 'vat_rate' => 0],
        3 => ['plan_id' => 3, 'lang' => 'tr', 'duration' => '1 month', 'name' => '1 Ay Üyelik', 'unit_price' => 200, 'currency' => 'TRY', 'vat_rate' => 0],
        4 => ['plan_id' => 4, 'lang' => 'tr', 'duration' => '12 months', 'name' => '1 Yıl Üyelik', 'unit_price' => 2000, 'currency' => 'TRY', 'vat_rate' => 0],
    ];
}
