

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header"><?= lang('auth.loginTitle'); ?></div>
        <div class="card-body">

            <?= form_open(admin_url('auth/login'), ' class="needs-validation form-signin crud4form" id="loginForm" data-packagelist=""'); ?>

            <?php echo form_hidden('goBack', $_GET['goBack'] ?? ''); ?>
            
            <?php if (isset($messages)): ?>
            <div class="alert alert-dismissible formAlert alert-success" role="alert">
                <div class=""><?= $messages; ?></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <?php endif; ?>
            <div class="form-group">
                <div class="form-label-group">
                    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="<?= lang('auth.email'); ?>" required="required">
                </div>
            </div>

            <div class="form-group">
                <div class="form-label-group">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="<?= lang('auth.password'); ?>" required="required">
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="rememberMe" value="1" id="inputRememberMe">
                            <?= lang('auth.rememberMe'); ?>                    </label>
                </div>
            </div>

            <button class="btn btn-primary btn-block" type="submit"><?= lang('auth.login'); ?></button>

            <?= form_close(); ?>         
        </div>
        
        <div class="card-footer text-center">
             <a class="d-block small" href="<?=admin_url('auth/forgot');?>"><?= lang('auth.askResetPassword'); ?></a>
            
                <hr/>

                <div class="text-center pb-1">
                    <a class="d-block small" href="<?=admin_url('auth/register');?>"><?= lang('auth.askNewAccount'); ?></a>
                </div>

                    </div>

    </div>
</div>

