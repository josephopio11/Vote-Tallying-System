<?php

namespace Admin\Models;

use CodeIgniter\Model;

class C4_logModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_log';
    protected $primaryKey     = 'c4_log_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_log_id","level","message","ip","userAgent","uri","session","get","post","created_at"];
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
        
        if (function_exists('c4_log_beforeInsert'))
        {
            return c4_log_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_log_afterInsert'))
        {
            c4_log_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_log_beforeUpdate'))
        {
            return c4_log_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_log_afterUpdate'))
        {
            c4_log_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_log_beforeDelete'))
        {
            return c4_log_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_log_afterDelete'))
        {
            c4_log_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_log_afterFind'))
        {
            return c4_log_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}