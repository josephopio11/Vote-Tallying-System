<?php

$url = voters_url('subcounty/save/subcounty');
$hiddenArray = [];

if( !empty($formData['id']) )
{
    $url .= '/' . $formData['id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="subcounty" autocomplete="off" role="presentation" data-pageslug="subcounty" data-formslug="subcounty"  data-jsname="subcounty" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "subcounty", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "subcounty", '', 'hidden');?> 
<?=form_input("id", $formData['id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-map-marker-alt"></i> <?=lang('subcounty._form_subcounty'); ?> </h5>
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

         <div class="form-group" id="groupField_countyid">
            <label for="countyid" class="required col-form-label"> <?=lang('subcounty.countyid'); ?></label>
            
            
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
                    <div class="input-group">
                        
                        <?php echo form_dropdown("countyid", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. voters_url('subcounty/getAllCounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="subcounty"
      data-rprimarykey="countyid" data-getrelationurl="subcounty/getAllCounty"
      data-rkeyfield="countyid" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="countyid6071" data-newinputname="new_countyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {countyid}"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('subcounty.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="25" ', 'text'); 
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