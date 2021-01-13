<?php

//--------------------------------------------------------------------
/**
 * parish Helper
 *
 * parish_beforeInsert, parish_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('parish_beforeInsert'))
{

    function parish_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('parish_afterInsert'))
{

    function parish_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('parish_beforeUpdate'))
{

    function parish_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('parish_afterUpdate'))
{

    function parish_afterUpdate(array $data)
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
    
if (!function_exists('parish_beforeDelete'))
{

    function parish_beforeDelete(array $data): array
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
    
if (!function_exists('parish_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from ParishModel
     * 
     * @param array $data
     */
    function parish_afterDelete(array $data)
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


if (!function_exists('saveParish'))
{

    function saveParish(array $data)
    {
        $ParishModel = new \Tally\Models\ParishModel();
        

        if ($ParishModel->save($data) !== false)
        {
            if (empty($data['id']))
            {
                return $ParishModel->getInsertID();
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
                
if (!function_exists('getAllParish'))
{

    function getAllParish($where = null, $limit=null, $orderBy = 'id')
    {
        $ParishModel = new \Tally\Models\ParishModel();
        
        
        //status Field
        $ParishModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $ParishModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $ParishModel->whereIn('id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $ParishModel->limit($limit);
        }
        
        $ParishModel->orderBy($orderBy, 'asc');

        return $ParishModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getParish'))
{

    function getParish($where = null, $order_by=null, $select='*')
    {
        $ParishModel = new \Tally\Models\ParishModel();
        
        
        //status Field
        $ParishModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['id' => $where];
            }
            
            $ParishModel->where($where);
        }

        $ParishModel->select($select);

        if (empty($order_by))
        {
            return $ParishModel->first();
        }
        else
        {
            return $ParishModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastParish'))
{
    
    function getLastParish($where = null)
    {
        return getParish($where, 'id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateParish'))
{

    function updateParish(array $data, $where = null)
    {

        $ParishModel = new \Tally\Models\ParishModel();

        if (!empty($where))
        {
            $ParishModel->where($where);
        }
        

        $ParishModel->set($data);

        return  $ParishModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteParish'))
{

    function deleteParish($where)
    {
        $ParishModel = new \Tally\Models\ParishModel();
        

        if(is_numeric($where))
        {
            return $ParishModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $ParishModel->select('id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $ParishModel->delete($data['id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countParish'))
{

    function countParish($where = null)
    {
        $ParishModel = new \Tally\Models\ParishModel();        
        
        //status Field
        $ParishModel->where('status', 1);
        

        if (!empty($where))
        {            
            $ParishModel->where($where);
        }

        return $ParishModel->countAllResults();
    }

}