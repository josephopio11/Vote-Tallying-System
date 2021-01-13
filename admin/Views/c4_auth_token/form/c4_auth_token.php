<?php

$url = admin_url('c4_auth_token/save/c4_auth_token');
$hiddenArray = [];

if( !empty($formData['c4_auth_token_id']) )
{
    $url .= '/' . $formData['c4_auth_token_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_auth_token" autocomplete="off" role="presentation" data-pageslug="c4_auth_token" data-formslug="c4_auth_token"  data-jsname="c4_auth_token" data-modalsize="lg" data-packagelist="selectpicker,popover,datetimepicker" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_auth_token", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_auth_token", '', 'hidden');?> 
<?=form_input("c4_auth_token_id", $formData['c4_auth_token_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-code-branch"></i> <?=lang('c4_auth_token._form_c4_auth_token'); ?> </h5>
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

         <div class="form-group" id="groupField_whoisID">
            <label for="whoisID" class="permit_empty col-form-label"> <?=lang('c4_auth_token.whoisID'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("whoisID", $formData['whoisID'] ?? '', '  id="whoisID" class="form-control" permit_empty maxlength="11" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_table">
            <label for="table" class="required col-form-label"> <?=lang('c4_auth_token.table'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("table", $formData['table'] ?? '', '  id="table" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_userAgent">
            <label for="userAgent" class="required col-form-label"> <?=lang('c4_auth_token.userAgent'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("userAgent", $formData['userAgent'] ?? '', '  id="userAgent" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_token">
            <label for="token" class="required col-form-label"> <?=lang('c4_auth_token.token'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("token", $formData['token'] ?? '', '  id="token" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_ip_address">
            <label for="ip_address" class="required col-form-label"> <?=lang('c4_auth_token.ip_address'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("ip_address", $formData['ip_address'] ?? '', '  id="ip_address" class="form-control" required maxlength="96" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_expires">
            <label for="expires" class="required col-form-label"> <?=lang('c4_auth_token.expires'); ?></label>
            
            
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("expires", $formData['expires'] ?? '', ' id="expires" class="form-control datetimepicker" required  ', 'text'); 
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