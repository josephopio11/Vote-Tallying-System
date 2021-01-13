<?php

$url = admin_url('c4_zone/save/c4_zone');
$hiddenArray = [];

if( !empty($formData['c4_zone_id']) )
{
    $url .= '/' . $formData['c4_zone_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_zone" autocomplete="off" role="presentation" data-pageslug="c4_zone" data-formslug="c4_zone"  data-jsname="c4_zone" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_zone", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_zone", '', 'hidden');?> 
<?=form_input("c4_zone_id", $formData['c4_zone_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-map-marker"></i> <?=lang('c4_zone._form_c4_zone'); ?> </h5>
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

         <div class="form-group" id="groupField_c4_country_id">
            <label for="c4_country_id" class="required col-form-label"> <?=lang('c4_zone.c4_country_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_country_id']))
                        {
                            $query_result =  getC4_country(['c4_country_id'=>$formData['c4_country_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_country_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("c4_country_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. admin_url('c4_zone/getAllC4_country') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="c4_zone"
      data-rprimarykey="c4_country_id" data-getrelationurl="c4_zone/getAllC4_country"
      data-rkeyfield="c4_country_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="c4_country_id7376" data-newinputname="new_c4_country_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_country_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('c4_zone.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="128" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_code">
            <label for="code" class="required col-form-label"> <?=lang('c4_zone.code'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("code", $formData['code'] ?? '', '  id="code" class="form-control" required maxlength="32" ', 'text'); 
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