<?php

//--------------------------------------------------------------------
/**
 * c4_session Helper
 *
 * c4_session_beforeInsert, c4_session_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_session_beforeInsert'))
{

    function c4_session_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_session_afterInsert'))
{

    function c4_session_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_session_beforeUpdate'))
{

    function c4_session_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_session_afterUpdate'))
{

    function c4_session_afterUpdate(array $data)
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
    
if (!function_exists('c4_session_beforeDelete'))
{

    function c4_session_beforeDelete(array $data): array
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
    
if (!function_exists('c4_session_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_sessionModel
     * 
     * @param array $data
     */
    function c4_session_afterDelete(array $data)
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


if (!function_exists('saveC4_session'))
{

    function saveC4_session(array $data)
    {
        $C4_sessionModel = new \Admin\Models\C4_sessionModel();
        

        if ($C4_sessionModel->save($data) !== false)
        {
            if (empty($data['id']))
            {
                return $C4_sessionModel->getInsertID();
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
                
if (!function_exists('getAllC4_session'))
{

    function getAllC4_session($where = null, $limit=null, $orderBy = 'id')
    {
        $C4_sessionModel = new \Admin\Models\C4_sessionModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_sessionModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_sessionModel->whereIn('id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_sessionModel->limit($limit);
        }
        
        $C4_sessionModel->orderBy($orderBy, 'asc');

        return $C4_sessionModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_session'))
{

    function getC4_session($where = null, $order_by=null, $select='*')
    {
        $C4_sessionModel = new \Admin\Models\C4_sessionModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['id' => $where];
            }
            
            $C4_sessionModel->where($where);
        }

        $C4_sessionModel->select($select);

        if (empty($order_by))
        {
            return $C4_sessionModel->first();
        }
        else
        {
            return $C4_sessionModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_session'))
{
    
    function getLastC4_session($where = null)
    {
        return getC4_session($where, 'id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_session'))
{

    function updateC4_session(array $data, $where = null)
    {

        $C4_sessionModel = new \Admin\Models\C4_sessionModel();

        if (!empty($where))
        {
            $C4_sessionModel->where($where);
        }
        

        $C4_sessionModel->set($data);

        return  $C4_sessionModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_session'))
{

    function deleteC4_session($where)
    {
        $C4_sessionModel = new \Admin\Models\C4_sessionModel();
        

        if(is_numeric($where))
        {
            return $C4_sessionModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_sessionModel->select('id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_sessionModel->delete($data['id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_session'))
{

    function countC4_session($where = null)
    {
        $C4_sessionModel = new \Admin\Models\C4_sessionModel();        
        
        

        if (!empty($where))
        {            
            $C4_sessionModel->where($where);
        }

        return $C4_sessionModel->countAllResults();
    }

}