<?php

$url = agents_url('polllist/save/polllist');
$hiddenArray = [];

if( !empty($formData['id']) )
{
    $url .= '/' . $formData['id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="polllist" autocomplete="off" role="presentation" data-pageslug="polllist" data-formslug="polllist"  data-jsname="polllist" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "polllist", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "polllist", '', 'hidden');?> 
<?=form_input("id", $formData['id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-barcode"></i> <?=lang('polllist._form_polllist'); ?> </h5>
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

         <div class="form-group" id="groupField_districtid">
            <label for="districtid" class="required col-form-label"> <?=lang('polllist.districtid'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['districtid']))
                        {
                            $query_result =  getC4_zone(['c4_zone_id'=>$formData['districtid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_zone_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("districtid", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. agents_url('polllist/getAllC4_zone') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="polllist"
      data-rprimarykey="c4_zone_id" data-getrelationurl="polllist/getAllC4_zone"
      data-rkeyfield="c4_zone_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="districtid5874" data-newinputname="new_districtid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_zone_id}"    data-filter="c4_country_id=219"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_countyid">
            <label for="countyid" class="required col-form-label"> <?=lang('polllist.countyid'); ?></label>
            
            
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
      data-ajax--url="'. agents_url('polllist/getAllCounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="polllist"
      data-rprimarykey="countyid" data-getrelationurl="polllist/getAllCounty"
      data-rkeyfield="countyid" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="countyid9504" data-newinputname="new_countyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {countyid}"    data-filter="districtid as zoneid"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_subcountyid">
            <label for="subcountyid" class="required col-form-label"> <?=lang('polllist.subcountyid'); ?></label>
            
            
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
      data-ajax--url="'. agents_url('polllist/getAllSubcounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="polllist"
      data-rprimarykey="id" data-getrelationurl="polllist/getAllSubcounty"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="subcountyid1384" data-newinputname="new_subcountyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="countyid as countyid"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_parishid">
            <label for="parishid" class="required col-form-label"> <?=lang('polllist.parishid'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['parishid']))
                        {
                            $query_result =  getParish(['id'=>$formData['parishid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("parishid", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. agents_url('polllist/getAllParish') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="polllist"
      data-rprimarykey="id" data-getrelationurl="polllist/getAllParish"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="parishid9492" data-newinputname="new_parishid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="subcountyid as subcountyid"    data-tags="true" data-relationformid="parish" 
'); ?>
                        
                                        <div data-createbutton="parishid9492" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=agents_url('parish/showForm/parish');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=agents_url('parish/showForm/parish');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="parishid9492"
                            data-relationformid="parish"
                            data-formid="polllist"
                            data-filter="subcountyid as subcountyid"
                            data-action="openselect2modal">
                        <span>
                            <i class="fas fa-archway"></i>
                            <span><?=lang('parish._form_parish');?></span>
                        </span>
                    </a>
                </div>
    
                    </div>

                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_pollstatid">
            <label for="pollstatid" class="required col-form-label"> <?=lang('polllist.pollstatid'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['pollstatid']))
                        {
                            $query_result =  getPollstat(['id'=>$formData['pollstatid']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("pollstatid", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. agents_url('polllist/getAllPollstat') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="polllist"
      data-rprimarykey="id" data-getrelationurl="polllist/getAllPollstat"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="pollstatid3949" data-newinputname="new_pollstatid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="parishid as parishid"    data-tags="true" data-relationformid="pollstat" 
'); ?>
                        
                                        <div data-createbutton="pollstatid3949" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=agents_url('pollstat/showForm/pollstat');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=agents_url('pollstat/showForm/pollstat');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="pollstatid3949"
                            data-relationformid="pollstat"
                            data-formid="polllist"
                            data-filter="parishid as parishid"
                            data-action="openselect2modal">
                        <span>
                            <i class="fab fa-markdown"></i>
                            <span><?=lang('pollstat._form_pollstat');?></span>
                        </span>
                    </a>
                </div>
    
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_comment">
            <label for="comment" class="permit_empty col-form-label"> <?=lang('polllist.comment'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"comment", 'rows' => '3'], $formData['comment'] ?? '', ' id="comment" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
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