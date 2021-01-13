<?php

//--------------------------------------------------------------------
/**
 * c4_subscription Helper
 *
 * c4_subscription_beforeInsert, c4_subscription_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_subscription_beforeInsert'))
{

    function c4_subscription_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_subscription_afterInsert'))
{

    function c4_subscription_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_subscription_beforeUpdate'))
{

    function c4_subscription_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_subscription_afterUpdate'))
{

    function c4_subscription_afterUpdate(array $data)
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
    
if (!function_exists('c4_subscription_beforeDelete'))
{

    function c4_subscription_beforeDelete(array $data): array
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
    
if (!function_exists('c4_subscription_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_subscriptionModel
     * 
     * @param array $data
     */
    function c4_subscription_afterDelete(array $data)
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


if (!function_exists('saveC4_subscription'))
{

    function saveC4_subscription(array $data)
    {
        $C4_subscriptionModel = new \Admin\Models\C4_subscriptionModel();
        

        if ($C4_subscriptionModel->save($data) !== false)
        {
            if (empty($data['c4_subscription_id']))
            {
                return $C4_subscriptionModel->getInsertID();
            }
            else
            {
                return $data['c4_subscription_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_subscription'))
{

    function getAllC4_subscription($where = null, $limit=null, $orderBy = 'c4_subscription_id')
    {
        $C4_subscriptionModel = new \Admin\Models\C4_subscriptionModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_subscriptionModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_subscriptionModel->whereIn('c4_subscription_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_subscriptionModel->limit($limit);
        }
        
        $C4_subscriptionModel->orderBy($orderBy, 'asc');

        return $C4_subscriptionModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_subscription'))
{

    function getC4_subscription($where = null, $order_by=null, $select='*')
    {
        $C4_subscriptionModel = new \Admin\Models\C4_subscriptionModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_subscription_id' => $where];
            }
            
            $C4_subscriptionModel->where($where);
        }

        $C4_subscriptionModel->select($select);

        if (empty($order_by))
        {
            return $C4_subscriptionModel->first();
        }
        else
        {
            return $C4_subscriptionModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_subscription'))
{
    
    function getLastC4_subscription($where = null)
    {
        return getC4_subscription($where, 'c4_subscription_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_subscription'))
{

    function updateC4_subscription(array $data, $where = null)
    {

        $C4_subscriptionModel = new \Admin\Models\C4_subscriptionModel();

        if (!empty($where))
        {
            $C4_subscriptionModel->where($where);
        }
        

        $C4_subscriptionModel->set($data);

        return  $C4_subscriptionModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_subscription'))
{

    function deleteC4_subscription($where)
    {
        $C4_subscriptionModel = new \Admin\Models\C4_subscriptionModel();
        

        if(is_numeric($where))
        {
            return $C4_subscriptionModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_subscriptionModel->select('c4_subscription_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_subscriptionModel->delete($data['c4_subscription_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_subscription'))
{

    function countC4_subscription($where = null)
    {
        $C4_subscriptionModel = new \Admin\Models\C4_subscriptionModel();        
        
        

        if (!empty($where))
        {            
            $C4_subscriptionModel->where($where);
        }

        return $C4_subscriptionModel->countAllResults();
    }

}