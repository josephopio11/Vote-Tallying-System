<?php
$locale = service('request')->getLocale(); 
$authService = \Agents\Config\Services::auth();
$resourcesUrl = resources_url();
?>
<?php
$table_name  = $formData['table_name'] ?? "";
$email_field = $formData['email_field'] ?? "";
$type = $formData['type'] ?? "single"; //single multiple template
$id = $formData['id'] ?? "";     //id of record for single

$datatable = $formData['datatable'] ?? "";
$jsname = $formData['jsname'] ?? "";

$url = '';
$title = lang('home.email_multi_send');

if ($type === 'single')
{
  $url = agents_url('home/sendEmail');
  $title = lang('home._form_email_send');
}

echo form_open($url, 'id="email_multi_send" autocomplete="off" data-pageslug="account" data-formslug="email_send" data-modalsize="lg" data-packagelist="select2_js,selectpicker,summernote,dropzone"');

$configEmail = Config('Email');
$emailFromList     = [];
$emailFromNameList = [];

if (!empty($configEmail->fromEmail))
{
    $emailFromList[$configEmail->fromEmail] = $configEmail->fromEmail;
}
if (!empty($configEmail->fromName))
{
    $emailFromNameList[$configEmail->fromName] = $configEmail->fromName;
}


$configPanel = Config('Agents');
$emailFromList[$configPanel->fromEmail] = $configPanel->fromEmail;
$emailFromNameList[$configPanel->projectName] = $configPanel->projectName;
$emailFromNameList[$configPanel->panelTitle] = $configPanel->panelTitle;

        
    $emailFromList[$authService->getEmail()] = $authService->getEmail();
    $emailFromNameList[$authService->getFullName()] = $authService->getFullName();
    
?>

<?= form_input("table_name", $table_name, '', 'hidden'); ?>
<?= form_input("email_field", $email_field, '', 'hidden'); ?>
<?= form_input("mailto", $formData['mailto'] ?? '', '', 'hidden'); ?>
<?= form_input("id", $id, '', 'hidden'); ?>
<?= form_input("type", $type, '', 'hidden'); ?>
<?= form_input("_formSlug", 'email', '', 'hidden'); ?> 


