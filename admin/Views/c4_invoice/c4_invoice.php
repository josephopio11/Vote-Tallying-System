<?php
$tableTitle = lang('c4_invoice._page_c4_invoice');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-file-invoice"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = admin_url('c4_invoice/showForm/c4_invoice');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_invoice"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-file-invoice"></i>
                                    <span><?=lang('c4_invoice._form_c4_invoice'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_c4_invoice" aria-controls="searchFormArea_c4_invoice" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_c4_invoice">
            <div class="card card-body border-light p-0">

<?php echo form_open(admin_url('c4_invoice/readC4_invoice/c4_invoice'), 'id="form_c4_invoice"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">

                                <!--  currency -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_invoice.currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_invoice.list_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_c4_invoice">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  invoice_status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.invoice_status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"DRAFT"}'><?=lang('c4_invoice.list_invoice_status')['DRAFT'] ?? 'DRAFT'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"SENT"}'><?=lang('c4_invoice.list_invoice_status')['SENT'] ?? 'SENT'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PAID"}'><?=lang('c4_invoice.list_invoice_status')['PAID'] ?? 'PAID'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"CANCELLED"}'><?=lang('c4_invoice.list_invoice_status')['CANCELLED'] ?? 'CANCELLED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"REFUNDED"}'><?=lang('c4_invoice.list_invoice_status')['REFUNDED'] ?? 'REFUNDED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PARTIALLY_PAID"}'><?=lang('c4_invoice.list_invoice_status')['PARTIALLY_PAID'] ?? 'PARTIALLY_PAID'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PARTIALLY_REFUNDED"}'><?=lang('c4_invoice.list_invoice_status')['PARTIALLY_REFUNDED'] ?? 'PARTIALLY_REFUNDED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"MARKED_AS_REFUNDED"}'><?=lang('c4_invoice.list_invoice_status')['MARKED_AS_REFUNDED'] ?? 'MARKED_AS_REFUNDED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"UNPAID"}'><?=lang('c4_invoice.list_invoice_status')['UNPAID'] ?? 'UNPAID'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PAYMENT_PENDING"}'><?=lang('c4_invoice.list_invoice_status')['PAYMENT_PENDING'] ?? 'PAYMENT_PENDING'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"TRY"}'><?=lang('c4_invoice.list_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"USD"}'><?=lang('c4_invoice.list_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"EUR"}'><?=lang('c4_invoice.list_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"GBP"}'><?=lang('c4_invoice.list_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  invoice_discount_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.invoice_discount_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_discount_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_discount_type":"percentage"}'><?=lang('c4_invoice.list_invoice_discount_type')['percentage'] ?? 'percentage'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_discount_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_discount_type":"amount"}'><?=lang('c4_invoice.list_invoice_discount_type')['amount'] ?? 'amount'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  invoice_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.invoice_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_type":"sales_invoice"}'><?=lang('c4_invoice.list_invoice_type')['sales_invoice'] ?? 'sales_invoice'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                                               data-datatable="table_c4_invoice" data-jsname="c4_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_type":"purchase_bill"}'><?=lang('c4_invoice.list_invoice_type')['purchase_bill'] ?? 'purchase_bill'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                        data-datatable="table_c4_invoice"  data-jsname="c4_invoice"
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
                        data-actionurl= "<?=admin_url('c4_invoice/update');?>"
                        data-datatable="table_c4_invoice"  data-jsname="c4_invoice"
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
                <table id="table_c4_invoice" class="table table-hover" width="100%" cellspacing="0" data-url="<?=admin_url('c4_invoice/readC4_invoice/c4_invoice');?>"></table>
            </div>





    </div>
</div>


<script src="<?= admin_url('c4_invoice/langJS');?>"></script>

    <script src="<?= site_url('assets/admin/c4_invoice/c4_invoice.js');?>"></script> 

    



            <script src="<?= admin_url('c4_invoice_item/langJS'); ?>"></script>

            
            <script src="<?= admin_url('c4_payment/langJS'); ?>"></script>

            