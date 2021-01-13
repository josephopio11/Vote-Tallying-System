<?php

namespace Agents\Models;

use CodeIgniter\Model;

class C4_paymentModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_payment';
    protected $primaryKey     = 'c4_payment_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_payment_id","c4_invoice_id","c4_account_id","order_ref","date","amount","currency","payment_method","json_data","checkout_status","response_status","response_id","response_data","notes","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_payment_beforeInsert'))
        {
            return c4_payment_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_payment_afterInsert'))
        {
            c4_payment_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_payment_beforeUpdate'))
        {
            return c4_payment_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_payment_afterUpdate'))
        {
            c4_payment_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_payment_beforeDelete'))
        {
            return c4_payment_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_payment_afterDelete'))
        {
            c4_payment_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_payment_afterFind'))
        {
            return c4_payment_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}