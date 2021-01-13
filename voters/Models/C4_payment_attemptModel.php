<?php

namespace Voters\Models;

use CodeIgniter\Model;

class C4_payment_attemptModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_payment_attempt';
    protected $primaryKey     = 'c4_payment_attempt_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_payment_attempt_id","order_ref","checkout_status","error_code","error_message","response_id","response_status","response_data","json_data","status","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_payment_attempt_beforeInsert'))
        {
            return c4_payment_attempt_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_payment_attempt_afterInsert'))
        {
            c4_payment_attempt_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_payment_attempt_beforeUpdate'))
        {
            return c4_payment_attempt_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_payment_attempt_afterUpdate'))
        {
            c4_payment_attempt_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_payment_attempt_beforeDelete'))
        {
            return c4_payment_attempt_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_payment_attempt_afterDelete'))
        {
            c4_payment_attempt_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_payment_attempt_afterFind'))
        {
            return c4_payment_attempt_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}