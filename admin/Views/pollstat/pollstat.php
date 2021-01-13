<?php
$tableTitle = lang('pollstat._page_pollstat');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fab fa-markdown"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = admin_url('pollstat/showForm/pollstat');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_pollstat"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fab fa-markdown"></i>
                                    <span><?=lang('pollstat._form_pollstat'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_pollstat" aria-controls="searchFormArea_pollstat" aria-expanded="false">
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
            <div class="card text-dark bg-white o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= admin_url('pollstat/readStatistic/pollstat/Polling-Stations');?>" 
                    data-card_slug="Polling-Stations" data-alliesname="COUNT_id">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('pollstat.Polling-Stations'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Polling-Stations" id="Polling-Stations"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

    </div>
    <!--  End Card Row -->

        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_pollstat">
            <div class="card card-body border-light p-0">

<?php echo form_open(admin_url('pollstat/readPollstat/pollstat'), 'id="form_pollstat"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  parishid --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_parishid"> <?=lang('pollstat.parishid'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['parishid']))
                        {
                            $query_result =  getParish(['parishid'=>$formData['parishid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("parishid", $option, '', ' class="form-control select2_js formSearch"
      id="search_parishid"
      data-ajax--url="'. admin_url('pollstat/getAllParish') . '"
      data-getrelationurl="'. admin_url('pollstat/getAllParish') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="id" 
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}" 
      data-relationformid="form_pollstat" 
'); ?>
                        
    
                </div>

                <!-- /parishid  -->        
                         

                    
                        <!--  General Search -->           
                        <div class="form-group col-md-2">
                            <label><?php echo lang('home.general_search'); ?></label>
    
                        <?php $searchText = lang("pollstat.name"); ?>

                            <input type="search"  name="filterSearch" class="form-control generalSearch" placeholder="<?= $searchText; ?>" />

                        </div>


                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_pollstat">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('pollstat.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('pollstat/update');?>"
                                               data-datatable="table_pollstat" data-jsname="pollstat"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("pollstat.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('pollstat.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('pollstat/update');?>"
                                               data-datatable="table_pollstat" data-jsname="pollstat"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("pollstat.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('pollstat.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=admin_url('pollstat/update');?>"
                        data-datatable="table_pollstat"  data-jsname="pollstat"
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
                        data-actionurl= "<?=admin_url('pollstat/update');?>"
                        data-datatable="table_pollstat"  data-jsname="pollstat"
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
                <table id="table_pollstat" class="table table-hover" width="100%" cellspacing="0" data-url="<?=admin_url('pollstat/readPollstat/pollstat');?>"></table>
            </div>





    </div>
</div>


<script src="<?= admin_url('pollstat/langJS');?>"></script>

    <script src="<?= site_url('assets/admin/pollstat/pollstat.js');?>"></script> 

    


