<?php
$tableTitle = lang('user._page_user');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="far fa-user"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = admin_url('user/showForm/user');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_user"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="far fa-user"></i>
                                    <span><?=lang('user._form_user'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
                <li class="nav-item">
                    <a href="<?php echo admin_url('user/showchart/user_statistic'); ?>"
                       class="nav-link btn btn-sm btn-primary mr-1 mr-1">
                        <span>
                            <i class="fas fa-chart-line"></i>
                            <span><?= lang("user._chart_user_statistic") ?></span>
                        </span>
                    </a>
                </li>

    
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_user" aria-controls="searchFormArea_user" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">

    <!--  Start Card Row -->
    <div class="row">

    </div>
    <!--  End Card Row -->

        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_user">
            <div class="card card-body border-light p-0">

<?php echo form_open(admin_url('user/readUser/user'), 'id="form_user"'); ?>
                
                
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
                    <label for="search_company_id"> <?=lang('user.company_id'); ?></label>
                
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
      data-ajax--url="'. admin_url('user/getAllCompany') . '"
      data-getrelationurl="'. admin_url('user/getAllCompany') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="company_id" 
      data-rkeyfield="company_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {company_id}" 
      data-relationformid="form_user" 
'); ?>
                        
    
                </div>

                <!-- /company_id  -->        
                         

                    
                        <!--  General Search -->           
                        <div class="form-group col-md-2">
                            <label><?php echo lang('home.general_search'); ?></label>
    
                        <?php $searchText = lang("user.email"). ', ' .lang("user.phone"); ?>

                            <input type="search"  name="filterSearch" class="form-control generalSearch" placeholder="<?= $searchText; ?>" />

                        </div>


                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_user">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('user.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('user/update');?>"
                                               data-datatable="table_user" data-jsname="user"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("user.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('user.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('user/update');?>"
                                               data-datatable="table_user" data-jsname="user"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("user.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('user.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=admin_url('user/update');?>"
                        data-datatable="table_user"  data-jsname="user"
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
                        data-actionurl= "<?=admin_url('user/update');?>"
                        data-datatable="table_user"  data-jsname="user"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_restored");?>"
                        data-processingtitle="<?=lang("home.restoring");?>" 
                        data-postdata='{"deleted_at":"0"}'
                        ><?= lang('home.restore'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>
             



                    
                    <div class="btn-group btn-group-sm ml-2"  role="group">            
                        <a href="#" 
                            data-modalsize="lg" 
                            data-datatable="table_user" 
                            data-modalurl="<?=admin_url('home/showForm/email');?>" 
                            data-modaldata='{"type":"multiple", "table_name":"user", "email_field":"email", "datatable":"table_user", "jsname":"user"}' 
                            data-action="openformmodal" 
                            class="btn btn-sm btn-primary"> <i class="fas fa-envelope-open-text"></i> Multi Emailing <span class="badge badge-light selectedCount">0</span> (<?=lang("user.email");?>)
                        </a>
                    </div>                    


                </div>


            </div>

        </div>
        <!-- end: Batch Processing -->



            <div class="table-responsive">
                <table id="table_user" class="table table-hover" width="100%" cellspacing="0" data-url="<?=admin_url('user/readUser/user');?>"></table>
            </div>





    </div>
</div>


<script src="<?= admin_url('user/langJS');?>"></script>

    <script src="<?= site_url('assets/admin/user/user.js');?>"></script> 

    


