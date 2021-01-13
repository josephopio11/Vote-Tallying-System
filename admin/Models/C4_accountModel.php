<?php

namespace Admin\Models;

use CodeIgniter\Model;

class C4_accountModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_account';
    protected $primaryKey     = 'c4_account_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_account_id","name","account_type","balance","currency","iban","bank_name","bank_branch","bank_account_no","is_archived","status","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_account_beforeInsert'))
        {
            return c4_account_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_account_afterInsert'))
        {
            c4_account_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_account_beforeUpdate'))
        {
            return c4_account_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_account_afterUpdate'))
        {
            c4_account_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_account_beforeDelete'))
        {
            return c4_account_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_account_afterDelete'))
        {
            c4_account_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_account_afterFind'))
        {
            return c4_account_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}