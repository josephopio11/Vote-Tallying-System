<?php
$authConfig = new \Agents\Config\Authentication();
?>

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header"><?= lang('auth.loginTitle'); ?></div>
        <div class="card-body">
            
                <div class="alert alert-dismissible formAlert alert-danger" role="alert">
                    <div class=""><?= $authConfig->disableLoginReason; ?></div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>             
        </div>

    </div>
</div>
