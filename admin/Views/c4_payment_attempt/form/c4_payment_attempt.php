<?php

$url = admin_url('c4_payment_attempt/save/c4_payment_attempt');
$hiddenArray = [];

if( !empty($formData['c4_payment_attempt_id']) )
{
    $url .= '/' . $formData['c4_payment_attempt_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_payment_attempt" autocomplete="off" role="presentation" data-pageslug="c4_payment_attempt" data-formslug="c4_payment_attempt"  data-jsname="c4_payment_attempt" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_payment_attempt", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_payment_attempt", '', 'hidden');?> 
<?=form_input("c4_payment_attempt_id", $formData['c4_payment_attempt_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-drumstick-bite"></i> <?=lang('c4_payment_attempt._form_c4_payment_attempt'); ?> </h5>
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

         <div class="form-group" id="groupField_order_ref">
            <label for="order_ref" class="required col-form-label"> <?=lang('c4_payment_attempt.order_ref'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("order_ref", $formData['order_ref'] ?? '', '  id="order_ref" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_checkout_status">
            <label for="checkout_status" class="required col-form-label"> <?=lang('c4_payment_attempt.checkout_status'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("checkout_status", $formData['checkout_status'] ?? '', '  id="checkout_status" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_error_code">
            <label for="error_code" class="permit_empty col-form-label"> <?=lang('c4_payment_attempt.error_code'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("error_code", $formData['error_code'] ?? '', '  id="error_code" class="form-control" permit_empty maxlength="11" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_error_message">
            <label for="error_message" class="permit_empty col-form-label"> <?=lang('c4_payment_attempt.error_message'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("error_message", $formData['error_message'] ?? '', '  id="error_message" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_response_id">
            <label for="response_id" class="permit_empty col-form-label"> <?=lang('c4_payment_attempt.response_id'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("response_id", $formData['response_id'] ?? '', '  id="response_id" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_response_status">
            <label for="response_status" class="permit_empty col-form-label"> <?=lang('c4_payment_attempt.response_status'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("response_status", $formData['response_status'] ?? '', '  id="response_status" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_response_data">
            <label for="response_data" class="permit_empty col-form-label"> <?=lang('c4_payment_attempt.response_data'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"response_data", 'rows' => '3'], $formData['response_data'] ?? '', ' id="response_data" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
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