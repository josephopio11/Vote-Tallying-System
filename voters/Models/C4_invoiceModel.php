<?php

namespace Voters\Models;

use CodeIgniter\Model;

class C4_invoiceModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_invoice';
    protected $primaryKey     = 'c4_invoice_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_invoice_id","contact_id","invoice_type","description","invoice_status","invoice_series","invoice_number","issue_date","due_date","json_data","gross_total","total_vat","total_excise_duty","total_discount","total_communications_tax","net_total","total_paid","remaining","currency","invoice_discount_type","invoice_discount_value","invoice_discount_amount","withholding_rate","withholding_amount","vat_withholding_rate","vat_withholding_amount","is_archived","has_items","files","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_invoice_beforeInsert'))
        {
            return c4_invoice_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_invoice_afterInsert'))
        {
            c4_invoice_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_invoice_beforeUpdate'))
        {
            return c4_invoice_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_invoice_afterUpdate'))
        {
            c4_invoice_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_invoice_beforeDelete'))
        {
            return c4_invoice_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_invoice_afterDelete'))
        {
            c4_invoice_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_invoice_afterFind'))
        {
            return c4_invoice_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}