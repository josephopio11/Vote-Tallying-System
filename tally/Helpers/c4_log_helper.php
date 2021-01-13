<?php

//--------------------------------------------------------------------
/**
 * c4_log Helper
 *
 * c4_log_beforeInsert, c4_log_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_log_beforeInsert'))
{

    function c4_log_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_log_afterInsert'))
{

    function c4_log_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_log_beforeUpdate'))
{

    function c4_log_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_log_afterUpdate'))
{

    function c4_log_afterUpdate(array $data)
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
    
if (!function_exists('c4_log_beforeDelete'))
{

    function c4_log_beforeDelete(array $data): array
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
    
if (!function_exists('c4_log_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_logModel
     * 
     * @param array $data
     */
    function c4_log_afterDelete(array $data)
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


if (!function_exists('saveC4_log'))
{

    function saveC4_log(array $data)
    {
        $C4_logModel = new \Tally\Models\C4_logModel();
        

        if ($C4_logModel->save($data) !== false)
        {
            if (empty($data['c4_log_id']))
            {
                return $C4_logModel->getInsertID();
            }
            else
            {
                return $data['c4_log_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_log'))
{

    function getAllC4_log($where = null, $limit=null, $orderBy = 'c4_log_id')
    {
        $C4_logModel = new \Tally\Models\C4_logModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_logModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_logModel->whereIn('c4_log_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_logModel->limit($limit);
        }
        
        $C4_logModel->orderBy($orderBy, 'asc');

        return $C4_logModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_log'))
{

    function getC4_log($where = null, $order_by=null, $select='*')
    {
        $C4_logModel = new \Tally\Models\C4_logModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_log_id' => $where];
            }
            
            $C4_logModel->where($where);
        }

        $C4_logModel->select($select);

        if (empty($order_by))
        {
            return $C4_logModel->first();
        }
        else
        {
            return $C4_logModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_log'))
{
    
    function getLastC4_log($where = null)
    {
        return getC4_log($where, 'c4_log_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_log'))
{

    function updateC4_log(array $data, $where = null)
    {

        $C4_logModel = new \Tally\Models\C4_logModel();

        if (!empty($where))
        {
            $C4_logModel->where($where);
        }
        

        $C4_logModel->set($data);

        return  $C4_logModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_log'))
{

    function deleteC4_log($where)
    {
        $C4_logModel = new \Tally\Models\C4_logModel();
        

        if(is_numeric($where))
        {
            return $C4_logModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_logModel->select('c4_log_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_logModel->delete($data['c4_log_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_log'))
{

    function countC4_log($where = null)
    {
        $C4_logModel = new \Tally\Models\C4_logModel();        
        
        

        if (!empty($where))
        {            
            $C4_logModel->where($where);
        }

        return $C4_logModel->countAllResults();
    }

}