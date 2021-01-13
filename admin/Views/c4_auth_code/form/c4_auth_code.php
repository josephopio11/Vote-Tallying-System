<?php

$url = admin_url('c4_auth_code/save/c4_auth_code');
$hiddenArray = [];

if( !empty($formData['c4_auth_code_id']) )
{
    $url .= '/' . $formData['c4_auth_code_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_auth_code" autocomplete="off" role="presentation" data-pageslug="c4_auth_code" data-formslug="c4_auth_code"  data-jsname="c4_auth_code" data-modalsize="lg" data-packagelist="selectpicker,popover,datetimepicker" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_auth_code", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_auth_code", '', 'hidden');?> 
<?=form_input("c4_auth_code_id", $formData['c4_auth_code_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-qrcode"></i> <?=lang('c4_auth_code._form_c4_auth_code'); ?> </h5>
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

         <div class="form-group" id="groupField_code">
            <label for="code" class="required col-form-label"> <?=lang('c4_auth_code.code'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("code", $formData['code'] ?? '', '  id="code" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_table">
            <label for="table" class="required col-form-label"> <?=lang('c4_auth_code.table'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("table", $formData['table'] ?? '', '  id="table" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_whoisID">
            <label for="whoisID" class="required col-form-label"> <?=lang('c4_auth_code.whoisID'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("whoisID", $formData['whoisID'] ?? '', '  id="whoisID" class="form-control" required maxlength="11" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_expires">
            <label for="expires" class="required col-form-label"> <?=lang('c4_auth_code.expires'); ?></label>
            
            
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("expires", $formData['expires'] ?? '', ' id="expires" class="form-control datetimepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_is_used">
            <label for="is_used" class="required col-form-label"> <?=lang('c4_auth_code.is_used'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_auth_code.list_is_used');
                    $p_array = isset($formData['is_used']) ? explode(',', $formData['is_used']) : [];
                        
                    if(!isset($formData['is_used'])){
                        $p_array = ['0'];
                    }
                ?>
                <div class="">
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="is_used0">
                        <?=form_radio("is_used", '0', in_array('0', $p_array), 'id="is_used0"  class="form-check-input" ');?>
                        <label class="form-check-label" for="is_used0"><?=$lang_options['0'];?></label>
                    </div>
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="is_used1">
                        <?=form_radio("is_used", '1', in_array('1', $p_array), 'id="is_used1"  class="form-check-input" ');?>
                        <label class="form-check-label" for="is_used1"><?=$lang_options['1'];?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_used_at">
            <label for="used_at" class="permit_empty col-form-label"> <?=lang('c4_auth_code.used_at'); ?></label>
            
            
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("used_at", $formData['used_at'] ?? '', ' id="used_at" class="form-control datetimepicker" permit_empty  ', 'text'); 
                        ?>
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_used_ip">
            <label for="used_ip" class="required col-form-label"> <?=lang('c4_auth_code.used_ip'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("used_ip", $formData['used_ip'] ?? '', '  id="used_ip" class="form-control" required maxlength="96" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_ip_address">
            <label for="ip_address" class="required col-form-label"> <?=lang('c4_auth_code.ip_address'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("ip_address", $formData['ip_address'] ?? '', '  id="ip_address" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_userAgent">
            <label for="userAgent" class="required col-form-label"> <?=lang('c4_auth_code.userAgent'); ?></label>
            
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