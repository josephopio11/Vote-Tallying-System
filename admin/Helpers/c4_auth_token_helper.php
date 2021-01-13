<?php

//--------------------------------------------------------------------
/**
 * c4_auth_token Helper
 *
 * c4_auth_token_beforeInsert, c4_auth_token_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_auth_token_beforeInsert'))
{

    function c4_auth_token_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_auth_token_afterInsert'))
{

    function c4_auth_token_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_auth_token_beforeUpdate'))
{

    function c4_auth_token_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_auth_token_afterUpdate'))
{

    function c4_auth_token_afterUpdate(array $data)
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
    
if (!function_exists('c4_auth_token_beforeDelete'))
{

    function c4_auth_token_beforeDelete(array $data): array
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
    
if (!function_exists('c4_auth_token_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_auth_tokenModel
     * 
     * @param array $data
     */
    function c4_auth_token_afterDelete(array $data)
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


if (!function_exists('saveC4_auth_token'))
{

    function saveC4_auth_token(array $data)
    {
        $C4_auth_tokenModel = new \Admin\Models\C4_auth_tokenModel();
        

        if ($C4_auth_tokenModel->save($data) !== false)
        {
            if (empty($data['c4_auth_token_id']))
            {
                return $C4_auth_tokenModel->getInsertID();
            }
            else
            {
                return $data['c4_auth_token_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_auth_token'))
{

    function getAllC4_auth_token($where = null, $limit=null, $orderBy = 'c4_auth_token_id')
    {
        $C4_auth_tokenModel = new \Admin\Models\C4_auth_tokenModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_auth_tokenModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_auth_tokenModel->whereIn('c4_auth_token_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_auth_tokenModel->limit($limit);
        }
        
        $C4_auth_tokenModel->orderBy($orderBy, 'asc');

        return $C4_auth_tokenModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_auth_token'))
{

    function getC4_auth_token($where = null, $order_by=null, $select='*')
    {
        $C4_auth_tokenModel = new \Admin\Models\C4_auth_tokenModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_auth_token_id' => $where];
            }
            
            $C4_auth_tokenModel->where($where);
        }

        $C4_auth_tokenModel->select($select);

        if (empty($order_by))
        {
            return $C4_auth_tokenModel->first();
        }
        else
        {
            return $C4_auth_tokenModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_auth_token'))
{
    
    function getLastC4_auth_token($where = null)
    {
        return getC4_auth_token($where, 'c4_auth_token_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_auth_token'))
{

    function updateC4_auth_token(array $data, $where = null)
    {

        $C4_auth_tokenModel = new \Admin\Models\C4_auth_tokenModel();

        if (!empty($where))
        {
            $C4_auth_tokenModel->where($where);
        }
        

        $C4_auth_tokenModel->set($data);

        return  $C4_auth_tokenModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_auth_token'))
{

    function deleteC4_auth_token($where)
    {
        $C4_auth_tokenModel = new \Admin\Models\C4_auth_tokenModel();
        

        if(is_numeric($where))
        {
            return $C4_auth_tokenModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_auth_tokenModel->select('c4_auth_token_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_auth_tokenModel->delete($data['c4_auth_token_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_auth_token'))
{

    function countC4_auth_token($where = null)
    {
        $C4_auth_tokenModel = new \Admin\Models\C4_auth_tokenModel();        
        
        

        if (!empty($where))
        {            
            $C4_auth_tokenModel->where($where);
        }

        return $C4_auth_tokenModel->countAllResults();
    }

}