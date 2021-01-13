<?php

$url = admin_url('c4_subscription/save/c4_subscription');
$hiddenArray = [];

if( !empty($formData['c4_subscription_id']) )
{
    $url .= '/' . $formData['c4_subscription_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_subscription" autocomplete="off" role="presentation" data-pageslug="c4_subscription" data-formslug="c4_subscription"  data-jsname="c4_subscription" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,datepicker" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_subscription", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_subscription", '', 'hidden');?> 
<?=form_input("c4_subscription_id", $formData['c4_subscription_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-compress"></i> <?=lang('c4_subscription._form_c4_subscription'); ?> </h5>
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
        <div class="col">

         <div class="form-group" id="groupField_company_id">
            <label for="company_id" class="required col-form-label"> <?=lang('c4_subscription.company_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['company_id']))
                        {
                            $query_result =  getCompany(['company_id'=>$formData['company_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['company_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("company_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. admin_url('c4_subscription/getAllCompany') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="c4_subscription"
      data-rprimarykey="company_id" data-getrelationurl="c4_subscription/getAllCompany"
      data-rkeyfield="company_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="company_id7084" data-newinputname="new_company_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {company_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_subscription_status">
            <label for="subscription_status" class="required col-form-label"> <?=lang('c4_subscription.subscription_status'); ?></label>
            
            
                <?php 
                    $lang_options = lang('c4_subscription.list_subscription_status');
                    $p_array = isset($formData['subscription_status']) ? explode(',', $formData['subscription_status']) : [];
                        
                    if(!isset($formData['subscription_status'])){
                        $p_array = ['in_trial'];
                    }
                ?>
                <div class="">
                    <div class="form-check form-check-inline mt-2 mb-1" for="subscription_statusin_trial">
                        <?=form_radio("subscription_status", 'in_trial', in_array('in_trial', $p_array), 'id="subscription_statusin_trial"  class="form-check-input" ');?>
                        <label class="form-check-label" for="subscription_statusin_trial"><?=$lang_options['in_trial'] ?? 'in_trial';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="subscription_statustrial_expired">
                        <?=form_radio("subscription_status", 'trial_expired', in_array('trial_expired', $p_array), 'id="subscription_statustrial_expired"  class="form-check-input" ');?>
                        <label class="form-check-label" for="subscription_statustrial_expired"><?=$lang_options['trial_expired'] ?? 'trial_expired';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="subscription_statusin_subscribe">
                        <?=form_radio("subscription_status", 'in_subscribe', in_array('in_subscribe', $p_array), 'id="subscription_statusin_subscribe"  class="form-check-input" ');?>
                        <label class="form-check-label" for="subscription_statusin_subscribe"><?=$lang_options['in_subscribe'] ?? 'in_subscribe';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="subscription_statussubscribe_expired">
                        <?=form_radio("subscription_status", 'subscribe_expired', in_array('subscribe_expired', $p_array), 'id="subscription_statussubscribe_expired"  class="form-check-input" ');?>
                        <label class="form-check-label" for="subscription_statussubscribe_expired"><?=$lang_options['subscribe_expired'] ?? 'subscribe_expired';?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_due_date">
            <label for="due_date" class="required col-form-label"> <?=lang('c4_subscription.due_date'); ?></label>
            
                            <?php 
                    if(!isset($formData['due_date'])){
                        $formData['due_date'] = date('Y-m-d');
                    }
                ?>
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("due_date", $formData['due_date'] ?? '', ' id="due_date" class="form-control datepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_plan_duration">
            <label for="plan_duration" class="required col-form-label"> <?=lang('c4_subscription.plan_duration'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("plan_duration", $formData['plan_duration'] ?? '', '  id="plan_duration" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_trail_start_date">
            <label for="trail_start_date" class="required col-form-label"> <?=lang('c4_subscription.trail_start_date'); ?></label>
            
                            <?php 
                    if(!isset($formData['trail_start_date'])){
                        $formData['trail_start_date'] = date('Y-m-d');
                    }
                ?>
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("trail_start_date", $formData['trail_start_date'] ?? '', ' id="trail_start_date" class="form-control datepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_trial_end_date">
            <label for="trial_end_date" class="required col-form-label"> <?=lang('c4_subscription.trial_end_date'); ?></label>
            
                            <?php 
                    if(!isset($formData['trial_end_date'])){
                        $formData['trial_end_date'] = date('Y-m-d');
                    }
                ?>
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("trial_end_date", $formData['trial_end_date'] ?? '', ' id="trial_end_date" class="form-control datepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_subscription_start_date">
            <label for="subscription_start_date" class="permit_empty col-form-label"> <?=lang('c4_subscription.subscription_start_date'); ?></label>
            
                                <div class="input-group date">
                        
                        <?php
                        echo form_input("subscription_start_date", $formData['subscription_start_date'] ?? '', ' id="subscription_start_date" class="form-control datepicker" permit_empty  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_subscription_end_date">
            <label for="subscription_end_date" class="permit_empty col-form-label"> <?=lang('c4_subscription.subscription_end_date'); ?></label>
            
                                <div class="input-group date">
                        
                        <?php
                        echo form_input("subscription_end_date", $formData['subscription_end_date'] ?? '', ' id="subscription_end_date" class="form-control datepicker" permit_empty  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

















</div>

<div class="modal-footer">
    
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('home.dismiss');?></button>
    <button type="submit" class="btn btn-primary"><?=lang('home.save');?></button>
</div>

<?php echo form_close(); ?>