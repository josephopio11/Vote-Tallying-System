<?php
$tableTitle = lang('votes._page_results');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-vote-yea"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = voters_url('votes/showForm/votes62729055');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_results"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-vote-yea"></i>
                                    <span><?=lang('votes._form_votes62729055'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">

    <!--  Start Card Row -->
    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-danger o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Olemukan-Moses');?>" 
                    data-card_slug="Olemukan-Moses" data-alliesname="SUM_candidate1">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Olemukan-Moses'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Olemukan-Moses" id="Olemukan-Moses"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-warning o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Tukei-William-Wilberforce');?>" 
                    data-card_slug="Tukei-William-Wilberforce" data-alliesname="SUM_candidate2">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Tukei-William-Wilberforce'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Tukei-William-Wilberforce" id="Tukei-William-Wilberforce"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-success o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Osekeny-Sam');?>" 
                    data-card_slug="Osekeny-Sam" data-alliesname="SUM_candidate3">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Osekeny-Sam'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Osekeny-Sam" id="Osekeny-Sam"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-primary o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Omagor-Sam-Okoche');?>" 
                    data-card_slug="Omagor-Sam-Okoche" data-alliesname="SUM_candidate4">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Omagor-Sam-Okoche'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Omagor-Sam-Okoche" id="Omagor-Sam-Okoche"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Total-Invalid');?>" 
                    data-card_slug="Total-Invalid" data-alliesname="SUM_invalidvotes">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Total-Invalid'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Total-Invalid" id="Total-Invalid"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Total-Not-Voted');?>" 
                    data-card_slug="Total-Not-Voted" data-alliesname="SUM_notvoted">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Total-Not-Voted'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Total-Not-Voted" id="Total-Not-Voted"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Polling-Stations-Recorded');?>" 
                    data-card_slug="Polling-Stations-Recorded" data-alliesname="COUNT_pollstatid">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Polling-Stations-Recorded'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Polling-Stations-Recorded" id="Polling-Stations-Recorded"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= voters_url('votes/readStatistic/results/Total-Voters');?>" 
                    data-card_slug="Total-Voters" data-alliesname="SUM_totalvoters">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('votes.Total-Voters'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Total-Voters" id="Total-Voters"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

    </div>
    <!--  End Card Row -->

        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_results">
            <div class="card card-body border-light p-0">

<?php echo form_open(voters_url('votes/readVotes/results'), 'id="form_results"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                         

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_results">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('votes.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=voters_url('votes/update');?>"
                                               data-datatable="table_results" data-jsname="results"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("votes.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('votes.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=voters_url('votes/update');?>"
                                               data-datatable="table_results" data-jsname="results"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("votes.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('votes.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=voters_url('votes/update');?>"
                        data-datatable="table_results"  data-jsname="results"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_deleted");?>"
                        data-processingtitle="<?=lang("home.deleted");?>" 
                        data-postdata='{"deleted_at":"1"}'
                        ><?= lang('home.delete'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>

                    <div class="btn-group btn-group-sm ml-2 undelete_link" style="display:none" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=voters_url('votes/update');?>"
                        data-datatable="table_results"  data-jsname="results"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_restored");?>"
                        data-processingtitle="<?=lang("home.restoring");?>" 
                        data-postdata='{"deleted_at":"0"}'
                        ><?= lang('home.restore'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>
             



                    

                </div>


            </div>

        </div>
        <!-- end: Batch Processing -->



            <div class="table-responsive">
                <table id="table_results" class="table table-hover" width="100%" cellspacing="0" data-url="<?=voters_url('votes/readVotes/results');?>"></table>
            </div>





    </div>
</div>


<script src="<?= voters_url('votes/langJS');?>"></script>

    <script src="<?= site_url('assets/voters/votes/results.js');?>"></script> 

    


