<?php

namespace Voters\Models;

use CodeIgniter\Model;

class C4_transaction_history_itemModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_transaction_history_item';
    protected $primaryKey     = 'c4_transaction_history_item_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_transaction_history_item_id","c4_transaction_id","eur_balance","gbp_balance","try_balance","usd_balance","created_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = '';
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
        
        if (function_exists('c4_transaction_history_item_beforeInsert'))
        {
            return c4_transaction_history_item_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_transaction_history_item_afterInsert'))
        {
            c4_transaction_history_item_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_transaction_history_item_beforeUpdate'))
        {
            return c4_transaction_history_item_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_transaction_history_item_afterUpdate'))
        {
            c4_transaction_history_item_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_transaction_history_item_beforeDelete'))
        {
            return c4_transaction_history_item_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_transaction_history_item_afterDelete'))
        {
            c4_transaction_history_item_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_transaction_history_item_afterFind'))
        {
            return c4_transaction_history_item_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}