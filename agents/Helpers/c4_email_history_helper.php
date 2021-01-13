<?php

//--------------------------------------------------------------------
/**
 * c4_email_history Helper
 *
 * c4_email_history_beforeInsert, c4_email_history_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_email_history_beforeInsert'))
{

    function c4_email_history_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_email_history_afterInsert'))
{

    function c4_email_history_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_email_history_beforeUpdate'))
{

    function c4_email_history_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_email_history_afterUpdate'))
{

    function c4_email_history_afterUpdate(array $data)
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
    
if (!function_exists('c4_email_history_beforeDelete'))
{

    function c4_email_history_beforeDelete(array $data): array
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
    
if (!function_exists('c4_email_history_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_email_historyModel
     * 
     * @param array $data
     */
    function c4_email_history_afterDelete(array $data)
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


if (!function_exists('saveC4_email_history'))
{

    function saveC4_email_history(array $data)
    {
        $C4_email_historyModel = new \Agents\Models\C4_email_historyModel();
        

        if ($C4_email_historyModel->save($data) !== false)
        {
            if (empty($data['c4_email_history_id']))
            {
                return $C4_email_historyModel->getInsertID();
            }
            else
            {
                return $data['c4_email_history_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_email_history'))
{

    function getAllC4_email_history($where = null, $limit=null, $orderBy = 'c4_email_history_id')
    {
        $C4_email_historyModel = new \Agents\Models\C4_email_historyModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_email_historyModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_email_historyModel->whereIn('c4_email_history_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_email_historyModel->limit($limit);
        }
        
        $C4_email_historyModel->orderBy($orderBy, 'asc');

        return $C4_email_historyModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_email_history'))
{

    function getC4_email_history($where = null, $order_by=null, $select='*')
    {
        $C4_email_historyModel = new \Agents\Models\C4_email_historyModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_email_history_id' => $where];
            }
            
            $C4_email_historyModel->where($where);
        }

        $C4_email_historyModel->select($select);

        if (empty($order_by))
        {
            return $C4_email_historyModel->first();
        }
        else
        {
            return $C4_email_historyModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_email_history'))
{
    
    function getLastC4_email_history($where = null)
    {
        return getC4_email_history($where, 'c4_email_history_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_email_history'))
{

    function updateC4_email_history(array $data, $where = null)
    {

        $C4_email_historyModel = new \Agents\Models\C4_email_historyModel();

        if (!empty($where))
        {
            $C4_email_historyModel->where($where);
        }
        

        $C4_email_historyModel->set($data);

        return  $C4_email_historyModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_email_history'))
{

    function deleteC4_email_history($where)
    {
        $C4_email_historyModel = new \Agents\Models\C4_email_historyModel();
        

        if(is_numeric($where))
        {
            return $C4_email_historyModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_email_historyModel->select('c4_email_history_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_email_historyModel->delete($data['c4_email_history_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_email_history'))
{

    function countC4_email_history($where = null)
    {
        $C4_email_historyModel = new \Agents\Models\C4_email_historyModel();        
        
        

        if (!empty($where))
        {            
            $C4_email_historyModel->where($where);
        }

        return $C4_email_historyModel->countAllResults();
    }

}