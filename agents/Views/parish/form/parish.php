<?php

$url = agents_url('parish/save/parish');
$hiddenArray = [];

if( !empty($formData['id']) )
{
    $url .= '/' . $formData['id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="parish" autocomplete="off" role="presentation" data-pageslug="parish" data-formslug="parish"  data-jsname="parish" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "parish", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "parish", '', 'hidden');?> 
<?=form_input("id", $formData['id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-dolly-flatbed"></i> <?=lang('parish._form_parish'); ?> </h5>
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

         <div class="form-group" id="groupField_subcountyid">
            <label for="subcountyid" class="required col-form-label"> <?=lang('parish.subcountyid'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['subcountyid']))
                        {
                            $query_result =  getSubcounty(['id'=>$formData['subcountyid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("subcountyid", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. agents_url('parish/getAllSubcounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="parish"
      data-rprimarykey="id" data-getrelationurl="parish/getAllSubcounty"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="subcountyid3436" data-newinputname="new_subcountyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-tags="true" data-relationformid="subcounty" 
'); ?>
                        
                                        <div data-createbutton="subcountyid3436" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=agents_url('subcounty/showForm/subcounty');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=agents_url('subcounty/showForm/subcounty');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="subcountyid3436"
                            data-relationformid="subcounty"
                            data-formid="parish"
                            data-filter=""
                            data-action="openselect2modal">
                        <span>
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?=lang('subcounty._form_subcounty');?></span>
                        </span>
                    </a>
                </div>
    
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('parish.name'); ?></label>
            
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