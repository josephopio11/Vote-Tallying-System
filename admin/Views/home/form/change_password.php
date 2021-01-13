<?php
$authService = service('auth');
$admin_id = $authService->getId();

$url                    = admin_url('home/accountsave/change_password' . '/' . $admin_id);
$hiddenArray['_method'] = "PUT";
$form_attr = 'id="password" autocomplete="off" role="presentation" data-pageslug="account" data-formslug="change_password"  data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray);
?>

<?= form_input("_formSlug", "change_password", '', 'hidden'); ?> 
<?= form_input("_pageSlug", "account", '', 'hidden'); ?> 
<?=  form_input("admin_id", $admin_id, '', 'hidden'); ?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-key"></i> <?= lang('auth.password'); ?> </h5>
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

        <div class="col-md-4">

            <div class="form-group" id="groupField_current_password">
                <label for="current_password" class="required col-form-label"><?= lang('auth.currentPassword'); ?></label>

                <div class="input-group">
                    <?php                    echo form_input("current_password", '', ' id="current_password" class="form-control" required maxlength="255" ', 'password');
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group" id="groupField_new_password">
                        <label for="new_password" class="required col-form-label"><?= lang('auth.newPassword'); ?></label>

                        <div class="input-group">
                            <?php                            echo form_input("new_password", '', ' id="new_password" class="form-control" required maxlength="255" ', 'password');
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group" id="groupField_new_password_confirm">
                        <label for="new_password_confirm" class="required col-form-label"><?= lang('auth.newPasswordConfirm'); ?></label>

                        <div class="input-group">
                            <?php                            echo form_input("new_password_confirm", '', ' id="new_password_confirm" class="form-control" required maxlength="255" ', 'password');
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal-footer">


    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('home.dismiss'); ?></button>
    <button type="submit" class="btn btn-info"><?= lang('home.save'); ?></button>
</div>

<?php echo form_close(); ?>