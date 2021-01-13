<?php
//'in_trial', 'trial_ended', 'active', 'end'

$auth   = service('auth');
$locale = service('request')->getLocale();

//echo $auth->getFullName();

$subscriptionService = \Tally\Config\Services::subscription();
$subscriptionStatus  = $subscriptionService->getStatus();

$subscriptionConfig = new \Tally\Config\SubscriptionConfig();
$plans_data  = $subscriptionConfig->plans_data;

?>

<div class="container-fluid">


    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-12">

            <div class="card border-light mb-3">

                <div class="card-body mb-0 pt-0">
                    <h2><?=$subscriptionService->getRemainingString();?></h2>
                    <p><?= lang('subscribe.subscribe_page_desc'); ?></p>

                </div>
            </div>

        </div>
    </div>    

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-12">
            <div class="card-deck">

<?php                if (!empty($plans_data)):

                foreach ($plans_data as $plan_id => $planData):
                
                    if($planData['lang'] != $locale)
                    {
                        continue;
                    }

                    $vat_amount = ($planData['unit_price'] * $planData['vat_rate']) / 100;
                    $amount = $planData['unit_price'] + $vat_amount;

                ?>

                <div class="card">

                    <h5 class="card-header"><?=$planData['name'];?></h5>

                    <div class="card-body">
                        
                        
                        <h3 class="card-title text-center"><?=$amount;?> <?=$planData['currency'];?></h3>
                        <p class="card-text"></p>
                    </div>

                    <!--<ul class="list-group list-group-flush">
                        <li class="list-group-item">Pay as you go</li>
                    </ul>
                    -->
                    
                    
                </div>

<?php                endforeach;

                endif;
                ?>

            </div>
        </div>

    </div>

    <div class="row justify-content-center mt-3">

        <div class="col-lg-8 col-md-12">

            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title"><?= lang('subscribe.pageInfo1Title'); ?></h5>
                    <p class="card-text"><?= lang('subscribe.pageInfo1Desc'); ?></p>
                </div>
            </div>             
        </div>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-12">
            <div class="card-deck">


                <div class="card">

                    <h5 class="card-header">TL </h5>

                    <div class="card-body bg-dark text-white">
                        <p class="card-text">

                            <?=lang('subscribe.receiver_name');?> : Wits Exam                            <br/>
                            BANK: Enpara qnbfinansbank
                            <br/>
                            IBAN: TR98 0011 1000 0000 0045 8152 39
                            <br/>
                            <?=lang('subscribe.description');?>: <?=lang('subscribe.subscription_fee');?>
                            <br/>

                        </p>
                    </div>


                </div>

                <div class="card">

                    <h5 class="card-header">USD </h5>

                    <div class="card-body bg-dark text-white">
                        <p class="card-text">

                            <?=lang('subscribe.receiver_name');?> : Wits Exam                            <br/>
                            BANKA: Enpara qnbfinansbank
                            <br/>
                            IBAN: TR10 0011 1000 0000 0089 8005 03
                            <br/>
                            <?=lang('subscribe.description');?>: <?=lang('subscribe.subscription_fee');?>
                            <br/>

                        </p>
                    </div>
                </div>

                <div class="card">

                    <h5 class="card-header">EUR </h5>

                    <div class="card-body bg-dark text-white">
                        <p class="card-text">

                            <?=lang('subscribe.receiver_name');?> : Wits Exam                            <br/>
                            BANKA: Enpara qnbfinansbank
                            <br/>
                            IBAN: TR73 0011 1000 0000 0092 1495 82
                            <br/>
                            <?=lang('subscribe.description');?>: <?=lang('subscribe.subscription_fee');?>
                            <br/>

                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
