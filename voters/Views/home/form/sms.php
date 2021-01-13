<?php

$form_id   = 'sms_multi_send';
$form_attr = 'id="' . $form_id . '" autocomplete="off" '
        . 'data-pageslug="account" data-formslug="sms_send" '
        . 'data-modalsize="lg" '
        . 'data-packagelist="select2_js,selectpicker"';

$table_name  = $formData['table_name'] ?? "";
$sms_field = $formData['sms_field'] ?? "";
$type = $formData['type'] ?? "single"; //single multiple template
$smsto = $formData['smsto'] ?? "";     //phone number
$id = $formData['id'] ?? "";     //id of record for single

$datatable = $formData['datatable'] ?? "";
$jsname = $formData['jsname'] ?? "";

$url = '';

if ($type === 'single')
{
  $url = voters_url('home/sendSms');  
}

echo form_open($url, $form_attr);

?>

<?= form_input("table_name", $table_name, '', 'hidden'); ?>     
<?= form_input("sms_field", $sms_field, '', 'hidden'); ?>   
<?= form_input("smsto", $smsto, '', 'hidden'); ?>     
<?= form_input("id", $id, '', 'hidden'); ?>     
<?= form_input("type", $type, '', 'hidden'); ?>     
<?= form_input("_formSlug", 'sms', '', 'hidden'); ?>     


<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-sms"></i> <?= lang('home.sms_multi_send'); ?> </h5>
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

            <?php if (!empty($smsto)): ?>

                <div class="form-group" id="groupField_subject" >
                    <label class="required col-form-label" for="subject"><i class="fas fa-mobile"></i>  <?= lang('home.sms_to'); ?></label>

                    <div class="input-group">
                        <?php
                        echo form_input("smsto", $formData['smsto'] ?? '', ' id="smsto" class="form-control" required disabled', 'text');
                        ?>
                    </div>

                </div>

            <?php endif; ?>

            <div class="form-group" id="groupField_message" >
                <label class="required col-form-label" for="message"><i class="fas fa-align-justify"></i>  <?= lang('home.sms_message'); ?></label>

                <div class="input-group">
                    <?php echo form_textarea('message', $formData['message'] ?? '', ' id="message" data-provide="" class="form-control" required  '); ?>   
                </div>

            </div>

            <?php
            if (!empty($table_name) && ($type === 'multiple')):

                $db     = \Config\Database::connect();
                $fields = $db->getFieldNames($table_name);

                $parserVariables = '{HTTP_SITE_URL}  {HTTP_PANEL_URL} ' . "
";
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

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('home.dismiss'); ?></button>

    <?php if ($type === 'single') : ?>

        <button type="submit" class="btn btn-primary"><?= lang('home.sendEmail'); ?></button>

    <?php endif; ?>

    <?php if ($type === 'multiple') : ?>
        <a class="btn btn-sm btn-danger ml-1" href="javascript:;"
           data-action="show_dt_replace"
           data-actionurl= "<?= voters_url('home/sendSms'); ?>"
           data-datatable="<?php echo $datatable; ?>"
           data-jsname="<?php echo $jsname; ?>"
           data-postformid="<?= $form_id; ?>"
           data-question="<?= lang('home.are_you_sure_multi_sending'); ?> "
           data-processingtitle="<?= lang('home.sms_sending'); ?>" 
           > <?= lang('home.sendMultiSms'); ?>
        </a>
    <?php endif; ?>






</div>

<?php echo form_close(); ?>
        