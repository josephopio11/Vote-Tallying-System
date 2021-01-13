<?php

$url = admin_url('c4_log/save/c4_log');
$hiddenArray = [];

if( !empty($formData['c4_log_id']) )
{
    $url .= '/' . $formData['c4_log_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_log" autocomplete="off" role="presentation" data-pageslug="c4_log" data-formslug="c4_log"  data-jsname="c4_log" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_log", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_log", '', 'hidden');?> 
<?=form_input("c4_log_id", $formData['c4_log_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fab fa-blogger"></i> <?=lang('c4_log._form_c4_log'); ?> </h5>
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

         <div class="form-group" id="groupField_level">
            <label for="level" class="required col-form-label"> <?=lang('c4_log.level'); ?></label>
            
            
                <?php 
                    $lang_options = lang('c4_log.list_level');
                    $p_array = isset($formData['level']) ? explode(',', $formData['level']) : [];
                        
                    if(!isset($formData['level'])){
                        $p_array = [];
                    }
                ?>
                <div class="">
                    <div class="form-check form-check-inline mt-2 mb-1" for="leveldebug">
                        <?=form_radio("level", 'debug', in_array('debug', $p_array), 'id="leveldebug"  class="form-check-input" ');?>
                        <label class="form-check-label" for="leveldebug"><?=$lang_options['debug'] ?? 'debug';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="levelinfo">
                        <?=form_radio("level", 'info', in_array('info', $p_array), 'id="levelinfo"  class="form-check-input" ');?>
                        <label class="form-check-label" for="levelinfo"><?=$lang_options['info'] ?? 'info';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="levelnotice">
                        <?=form_radio("level", 'notice', in_array('notice', $p_array), 'id="levelnotice"  class="form-check-input" ');?>
                        <label class="form-check-label" for="levelnotice"><?=$lang_options['notice'] ?? 'notice';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="levelwarning">
                        <?=form_radio("level", 'warning', in_array('warning', $p_array), 'id="levelwarning"  class="form-check-input" ');?>
                        <label class="form-check-label" for="levelwarning"><?=$lang_options['warning'] ?? 'warning';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="levelerror">
                        <?=form_radio("level", 'error', in_array('error', $p_array), 'id="levelerror"  class="form-check-input" ');?>
                        <label class="form-check-label" for="levelerror"><?=$lang_options['error'] ?? 'error';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="levelcritical">
                        <?=form_radio("level", 'critical', in_array('critical', $p_array), 'id="levelcritical"  class="form-check-input" ');?>
                        <label class="form-check-label" for="levelcritical"><?=$lang_options['critical'] ?? 'critical';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="levelalert">
                        <?=form_radio("level", 'alert', in_array('alert', $p_array), 'id="levelalert"  class="form-check-input" ');?>
                        <label class="form-check-label" for="levelalert"><?=$lang_options['alert'] ?? 'alert';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="levelemergency">
                        <?=form_radio("level", 'emergency', in_array('emergency', $p_array), 'id="levelemergency"  class="form-check-input" ');?>
                        <label class="form-check-label" for="levelemergency"><?=$lang_options['emergency'] ?? 'emergency';?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_message">
            <label for="message" class="required col-form-label"> <?=lang('c4_log.message'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"message", 'rows' => '3'], $formData['message'] ?? '', ' id="message" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_ip">
            <label for="ip" class="permit_empty col-form-label"> <?=lang('c4_log.ip'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("ip", $formData['ip'] ?? '', '  id="ip" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_userAgent">
            <label for="userAgent" class="permit_empty col-form-label"> <?=lang('c4_log.userAgent'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("userAgent", $formData['userAgent'] ?? '', '  id="userAgent" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_uri">
            <label for="uri" class="permit_empty col-form-label"> <?=lang('c4_log.uri'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("uri", $formData['uri'] ?? '', '  id="uri" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_session">
            <label for="session" class="permit_empty col-form-label"> <?=lang('c4_log.session'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"session", 'rows' => '3'], $formData['session'] ?? '', ' id="session" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_get">
            <label for="get" class="permit_empty col-form-label"> <?=lang('c4_log.get'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("get", $formData['get'] ?? '', '  id="get" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_post">
            <label for="post" class="permit_empty col-form-label"> <?=lang('c4_log.post'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"post", 'rows' => '3'], $formData['post'] ?? '', ' id="post" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
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