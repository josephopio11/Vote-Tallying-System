<?php
$tableTitle = lang('c4_subscription._page_c4_subscription');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-compress"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = admin_url('c4_subscription/showForm/c4_subscription');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_subscription"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-compress"></i>
                                    <span><?=lang('c4_subscription._form_c4_subscription'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_c4_subscription" aria-controls="searchFormArea_c4_subscription" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_c4_subscription">
            <div class="card card-body border-light p-0">

<?php echo form_open(admin_url('c4_subscription/readC4_subscription/c4_subscription'), 'id="form_c4_subscription"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  company_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_company_id"> <?=lang('c4_subscription.company_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['company_id']))
                        {
                            $query_result =  getCompany(['company_id'=>$formData['company_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['company_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("company_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_company_id"
      data-ajax--url="'. admin_url('c4_subscription/getAllCompany') . '"
      data-getrelationurl="'. admin_url('c4_subscription/getAllCompany') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="company_id" 
      data-rkeyfield="company_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {company_id}" 
      data-relationformid="form_c4_subscription" 
'); ?>
                        
    
                </div>

                <!-- /company_id  -->        

                                <!--  subscription_status -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_subscription.subscription_status'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_subscription.list_subscription_status');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("subscription_status", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_c4_subscription">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  subscription_status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_subscription.subscription_status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_subscription/update');?>"
                                               data-datatable="table_c4_subscription" data-jsname="c4_subscription"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_subscription.subscription_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"subscription_status":"in_trial"}'><?=lang('c4_subscription.list_subscription_status')['in_trial'] ?? 'in_trial'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_subscription/update');?>"
                                               data-datatable="table_c4_subscription" data-jsname="c4_subscription"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_subscription.subscription_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"subscription_status":"trial_expired"}'><?=lang('c4_subscription.list_subscription_status')['trial_expired'] ?? 'trial_expired'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_subscription/update');?>"
                                               data-datatable="table_c4_subscription" data-jsname="c4_subscription"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_subscription.subscription_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"subscription_status":"in_subscribe"}'><?=lang('c4_subscription.list_subscription_status')['in_subscribe'] ?? 'in_subscribe'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_subscription/update');?>"
                                               data-datatable="table_c4_subscription" data-jsname="c4_subscription"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_subscription.subscription_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"subscription_status":"subscribe_expired"}'><?=lang('c4_subscription.list_subscription_status')['subscribe_expired'] ?? 'subscribe_expired'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=admin_url('c4_subscription/delete');?>"
                        data-datatable="table_c4_subscription" data-jsname="c4_subscription"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_deleted");?>"
                        data-processingtitle="<?=lang("home.deleted");?>" 
                        data-postdata='{"deleted_at":"1"}'
                        ><?= lang('home.delete'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>
             



                    

                </div>


            </div>

        </div>
        <!-- end: Batch Processing -->



            <div class="table-responsive">
                <table id="table_c4_subscription" class="table table-hover" width="100%" cellspacing="0" data-url="<?=admin_url('c4_subscription/readC4_subscription/c4_subscription');?>"></table>
            </div>





    </div>
</div>


<script src="<?= admin_url('c4_subscription/langJS');?>"></script>

    <script src="<?= site_url('assets/admin/c4_subscription/c4_subscription.js');?>"></script> 

    


