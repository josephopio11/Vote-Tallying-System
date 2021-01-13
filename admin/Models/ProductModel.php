<?php

namespace Admin\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'product';
    protected $primaryKey     = 'product_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["product_id","name","code","barcode","photo","buying_price","buying_currency","list_price","currency","vat_rate","communications_tax","communications_tax_type","purchase_excise_duty","purchase_excise_duty_type","sales_excise_duty","sales_excise_duty_type","is_archived","inventory_tracking","initial_stock_count","critical_stock_alert","has_stock_movements","critical_stock_count","stock_count","status","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('product_beforeInsert'))
        {
            return product_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('product_afterInsert'))
        {
            product_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('product_beforeUpdate'))
        {
            return product_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('product_afterUpdate'))
        {
            product_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('product_beforeDelete'))
        {
            return product_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('product_afterDelete'))
        {
            product_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('product_afterFind'))
        {
            return product_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}