<?php

$url = voters_url('users/save/users');
$hiddenArray = [];

if( !empty($formData['user_id']) )
{
    $url .= '/' . $formData['user_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="users" autocomplete="off" role="presentation" data-pageslug="users" data-formslug="users"  data-jsname="users" data-modalsize="lg" data-packagelist="selectpicker,popover,datepicker,select2_js,uisortable,cropperjs" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "users", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "users", '', 'hidden');?> 
<?=form_input("user_id", $formData['user_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-user"></i> <?=lang('users._form_users'); ?> </h5>
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

        <p class="groupTitle">Personal Details</p>

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_firstname">
            <label for="firstname" class="required col-form-label"> <?=lang('users.firstname'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("firstname", $formData['firstname'] ?? '', '  id="firstname" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_lastname">
            <label for="lastname" class="required col-form-label"> <?=lang('users.lastname'); ?></label>
            
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

         <div class="form-group" id="groupField_gender">
            <label for="gender" class="required col-form-label"> <?=lang('users.gender'); ?></label>
            
                                 <div class="input-group">
                        
                        <?php
                        echo form_dropdown("gender", lang('users.list_gender'), $formData['gender'] ?? '', ' id="gender" class="form-control selectpicker" required  '); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_dob">
            <label for="dob" class="required col-form-label"> <?=lang('users.dob'); ?></label>
            
                            <?php 
                    if(!isset($formData['dob'])){
                        $formData['dob'] = date('Y-m-d');
                    }
                ?>
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("dob", $formData['dob'] ?? '', ' id="dob" class="form-control datepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_nationalID">
            <label for="nationalID" class="permit_empty col-form-label"> <?=lang('users.nationalID'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("nationalID", $formData['nationalID'] ?? '', '  id="nationalID" class="form-control" permit_empty maxlength="20" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    <p class="groupTitle">Contact Information</p>

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_email">
            <label for="email" class="required col-form-label"> <?=lang('users.email'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("email", $formData['email'] ?? '', ' id="email" class="form-control" required maxlength="96" ', 'email'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_password">
            <label for="password" class="permit_empty col-form-label"> <?=lang('users.password'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("password", '', ' id="password" class="form-control" permit_empty maxlength="255" ', 'password'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_phone">
            <label for="phone" class="permit_empty col-form-label"> <?=lang('users.phone'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("phone", $formData['phone'] ?? '', ' id="phone" class="form-control" permit_empty maxlength="15" ', 'phone'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    <p class="groupTitle">Others</p>

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_usertype">
            <label for="usertype" class="required col-form-label"> <?=lang('users.usertype'); ?></label>
            
                                <?php
                        if(empty($formData['usertype'])){
                            //Default Value...
                            $formData['usertype'] = 'locked';
                        }
                    ?>

                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['usertype']))
                        {
                            $query_result =  getUsertype(['type_id'=>$formData['usertype']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['type_id'] =>  $query_result['usertype']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("usertype", $option, 'locked', ' class="form-control select2_js" 
      data-ajax--url="'. voters_url('users/getAllUsertype') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="users"
      data-rprimarykey="type_id" data-getrelationurl="users/getAllUsertype"
      data-rkeyfield="type_id" data-rvaluefield="usertype" data-rvaluefield2=""
      data-required ="required" id="usertype3793" data-newinputname="new_usertype""
      data-optionview="{usertype}" data-selectedview="{usertype}"  data-titleview="ID: {type_id}"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_avatar">
            <label for="avatar" class="permit_empty col-form-label"> <?=lang('users.avatar'); ?></label>
            
            
<div class="input-group">
    <?php
    $def = resources_url('images/empty.png');
    $randomID = rand(10000, 99999);

    if (!empty($formData['avatar']))
    {
        $fileService = \Voters\Config\Services::file();
        $file = $fileService->getFile($formData['avatar']);

        if (!empty($file))
        {
            // $def = getThumbFromData($file);
            $def = $file['url_thumb'];
        }
    }

    ?>

    <label class="label labelcropper" data-toggle="tooltip" title="<?=lang("users.avatar_helpText")?>" style="cursor: pointer;">
        <img class="rounded cropper_img img-thumbnail float-left" id="cropper_img_<?=$randomID;?>" src="<?=$def;?>" alt="avatar" style="max-width: 90px;"/>
        <input type="file" name="file" accept="image/*" class="sr-only cropperjs" id="input_<?=$randomID;?>" 
            data-action="<?=voters_url("users/uploadFile/users/avatar");?>" data-inputname="avatar" data-idnumber="<?=$randomID;?>" 
            data-isrounded="" data-maxw="220" data-maxh="220" 
           data-minw="220" data-minh="220" data-fixedcropbox="">
    </label>
   
    <?php echo form_input("avatar", $formData['avatar'] ?? '', '', 'hidden'); ?>

</div>

<div class="progress cropper_progress" id="progress_<?=$randomID;?>" style="display:none">
    <div id="progressbar_<?=$randomID;?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
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