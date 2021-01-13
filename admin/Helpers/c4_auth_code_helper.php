<?php

//--------------------------------------------------------------------
/**
 * c4_auth_code Helper
 *
 * c4_auth_code_beforeInsert, c4_auth_code_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_auth_code_beforeInsert'))
{

    function c4_auth_code_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_auth_code_afterInsert'))
{

    function c4_auth_code_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_auth_code_beforeUpdate'))
{

    function c4_auth_code_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_auth_code_afterUpdate'))
{

    function c4_auth_code_afterUpdate(array $data)
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
    
if (!function_exists('c4_auth_code_beforeDelete'))
{

    function c4_auth_code_beforeDelete(array $data): array
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
    
if (!function_exists('c4_auth_code_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_auth_codeModel
     * 
     * @param array $data
     */
    function c4_auth_code_afterDelete(array $data)
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


if (!function_exists('saveC4_auth_code'))
{

    function saveC4_auth_code(array $data)
    {
        $C4_auth_codeModel = new \Admin\Models\C4_auth_codeModel();
        

        if ($C4_auth_codeModel->save($data) !== false)
        {
            if (empty($data['c4_auth_code_id']))
            {
                return $C4_auth_codeModel->getInsertID();
            }
            else
            {
                return $data['c4_auth_code_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_auth_code'))
{

    function getAllC4_auth_code($where = null, $limit=null, $orderBy = 'c4_auth_code_id')
    {
        $C4_auth_codeModel = new \Admin\Models\C4_auth_codeModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_auth_codeModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_auth_codeModel->whereIn('c4_auth_code_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_auth_codeModel->limit($limit);
        }
        
        $C4_auth_codeModel->orderBy($orderBy, 'asc');

        return $C4_auth_codeModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_auth_code'))
{

    function getC4_auth_code($where = null, $order_by=null, $select='*')
    {
        $C4_auth_codeModel = new \Admin\Models\C4_auth_codeModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_auth_code_id' => $where];
            }
            
            $C4_auth_codeModel->where($where);
        }

        $C4_auth_codeModel->select($select);

        if (empty($order_by))
        {
            return $C4_auth_codeModel->first();
        }
        else
        {
            return $C4_auth_codeModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_auth_code'))
{
    
    function getLastC4_auth_code($where = null)
    {
        return getC4_auth_code($where, 'c4_auth_code_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_auth_code'))
{

    function updateC4_auth_code(array $data, $where = null)
    {

        $C4_auth_codeModel = new \Admin\Models\C4_auth_codeModel();

        if (!empty($where))
        {
            $C4_auth_codeModel->where($where);
        }
        

        $C4_auth_codeModel->set($data);

        return  $C4_auth_codeModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_auth_code'))
{

    function deleteC4_auth_code($where)
    {
        $C4_auth_codeModel = new \Admin\Models\C4_auth_codeModel();
        

        if(is_numeric($where))
        {
            return $C4_auth_codeModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_auth_codeModel->select('c4_auth_code_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_auth_codeModel->delete($data['c4_auth_code_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_auth_code'))
{

    function countC4_auth_code($where = null)
    {
        $C4_auth_codeModel = new \Admin\Models\C4_auth_codeModel();        
        
        

        if (!empty($where))
        {            
            $C4_auth_codeModel->where($where);
        }

        return $C4_auth_codeModel->countAllResults();
    }

}