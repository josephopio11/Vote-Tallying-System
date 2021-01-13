<?php

//--------------------------------------------------------------------
/**
 * product Helper
 *
 * product_beforeInsert, product_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('product_beforeInsert'))
{

    function product_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('product_afterInsert'))
{

    function product_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('product_beforeUpdate'))
{

    function product_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('product_afterUpdate'))
{

    function product_afterUpdate(array $data)
    {
        $ids   = $data['id'];
        $updatedData = $data['data'];

        if (empty($ids))
        {
            return $data;
        }

    }
}

//--------------------------------------------------------------------
    
if (!function_exists('product_beforeDelete'))
{

    function product_beforeDelete(array $data): array
    {
    
        $ids   = $data['id'];
        $purge = $data['purge'];

        if (empty($ids))
        {
            return $data;
        }
            
        return $data;
    }
}

//--------------------------------------------------------------------
    
if (!function_exists('product_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from ProductModel
     * 
     * @param array $data
     */
    function product_afterDelete(array $data)
    {
        $ids   = $data['id'];
        $purge = $data['purge'];
    
        if (empty($ids))
        {
            return $data;
        }
    }

}

//--------------------------------------------------------------------


if (!function_exists('saveProduct'))
{

    function saveProduct(array $data)
    {
        $ProductModel = new \Admin\Models\ProductModel();
        

        if ($ProductModel->save($data) !== false)
        {
            if (empty($data['product_id']))
            {
                return $ProductModel->getInsertID();
            }
            else
            {
                return $data['product_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllProduct'))
{

    function getAllProduct($where = null, $limit=null, $orderBy = 'product_id')
    {
        $ProductModel = new \Admin\Models\ProductModel();
        
        
        //status Field
        $ProductModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $ProductModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $ProductModel->whereIn('product_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $ProductModel->limit($limit);
        }
        
        $ProductModel->orderBy($orderBy, 'asc');

        return $ProductModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getProduct'))
{

    function getProduct($where = null, $order_by=null, $select='*')
    {
        $ProductModel = new \Admin\Models\ProductModel();
        
        
        //status Field
        $ProductModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['product_id' => $where];
            }
            
            $ProductModel->where($where);
        }

        $ProductModel->select($select);

        if (empty($order_by))
        {
            return $ProductModel->first();
        }
        else
        {
            return $ProductModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastProduct'))
{
    
    function getLastProduct($where = null)
    {
        return getProduct($where, 'product_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateProduct'))
{

    function updateProduct(array $data, $where = null)
    {

        $ProductModel = new \Admin\Models\ProductModel();

        if (!empty($where))
        {
            $ProductModel->where($where);
        }
        

        $ProductModel->set($data);

        return  $ProductModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteProduct'))
{

    function deleteProduct($where)
    {
        $ProductModel = new \Admin\Models\ProductModel();
        

        if(is_numeric($where))
        {
            return $ProductModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $ProductModel->select('product_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $ProductModel->delete($data['product_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countProduct'))
{

    function countProduct($where = null)
    {
        $ProductModel = new \Admin\Models\ProductModel();        
        
        //status Field
        $ProductModel->where('status', 1);
        

        if (!empty($where))
        {            
            $ProductModel->where($where);
        }

        return $ProductModel->countAllResults();
    }

}