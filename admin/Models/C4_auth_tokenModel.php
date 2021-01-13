<?php

namespace Admin\Models;

use CodeIgniter\Model;

class C4_auth_tokenModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_auth_token';
    protected $primaryKey     = 'c4_auth_token_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_auth_token_id","whoisID","table","userAgent","token","ip_address","expires","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_auth_token_beforeInsert'))
        {
            return c4_auth_token_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_auth_token_afterInsert'))
        {
            c4_auth_token_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_auth_token_beforeUpdate'))
        {
            return c4_auth_token_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_auth_token_afterUpdate'))
        {
            c4_auth_token_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_auth_token_beforeDelete'))
        {
            return c4_auth_token_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_auth_token_afterDelete'))
        {
            c4_auth_token_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_auth_token_afterFind'))
        {
            return c4_auth_token_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}