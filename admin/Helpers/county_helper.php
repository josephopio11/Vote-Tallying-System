<?php

//--------------------------------------------------------------------
/**
 * county Helper
 *
 * county_beforeInsert, county_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('county_beforeInsert'))
{

    function county_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('county_afterInsert'))
{

    function county_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('county_beforeUpdate'))
{

    function county_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('county_afterUpdate'))
{

    function county_afterUpdate(array $data)
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
    
if (!function_exists('county_beforeDelete'))
{

    function county_beforeDelete(array $data): array
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
    
if (!function_exists('county_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from CountyModel
     * 
     * @param array $data
     */
    function county_afterDelete(array $data)
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


if (!function_exists('saveCounty'))
{

    function saveCounty(array $data)
    {
        $CountyModel = new \Admin\Models\CountyModel();
        

        if ($CountyModel->save($data) !== false)
        {
            if (empty($data['countyid']))
            {
                return $CountyModel->getInsertID();
            }
            else
            {
                return $data['countyid'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllCounty'))
{

    function getAllCounty($where = null, $limit=null, $orderBy = 'countyid')
    {
        $CountyModel = new \Admin\Models\CountyModel();
        
        
        //status Field
        $CountyModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $CountyModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $CountyModel->whereIn('countyid', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $CountyModel->limit($limit);
        }
        
        $CountyModel->orderBy($orderBy, 'asc');

        return $CountyModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getCounty'))
{

    function getCounty($where = null, $order_by=null, $select='*')
    {
        $CountyModel = new \Admin\Models\CountyModel();
        
        
        //status Field
        $CountyModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['countyid' => $where];
            }
            
            $CountyModel->where($where);
        }

        $CountyModel->select($select);

        if (empty($order_by))
        {
            return $CountyModel->first();
        }
        else
        {
            return $CountyModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastCounty'))
{
    
    function getLastCounty($where = null)
    {
        return getCounty($where, 'countyid');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateCounty'))
{

    function updateCounty(array $data, $where = null)
    {

        $CountyModel = new \Admin\Models\CountyModel();

        if (!empty($where))
        {
            $CountyModel->where($where);
        }
        

        $CountyModel->set($data);

        return  $CountyModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteCounty'))
{

    function deleteCounty($where)
    {
        $CountyModel = new \Admin\Models\CountyModel();
        

        if(is_numeric($where))
        {
            return $CountyModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $CountyModel->select('countyid')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $CountyModel->delete($data['countyid']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countCounty'))
{

    function countCounty($where = null)
    {
        $CountyModel = new \Admin\Models\CountyModel();        
        
        //status Field
        $CountyModel->where('status', 1);
        

        if (!empty($where))
        {            
            $CountyModel->where($where);
        }

        return $CountyModel->countAllResults();
    }

}