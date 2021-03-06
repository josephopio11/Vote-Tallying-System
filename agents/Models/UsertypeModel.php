<?php

namespace Agents\Models;

use CodeIgniter\Model;

class UsertypeModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'usertype';
    protected $primaryKey     = 'type_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["type_id","usertype","comment","status","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('usertype_beforeInsert'))
        {
            return usertype_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('usertype_afterInsert'))
        {
            usertype_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('usertype_beforeUpdate'))
        {
            return usertype_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('usertype_afterUpdate'))
        {
            usertype_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('usertype_beforeDelete'))
        {
            return usertype_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('usertype_afterDelete'))
        {
            usertype_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('usertype_afterFind'))
        {
            return usertype_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}