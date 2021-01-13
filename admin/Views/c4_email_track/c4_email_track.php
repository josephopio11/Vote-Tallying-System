<?php
$tableTitle = lang('c4_email_track._page_c4_email_track');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-envelope-open-text"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = admin_url('c4_email_track/showForm/c4_email_track');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_email_track"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-envelope-open-text"></i>
                                    <span><?=lang('c4_email_track._form_c4_email_track'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_c4_email_track" aria-controls="searchFormArea_c4_email_track" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_c4_email_track">
            <div class="card card-body border-light p-0">

<?php echo form_open(admin_url('c4_email_track/readC4_email_track/c4_email_track'), 'id="form_c4_email_track"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  c4_email_history_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_c4_email_history_id"> <?=lang('c4_email_track.c4_email_history_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_email_history_id']))
                        {
                            $query_result =  getC4_email_history(['c4_email_history_id'=>$formData['c4_email_history_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_email_history_id'] =>  $query_result['cid']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("c4_email_history_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_c4_email_history_id"
      data-ajax--url="'. admin_url('c4_email_track/getAllC4_email_history') . '"
      data-getrelationurl="'. admin_url('c4_email_track/getAllC4_email_history') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="c4_email_history_id" 
      data-rkeyfield="c4_email_history_id" data-rvaluefield="cid" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{cid}" data-selectedview="{cid}"  data-titleview="ID: {c4_email_history_id}" 
      data-relationformid="form_c4_email_track" 
'); ?>
                        
    
                </div>

                <!-- /c4_email_history_id  -->        
                         

                    
                        <!--  General Search -->           
                        <div class="form-group col-md-2">
                            <label><?php echo lang('home.general_search'); ?></label>
    
                        <?php $searchText = lang("c4_email_track.ip"); ?>

                            <input type="search"  name="filterSearch" class="form-control generalSearch" placeholder="<?= $searchText; ?>" />

                        </div>


                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_c4_email_track">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                 



                    

                </div>


            </div>

        </div>
        <!-- end: Batch Processing -->



            <div class="table-responsive">
                <table id="table_c4_email_track" class="table table-hover" width="100%" cellspacing="0" data-url="<?=admin_url('c4_email_track/readC4_email_track/c4_email_track');?>"></table>
            </div>





    </div>
</div>


<script src="<?= admin_url('c4_email_track/langJS');?>"></script>

    <script src="<?= site_url('assets/admin/c4_email_track/c4_email_track.js');?>"></script> 

    


