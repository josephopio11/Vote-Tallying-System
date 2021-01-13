<?php
$tableTitle = lang('polllist._page_polllist');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-barcode"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = tally_url('polllist/showForm/polllist');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_polllist"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-barcode"></i>
                                    <span><?=lang('polllist._form_polllist'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_polllist" aria-controls="searchFormArea_polllist" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_polllist">
            <div class="card card-body border-light p-0">

<?php echo form_open(tally_url('polllist/readPolllist/polllist'), 'id="form_polllist"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  pollstatid --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_pollstatid"> <?=lang('polllist.pollstatid'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['pollstatid']))
                        {
                            $query_result =  getPollstat(['pollstatid'=>$formData['pollstatid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("pollstatid", $option, '', ' class="form-control select2_js formSearch"
      id="search_pollstatid"
      data-ajax--url="'. tally_url('polllist/getAllPollstat') . '"
      data-getrelationurl="'. tally_url('polllist/getAllPollstat') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="id" 
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}" 
      data-relationformid="form_polllist" 
'); ?>
                        
    
                </div>

                <!-- /pollstatid  -->        
                                    
                <!--  parishid --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_parishid"> <?=lang('polllist.parishid'); ?></label>
                
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
      data-ajax--url="'. tally_url('polllist/getAllParish') . '"
      data-getrelationurl="'. tally_url('polllist/getAllParish') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="id" 
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}" 
      data-relationformid="form_polllist" 
'); ?>
                        
    
                </div>

                <!-- /parishid  -->        
                                    
                <!--  subcountyid --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_subcountyid"> <?=lang('polllist.subcountyid'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['subcountyid']))
                        {
                            $query_result =  getSubcounty(['subcountyid'=>$formData['subcountyid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("subcountyid", $option, '', ' class="form-control select2_js formSearch"
      id="search_subcountyid"
      data-ajax--url="'. tally_url('polllist/getAllSubcounty') . '"
      data-getrelationurl="'. tally_url('polllist/getAllSubcounty') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="id" 
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}" 
      data-relationformid="form_polllist" 
'); ?>
                        
    
                </div>

                <!-- /subcountyid  -->        
                                    
                <!--  countyid --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_countyid"> <?=lang('polllist.countyid'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['countyid']))
                        {
                            $query_result =  getCounty(['countyid'=>$formData['countyid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['countyid'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("countyid", $option, '', ' class="form-control select2_js formSearch"
      id="search_countyid"
      data-ajax--url="'. tally_url('polllist/getAllCounty') . '"
      data-getrelationurl="'. tally_url('polllist/getAllCounty') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="countyid" 
      data-rkeyfield="countyid" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {countyid}" 
      data-relationformid="form_polllist" 
'); ?>
                        
    
                </div>

                <!-- /countyid  -->        
                                    
                <!--  districtid --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_districtid"> <?=lang('polllist.districtid'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['districtid']))
                        {
                            $query_result =  getC4_zone(['districtid'=>$formData['districtid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_zone_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("districtid", $option, '', ' class="form-control select2_js formSearch"
      id="search_districtid"
      data-ajax--url="'. tally_url('polllist/getAllC4_zone') . '"
      data-getrelationurl="'. tally_url('polllist/getAllC4_zone') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="c4_zone_id" 
      data-rkeyfield="c4_zone_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_zone_id}" 
      data-relationformid="form_polllist" 
'); ?>
                        
    
                </div>

                <!-- /districtid  -->        
                         

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_polllist">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('polllist.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=tally_url('polllist/update');?>"
                                               data-datatable="table_polllist" data-jsname="polllist"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("polllist.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('polllist.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=tally_url('polllist/update');?>"
                                               data-datatable="table_polllist" data-jsname="polllist"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("polllist.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('polllist.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=tally_url('polllist/update');?>"
                        data-datatable="table_polllist"  data-jsname="polllist"
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
                        data-actionurl= "<?=tally_url('polllist/update');?>"
                        data-datatable="table_polllist"  data-jsname="polllist"
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
                <table id="table_polllist" class="table table-hover" width="100%" cellspacing="0" data-url="<?=tally_url('polllist/readPolllist/polllist');?>"></table>
            </div>





    </div>
</div>


<script src="<?= tally_url('polllist/langJS');?>"></script>

    <script src="<?= site_url('assets/tally/polllist/polllist.js');?>"></script> 

    


