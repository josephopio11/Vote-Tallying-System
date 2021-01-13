<?php
$url         = tally_url('subscription/save/subscribe');
$hiddenArray = [];

$form_attr = 'id="cardform" autocomplete="off" role="presentation" data-pageslug="cardform" data-formslug="cardform" data-modalsize="lg" data-packagelist="selectpicker,popover"';
$locale = service('request')->getLocale();

$subscriptionConfig = new \Tally\Config\SubscriptionConfig();
$plans              = $subscriptionConfig->plans_data;

$id  =  isset($id) && is_numeric($id) ? $id : NULL;

if (empty($id))
{
    echo 'plan_id not found';
    return;
}

if (!isset($plans[$id]))
{
    echo "$id ID not found";
    return;
}

$plan = $plans[$id];

echo form_open($url, $form_attr, $hiddenArray);
echo form_input("_formSlug", $formData['_formSlug'] ?? "subscribe", '', 'hidden');

echo form_input("plan_id", $id, '', 'hidden'); //important
echo form_input("unit_price", $plan['unit_price'], '', 'hidden');
echo form_input("currency", $plan['currency'], '', 'hidden');
echo form_input("duration", $plan['duration'], '', 'hidden');

$amount = $plan['unit_price'] * (($plan['vat_rate'] + 100) / 100);
?>
<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fab fa-amazon-pay"></i> <?= $plan['name']; ?> </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">


    <div class="alert alert-danger alert-dismissible formAlert d-none" role="alert" >
        <div class=""><span class="sr-only">Errors...</span></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
   
    
<div class="form-row">

    <div class="form-group col-sm-4">
    </div>
    <div class="form-group col-sm-8">
        <h5> <?=$plan['name']; ?> </h5>
        <h5><span class="" data-moneyarea="true"><?=$amount; ?> <?= $plan['currency']; ?></span></h5>
    </div>

</div>

<div class="form-row">

    <label for="card_number" class="required form-group col-sm-4 col-form-label">
        <i class="fa fa-credit-card"></i> <?= lang('home.card_number'); ?>    
    </label>

    <div class="form-group col-sm-4">
        <div class="input-group">                               
            <?php echo form_input("card_number", $formData['card_number'] ?? '', ' required id="card_number" class="form-control" maxlength="20"  placeholder="_ _ _ _   _ _ _ _   _ _ _ _   _ _ _ _" autocomplete="off" pattern="[0-9 ]+"', 'text');?>
        </div>
    </div>
</div>
    

<div class="form-row">

    <label for="card_name" class="required form-group col-sm-4 col-form-label">
        <i class="fas fa-user-shield"></i> <?= lang('home.card_name'); ?>
    </label>
    
    <div class="form-group col-sm-4">

        <div class="input-group">       
            <?php echo form_input("card_name", $formData['card_name'] ?? '', ' required id="card_name" class="form-control" maxlength="50" ', 'text');?>
        </div>

    </div>
</div>

<div class="form-row">


    <label for="card_exp_month" class="required form-group col-sm-4 col-form-label">
        <i class="far fa-calendar-alt"></i> <?php echo lang('home.card_exp_date'); ?>   </label>

        <div class="form-group col-sm-2">

            <div class="input-group">                       
                <?php                $months = [
                ''   => lang('home.month'),
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12'
                ];

                echo form_dropdown('card_exp_month', $months, '', ' required id="card_exp_month" class="form-control"');
                ?>
            </div>

        </div>

    <div class="form-group col-sm-2">

        <div class="input-group">

             <?php                        $years = ['' => lang('home.year')];

                        $i = date('Y');
                        $f = $i + 15;

                        for ($year = $i; $year <= $f; $year++)
                        {
                            $years[$year] = $year;
                        }

                        echo form_dropdown('card_exp_year', $years, '', ' required id="card_exp_year" class="form-control"');
                        ?>

        </div>
    </div>
</div>


<div class="form-row">


    <label for="card_cvv" class="required form-group col-sm-4 col-form-label">
        <i class="fas fa-key"></i> <?php echo lang('home.card_cvv'); ?>  </label>


    <div class="form-group col-sm-2">
        <div class="input-group">
            
            <?php echo form_input("card_cvv", $formData['card_cvv'] ?? '', ' required  id="card_cvv" class="form-control" autocomplete="off" pattern="\d*" maxlength="4" size="4" ', 'number');?>
 
            <div class="input-group-append d-flex align-items-center">

                <i class="far fa-question-circle ml-1" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<img src='<?=resources_url();?>images/CVV.png'></img>" data-original-title="" title=""></i>

            </div>

        </div>
    </div>

</div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('home.dismiss'); ?></button>
    <button type="submit" class="btn btn-primary"><?= lang('home.save'); ?></button>
</div>

<?php echo form_close(); ?>

