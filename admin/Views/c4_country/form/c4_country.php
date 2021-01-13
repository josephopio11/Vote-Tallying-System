<?php

$url = admin_url('c4_country/save/c4_country');
$hiddenArray = [];

if( !empty($formData['c4_country_id']) )
{
    $url .= '/' . $formData['c4_country_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_country" autocomplete="off" role="presentation" data-pageslug="c4_country" data-formslug="c4_country"  data-jsname="c4_country" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_country", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_country", '', 'hidden');?> 
<?=form_input("c4_country_id", $formData['c4_country_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-map"></i> <?=lang('c4_country._form_c4_country'); ?> </h5>
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

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('c4_country.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_iso_code_2">
            <label for="iso_code_2" class="permit_empty col-form-label"> <?=lang('c4_country.iso_code_2'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("iso_code_2", $formData['iso_code_2'] ?? '', '  id="iso_code_2" class="form-control" permit_empty maxlength="2" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_iso_code_3">
            <label for="iso_code_3" class="permit_empty col-form-label"> <?=lang('c4_country.iso_code_3'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("iso_code_3", $formData['iso_code_3'] ?? '', '  id="iso_code_3" class="form-control" permit_empty maxlength="3" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_address_format">
            <label for="address_format" class="permit_empty col-form-label"> <?=lang('c4_country.address_format'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"address_format", 'rows' => '3'], $formData['address_format'] ?? '', ' id="address_format" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_postcode_required">
            <label for="postcode_required" class="required col-form-label"> <?=lang('c4_country.postcode_required'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_country.list_postcode_required');
                    $p_array = isset($formData['postcode_required']) ? explode(',', $formData['postcode_required']) : [];
                        
                    if(!isset($formData['postcode_required'])){
                        $p_array = ['0'];
                    }
                ?>
                <div class="">
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="postcode_required0">
                        <?=form_radio("postcode_required", '0', in_array('0', $p_array), 'id="postcode_required0"  class="form-check-input" ');?>
                        <label class="form-check-label" for="postcode_required0"><?=$lang_options['0'];?></label>
                    </div>
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="postcode_required1">
                        <?=form_radio("postcode_required", '1', in_array('1', $p_array), 'id="postcode_required1"  class="form-check-input" ');?>
                        <label class="form-check-label" for="postcode_required1"><?=$lang_options['1'];?></label>
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