<?php

namespace Admin\Models;

use CodeIgniter\Model;

class C4_zoneModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_zone';
    protected $primaryKey     = 'c4_zone_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_zone_id","c4_country_id","name","code"];
    protected $useTimestamps  = false;
    protected $createdField   = '';
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
        
        if (function_exists('c4_zone_beforeInsert'))
        {
            return c4_zone_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_zone_afterInsert'))
        {
            c4_zone_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_zone_beforeUpdate'))
        {
            return c4_zone_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_zone_afterUpdate'))
        {
            c4_zone_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_zone_beforeDelete'))
        {
            return c4_zone_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_zone_afterDelete'))
        {
            c4_zone_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_zone_afterFind'))
        {
            return c4_zone_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}