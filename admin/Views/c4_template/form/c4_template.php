<?php

$url = admin_url('c4_template/save/c4_template');
$hiddenArray = [];

if( !empty($formData['c4_template_id']) )
{
    $url .= '/' . $formData['c4_template_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_template" autocomplete="off" role="presentation" data-pageslug="c4_template" data-formslug="c4_template"  data-jsname="c4_template" data-modalsize="lg" data-packagelist="selectpicker,popover,uisortable,dropzone" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_template", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_template", '', 'hidden');?> 
<?=form_input("c4_template_id", $formData['c4_template_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-gopuram"></i> <?=lang('c4_template._form_c4_template'); ?> </h5>
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
            <label for="name" class="required col-form-label"> <?=lang('c4_template.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_title">
            <label for="title" class="required col-form-label"> <?=lang('c4_template.title'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"title", 'rows' => '3'], $formData['title'] ?? '', ' id="title" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_content">
            <label for="content" class="required col-form-label"> <?=lang('c4_template.content'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"content", 'rows' => '3'], $formData['content'] ?? '', ' id="content" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_files">
            <label for="files" class="required col-form-label"> <?=lang('c4_template.files'); ?></label>
            
                            <div class="input-group">
                <?php
                    $files = [];
                    $help_text = lang("c4_template.files"."_helpText");
                    if (!empty($formData['files']))
                    {
                        $fileService = \Admin\Config\Services::file();
                        $files = $fileService->getAllFile($formData['files']);
                            
                        if(!empty($files))
                        {
                            $help_text = '';
                        }
                    }
                ?>

                <div class="dropzone sortable" action="<?=admin_url("c4_template/uploadFile/c4_template/files");?>" 
                    data-maxfiles = "5" 
                    id="dropzone_files" 
                    data-fieldname="files"
                    data-inputname="files[]"
                    data-ismultiple="true"
                    data-tablename="c4_template"  
                    data-acceptedfiles=".pdf,.gz,.gzip,.zip,.rar"
                    data-message="<?=$help_text;?>">
                    
                    <?php
                        if(!empty($files))
                        {
                            foreach ($files as  $file):
                                $file_id = $file['file_id']; 
                                $file_name = $file['originalName'];
             
                                $thumb_url = $file['url_thumb'];
                                $file_full_url = $file['url_download'];

                                ?>
                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" data-id="<?php echo $file_id; ?>" id="<?php echo $file_id; ?>">  
                                    <div class="dz-image d-flex justify-content-center">
                                        <img data-dz-thumbnail="" alt="" src="<?php echo $thumb_url; ?>" class="float-left img-thumbnail" onerror="this.src='https://resources.crud4.com/v1/images/notfound.png'"/>
                                    </div>
                                    <div class="dz-progress">
                                        <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                    </div>
                                    <div class="dz-error-message">
                                        <span data-dz-errormessage=""></span>
                                    </div>
                                    
                                    <div class="dz-details">
                                        <div class="dz-size"><span data-dz-size=""><strong><?php echo $file['size']; ?></strong> MB</span></div>    
                                        <div class="dz-filename"><span data-dz-name=""><?php echo $file_name; ?></span></div>  
                                    </div>
                                    <div>    
                                        <div class="pt-1 align-middle text-center">
                                            <a href="<?=admin_url("c4_template/deleteFile/$file_id");?>" id="file_<?php echo $file_id; ?>" 
                                            
                                                data-action="apirequest"
                                                data-deleteline=".dz-preview"
                                                data-question="areyousure_deletefile"
                                                data-subtitle="can_not_be_undone"
                                                data-usehomelang="true"
                                                data-ajaxmethod="DELETE"
                                                data-fileid="<?php echo $file_id; ?>"
                                                data-datatable="table_c4_template"
                                                data-actionurl="<?=admin_url("c4_template/deleteFile/$file_id");?>" 
                                                title="Delete" 
                                                class="btn btn-secondary btn-sm" data-dz-remove><i class="fa fa-trash"></i>
                                            </a>

                                            <a href="<?php echo $file_full_url; ?>" download title="Download"  target="_blank" class="btn btn-warning btn-sm">
                                                <span><i class="fa fa-download"></i></span>
                                            </a>
                                        </div>
                                        <input type="hidden" name="files[]" value="<?=$file_id;?>"></input>        
                                              
                                                
                                     </div>                
                                </div>
                                <?php
                            endforeach;
                        }
                        else
                        {
                           echo form_hidden("files", '0');
                        }
                     ?>            
                </div>
            </div>

        </div>

         <div class="form-group" id="groupField_lang">
            <label for="lang" class="required col-form-label"> <?=lang('c4_template.lang'); ?></label>
            
            <?php 
    $config     = config('App');
    $supportedLocales = array_combine($config->supportedLocales, $config->supportedLocales);
 
   echo form_dropdown("lang",  $supportedLocales, $formData['lang'] ?? 'en' , 'class="form-control" id="lang" style="width: 100%"'); ?>
        
        </div>

         <div class="form-group" id="groupField_description">
            <label for="description" class="permit_empty col-form-label"> <?=lang('c4_template.description'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"description", 'rows' => '3'], $formData['description'] ?? '', ' id="description" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_usefullData">
            <label for="usefullData" class="permit_empty col-form-label"> <?=lang('c4_template.usefullData'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"usefullData", 'rows' => '3'], $formData['usefullData'] ?? '', ' id="usefullData" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
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