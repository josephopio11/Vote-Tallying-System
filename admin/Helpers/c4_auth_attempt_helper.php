<?php

//--------------------------------------------------------------------
/**
 * c4_auth_attempt Helper
 *
 * c4_auth_attempt_beforeInsert, c4_auth_attempt_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_auth_attempt_beforeInsert'))
{

    function c4_auth_attempt_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_auth_attempt_afterInsert'))
{

    function c4_auth_attempt_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_auth_attempt_beforeUpdate'))
{

    function c4_auth_attempt_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_auth_attempt_afterUpdate'))
{

    function c4_auth_attempt_afterUpdate(array $data)
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
    
if (!function_exists('c4_auth_attempt_beforeDelete'))
{

    function c4_auth_attempt_beforeDelete(array $data): array
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
    
if (!function_exists('c4_auth_attempt_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_auth_attemptModel
     * 
     * @param array $data
     */
    function c4_auth_attempt_afterDelete(array $data)
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


if (!function_exists('saveC4_auth_attempt'))
{

    function saveC4_auth_attempt(array $data)
    {
        $C4_auth_attemptModel = new \Admin\Models\C4_auth_attemptModel();
        

        if ($C4_auth_attemptModel->save($data) !== false)
        {
            if (empty($data['c4_auth_attempt_id']))
            {
                return $C4_auth_attemptModel->getInsertID();
            }
            else
            {
                return $data['c4_auth_attempt_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_auth_attempt'))
{

    function getAllC4_auth_attempt($where = null, $limit=null, $orderBy = 'c4_auth_attempt_id')
    {
        $C4_auth_attemptModel = new \Admin\Models\C4_auth_attemptModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_auth_attemptModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_auth_attemptModel->whereIn('c4_auth_attempt_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_auth_attemptModel->limit($limit);
        }
        
        $C4_auth_attemptModel->orderBy($orderBy, 'asc');

        return $C4_auth_attemptModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_auth_attempt'))
{

    function getC4_auth_attempt($where = null, $order_by=null, $select='*')
    {
        $C4_auth_attemptModel = new \Admin\Models\C4_auth_attemptModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_auth_attempt_id' => $where];
            }
            
            $C4_auth_attemptModel->where($where);
        }

        $C4_auth_attemptModel->select($select);

        if (empty($order_by))
        {
            return $C4_auth_attemptModel->first();
        }
        else
        {
            return $C4_auth_attemptModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_auth_attempt'))
{
    
    function getLastC4_auth_attempt($where = null)
    {
        return getC4_auth_attempt($where, 'c4_auth_attempt_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_auth_attempt'))
{

    function updateC4_auth_attempt(array $data, $where = null)
    {

        $C4_auth_attemptModel = new \Admin\Models\C4_auth_attemptModel();

        if (!empty($where))
        {
            $C4_auth_attemptModel->where($where);
        }
        

        $C4_auth_attemptModel->set($data);

        return  $C4_auth_attemptModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_auth_attempt'))
{

    function deleteC4_auth_attempt($where)
    {
        $C4_auth_attemptModel = new \Admin\Models\C4_auth_attemptModel();
        

        if(is_numeric($where))
        {
            return $C4_auth_attemptModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_auth_attemptModel->select('c4_auth_attempt_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_auth_attemptModel->delete($data['c4_auth_attempt_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_auth_attempt'))
{

    function countC4_auth_attempt($where = null)
    {
        $C4_auth_attemptModel = new \Admin\Models\C4_auth_attemptModel();        
        
        

        if (!empty($where))
        {            
            $C4_auth_attemptModel->where($where);
        }

        return $C4_auth_attemptModel->countAllResults();
    }

}