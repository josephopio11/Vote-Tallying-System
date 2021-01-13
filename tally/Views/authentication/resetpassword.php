<?php
$locale = service('request')->getLocale(); 
$resourcesUrl = resources_url();
?>


<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header"><?= lang('auth.resetPassword'); ?></div>
        <div class="card-body">

             <?php if (isset($errors)): ?>            

            <div class="alert alert-dismissible formAlert alert-danger" role="alert">
                <div class=""><?= implode($errors); ?></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <?php endif; ?>
            <?php if (isset($message)): ?>
            <div class="alert alert-dismissible formAlert alert-success" role="alert">
                <div class=""><?= implode($message); ?></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <?php endif; ?>
        </div>
        
        <div class="card-footer text-center">
             <a class="d-block small" href="<?= tally_url('auth'); ?>"><?= lang('auth.loginPage'); ?></a>
        </div>
        
    </div>
</div>
