<?php
$authService            = service('auth');
$memberId               = $authService->getId();
?>

<div class="container">
    <?php
    $formData               = $authService->getMemberData();
    $url                    = tally_url('home/accountsave/personel/'. $memberId);
    $hiddenArray['_method'] = "PUT";
    $form_attr              = 'id="personel" autocomplete="off" role="presentation" data-pageslug="account" data-formslug="personel" data-modalsize="lg" data-packagelist="selectpicker,popover,uisortable,cropperjs" data-closeonsave="true" class="bg-white crud4form"';

    echo form_open($url, $form_attr, $hiddenArray);
    ?>

    <?= form_input("_formSlug", "personel", '', 'hidden'); ?> 
    <?= form_input("_pageSlug", "account", '', 'hidden'); ?> 
    <?= form_input("memberId", $memberId, '', 'hidden'); ?> 


    <div class="card bg-white">
        <div class="card-header  bg-white">
            <h5 class="modal-title" id=""><i class="fas fa-user"></i> <?= lang('auth.accountPersonel'); ?> </h5>

        </div>

        <div class="card-body">


            <div class="alert alert-danger alert-dismissible formAlert d-none" role="alert" >
                <div class=""><span class="sr-only">Errors...</span></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="form-row">
                
                                    
                
                <div class="col-md-2">

                    <div class="form-group" id="groupField_avatar">
                        <label for="avatar" class="permit_empty col-form-label"> <?= lang('auth.accountAvatar'); ?></label>


                        <div class="input-group">
                            <?php                            
                            $def      = resources_url('images/empty.png');
                            $randomID = rand(10000, 99999);

                            if (!empty($formData['avatar']))
                            {
                                $fileService = \Tally\Config\Services::file();
                                $file        = $fileService->getFile($formData['avatar']);

                                if (!empty($file))
                                {
                                    $def = $file['url_download'];
                                }
                            }
                            ?>

                            <label class="label labelcropper" data-toggle="tooltip" style="cursor: pointer;">

                                <img class="rounded cropper_img img-thumbnail float-left" id="cropper_img_<?= $randomID; ?>" src="<?= $def; ?>" 
                                     alt="avatar" style="width: 150px;"/>

                                <input type="file" name="file" accept="image/*" class="sr-only cropperjs" id="input_<?= $randomID; ?>" 
                                       data-action="<?= tally_url("home/uploadFile/account/avatar"); ?>" data-inputname="avatar" 
                                       data-idnumber="<?= $randomID; ?>" 
                                       data-isrounded="" data-maxw="500" data-maxh="500" 
                                       data-minw="150" data-minh="150" data-fixedcropbox="true"/>
                            </label>

                            <?php echo form_input("avatar", $formData['avatar'] ?? '', '', 'hidden'); ?>

                        </div>

                        <div class="progress cropper_progress" id="progress_<?= $randomID; ?>" style="display:none">
                            <div id="progressbar_<?= $randomID; ?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>

                    </div>
                </div>
                
                
                                
                <div class="col-md-10">

                    <div class="form-row">

                        <div class="col">
                            <div class="form-group" id="groupField_firstname">
                                <label for="firstname" class="required col-form-label"> <?= lang('auth.firstname'); ?></label>

                                <div class="input-group">

                                    <?php                                    echo form_input("firstname", $formData['firstname'] ?? '', ' id="firstname" class="form-control" required maxlength="32" ', 'text');
                                    ?>

                                </div>


                            </div>
                        </div>

                        <div class="col">

                            <div class="form-group" id="groupField_lastname">
                                <label for="lastname" class="permit_empty col-form-label"> <?= lang('auth.lastname'); ?></label>

                                <div class="input-group">

                                    <?php                                    echo form_input("lastname", $formData['lastname'] ?? '', '  id="lastname" class="form-control" permit_empty maxlength="32" ', 'text');
                                    ?>

                                </div>


                            </div>
                        </div>
                        <div class="col"></div>

                    </div>

                    <div class="form-row">

                       
                    </div>

                </div>

            </div>



        </div>

        <div class="card-footer bg-white text-right">


            <button type="submit" class="btn btn-primary"><?= lang('home.save'); ?></button>
        </div>

    </div>
    <?php echo form_close(); ?>



    <div class="m-4"></div>


    <div class="card">

        <div class="card-header bg-white">
            <h5 class="modal-title" id=""><i class="fas fa-key"></i> <?= lang('auth.password'); ?> </h5>

        </div>

        <div class="card-body bg-white">

            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                    <img src="<?= resources_url('images/secure-lock.png'); ?>" class="rounded mx-auto d-block mb-3" width="200" alt="Password"></img>
                    <a class="btn btn-primary btn-lg btn-block" 
                       href="<?= tally_url('home/showForm/change_password/'. $memberId); ?>" 
                       data-modalsize="lg" 
                       data-modalurl="<?= tally_url('home/showForm/change_password/'. $memberId); ?>" 
                       data-modaldata="" data-modalview="centermodal" 
                       data-modalbackdrop="true" 
                       data-action="openformmodal">
                        <span>
                            <i class="fas fa-key"></i>
                            <span><?= lang('auth.changePassword'); ?></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>