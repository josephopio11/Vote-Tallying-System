<?php

//--------------------------------------------------------------------
/**
 * subcounty Helper
 *
 * subcounty_beforeInsert, subcounty_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('subcounty_beforeInsert'))
{

    function subcounty_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('subcounty_afterInsert'))
{

    function subcounty_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('subcounty_beforeUpdate'))
{

    function subcounty_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('subcounty_afterUpdate'))
{

    function subcounty_afterUpdate(array $data)
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
    
if (!function_exists('subcounty_beforeDelete'))
{

    function subcounty_beforeDelete(array $data): array
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
    
if (!function_exists('subcounty_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from SubcountyModel
     * 
     * @param array $data
     */
    function subcounty_afterDelete(array $data)
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


if (!function_exists('saveSubcounty'))
{

    function saveSubcounty(array $data)
    {
        $SubcountyModel = new \Admin\Models\SubcountyModel();
        

        if ($SubcountyModel->save($data) !== false)
        {
            if (empty($data['id']))
            {
                return $SubcountyModel->getInsertID();
            }
            else
            {
                return $data['id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllSubcounty'))
{

    function getAllSubcounty($where = null, $limit=null, $orderBy = 'id')
    {
        $SubcountyModel = new \Admin\Models\SubcountyModel();
        
        
        //status Field
        $SubcountyModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $SubcountyModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $SubcountyModel->whereIn('id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $SubcountyModel->limit($limit);
        }
        
        $SubcountyModel->orderBy($orderBy, 'asc');

        return $SubcountyModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getSubcounty'))
{

    function getSubcounty($where = null, $order_by=null, $select='*')
    {
        $SubcountyModel = new \Admin\Models\SubcountyModel();
        
        
        //status Field
        $SubcountyModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['id' => $where];
            }
            
            $SubcountyModel->where($where);
        }

        $SubcountyModel->select($select);

        if (empty($order_by))
        {
            return $SubcountyModel->first();
        }
        else
        {
            return $SubcountyModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastSubcounty'))
{
    
    function getLastSubcounty($where = null)
    {
        return getSubcounty($where, 'id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateSubcounty'))
{

    function updateSubcounty(array $data, $where = null)
    {

        $SubcountyModel = new \Admin\Models\SubcountyModel();

        if (!empty($where))
        {
            $SubcountyModel->where($where);
        }
        

        $SubcountyModel->set($data);

        return  $SubcountyModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteSubcounty'))
{

    function deleteSubcounty($where)
    {
        $SubcountyModel = new \Admin\Models\SubcountyModel();
        

        if(is_numeric($where))
        {
            return $SubcountyModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $SubcountyModel->select('id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $SubcountyModel->delete($data['id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countSubcounty'))
{

    function countSubcounty($where = null)
    {
        $SubcountyModel = new \Admin\Models\SubcountyModel();        
        
        //status Field
        $SubcountyModel->where('status', 1);
        

        if (!empty($where))
        {            
            $SubcountyModel->where($where);
        }

        return $SubcountyModel->countAllResults();
    }

}