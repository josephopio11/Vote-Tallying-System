<?php
$tableTitle = lang('users._page_users');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-user"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = agents_url('users/showForm/users');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_users"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-user"></i>
                                    <span><?=lang('users._form_users'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_users" aria-controls="searchFormArea_users" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">

    <!--  Start Card Row -->
    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= agents_url('users/readStatistic/users/Total-Users');?>" 
                    data-card_slug="Total-Users" data-alliesname="COUNT_user_id">
                <div class="card-header p-2"><i class = "far fa-user"></i> <?= lang('users.Total-Users'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Total-Users" id="Total-Users"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= agents_url('users/readStatistic/users/Root-Users');?>" 
                    data-card_slug="Root-Users" data-alliesname="COUNT_usertype">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('users.Root-Users'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Root-Users" id="Root-Users"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= agents_url('users/readStatistic/users/Admin-Users');?>" 
                    data-card_slug="Admin-Users" data-alliesname="COUNT_usertype">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('users.Admin-Users'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Admin-Users" id="Admin-Users"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-dark o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= agents_url('users/readStatistic/users/Polling-Agents');?>" 
                    data-card_slug="Polling-Agents" data-alliesname="COUNT_usertype">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('users.Polling-Agents'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Polling-Agents" id="Polling-Agents"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

    </div>
    <!--  End Card Row -->

        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_users">
            <div class="card card-body border-light p-0">

<?php echo form_open(agents_url('users/readUsers/users'), 'id="form_users"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                         

                    
                        <!--  General Search -->           
                        <div class="form-group col-md-2">
                            <label><?php echo lang('home.general_search'); ?></label>
    
                        <?php $searchText = lang("users.firstname"). ', ' .lang("users.lastname"). ', ' .lang("users.email"). ', ' .lang("users.phone"); ?>

                            <input type="search"  name="filterSearch" class="form-control generalSearch" placeholder="<?= $searchText; ?>" />

                        </div>


                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_users">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  gender -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('users.gender'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=agents_url('users/update');?>"
                                               data-datatable="table_users" data-jsname="users"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("users.gender");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"gender":"male"}'><?=lang('users.list_gender')['male'] ?? 'male'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=agents_url('users/update');?>"
                                               data-datatable="table_users" data-jsname="users"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("users.gender");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"gender":"female"}'><?=lang('users.list_gender')['female'] ?? 'female'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('users.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=agents_url('users/update');?>"
                                               data-datatable="table_users" data-jsname="users"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("users.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('users.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=agents_url('users/update');?>"
                                               data-datatable="table_users" data-jsname="users"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("users.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('users.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=agents_url('users/update');?>"
                        data-datatable="table_users"  data-jsname="users"
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
                        data-actionurl= "<?=agents_url('users/update');?>"
                        data-datatable="table_users"  data-jsname="users"
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
                <table id="table_users" class="table table-hover" width="100%" cellspacing="0" data-url="<?=agents_url('users/readUsers/users');?>"></table>
            </div>





    </div>
</div>


<script src="<?= agents_url('users/langJS');?>"></script>

    <script src="<?= site_url('assets/agents/users/users.js');?>"></script> 

    


