<?php

//--------------------------------------------------------------------
/**
 * users Helper
 *
 * users_beforeInsert, users_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('users_beforeInsert'))
{

    function users_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('users_afterInsert'))
{

    function users_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('users_beforeUpdate'))
{

    function users_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('users_afterUpdate'))
{

    function users_afterUpdate(array $data)
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
    
if (!function_exists('users_beforeDelete'))
{

    function users_beforeDelete(array $data): array
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
    
if (!function_exists('users_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from UsersModel
     * 
     * @param array $data
     */
    function users_afterDelete(array $data)
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


if (!function_exists('saveUsers'))
{

    function saveUsers(array $data)
    {
        $UsersModel = new \Agents\Models\UsersModel();
        

        if ($UsersModel->save($data) !== false)
        {
            if (empty($data['user_id']))
            {
                return $UsersModel->getInsertID();
            }
            else
            {
                return $data['user_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllUsers'))
{

    function getAllUsers($where = null, $limit=null, $orderBy = 'user_id')
    {
        $UsersModel = new \Agents\Models\UsersModel();
        
        
        //status Field
        $UsersModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $UsersModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $UsersModel->whereIn('user_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $UsersModel->limit($limit);
        }
        
        $UsersModel->orderBy($orderBy, 'asc');

        return $UsersModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getUsers'))
{

    function getUsers($where = null, $order_by=null, $select='*')
    {
        $UsersModel = new \Agents\Models\UsersModel();
        
        
        //status Field
        $UsersModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['user_id' => $where];
            }
            
            $UsersModel->where($where);
        }

        $UsersModel->select($select);

        if (empty($order_by))
        {
            return $UsersModel->first();
        }
        else
        {
            return $UsersModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastUsers'))
{
    
    function getLastUsers($where = null)
    {
        return getUsers($where, 'user_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateUsers'))
{

    function updateUsers(array $data, $where = null)
    {

        $UsersModel = new \Agents\Models\UsersModel();

        if (!empty($where))
        {
            $UsersModel->where($where);
        }
        

        $UsersModel->set($data);

        return  $UsersModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteUsers'))
{

    function deleteUsers($where)
    {
        $UsersModel = new \Agents\Models\UsersModel();
        

        if(is_numeric($where))
        {
            return $UsersModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $UsersModel->select('user_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $UsersModel->delete($data['user_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countUsers'))
{

    function countUsers($where = null)
    {
        $UsersModel = new \Agents\Models\UsersModel();        
        
        //status Field
        $UsersModel->where('status', 1);
        

        if (!empty($where))
        {            
            $UsersModel->where($where);
        }

        return $UsersModel->countAllResults();
    }

}