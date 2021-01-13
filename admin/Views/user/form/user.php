<?php

$url = admin_url('user/save/user');
$hiddenArray = [];

if( !empty($formData['user_id']) )
{
    $url .= '/' . $formData['user_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="user" autocomplete="off" role="presentation" data-pageslug="user" data-formslug="user"  data-jsname="user" data-modalsize="lg" data-packagelist="selectpicker,popover,uisortable,cropperjs,select2_js" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "user", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "user", '', 'hidden');?> 
<?=form_input("user_id", $formData['user_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="far fa-user"></i> <?=lang('user._form_user'); ?> </h5>
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

         <div class="form-group" id="groupField_avatar">
            <label for="avatar" class="permit_empty col-form-label"> <?=lang('user.avatar'); ?></label>
            
            
  <style>  

    .cropper-view-box,
    .cropper-face {
      border-radius: 50%;
    }
  </style>
<div class="input-group">
    <?php
    $def = resources_url('images/empty.png');
    $randomID = rand(10000, 99999);

    if (!empty($formData['avatar']))
    {
        $fileService = \Admin\Config\Services::file();
        $file = $fileService->getFile($formData['avatar']);

        if (!empty($file))
        {
            // $def = getThumbFromData($file);
            $def = $file['url_thumb'];
        }
    }

    ?>

    <label class="label labelcropper" data-toggle="tooltip" title="<?=lang("user.avatar_helpText")?>" style="cursor: pointer;">
        <img class="rounded cropper_img img-thumbnail float-left" id="cropper_img_<?=$randomID;?>" src="<?=$def;?>" alt="avatar" style="max-width: 90px;"/>
        <input type="file" name="file" accept="image/*" class="sr-only cropperjs" id="input_<?=$randomID;?>" 
            data-action="<?=admin_url("user/uploadFile/user/avatar");?>" data-inputname="avatar" data-idnumber="<?=$randomID;?>" 
            data-isrounded="1" data-maxw="400" data-maxh="400" 
           data-minw="400" data-minh="400" data-fixedcropbox="1">
    </label>
   
    <?php echo form_input("avatar", $formData['avatar'] ?? '', '', 'hidden'); ?>

</div>

<div class="progress cropper_progress" id="progress_<?=$randomID;?>" style="display:none">
    <div id="progressbar_<?=$randomID;?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
</div>

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_company_id">
            <label for="company_id" class="required col-form-label"> <?=lang('user.company_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['company_id']))
                        {
                            $query_result =  getCompany(['company_id'=>$formData['company_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['company_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("company_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. admin_url('user/getAllCompany') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="user"
      data-rprimarykey="company_id" data-getrelationurl="user/getAllCompany"
      data-rkeyfield="company_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="company_id5107" data-newinputname="new_company_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {company_id}"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_firstname">
            <label for="firstname" class="required col-form-label"> <?=lang('user.firstname'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("firstname", $formData['firstname'] ?? '', ' id="firstname" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_lastname">
            <label for="lastname" class="required col-form-label"> <?=lang('user.lastname'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("lastname", $formData['lastname'] ?? '', '  id="lastname" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_email">
            <label for="email" class="required col-form-label"> <?=lang('user.email'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("email", $formData['email'] ?? '', ' id="email" class="form-control" required maxlength="96" ', 'email'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_phone">
            <label for="phone" class="permit_empty col-form-label"> <?=lang('user.phone'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("phone", $formData['phone'] ?? '', ' id="phone" class="form-control" permit_empty maxlength="15" ', 'phone'); 
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