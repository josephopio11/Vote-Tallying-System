<?php
$subscribeService = \Agents\Config\Services::subscription();

if (!isset($cardTitle))
{
    $cardTitle = '';
}
?>

<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fab fa-canadian-maple-leaf"></i> <?= $cardTitle; ?> &nbsp;</h5>
        </div>
    </div>
    <div class="card-body mb-0 pt-0">

        <blockquote class="blockquote text-center">
            <br/>
            <img src="<?= resources_url('images/securedarea.jpg'); ?>" class="rounded" alt="Secured Area">
                <br/><br/>
                <p>Your subscription status is <b><?= $subscribeService->getStatus(); ?></b></p>
                <br/>
                <p>You have no permission to see this area.</p>
        </blockquote>
    </div>
</div>