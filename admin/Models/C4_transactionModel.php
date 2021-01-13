<?php

namespace Admin\Models;

use CodeIgniter\Model;

class C4_transactionModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_transaction';
    protected $primaryKey     = 'c4_transaction_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_transaction_id","c4_account_id","c4_payment_id","transaction_type","description","debit_amount","debit_currency","credit_amount","credit_currency","date","created_at","updated_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = '';
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
        
        if (function_exists('c4_transaction_beforeInsert'))
        {
            return c4_transaction_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_transaction_afterInsert'))
        {
            c4_transaction_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_transaction_beforeUpdate'))
        {
            return c4_transaction_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_transaction_afterUpdate'))
        {
            c4_transaction_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_transaction_beforeDelete'))
        {
            return c4_transaction_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_transaction_afterDelete'))
        {
            c4_transaction_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_transaction_afterFind'))
        {
            return c4_transaction_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}