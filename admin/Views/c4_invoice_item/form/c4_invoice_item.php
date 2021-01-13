<?php

$url = admin_url('c4_invoice_item/save/c4_invoice_item');
$hiddenArray = [];

if( !empty($formData['c4_invoice_item_id']) )
{
    $url .= '/' . $formData['c4_invoice_item_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_invoice_item" autocomplete="off" role="presentation" data-pageslug="c4_invoice_item" data-formslug="c4_invoice_item"  data-jsname="c4_invoice_item" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,input_number,INVOICE_ITEM_CALCULATION" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_invoice_item", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_invoice_item", '', 'hidden');?> 
<?=form_input("c4_invoice_item_id", $formData['c4_invoice_item_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-file-invoice-dollar"></i> <?=lang('c4_invoice_item._form_c4_invoice_item'); ?> </h5>
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

         <div class="form-group" id="groupField_c4_invoice_id">
            <label for="c4_invoice_id" class="required col-form-label"> <?=lang('c4_invoice_item.c4_invoice_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_invoice_id']))
                        {
                            $query_result =  getC4_invoice(['c4_invoice_id'=>$formData['c4_invoice_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_invoice_id'] =>  $query_result['description']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("c4_invoice_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. admin_url('c4_invoice_item/getAllC4_invoice') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="c4_invoice_item"
      data-rprimarykey="c4_invoice_id" data-getrelationurl="c4_invoice_item/getAllC4_invoice"
      data-rkeyfield="c4_invoice_id" data-rvaluefield="description" data-rvaluefield2=""
      data-required ="required" id="c4_invoice_id8630" data-newinputname="new_c4_invoice_id""
      data-optionview="{description}" data-selectedview="{description}"  data-titleview="ID: {c4_invoice_id}"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('c4_invoice_item.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_unit_price">
            <label for="unit_price" class="required col-form-label"> <?=lang('c4_invoice_item.unit_price'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("unit_price", $formData['unit_price'] ?? '', ' id="unit_price" class="form-control input_number INVOICE_ITEM_CALCULATION" required maxlength="15"  data-unit_price_field="unit_price"  data-quantity_field="quantity"  data-vat_rate_field="vat_rate"  data-discount_value_field="discount_value"  data-discount_type_field="discount_type"  data-excise_duty_value_field="excise_duty_value"  data-excise_duty_type_field="excise_duty_type"  data-communications_tax_value_field="communications_tax_value"  data-communications_tax_type_field="communications_tax_type"  data-net_total_field="net_total" ', 'text'); 
                        ?>
                        
                    </div>
                    
        
                     

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_quantity">
            <label for="quantity" class="required col-form-label"> <?=lang('c4_invoice_item.quantity'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("quantity", $formData['quantity'] ?? '1.0000', ' id="quantity" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_vat_rate">
            <label for="vat_rate" class="required col-form-label"> <?=lang('c4_invoice_item.vat_rate'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_dropdown("vat_rate", lang('c4_invoice_item.list_vat_rate'), $formData['vat_rate'] ?? '18', '  id="vat_rate" class="form-control" required maxlength="15" '); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_net_total">
            <label for="net_total" class="required col-form-label"> <?=lang('c4_invoice_item.net_total'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("net_total", $formData['net_total'] ?? '', ' id="net_total" class="form-control input_number" required maxlength="15" ', 'text'); 
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