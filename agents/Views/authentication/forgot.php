

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header"><?= lang('auth.resetPassword'); ?></div>
        <div class="card-body">
            <div class="text-center mb-4">
                <h4><?= lang('auth.forgotYourPassword'); ?></h4>
                <p><?= lang('auth.forgotPageDesc'); ?></p>
            </div>

            <?php echo form_open(agents_url('auth/forgot'), ' class="crud4form needs-validation form-signin" id="forgotForm" data-packagelist=""'); ?>
           

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

            <button class="btn btn-primary btn-block" id="forgotFormButton" href="#" type="submit"><?= lang('auth.reset'); ?></button>

            <?= form_close(); ?>            
        </div>
        
        <div class="card-footer text-center">
            <a class="d-block small" href="<?= agents_url('auth'); ?>"><?= lang('auth.loginPage'); ?></a>
        </div>
    </div>
</div>
