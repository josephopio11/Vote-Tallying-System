<?php

$url = agents_url('votes/save/votes');
$hiddenArray = [];

if( !empty($formData['id']) )
{
    $url .= '/' . $formData['id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="votes" autocomplete="off" role="presentation" data-pageslug="votes" data-formslug="votes"  data-jsname="votes" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,uisortable,cropperjs" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "votes", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "votes", '', 'hidden');?> 
<?=form_input("id", $formData['id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-vote-yea"></i> <?=lang('votes._form_votes'); ?> </h5>
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

        <p class="groupTitle">Polling Station</p>

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_districtid">
            <label for="districtid" class="required col-form-label"> <?=lang('votes.districtid'); ?></label>
            
            
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
      data-ajax--url="'. agents_url('votes/getAllC4_zone') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="c4_zone_id" data-getrelationurl="votes/getAllC4_zone"
      data-rkeyfield="c4_zone_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="districtid5740" data-newinputname="new_districtid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_zone_id}"    data-filter="c4_country_id=219"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_countyid">
            <label for="countyid" class="required col-form-label"> <?=lang('votes.countyid'); ?></label>
            
            
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
      data-ajax--url="'. agents_url('votes/getAllCounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="countyid" data-getrelationurl="votes/getAllCounty"
      data-rkeyfield="countyid" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="countyid4556" data-newinputname="new_countyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {countyid}"    data-filter="districtid as zoneid"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_subcountyid">
            <label for="subcountyid" class="required col-form-label"> <?=lang('votes.subcountyid'); ?></label>
            
            
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
      data-ajax--url="'. agents_url('votes/getAllSubcounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="id" data-getrelationurl="votes/getAllSubcounty"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="subcountyid7277" data-newinputname="new_subcountyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="countyid as countyid"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_parishid">
            <label for="parishid" class="required col-form-label"> <?=lang('votes.parishid'); ?></label>
            
            
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
      data-ajax--url="'. agents_url('votes/getAllParish') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="id" data-getrelationurl="votes/getAllParish"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="parishid1964" data-newinputname="new_parishid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="subcountyid as subcountyid"    data-tags="true" data-relationformid="parish" 
'); ?>
                        
                                        <div data-createbutton="parishid1964" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=agents_url('parish/showForm/parish');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=agents_url('parish/showForm/parish');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="parishid1964"
                            data-relationformid="parish"
                            data-formid="votes"
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
            <label for="pollstatid" class="required col-form-label"> <?=lang('votes.pollstatid'); ?></label>
            
            
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
      data-ajax--url="'. agents_url('votes/getAllPollstat') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="id" data-getrelationurl="votes/getAllPollstat"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="pollstatid8937" data-newinputname="new_pollstatid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="parishid as parishid"    data-tags="true" data-relationformid="pollstat" 
'); ?>
                        
                                        <div data-createbutton="pollstatid8937" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=agents_url('pollstat/showForm/pollstat');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=agents_url('pollstat/showForm/pollstat');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="pollstatid8937"
                            data-relationformid="pollstat"
                            data-formid="votes"
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
        </div>
    </div>

    <p class="groupTitle">Votes</p>

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_candidate1">
            <label for="candidate1" class="required col-form-label"> <?=lang('votes.candidate1'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("candidate1", $formData['candidate1'] ?? '', '  id="candidate1" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_candidate2">
            <label for="candidate2" class="required col-form-label"> <?=lang('votes.candidate2'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("candidate2", $formData['candidate2'] ?? '', '  id="candidate2" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_candidate3">
            <label for="candidate3" class="required col-form-label"> <?=lang('votes.candidate3'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("candidate3", $formData['candidate3'] ?? '', '  id="candidate3" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_candidate4">
            <label for="candidate4" class="required col-form-label"> <?=lang('votes.candidate4'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("candidate4", $formData['candidate4'] ?? '', '  id="candidate4" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_validvotes">
            <label for="validvotes" class="required col-form-label"> <?=lang('votes.validvotes'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("validvotes", $formData['validvotes'] ?? '', '  id="validvotes" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    <small id="validvotes_helpText" class="form-text text-muted"><?=lang("votes.validvotes_helpText")?></small>

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_invalidvotes">
            <label for="invalidvotes" class="required col-form-label"> <?=lang('votes.invalidvotes'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("invalidvotes", $formData['invalidvotes'] ?? '', '  id="invalidvotes" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    <small id="invalidvotes_helpText" class="form-text text-muted"><?=lang("votes.invalidvotes_helpText")?></small>

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_totalvoters">
            <label for="totalvoters" class="required col-form-label"> <?=lang('votes.totalvoters'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("totalvoters", $formData['totalvoters'] ?? '', '  id="totalvoters" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    <small id="totalvoters_helpText" class="form-text text-muted"><?=lang("votes.totalvoters_helpText")?></small>

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_notvoted">
            <label for="notvoted" class="required col-form-label"> <?=lang('votes.notvoted'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("notvoted", $formData['notvoted'] ?? '', '  id="notvoted" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    <small id="notvoted_helpText" class="form-text text-muted"><?=lang("votes.notvoted_helpText")?></small>

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_totalballotiss">
            <label for="totalballotiss" class="required col-form-label"> <?=lang('votes.totalballotiss'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("totalballotiss", $formData['totalballotiss'] ?? '', '  id="totalballotiss" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    <small id="totalballotiss_helpText" class="form-text text-muted"><?=lang("votes.totalballotiss_helpText")?></small>

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_totalballotuse">
            <label for="totalballotuse" class="required col-form-label"> <?=lang('votes.totalballotuse'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("totalballotuse", $formData['totalballotuse'] ?? '', '  id="totalballotuse" class="form-control" required maxlength="11" ', 'number'); 
                        ?>
                        
                    </div>
                    <small id="totalballotuse_helpText" class="form-text text-muted"><?=lang("votes.totalballotuse_helpText")?></small>

        </div>
        </div>
    </div>

    <p class="groupTitle">Evidence</p>

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_evidence">
            <label for="evidence" class="required col-form-label"><i class="fas fa-file-image"></i>  <?=lang('votes.evidence'); ?></label>
            
            
<div class="input-group">
    <?php
    $def = resources_url('images/empty.png');
    $randomID = rand(10000, 99999);

    if (!empty($formData['evidence']))
    {
        $fileService = \Agents\Config\Services::file();
        $file = $fileService->getFile($formData['evidence']);

        if (!empty($file))
        {
            // $def = getThumbFromData($file);
            $def = $file['url_thumb'];
        }
    }

    ?>

    <label class="label labelcropper" data-toggle="tooltip" title="<?=lang("votes.evidence_helpText")?>" style="cursor: pointer;">
        <img class="rounded cropper_img img-thumbnail float-left" id="cropper_img_<?=$randomID;?>" src="<?=$def;?>" alt="avatar" style="max-width: 90px;"/>
        <input type="file" name="file" accept="image/*" class="sr-only cropperjs" id="input_<?=$randomID;?>" 
            data-action="<?=agents_url("votes/uploadFile/votes/evidence");?>" data-inputname="evidence" data-idnumber="<?=$randomID;?>" 
            data-isrounded="" data-maxw="2048" data-maxh="2048" 
           data-minw="220" data-minh="220" data-fixedcropbox="">
    </label>
   
    <?php echo form_input("evidence", $formData['evidence'] ?? '', '', 'hidden'); ?>

</div>

<div class="progress cropper_progress" id="progress_<?=$randomID;?>" style="display:none">
    <div id="progressbar_<?=$randomID;?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
</div>

        </div>

         <div class="form-group" id="groupField_userid">
            <label for="userid" class="required col-form-label"> <?=lang('votes.userid'); ?></label>
            
                                <?php
                        $query_result =  getAllUsers();

                        if(!empty($query_result)){
                            $query_result = array_column($query_result, 'firstname', 'user_id');
                             
                        }
                        else{
                            $query_result = [''=>lang('home.no_record')];
                        }
                    ?>

                    <div class="input-group">
                        
                        <?php echo form_dropdown("userid", $query_result, $formData['userid'] ?? '', ' id="userid" class="form-control selectpicker" required maxlength="11" '); ?>
                        
                    </div>
                    <small id="userid_helpText" class="form-text text-muted"><?=lang("votes.userid_helpText")?></small>

        </div>
        </div>
    </div>

















</div>

<div class="modal-footer">
    
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('home.dismiss');?></button>
    <button type="submit" class="btn btn-primary"><?=lang('home.save');?></button>
</div>

<?php echo form_close(); ?>