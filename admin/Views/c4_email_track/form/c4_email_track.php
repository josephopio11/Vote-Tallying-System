<?php

$url = admin_url('c4_email_track/save/c4_email_track');
$hiddenArray = [];

if( !empty($formData['c4_email_track_id']) )
{
    $url .= '/' . $formData['c4_email_track_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_email_track" autocomplete="off" role="presentation" data-pageslug="c4_email_track" data-formslug="c4_email_track"  data-jsname="c4_email_track" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_email_track", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_email_track", '', 'hidden');?> 
<?=form_input("c4_email_track_id", $formData['c4_email_track_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-envelope-open-text"></i> <?=lang('c4_email_track._form_c4_email_track'); ?> </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">


    <div class="alert alert-danger alert-dismissible formAlert d-none" role="alert" >
        <div class=""><span class="sr-only">Errors...</span></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

        

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_c4_email_history_id">
            <label for="c4_email_history_id" class="required col-form-label"> <?=lang('c4_email_track.c4_email_history_id'); ?></label>
            
            
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
                    <div class="input-group">
                        
                        <?php echo form_dropdown("c4_email_history_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. admin_url('c4_email_track/getAllC4_email_history') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="c4_email_track"
      data-rprimarykey="c4_email_history_id" data-getrelationurl="c4_email_track/getAllC4_email_history"
      data-rkeyfield="c4_email_history_id" data-rvaluefield="cid" data-rvaluefield2=""
      data-required ="required" id="c4_email_history_id1553" data-newinputname="new_c4_email_history_id""
      data-optionview="{cid}" data-selectedview="{cid}"  data-titleview="ID: {c4_email_history_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_browser">
            <label for="browser" class="required col-form-label"> <?=lang('c4_email_track.browser'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("browser", $formData['browser'] ?? '', '  id="browser" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_ip">
            <label for="ip" class="required col-form-label"> <?=lang('c4_email_track.ip'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("ip", $formData['ip'] ?? '', '  id="ip" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

















</div>

<div class="modal-footer">
    
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('home.dismiss');?></button>
    <button type="submit" class="btn btn-primary"><?=lang('home.save');?></button>
</div>

<?php echo form_close(); ?>