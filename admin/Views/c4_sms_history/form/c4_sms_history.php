<?php

$url = admin_url('c4_sms_history/save/c4_sms_history');
$hiddenArray = [];

if( !empty($formData['c4_sms_history_id']) )
{
    $url .= '/' . $formData['c4_sms_history_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_sms_history" autocomplete="off" role="presentation" data-pageslug="c4_sms_history" data-formslug="c4_sms_history"  data-jsname="c4_sms_history" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_sms_history", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_sms_history", '', 'hidden');?> 
<?=form_input("c4_sms_history_id", $formData['c4_sms_history_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-phone"></i> <?=lang('c4_sms_history._form_c4_sms_history'); ?> </h5>
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

         <div class="form-group" id="groupField_smsto">
            <label for="smsto" class="required col-form-label"> <?=lang('c4_sms_history.smsto'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("smsto", $formData['smsto'] ?? '', '  id="smsto" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_message">
            <label for="message" class="required col-form-label"> <?=lang('c4_sms_history.message'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"message", 'rows' => '3'], $formData['message'] ?? '', ' id="message" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_is_sended">
            <label for="is_sended" class="required col-form-label"> <?=lang('c4_sms_history.is_sended'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_sms_history.list_is_sended');
                    $p_array = isset($formData['is_sended']) ? explode(',', $formData['is_sended']) : [];
                        
                    if(!isset($formData['is_sended'])){
                        $p_array = ['0'];
                    }
                ?>
                <div class="">
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="is_sended0">
                        <?=form_radio("is_sended", '0', in_array('0', $p_array), 'id="is_sended0"  class="form-check-input" ');?>
                        <label class="form-check-label" for="is_sended0"><?=$lang_options['0'];?></label>
                    </div>
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="is_sended1">
                        <?=form_radio("is_sended", '1', in_array('1', $p_array), 'id="is_sended1"  class="form-check-input" ');?>
                        <label class="form-check-label" for="is_sended1"><?=$lang_options['1'];?></label>
                    </div>
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