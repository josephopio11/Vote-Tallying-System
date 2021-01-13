<?php
$locale = service('request')->getLocale(); 
$resourcesUrl = resources_url();
?>

<div class="container">

    <div class="card card-login mx-auto mt-5">

        <div class="card-header"><?= lang('auth.registerTitle'); ?></div>

        <div class="card-body">            
            
            <?php echo form_open(voters_url('auth/register'), ' class="crud4form needs-validation form-signin" id="register" data-packagelist="selectpicker,dropzone,select2_js"'); ?>            
            <?php echo form_hidden('goBack', $_GET['goBack'] ?? ''); ?>
            
            <?php if (isset($messages)): ?>            
                <div class="alert alert-dismissible formAlert alert-success" role="alert">
                    <div class=""><?= $messages; ?></div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

            <?php endif; ?>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="firstname"><?= lang('auth.firstname'); ?></label>
                        <input name="firstname" class="form-control py-4" id="firstname" type="text" placeholder="" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="lastname"><?= lang('auth.lastname'); ?></label>
                        <input name="lastname" class="form-control py-4" id="inputLastName" type="text" placeholder="" required/>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group"><label class="small mb-1" for="email"><?= lang('auth.email'); ?></label>
                        <input class="form-control py-4" id="email" type="text" name="email" placeholder="" required/>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group"><label class="small mb-1" for="phone"><?= lang('auth.phone'); ?></label>
                        <input class="form-control py-4" id="email" type="text" name="phone" placeholder="" required/>
                    </div>
                </div>
            </div>



            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="c4_country_id"><?= lang('auth.country'); ?></label>

                        <?php                        
                        $option = [];
                        if (!empty($formData['c4_country_id']))
                        {
                            $query_result = getCountry(['c4_country_id' => $formData['c4_country_id']]);

                            if (!empty($query_result))
                            {
                                $option = [$query_result['c4_country_id'] => $query_result['name']];
                            }
                        }
                        ?>

                       <?php echo form_dropdown("c4_country_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="' . voters_url('general/getAllC4_country') . '" 
      data-placeholder="' . lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-tags="false" data-formname="register"
      data-rkeyfield="c4_country_id" data-rvaluefield="name"
      data-required ="required" id="c4_country_id" data-newinputname="new_country_id" '); ?>


                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="c4_zone_id"><?= lang('auth.zone'); ?></label>


                        <?php                        $option = [];
                        if (!empty($formData['c4_zone_id']))
                        {
                            $query_result = getZone(['c4_zone_id' => $formData['zone_id']]);

                            if (!empty($query_result))
                            {
                                $option = [$query_result['c4_zone_id'] => $query_result['name']];
                            }
                        }
                        
                        echo form_dropdown("c4_zone_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="' . voters_url('general/getAllC4_zone') . '" 
      data-placeholder="' . lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-tags="false" data-formname="register"
      data-rkeyfield="c4_zone_id" data-rvaluefield="name"
      data-required ="required" id="c4_zone_id" data-newinputname="new_zone_id" data-filter="c4_country_id"'); 
        ?>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <a href="<?=voters_url('general/userAgreement');?>" target="_blank"></a>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="acceptMembership" value="1" id="acceptMembership" required>
                        <?= lang('auth.acceptMembership'); ?>                    
                    </label>
                </div>
            </div>
            
            <hr/>
            <div class="text-center text-secondary d-block small mb-2 pb-1"><?= lang('auth.yourPasswordWillSent'); ?></div>
            <hr/>
            
            <button class="btn btn-primary btn-block" type="submit"><?= lang('auth.register'); ?></button>

            <?= form_close(); ?>            
            <hr/>
            <div class="text-center d-block small pb-2">
                         <?= lang('auth.askAccountToLogin'); ?> <a class="" href="<?= voters_url('auth/login'); ?>"><?= lang('auth.login'); ?></a>
            </div>
            <hr/>
            
            <div class="text-center d-block small">
                    <a href="<?=voters_url('general/termsOfService');?>" target="_blank"><?= lang('auth.agreementIfContinue'); ?></a>
            </div>

        </div>
    </div>
</div>

