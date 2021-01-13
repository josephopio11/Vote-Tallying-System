<?php

//--------------------------------------------------------------------
/**
 * user Helper
 *
 * user_beforeInsert, user_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('user_beforeInsert'))
{

    function user_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('user_afterInsert'))
{

    function user_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('user_beforeUpdate'))
{

    function user_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('user_afterUpdate'))
{

    function user_afterUpdate(array $data)
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
    
if (!function_exists('user_beforeDelete'))
{

    function user_beforeDelete(array $data): array
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
    
if (!function_exists('user_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from UserModel
     * 
     * @param array $data
     */
    function user_afterDelete(array $data)
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


if (!function_exists('saveUser'))
{

    function saveUser(array $data)
    {
        $UserModel = new \Admin\Models\UserModel();
        

        if ($UserModel->save($data) !== false)
        {
            if (empty($data['user_id']))
            {
                return $UserModel->getInsertID();
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
                
if (!function_exists('getAllUser'))
{

    function getAllUser($where = null, $limit=null, $orderBy = 'user_id')
    {
        $UserModel = new \Admin\Models\UserModel();
        
        
        //status Field
        $UserModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $UserModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $UserModel->whereIn('user_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $UserModel->limit($limit);
        }
        
        $UserModel->orderBy($orderBy, 'asc');

        return $UserModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getUser'))
{

    function getUser($where = null, $order_by=null, $select='*')
    {
        $UserModel = new \Admin\Models\UserModel();
        
        
        //status Field
        $UserModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['user_id' => $where];
            }
            
            $UserModel->where($where);
        }

        $UserModel->select($select);

        if (empty($order_by))
        {
            return $UserModel->first();
        }
        else
        {
            return $UserModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastUser'))
{
    
    function getLastUser($where = null)
    {
        return getUser($where, 'user_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateUser'))
{

    function updateUser(array $data, $where = null)
    {

        $UserModel = new \Admin\Models\UserModel();

        if (!empty($where))
        {
            $UserModel->where($where);
        }
        

        $UserModel->set($data);

        return  $UserModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteUser'))
{

    function deleteUser($where)
    {
        $UserModel = new \Admin\Models\UserModel();
        

        if(is_numeric($where))
        {
            return $UserModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $UserModel->select('user_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $UserModel->delete($data['user_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countUser'))
{

    function countUser($where = null)
    {
        $UserModel = new \Admin\Models\UserModel();        
        
        //status Field
        $UserModel->where('status', 1);
        

        if (!empty($where))
        {            
            $UserModel->where($where);
        }

        return $UserModel->countAllResults();
    }

}