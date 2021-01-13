<?php
$tableTitle = lang('c4_payment._page_c4_payment');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fab fa-amazon-pay"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = admin_url('c4_payment/showForm/c4_payment');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_payment"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fab fa-amazon-pay"></i>
                                    <span><?=lang('c4_payment._form_c4_payment'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_c4_payment" aria-controls="searchFormArea_c4_payment" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_c4_payment">
            <div class="card card-body border-light p-0">

<?php echo form_open(admin_url('c4_payment/readC4_payment/c4_payment'), 'id="form_c4_payment"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  c4_invoice_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_c4_invoice_id"> <?=lang('c4_payment.c4_invoice_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_invoice_id']))
                        {
                            $query_result =  getC4_invoice(['c4_invoice_id'=>$formData['c4_invoice_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_invoice_id'] =>  $query_result['description']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("c4_invoice_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_c4_invoice_id"
      data-ajax--url="'. admin_url('c4_payment/getAllC4_invoice') . '"
      data-getrelationurl="'. admin_url('c4_payment/getAllC4_invoice') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="c4_invoice_id" 
      data-rkeyfield="c4_invoice_id" data-rvaluefield="description" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{description}" data-selectedview="{description}"  data-titleview="ID: {c4_invoice_id}" 
      data-relationformid="form_c4_payment" 
'); ?>
                        
    
                </div>

                <!-- /c4_invoice_id  -->        
                                    
                <!--  c4_account_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_c4_account_id"> <?=lang('c4_payment.c4_account_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_account_id']))
                        {
                            $query_result =  getC4_account(['c4_account_id'=>$formData['c4_account_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_account_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("c4_account_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_c4_account_id"
      data-ajax--url="'. admin_url('c4_payment/getAllC4_account') . '"
      data-getrelationurl="'. admin_url('c4_payment/getAllC4_account') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="c4_account_id" 
      data-rkeyfield="c4_account_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_account_id}" 
      data-relationformid="form_c4_payment" 
'); ?>
                        
    
                </div>

                <!-- /c4_account_id  -->        

                                <!--  currency -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_payment.currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_payment.list_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

            
                                <!--  checkout_status -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_payment.checkout_status'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_payment.list_checkout_status');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("checkout_status", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_c4_payment">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_payment.currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_payment/update');?>"
                                               data-datatable="table_c4_payment" data-jsname="c4_payment"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_payment.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"TRY"}'><?=lang('c4_payment.list_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_payment/update');?>"
                                               data-datatable="table_c4_payment" data-jsname="c4_payment"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_payment.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"USD"}'><?=lang('c4_payment.list_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_payment/update');?>"
                                               data-datatable="table_c4_payment" data-jsname="c4_payment"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_payment.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"EUR"}'><?=lang('c4_payment.list_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_payment/update');?>"
                                               data-datatable="table_c4_payment" data-jsname="c4_payment"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_payment.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"GBP"}'><?=lang('c4_payment.list_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=admin_url('c4_payment/update');?>"
                        data-datatable="table_c4_payment"  data-jsname="c4_payment"
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
                        data-actionurl= "<?=admin_url('c4_payment/update');?>"
                        data-datatable="table_c4_payment"  data-jsname="c4_payment"
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
                <table id="table_c4_payment" class="table table-hover" width="100%" cellspacing="0" data-url="<?=admin_url('c4_payment/readC4_payment/c4_payment');?>"></table>
            </div>





    </div>
</div>


<script src="<?= admin_url('c4_payment/langJS');?>"></script>

    <script src="<?= site_url('assets/admin/c4_payment/c4_payment.js');?>"></script> 

    


