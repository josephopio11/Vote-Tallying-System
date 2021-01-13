<?php

$url = admin_url('c4_email_history/save/c4_email_history');
$hiddenArray = [];

if( !empty($formData['c4_email_history_id']) )
{
    $url .= '/' . $formData['c4_email_history_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_email_history" autocomplete="off" role="presentation" data-pageslug="c4_email_history" data-formslug="c4_email_history"  data-jsname="c4_email_history" data-modalsize="lg" data-packagelist="selectpicker,popover,uisortable,dropzone" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_email_history", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_email_history", '', 'hidden');?> 
<?=form_input("c4_email_history_id", $formData['c4_email_history_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-envelope-open-text"></i> <?=lang('c4_email_history._form_c4_email_history'); ?> </h5>
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

         <div class="form-group" id="groupField_cid">
            <label for="cid" class="required col-form-label"> <?=lang('c4_email_history.cid'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("cid", $formData['cid'] ?? '', '  id="cid" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_mailto">
            <label for="mailto" class="required col-form-label"> <?=lang('c4_email_history.mailto'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("mailto", $formData['mailto'] ?? '', '  id="mailto" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_subject">
            <label for="subject" class="required col-form-label"> <?=lang('c4_email_history.subject'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("subject", $formData['subject'] ?? '', '  id="subject" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_message">
            <label for="message" class="required col-form-label"> <?=lang('c4_email_history.message'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"message", 'rows' => '3'], $formData['message'] ?? '', ' id="message" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_files">
            <label for="files" class="permit_empty col-form-label"> <?=lang('c4_email_history.files'); ?></label>
            
                            <div class="input-group">
                <?php
                    $files = [];
                    $help_text = lang("c4_email_history.files"."_helpText");
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

                <div class="dropzone sortable" action="<?=admin_url("c4_email_history/uploadFile/c4_email_history/files");?>" 
                    data-maxfiles = "5" 
                    id="dropzone_files" 
                    data-fieldname="files"
                    data-inputname="files[]"
                    data-ismultiple="true"
                    data-tablename="c4_email_history"  
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
                                            <a href="<?=admin_url("c4_email_history/deleteFile/$file_id");?>" id="file_<?php echo $file_id; ?>" 
                                            
                                                data-action="apirequest"
                                                data-deleteline=".dz-preview"
                                                data-question="areyousure_deletefile"
                                                data-subtitle="can_not_be_undone"
                                                data-usehomelang="true"
                                                data-ajaxmethod="DELETE"
                                                data-fileid="<?php echo $file_id; ?>"
                                                data-datatable="table_c4_email_history"
                                                data-actionurl="<?=admin_url("c4_email_history/deleteFile/$file_id");?>" 
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

         <div class="form-group" id="groupField_is_sended">
            <label for="is_sended" class="required col-form-label"> <?=lang('c4_email_history.is_sended'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_email_history.list_is_sended');
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

         <div class="form-group" id="groupField_is_read">
            <label for="is_read" class="required col-form-label"> <?=lang('c4_email_history.is_read'); ?></label>
            
                            <?php 
                    $lang_options = lang('c4_email_history.list_is_read');
                    $p_array = isset($formData['is_read']) ? explode(',', $formData['is_read']) : [];
                        
                    if(!isset($formData['is_read'])){
                        $p_array = ['0'];
                    }
                ?>
                <div class="">
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="is_read0">
                        <?=form_radio("is_read", '0', in_array('0', $p_array), 'id="is_read0"  class="form-check-input" ');?>
                        <label class="form-check-label" for="is_read0"><?=$lang_options['0'];?></label>
                    </div>
        
                    <div class="form-check form-check-inline mt-2 mb-1" for="is_read1">
                        <?=form_radio("is_read", '1', in_array('1', $p_array), 'id="is_read1"  class="form-check-input" ');?>
                        <label class="form-check-label" for="is_read1"><?=$lang_options['1'];?></label>
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