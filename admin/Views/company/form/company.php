<?php

$url = admin_url('company/save/company');
$hiddenArray = [];

if( !empty($formData['company_id']) )
{
    $url .= '/' . $formData['company_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="company" autocomplete="off" role="presentation" data-pageslug="company" data-formslug="company"  data-jsname="company" data-modalsize="lg" data-packagelist="selectpicker,popover,uisortable,cropperjs,select2_js" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "company", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "company", '', 'hidden');?> 
<?=form_input("company_id", $formData['company_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-building"></i> <?=lang('company._form_company'); ?> </h5>
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

         <div class="form-group" id="groupField_logo">
            <label for="logo" class="permit_empty col-form-label"> <?=lang('company.logo'); ?></label>
            
            
<div class="input-group">
    <?php
    $def = resources_url('images/empty.png');
    $randomID = rand(10000, 99999);

    if (!empty($formData['logo']))
    {
        $fileService = \Admin\Config\Services::file();
        $file = $fileService->getFile($formData['logo']);

        if (!empty($file))
        {
            // $def = getThumbFromData($file);
            $def = $file['url_thumb'];
        }
    }

    ?>

    <label class="label labelcropper" data-toggle="tooltip" title="<?=lang("company.logo_helpText")?>" style="cursor: pointer;">
        <img class="rounded cropper_img img-thumbnail float-left" id="cropper_img_<?=$randomID;?>" src="<?=$def;?>" alt="avatar" style="max-width: 90px;"/>
        <input type="file" name="file" accept="image/*" class="sr-only cropperjs" id="input_<?=$randomID;?>" 
            data-action="<?=admin_url("company/uploadFile/company/logo");?>" data-inputname="logo" data-idnumber="<?=$randomID;?>" 
            data-isrounded="" data-maxw="400" data-maxh="400" 
           data-minw="220" data-minh="220" data-fixedcropbox="1">
    </label>
   
    <?php echo form_input("logo", $formData['logo'] ?? '', '', 'hidden'); ?>

</div>

<div class="progress cropper_progress" id="progress_<?=$randomID;?>" style="display:none">
    <div id="progressbar_<?=$randomID;?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
</div>

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('company.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', ' id="name" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_occupation_field">
            <label for="occupation_field" class="required col-form-label"> <?=lang('company.occupation_field'); ?></label>
            
                                 <div class="input-group">
                        
                        <?php
                        echo form_dropdown("occupation_field", lang('company.list_occupation_field'), $formData['occupation_field'] ?? '', ' id="occupation_field" class="form-control selectpicker" required maxlength="128" '); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">
        </div>
        <div class="col">

         <div class="form-group" id="groupField_legal_name">
            <label for="legal_name" class="permit_empty col-form-label"> <?=lang('company.legal_name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("legal_name", $formData['legal_name'] ?? '', '  id="legal_name" class="form-control" permit_empty maxlength="250" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_country_id">
            <label for="country_id" class="permit_empty col-form-label"> <?=lang('company.country_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['country_id']))
                        {
                            $query_result =  getC4_country(['c4_country_id'=>$formData['country_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_country_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("country_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. admin_url('company/getAllC4_country') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="company"
      data-rprimarykey="c4_country_id" data-getrelationurl="company/getAllC4_country"
      data-rkeyfield="c4_country_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty" id="country_id6588" data-newinputname="new_country_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_country_id}"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_zone_id">
            <label for="zone_id" class="permit_empty col-form-label"> <?=lang('company.zone_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['zone_id']))
                        {
                            $query_result =  getC4_zone(['c4_zone_id'=>$formData['zone_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_zone_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("zone_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. admin_url('company/getAllC4_zone') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="company"
      data-rprimarykey="c4_zone_id" data-getrelationurl="company/getAllC4_zone"
      data-rkeyfield="c4_zone_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty" id="zone_id3808" data-newinputname="new_zone_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_zone_id}"    data-filter="country_id as c4_country_id"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_address">
            <label for="address" class="permit_empty col-form-label"> <?=lang('company.address'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"address", 'rows' => '3'], $formData['address'] ?? '', ' id="address" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
                    </div>
                    
        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_tax_number">
            <label for="tax_number" class="permit_empty col-form-label"> <?=lang('company.tax_number'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("tax_number", $formData['tax_number'] ?? '', '  id="tax_number" class="form-control" permit_empty maxlength="250" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_tax_office">
            <label for="tax_office" class="permit_empty col-form-label"> <?=lang('company.tax_office'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("tax_office", $formData['tax_office'] ?? '', '  id="tax_office" class="form-control" permit_empty maxlength="250" ', 'text'); 
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