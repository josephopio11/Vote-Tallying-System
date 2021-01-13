<?php

namespace Voters\Models;

use CodeIgniter\Model;

class C4_countryModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_country';
    protected $primaryKey     = 'c4_country_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_country_id","name","iso_code_2","iso_code_3","address_format","postcode_required"];
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
        
        if (function_exists('c4_country_beforeInsert'))
        {
            return c4_country_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_country_afterInsert'))
        {
            c4_country_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_country_beforeUpdate'))
        {
            return c4_country_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_country_afterUpdate'))
        {
            c4_country_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_country_beforeDelete'))
        {
            return c4_country_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_country_afterDelete'))
        {
            c4_country_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_country_afterFind'))
        {
            return c4_country_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}