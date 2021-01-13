<?php

//--------------------------------------------------------------------
/**
 * c4_email_track Helper
 *
 * c4_email_track_beforeInsert, c4_email_track_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_email_track_beforeInsert'))
{

    function c4_email_track_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_email_track_afterInsert'))
{

    function c4_email_track_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_email_track_beforeUpdate'))
{

    function c4_email_track_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_email_track_afterUpdate'))
{

    function c4_email_track_afterUpdate(array $data)
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
    
if (!function_exists('c4_email_track_beforeDelete'))
{

    function c4_email_track_beforeDelete(array $data): array
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
    
if (!function_exists('c4_email_track_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_email_trackModel
     * 
     * @param array $data
     */
    function c4_email_track_afterDelete(array $data)
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


if (!function_exists('saveC4_email_track'))
{

    function saveC4_email_track(array $data)
    {
        $C4_email_trackModel = new \Agents\Models\C4_email_trackModel();
        

        if ($C4_email_trackModel->save($data) !== false)
        {
            if (empty($data['c4_email_track_id']))
            {
                return $C4_email_trackModel->getInsertID();
            }
            else
            {
                return $data['c4_email_track_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_email_track'))
{

    function getAllC4_email_track($where = null, $limit=null, $orderBy = 'c4_email_track_id')
    {
        $C4_email_trackModel = new \Agents\Models\C4_email_trackModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_email_trackModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_email_trackModel->whereIn('c4_email_track_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_email_trackModel->limit($limit);
        }
        
        $C4_email_trackModel->orderBy($orderBy, 'asc');

        return $C4_email_trackModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_email_track'))
{

    function getC4_email_track($where = null, $order_by=null, $select='*')
    {
        $C4_email_trackModel = new \Agents\Models\C4_email_trackModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_email_track_id' => $where];
            }
            
            $C4_email_trackModel->where($where);
        }

        $C4_email_trackModel->select($select);

        if (empty($order_by))
        {
            return $C4_email_trackModel->first();
        }
        else
        {
            return $C4_email_trackModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_email_track'))
{
    
    function getLastC4_email_track($where = null)
    {
        return getC4_email_track($where, 'c4_email_track_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_email_track'))
{

    function updateC4_email_track(array $data, $where = null)
    {

        $C4_email_trackModel = new \Agents\Models\C4_email_trackModel();

        if (!empty($where))
        {
            $C4_email_trackModel->where($where);
        }
        

        $C4_email_trackModel->set($data);

        return  $C4_email_trackModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_email_track'))
{

    function deleteC4_email_track($where)
    {
        $C4_email_trackModel = new \Agents\Models\C4_email_trackModel();
        

        if(is_numeric($where))
        {
            return $C4_email_trackModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_email_trackModel->select('c4_email_track_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_email_trackModel->delete($data['c4_email_track_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_email_track'))
{

    function countC4_email_track($where = null)
    {
        $C4_email_trackModel = new \Agents\Models\C4_email_trackModel();        
        
        

        if (!empty($where))
        {            
            $C4_email_trackModel->where($where);
        }

        return $C4_email_trackModel->countAllResults();
    }

}