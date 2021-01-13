<?php

$url = admin_url('c4_session/save/c4_session');
$hiddenArray = [];

if( !empty($formData['id']) )
{
    $url .= '/' . $formData['id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_session" autocomplete="off" role="presentation" data-pageslug="c4_session" data-formslug="c4_session"  data-jsname="c4_session" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_session", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_session", '', 'hidden');?> 
<?=form_input("id", $formData['id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-diagnoses"></i> <?=lang('c4_session._form_c4_session'); ?> </h5>
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
            <label for="ip_address" class="required col-form-label"> <?=lang('c4_session.ip_address'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("ip_address", $formData['ip_address'] ?? '', '  id="ip_address" class="form-control" required maxlength="45" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_timestamp">
            <label for="timestamp" class="required col-form-label"> <?=lang('c4_session.timestamp'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("timestamp", $formData['timestamp'] ?? '', '  id="timestamp" class="form-control" required maxlength="10" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_data">
            <label for="data" class="permit_empty col-form-label"> <?=lang('c4_session.data'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("data", $formData['data'] ?? '', '  id="data" class="form-control" permit_empty  ', 'text'); 
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