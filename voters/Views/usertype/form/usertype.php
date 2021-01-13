<?php

$url = voters_url('usertype/save/usertype');
$hiddenArray = [];

if( !empty($formData['type_id']) )
{
    $url .= '/' . $formData['type_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="usertype" autocomplete="off" role="presentation" data-pageslug="usertype" data-formslug="usertype"  data-jsname="usertype" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "usertype", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "usertype", '', 'hidden');?> 
<?=form_input("type_id", $formData['type_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-user-cog"></i> <?=lang('usertype._form_usertype'); ?> </h5>
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

         <div class="form-group" id="groupField_usertype">
            <label for="usertype" class="required col-form-label"> <?=lang('usertype.usertype'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("usertype", $formData['usertype'] ?? '', '  id="usertype" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_comment">
            <label for="comment" class="required col-form-label"> <?=lang('usertype.comment'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"comment", 'rows' => '3'], $formData['comment'] ?? '', ' id="comment" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
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