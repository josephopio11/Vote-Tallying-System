<?php

//--------------------------------------------------------------------
/**
 * c4_country Helper
 *
 * c4_country_beforeInsert, c4_country_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_country_beforeInsert'))
{

    function c4_country_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_country_afterInsert'))
{

    function c4_country_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_country_beforeUpdate'))
{

    function c4_country_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_country_afterUpdate'))
{

    function c4_country_afterUpdate(array $data)
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
    
if (!function_exists('c4_country_beforeDelete'))
{

    function c4_country_beforeDelete(array $data): array
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
    
if (!function_exists('c4_country_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_countryModel
     * 
     * @param array $data
     */
    function c4_country_afterDelete(array $data)
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


if (!function_exists('saveC4_country'))
{

    function saveC4_country(array $data)
    {
        $C4_countryModel = new \Agents\Models\C4_countryModel();
        

        if ($C4_countryModel->save($data) !== false)
        {
            if (empty($data['c4_country_id']))
            {
                return $C4_countryModel->getInsertID();
            }
            else
            {
                return $data['c4_country_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_country'))
{

    function getAllC4_country($where = null, $limit=null, $orderBy = 'c4_country_id')
    {
        $C4_countryModel = new \Agents\Models\C4_countryModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_countryModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_countryModel->whereIn('c4_country_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_countryModel->limit($limit);
        }
        
        $C4_countryModel->orderBy($orderBy, 'asc');

        return $C4_countryModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_country'))
{

    function getC4_country($where = null, $order_by=null, $select='*')
    {
        $C4_countryModel = new \Agents\Models\C4_countryModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_country_id' => $where];
            }
            
            $C4_countryModel->where($where);
        }

        $C4_countryModel->select($select);

        if (empty($order_by))
        {
            return $C4_countryModel->first();
        }
        else
        {
            return $C4_countryModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_country'))
{
    
    function getLastC4_country($where = null)
    {
        return getC4_country($where, 'c4_country_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_country'))
{

    function updateC4_country(array $data, $where = null)
    {

        $C4_countryModel = new \Agents\Models\C4_countryModel();

        if (!empty($where))
        {
            $C4_countryModel->where($where);
        }
        

        $C4_countryModel->set($data);

        return  $C4_countryModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_country'))
{

    function deleteC4_country($where)
    {
        $C4_countryModel = new \Agents\Models\C4_countryModel();
        

        if(is_numeric($where))
        {
            return $C4_countryModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_countryModel->select('c4_country_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_countryModel->delete($data['c4_country_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_country'))
{

    function countC4_country($where = null)
    {
        $C4_countryModel = new \Agents\Models\C4_countryModel();        
        
        

        if (!empty($where))
        {            
            $C4_countryModel->where($where);
        }

        return $C4_countryModel->countAllResults();
    }

}