<?php

$url = voters_url('votes/save/votes');
$hiddenArray = [];

if( !empty($formData['id']) )
{
    $url .= '/' . $formData['id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="votes" autocomplete="off" role="presentation" data-pageslug="votes" data-formslug="votes"  data-jsname="votes" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,uisortable,dropzone" data-closeonsave="true" class="bg-white crud4form"';

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
      data-ajax--url="'. voters_url('votes/getAllC4_zone') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="c4_zone_id" data-getrelationurl="votes/getAllC4_zone"
      data-rkeyfield="c4_zone_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="districtid4143" data-newinputname="new_districtid""
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
      data-ajax--url="'. voters_url('votes/getAllCounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="countyid" data-getrelationurl="votes/getAllCounty"
      data-rkeyfield="countyid" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="countyid2642" data-newinputname="new_countyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {countyid}"    data-filter="districtid as zoneid"    data-tags="true" data-relationformid="county" 
'); ?>
                        
                                        <div data-createbutton="countyid2642" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=voters_url('county/showForm/county');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=voters_url('county/showForm/county');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="countyid2642"
                            data-relationformid="county"
                            data-formid="votes"
                            data-filter="districtid as zoneid"
                            data-action="openselect2modal">
                        <span>
                            <i class="fab fa-app-store"></i>
                            <span><?=lang('county._form_county');?></span>
                        </span>
                    </a>
                </div>
    
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
      data-ajax--url="'. voters_url('votes/getAllSubcounty') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="id" data-getrelationurl="votes/getAllSubcounty"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="subcountyid7930" data-newinputname="new_subcountyid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="countyid as countyid"    data-tags="true" data-relationformid="subcounty" 
'); ?>
                        
                                        <div data-createbutton="subcountyid7930" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=voters_url('subcounty/showForm/subcounty');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=voters_url('subcounty/showForm/subcounty');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="subcountyid7930"
                            data-relationformid="subcounty"
                            data-formid="votes"
                            data-filter="countyid as countyid"
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
      data-ajax--url="'. voters_url('votes/getAllParish') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="id" data-getrelationurl="votes/getAllParish"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="parishid1169" data-newinputname="new_parishid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="subcountyid as subcountyid"    data-tags="true" data-relationformid="parish" 
'); ?>
                        
                                        <div data-createbutton="parishid1169" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=voters_url('parish/showForm/parish');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=voters_url('parish/showForm/parish');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="parishid1169"
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
      data-ajax--url="'. voters_url('votes/getAllPollstat') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="votes"
      data-rprimarykey="id" data-getrelationurl="votes/getAllPollstat"
      data-rkeyfield="id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="pollstatid3937" data-newinputname="new_pollstatid""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {id}"    data-filter="parishid as parishid"    data-tags="true" data-relationformid="pollstat" 
'); ?>
                        
                                        <div data-createbutton="pollstatid3937" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=voters_url('pollstat/showForm/pollstat');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=voters_url('pollstat/showForm/pollstat');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="pollstatid3937"
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
                    $files = [];
                    $help_text = lang("votes.evidence"."_helpText");
                    if (!empty($formData['evidence']))
                    {
                        $fileService = \Voters\Config\Services::file();
                        $files = $fileService->getAllFile($formData['evidence']);
                            
                        if(!empty($files))
                        {
                            $help_text = '';
                        }
                    }
                ?>

                <div class="dropzone sortable" action="<?=voters_url("votes/uploadFile/votes/evidence");?>" 
                    data-maxfiles = "1" 
                    id="dropzone_evidence" 
                    data-fieldname="evidence"
                    data-inputname="evidence"
                    data-ismultiple="false"
                    data-tablename="votes"  
                    data-acceptedfiles="image/*"
                    data-message="<?=$help_text;?>">
                    
                    <?php
                        if(!empty($files))
                        {
                            foreach ($files as  $file):
                                $file_id = $file['file_id']; 
                                $file_name = $file['originalName'];
             
                                $thumb_url = $file['url_thumb'];
                                $file_full_url = $file['url_download'];

                                ?>
                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" data-id="<?php echo $file_id; ?>" id="<?php echo $file_id; ?>">  
                                    <div class="dz-image d-flex justify-content-center">
                                        <img data-dz-thumbnail="" alt="" src="<?php echo $thumb_url; ?>" class="float-left img-thumbnail" onerror="this.src='https://resources.crud4.com/v1/images/notfound.png'"/>
                                    </div>
                                    <div class="dz-progress">
                                        <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                    </div>
                                    <div class="dz-error-message">
                                        <span data-dz-errormessage=""></span>
                                    </div>
                                    
                                    <div class="dz-details">
                                        <div class="dz-size"><span data-dz-size=""><strong><?php echo $file['size']; ?></strong> MB</span></div>    
                                        <div class="dz-filename"><span data-dz-name=""><?php echo $file_name; ?></span></div>  
                                    </div>
                                    <div>    
                                        <div class="pt-1 align-middle text-center">
                                            <a href="<?=voters_url("votes/deleteFile/$file_id");?>" id="file_<?php echo $file_id; ?>" 
                                            
                                                data-action="apirequest"
                                                data-deleteline=".dz-preview"
                                                data-question="areyousure_deletefile"
                                                data-subtitle="can_not_be_undone"
                                                data-usehomelang="true"
                                                data-ajaxmethod="DELETE"
                                                data-fileid="<?php echo $file_id; ?>"
                                                data-datatable="table_votes"
                                                data-actionurl="<?=voters_url("votes/deleteFile/$file_id");?>" 
                                                title="Delete" 
                                                class="btn btn-secondary btn-sm" data-dz-remove><i class="fa fa-trash"></i>
                                            </a>

                                            <a href="<?php echo $file_full_url; ?>" download title="Download"  target="_blank" class="btn btn-warning btn-sm">
                                                <span><i class="fa fa-download"></i></span>
                                            </a>
                                        </div>
                                        <input type="hidden" name="evidence" value="<?=$file_id;?>"></input>        
                                              
                                                
                                     </div>                
                                </div>
                                <?php
                            endforeach;
                        }
                        else
                        {
                           echo form_hidden("evidence", '0');
                        }
                     ?>            
                </div>
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