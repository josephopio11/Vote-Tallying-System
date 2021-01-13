<?php

//--------------------------------------------------------------------
/**
 * usertype Helper
 *
 * usertype_beforeInsert, usertype_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('usertype_beforeInsert'))
{

    function usertype_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('usertype_afterInsert'))
{

    function usertype_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('usertype_beforeUpdate'))
{

    function usertype_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('usertype_afterUpdate'))
{

    function usertype_afterUpdate(array $data)
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
    
if (!function_exists('usertype_beforeDelete'))
{

    function usertype_beforeDelete(array $data): array
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
    
if (!function_exists('usertype_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from UsertypeModel
     * 
     * @param array $data
     */
    function usertype_afterDelete(array $data)
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


if (!function_exists('saveUsertype'))
{

    function saveUsertype(array $data)
    {
        $UsertypeModel = new \Agents\Models\UsertypeModel();
        

        if ($UsertypeModel->save($data) !== false)
        {
            if (empty($data['type_id']))
            {
                return $UsertypeModel->getInsertID();
            }
            else
            {
                return $data['type_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllUsertype'))
{

    function getAllUsertype($where = null, $limit=null, $orderBy = 'type_id')
    {
        $UsertypeModel = new \Agents\Models\UsertypeModel();
        
        
        //status Field
        $UsertypeModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $UsertypeModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $UsertypeModel->whereIn('type_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $UsertypeModel->limit($limit);
        }
        
        $UsertypeModel->orderBy($orderBy, 'asc');

        return $UsertypeModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getUsertype'))
{

    function getUsertype($where = null, $order_by=null, $select='*')
    {
        $UsertypeModel = new \Agents\Models\UsertypeModel();
        
        
        //status Field
        $UsertypeModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['type_id' => $where];
            }
            
            $UsertypeModel->where($where);
        }

        $UsertypeModel->select($select);

        if (empty($order_by))
        {
            return $UsertypeModel->first();
        }
        else
        {
            return $UsertypeModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastUsertype'))
{
    
    function getLastUsertype($where = null)
    {
        return getUsertype($where, 'type_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateUsertype'))
{

    function updateUsertype(array $data, $where = null)
    {

        $UsertypeModel = new \Agents\Models\UsertypeModel();

        if (!empty($where))
        {
            $UsertypeModel->where($where);
        }
        

        $UsertypeModel->set($data);

        return  $UsertypeModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteUsertype'))
{

    function deleteUsertype($where)
    {
        $UsertypeModel = new \Agents\Models\UsertypeModel();
        

        if(is_numeric($where))
        {
            return $UsertypeModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $UsertypeModel->select('type_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $UsertypeModel->delete($data['type_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countUsertype'))
{

    function countUsertype($where = null)
    {
        $UsertypeModel = new \Agents\Models\UsertypeModel();        
        
        //status Field
        $UsertypeModel->where('status', 1);
        

        if (!empty($where))
        {            
            $UsertypeModel->where($where);
        }

        return $UsertypeModel->countAllResults();
    }

}