<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-envelope-open-text"></i> <?= $title; ?> </h5>
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

            <?php if (!empty($formData['mailto'] ?? '')): ?>

                <div class="form-group" id="groupField_subject" >
                    <label class="required col-form-label" for="subject"><i class="fas fa-user"></i>  <?= lang('home.email_to'); ?></label>

                    <div class="input-group">
                        <?php                        echo form_input("mailto", $formData['mailto'] ?? '', ' id="mailto" class="form-control" required disabled', 'text');
                        ?>
                    </div>

                </div>

            <?php endif; ?>

            <div class="form-group" id="groupField_subject" >
                <label class="required col-form-label" for="subject"><i class="fas fa-tag"></i>  <?= lang('home.email_subject'); ?></label>

                <div class="input-group">
                    <?php                    echo form_input("subject", $formData['subject'] ?? '', ' id="subject" class="form-control" required  ', 'text');
                    ?>
                </div>

            </div>

            <div class="form-group" id="groupField_message" >
                <label class="required col-form-label" for="message"><i class="fas fa-align-justify"></i>  <?= lang('home.email_message'); ?></label>

                <div class="input-group">
                    <?php echo form_textarea('message', $formData['message'] ?? '', ' id="message" data-provide="" class="form-control selectpicker summernote" required  '); ?>   
                </div>

            </div>

            <?php
            if (!empty($table_name) && ($type === 'multiple')):

                $db     = \Config\Database::connect();
                $fields = $db->getFieldNames($table_name);

                $parserVariables = '{HTTP_SITE_URL}  {HTTP_PANEL_URL} ';

                if (!empty($fields))
                {
                    foreach ($fields as $fieldName)
                    {
                        $parserVariables .= '{' . $fieldName . '}  ';
                    }
                }
                ?>
                <div class="form-group" id="" >
                    <label class="col-form-label"  for="message">
                        <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#collapseExample"><i class="fas fa-align-justify"></i> Parser Variables </button></label>

                    <div class="input-group collapse" id="collapseExample">
                        <?php echo form_textarea(['parserVariables' => '', 'cols' => '40', 'rows' => '3'], $parserVariables, ' id="message" data-provide="" class="form-control"  readonly'); ?>   
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

     <hr/>        

    <div class="form-row">
        <div class="col">

            <div class="form-group" id="groupField_fromName">
                <label for="fromName" class="required col-form-label"> <?= lang('home.email_from'); ?></label>
                <div class="input-group">

                    <?php                    echo form_dropdown("fromName", $emailFromNameList, '', '  id="fromName" class="form-control" required maxlength="255" ', 'text');
                    ?>

                </div>


            </div>
        </div>
        <div class="col">

            <div class="form-group" id="groupField_fromEmail">
                <label for="fromEmail" class="required col-form-label"> <?= lang('home.email_fromEmail'); ?></label>
                <div class="input-group">

                    <?php                    echo form_dropdown("fromEmail", $emailFromList, '', ' id="fromEmail" class="form-control" required maxlength="255" ', 'email');
                    ?>
                </div>
            </div>
        </div>
        <div class="col">

            <div class="form-group" id="groupField_trackEmail">
                <label for="trackEmail" class="required col-form-label"> <?= lang('home.email_track'); ?></label>
                <?php                $p_array = ['1'];
                ?>
                <div class="">

                    <div class="form-check form-check-inline mt-2 mb-1" for="trackEmail1">
                        <?= form_radio("trackEmail", '1', in_array('1', $p_array), 'id="trackEmail1"  class="form-check-input" '); ?>
                        <label class="form-check-label" for="trackEmail1"><?= lang('home.yes') ?></label>
                    </div>

                    <div class="form-check form-check-inline mt-2 mb-1" for="trackEmail0">
                        <?= form_radio("trackEmail", '0', in_array('0', $p_array), 'id="trackEmail0"  class="form-check-input" '); ?>
                        <label class="form-check-label" for="trackEmail0"><?=lang('home.no'); ?></label>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <hr/>      

    <div class="form-row">

        <div class="col">

            <div class="form-group" id="groupField_files" >
                <label class="permit_empty col-form-label" for="files"><i class="far fa-file"></i> <?= lang('home.file'); ?></label>

                <div class="input-group">
                    <?php                    $files     = [];
                    $help_text = lang("home.files_helpText");
                    if (!empty($formData['files']))
                    {
                        $files = getFiles($formData['files']);

                        if (!empty($files))
                        {
                            $help_text = '';
                        }
                    }
                    ?>

                    <div class="dropzone sortable" action="<?= agents_url("home/uploadFile/email_send/files"); ?>" 
                         data-maxfiles = "5" 
                         id="drop_files" 
                         data-fieldname="files"
                         data-inputname="files[]"
                         data-ismultiple="true"
                         data-tablename="email_sended"  
                         data-acceptedfiles="image/*"
                         data-message="<?= $help_text; ?>">

                        <?php                        if (!empty($files))
                        {
                            foreach ($files as $file):
                                $file_id       = $file['file_id'];
                                $file_name     = $file['originalName'];
                                $file_full_url = site_url($file['path'] . '/' . $file['name']);
                                ?>
                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" data-id="<?php echo $file_id; ?>" id="<?php echo $file_id; ?>">  
                                    <div class="dz-image d-flex justify-content-center">
                                        <img data-dz-thumbnail="" alt="" src="<?php echo $file['thumb_url']; ?>" class="float-left img-thumbnail" onerror="this.src='https://user-images.githubusercontent.com/24848110/33519396-7e56363c-d79d-11e7-969b-09782f5ccbab.png'"/>
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
                                            <a href="<?= agents_url("email_sended/deleteFile/$file_id"); ?>" id="file_<?= $file_id; ?>" 
                                                data-action="apirequest"
                                                data-deleteline=".dz-preview"
                                                data-question="areyousure_deletefile"
                                                data-subtitle="can_not_be_undone"
                                                data-usehomelang="true"
                                                data-ajaxmethod="DELETE"
                                                data-fileid="<?= $file_id; ?>"
                                                data-datatable="<?= $datatable; ?>"
                                                data-jsname="<?= $jsname; ?>"
                                                data-actionurl="<?= agents_url("email_sended/deleteFile/$file_id"); ?>" 
                                                title="Delete" 
                                                class="btn btn-secondary btn-sm"><i class="fa fa-trash"></i>
                                            </a>

                                            <a href="<?php echo $file_full_url; ?>" download title="Download"  target="_blank" class="btn btn-warning btn-sm">
                                                <span><i class="fa fa-download"></i></span>
                                            </a>
                                        </div>
                                        <input type="hidden" name="files[]" value="<?= $file_id; ?>">
                                    </div>                
                                </div>
                                <?php                            endforeach;
                        }
                        else
                        {
                            echo form_hidden('files[]', '');
                        }
                        ?>            
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('home.dismiss'); ?></button>

    <?php if ($type === 'single') : ?>

        <button type="submit" class="btn btn-primary"><?= lang('home.sendEmail'); ?></button>

    <?php endif; ?>

    <?php if ($type === 'multiple') : ?>
        <a class="btn btn-sm btn-danger ml-1" href="javascript:;"
           data-action="show_dt_replace"
           data-actionurl= "<?= agents_url('home/sendEmail'); ?>"
           data-datatable="<?= $datatable; ?>"
           data-jsname="<?= $jsname; ?>"
           data-postformid="email_multi_send"
           data-question="<?= lang('home.are_you_sure_multi_sending'); ?> "
           data-processingtitle="<?= lang('home.mail_sending'); ?>" 
           > <?= lang('home.sendMultiEmail'); ?>
        </a>
    <?php endif; ?>

</div>

<?php echo form_close(); ?>