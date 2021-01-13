<?php

namespace Voters\Models;

use CodeIgniter\Model;

class C4_invoice_itemModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_invoice_item';
    protected $primaryKey     = 'c4_invoice_item_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_invoice_item_id","c4_invoice_id","product_id","name","quantity","unit_price","currency","vat_rate","discount_type","discount_value","excise_duty_type","excise_duty_value","communications_tax_type","communications_tax_value","net_total","description","unit_of_measure","status","created_at","updated_at","deleted_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeDelete   = ['beforeDelete'];
    protected $afterDelete    = ['afterDelete'];
    protected $afterFind      = ['afterFind'];

    //--------------------------------------------------------------------

    /**
     * Return DB fields which ones are allowed
     * @return array
     */
    public function getAllowedFields(): array
    {

        return $this->allowedFields;
    }

    //--------------------------------------------------------------------

    protected function beforeInsert(array $data)
    {
        
        if (function_exists('c4_invoice_item_beforeInsert'))
        {
            return c4_invoice_item_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_invoice_item_afterInsert'))
        {
            c4_invoice_item_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_invoice_item_beforeUpdate'))
        {
            return c4_invoice_item_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_invoice_item_afterUpdate'))
        {
            c4_invoice_item_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_invoice_item_beforeDelete'))
        {
            return c4_invoice_item_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_invoice_item_afterDelete'))
        {
            c4_invoice_item_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_invoice_item_afterFind'))
        {
            return c4_invoice_item_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}