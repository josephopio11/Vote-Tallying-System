<?php

$url = admin_url('admin/save/admin_password');
$hiddenArray = [];

if( !empty($formData['admin_id']) )
{
    $url .= '/' . $formData['admin_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="admin_password" autocomplete="off" role="presentation" data-pageslug="admin" data-formslug="admin_password"  data-jsname="admin" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "admin_password", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "admin", '', 'hidden');?> 
<?=form_input("admin_id", $formData['admin_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-key"></i> <?=lang('admin._form_admin_password'); ?> </h5>
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

         <div class="form-group" id="groupField_password">
            <label for="password" class="required col-form-label"> <?=lang('admin.password'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("password", '', ' id="password" class="form-control" required maxlength="255" ', 'password'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

















</div>

<div class="modal-footer">
    
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('home.dismiss');?></button>
    <button type="submit" class="btn btn-info"><?=lang('home.save');?></button>
</div>

<?php echo form_close(); ?>