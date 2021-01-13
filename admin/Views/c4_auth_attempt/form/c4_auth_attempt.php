<?php

$url = admin_url('c4_auth_attempt/save/c4_auth_attempt');
$hiddenArray = [];

if( !empty($formData['c4_auth_attempt_id']) )
{
    $url .= '/' . $formData['c4_auth_attempt_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_auth_attempt" autocomplete="off" role="presentation" data-pageslug="authentication_attempt" data-formslug="c4_auth_attempt"  data-jsname="authentication_attempt" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_auth_attempt", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "authentication_attempt", '', 'hidden');?> 
<?=form_input("c4_auth_attempt_id", $formData['c4_auth_attempt_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fab fa-autoprefixer"></i> <?=lang('c4_auth_attempt._form_c4_auth_attempt'); ?> </h5>
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

         <div class="form-group" id="groupField_ip_address">
            <label for="ip_address" class="required col-form-label"> <?=lang('c4_auth_attempt.ip_address'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("ip_address", $formData['ip_address'] ?? '', '  id="ip_address" class="form-control" required maxlength="96" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_email">
            <label for="email" class="required col-form-label"> <?=lang('c4_auth_attempt.email'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("email", $formData['email'] ?? '', ' id="email" class="form-control" required maxlength="128" ', 'email'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_table">
            <label for="table" class="required col-form-label"> <?=lang('c4_auth_attempt.table'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("table", $formData['table'] ?? '', '  id="table" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_whoisID">
            <label for="whoisID" class="required col-form-label"> <?=lang('c4_auth_attempt.whoisID'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("whoisID", $formData['whoisID'] ?? '', '  id="whoisID" class="form-control" required maxlength="20" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_attemp_type">
            <label for="attemp_type" class="required col-form-label"> <?=lang('c4_auth_attempt.attemp_type'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("attemp_type", $formData['attemp_type'] ?? '', '  id="attemp_type" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_success">
            <label for="success" class="required col-form-label"> <?=lang('c4_auth_attempt.success'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_auth_attempt.list_success');
                    $p_array = isset($formData['success']) ? explode(',', $formData['success']) : [];
                        
                    if(!isset($formData['success'])){
                        $p_array = ['0'];
                    }
                ?>
                <div class="">
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="success0">
                        <?=form_radio("success", '0', in_array('0', $p_array), 'id="success0"  class="form-check-input" ');?>
                        <label class="form-check-label" for="success0"><?=$lang_options['0'];?></label>
                    </div>
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="success1">
                        <?=form_radio("success", '1', in_array('1', $p_array), 'id="success1"  class="form-check-input" ');?>
                        <label class="form-check-label" for="success1"><?=$lang_options['1'];?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_message">
            <label for="message" class="required col-form-label"> <?=lang('c4_auth_attempt.message'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("message", $formData['message'] ?? '', '  id="message" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_userAgent">
            <label for="userAgent" class="required col-form-label"> <?=lang('c4_auth_attempt.userAgent'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("userAgent", $formData['userAgent'] ?? '', '  id="userAgent" class="form-control" required maxlength="255" ', 'text'); 
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