<?php

//--------------------------------------------------------------------
/**
 * c4_zone Helper
 *
 * c4_zone_beforeInsert, c4_zone_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_zone_beforeInsert'))
{

    function c4_zone_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_zone_afterInsert'))
{

    function c4_zone_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_zone_beforeUpdate'))
{

    function c4_zone_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_zone_afterUpdate'))
{

    function c4_zone_afterUpdate(array $data)
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
    
if (!function_exists('c4_zone_beforeDelete'))
{

    function c4_zone_beforeDelete(array $data): array
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
    
if (!function_exists('c4_zone_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_zoneModel
     * 
     * @param array $data
     */
    function c4_zone_afterDelete(array $data)
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


if (!function_exists('saveC4_zone'))
{

    function saveC4_zone(array $data)
    {
        $C4_zoneModel = new \Tally\Models\C4_zoneModel();
        

        if ($C4_zoneModel->save($data) !== false)
        {
            if (empty($data['c4_zone_id']))
            {
                return $C4_zoneModel->getInsertID();
            }
            else
            {
                return $data['c4_zone_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_zone'))
{

    function getAllC4_zone($where = null, $limit=null, $orderBy = 'c4_zone_id')
    {
        $C4_zoneModel = new \Tally\Models\C4_zoneModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_zoneModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_zoneModel->whereIn('c4_zone_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_zoneModel->limit($limit);
        }
        
        $C4_zoneModel->orderBy($orderBy, 'asc');

        return $C4_zoneModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_zone'))
{

    function getC4_zone($where = null, $order_by=null, $select='*')
    {
        $C4_zoneModel = new \Tally\Models\C4_zoneModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_zone_id' => $where];
            }
            
            $C4_zoneModel->where($where);
        }

        $C4_zoneModel->select($select);

        if (empty($order_by))
        {
            return $C4_zoneModel->first();
        }
        else
        {
            return $C4_zoneModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_zone'))
{
    
    function getLastC4_zone($where = null)
    {
        return getC4_zone($where, 'c4_zone_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_zone'))
{

    function updateC4_zone(array $data, $where = null)
    {

        $C4_zoneModel = new \Tally\Models\C4_zoneModel();

        if (!empty($where))
        {
            $C4_zoneModel->where($where);
        }
        

        $C4_zoneModel->set($data);

        return  $C4_zoneModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_zone'))
{

    function deleteC4_zone($where)
    {
        $C4_zoneModel = new \Tally\Models\C4_zoneModel();
        

        if(is_numeric($where))
        {
            return $C4_zoneModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_zoneModel->select('c4_zone_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_zoneModel->delete($data['c4_zone_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_zone'))
{

    function countC4_zone($where = null)
    {
        $C4_zoneModel = new \Tally\Models\C4_zoneModel();        
        
        

        if (!empty($where))
        {            
            $C4_zoneModel->where($where);
        }

        return $C4_zoneModel->countAllResults();
    }

}