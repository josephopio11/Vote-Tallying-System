<div class="row">

    
        <div class="col-lg-2 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-dark bg-white o-hidden h-100" data-viewplace="ondashboard" data-action="readStatistic" data-type="number" 
                data-ajaxurl="<?= admin_url('pollstat/readStatistic/pollstat/Polling-Stations');?>" data-card_slug="Polling-Stations" data-alliesname="COUNT_id">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('pollstat.Polling-Stations'); ?></div>
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Polling-Stations" id="Polling-Stations"><!-- Data Comes With AJAX Here --></div>
                </div>
                
    <a class="card-footer p-1 text-dark clearfix small z-1" href="<?=admin_url('pollstat/pollstat');?>"">
        <span class="float-left"><?=lang('home.view_more');?></span>
        <span class="float-right"><i class="fas fa-angle-right"></i></span>
    </a>    
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="ondashboard" data-action="readStatistic" data-type="number" 
                data-ajaxurl="<?= admin_url('county/readStatistic/county/Counties');?>" data-card_slug="Counties" data-alliesname="COUNT_countyid">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('county.Counties'); ?></div>
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Counties" id="Counties"><!-- Data Comes With AJAX Here --></div>
                </div>
                
    <a class="card-footer p-1 text-white clearfix small z-1" href="<?=admin_url('county/county');?>"">
        <span class="float-left"><?=lang('home.view_more');?></span>
        <span class="float-right"><i class="fas fa-angle-right"></i></span>
    </a>    
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="ondashboard" data-action="readStatistic" data-type="number" 
                data-ajaxurl="<?= admin_url('user/readStatistic/user/Number-of-User');?>" data-card_slug="Number-of-User" data-alliesname="COUNT_user_id">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('user.Number-of-User'); ?></div>
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Number-of-User" id="Number-of-User"><!-- Data Comes With AJAX Here --></div>
                </div>
                
    <a class="card-footer p-1 text-white clearfix small z-1" href="<?=admin_url('user/user');?>"">
        <span class="float-left"><?=lang('home.view_more');?></span>
        <span class="float-right"><i class="fas fa-angle-right"></i></span>
    </a>    
            </div>
        </div>

</div>
    <!-- Charts -->
    <div class="row">
        <div class="col-xl-6 col-sm-12 mb-2">
                    <div class="col-xl-12 col-sm-12">    
                    <?php echo admin_view('user/chart/user_statistic', ['hideTable' => true]);?>                    </div>
                    </div>
    </div>
    <!-- /Charts -->
