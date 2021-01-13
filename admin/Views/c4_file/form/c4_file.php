<?php

$url = admin_url('c4_file/save/c4_file');
$hiddenArray = [];

if( !empty($formData['c4_file_id']) )
{
    $url .= '/' . $formData['c4_file_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_file" autocomplete="off" role="presentation" data-pageslug="c4_file" data-formslug="c4_file"  data-jsname="c4_file" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_file", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_file", '', 'hidden');?> 
<?=form_input("c4_file_id", $formData['c4_file_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="far fa-file"></i> <?=lang('c4_file._form_c4_file'); ?> </h5>
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
            <label for="name" class="required col-form-label"> <?=lang('c4_file.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_fullPath">
            <label for="fullPath" class="required col-form-label"> <?=lang('c4_file.fullPath'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("fullPath", $formData['fullPath'] ?? '', ' id="fullPath" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_isPublic">
            <label for="isPublic" class="required col-form-label"> <?=lang('c4_file.isPublic'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_file.list_isPublic');
                    $p_array = isset($formData['isPublic']) ? explode(',', $formData['isPublic']) : [];
                        
                    if(!isset($formData['isPublic'])){
                        $p_array = ['1'];
                    }
                ?>
                <div class="">
    
                    <div class="form-check form-check-inline mt-2 mb-1" for="isPublic1">
                        <?=form_radio("isPublic", '1', in_array('1', $p_array), 'id="isPublic1"  class="form-check-input" ');?>
                        <label class="form-check-label" for="isPublic1"><?=$lang_options['1'];?></label>
                    </div>
    
                    <div class="form-check form-check-inline mt-2 mb-1" for="isPublic0">
                        <?=form_radio("isPublic", '0', in_array('0', $p_array), 'id="isPublic0"  class="form-check-input" ');?>
                        <label class="form-check-label" for="isPublic0"><?=$lang_options['0'];?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_isImage">
            <label for="isImage" class="required col-form-label"> <?=lang('c4_file.isImage'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_file.list_isImage');
                    $p_array = isset($formData['isImage']) ? explode(',', $formData['isImage']) : [];
                        
                    if(!isset($formData['isImage'])){
                        $p_array = ['0'];
                    }
                ?>
                <div class="">
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="isImage0">
                        <?=form_radio("isImage", '0', in_array('0', $p_array), 'id="isImage0"  class="form-check-input" ');?>
                        <label class="form-check-label" for="isImage0"><?=$lang_options['0'];?></label>
                    </div>
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="isImage1">
                        <?=form_radio("isImage", '1', in_array('1', $p_array), 'id="isImage1"  class="form-check-input" ');?>
                        <label class="form-check-label" for="isImage1"><?=$lang_options['1'];?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_originalName">
            <label for="originalName" class="required col-form-label"> <?=lang('c4_file.originalName'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("originalName", $formData['originalName'] ?? '', '  id="originalName" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_thumb">
            <label for="thumb" class="permit_empty col-form-label"> <?=lang('c4_file.thumb'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("thumb", $formData['thumb'] ?? '', '  id="thumb" class="form-control" permit_empty maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_extension">
            <label for="extension" class="required col-form-label"> <?=lang('c4_file.extension'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("extension", $formData['extension'] ?? '', '  id="extension" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_size">
            <label for="size" class="required col-form-label"> <?=lang('c4_file.size'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("size", $formData['size'] ?? '', '  id="size" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_type">
            <label for="type" class="required col-form-label"> <?=lang('c4_file.type'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("type", $formData['type'] ?? '', '  id="type" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_path">
            <label for="path" class="required col-form-label"> <?=lang('c4_file.path'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("path", $formData['path'] ?? '', '  id="path" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_sort_order">
            <label for="sort_order" class="required col-form-label"> <?=lang('c4_file.sort_order'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("sort_order", $formData['sort_order'] ?? '', '  id="sort_order" class="form-control" required maxlength="11" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_keywords">
            <label for="keywords" class="required col-form-label"> <?=lang('c4_file.keywords'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("keywords", $formData['keywords'] ?? '', '  id="keywords" class="form-control" required maxlength="255" ', 'text'); 
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