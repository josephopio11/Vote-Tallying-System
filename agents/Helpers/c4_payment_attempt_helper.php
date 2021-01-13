<?php

//--------------------------------------------------------------------
/**
 * c4_payment_attempt Helper
 *
 * c4_payment_attempt_beforeInsert, c4_payment_attempt_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_payment_attempt_beforeInsert'))
{

    function c4_payment_attempt_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_payment_attempt_afterInsert'))
{

    function c4_payment_attempt_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_payment_attempt_beforeUpdate'))
{

    function c4_payment_attempt_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_payment_attempt_afterUpdate'))
{

    function c4_payment_attempt_afterUpdate(array $data)
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
    
if (!function_exists('c4_payment_attempt_beforeDelete'))
{

    function c4_payment_attempt_beforeDelete(array $data): array
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
    
if (!function_exists('c4_payment_attempt_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_payment_attemptModel
     * 
     * @param array $data
     */
    function c4_payment_attempt_afterDelete(array $data)
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


if (!function_exists('saveC4_payment_attempt'))
{

    function saveC4_payment_attempt(array $data)
    {
        $C4_payment_attemptModel = new \Agents\Models\C4_payment_attemptModel();
        

        if ($C4_payment_attemptModel->save($data) !== false)
        {
            if (empty($data['c4_payment_attempt_id']))
            {
                return $C4_payment_attemptModel->getInsertID();
            }
            else
            {
                return $data['c4_payment_attempt_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_payment_attempt'))
{

    function getAllC4_payment_attempt($where = null, $limit=null, $orderBy = 'c4_payment_attempt_id')
    {
        $C4_payment_attemptModel = new \Agents\Models\C4_payment_attemptModel();
        
        
        //status Field
        $C4_payment_attemptModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_payment_attemptModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_payment_attemptModel->whereIn('c4_payment_attempt_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_payment_attemptModel->limit($limit);
        }
        
        $C4_payment_attemptModel->orderBy($orderBy, 'asc');

        return $C4_payment_attemptModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_payment_attempt'))
{

    function getC4_payment_attempt($where = null, $order_by=null, $select='*')
    {
        $C4_payment_attemptModel = new \Agents\Models\C4_payment_attemptModel();
        
        
        //status Field
        $C4_payment_attemptModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_payment_attempt_id' => $where];
            }
            
            $C4_payment_attemptModel->where($where);
        }

        $C4_payment_attemptModel->select($select);

        if (empty($order_by))
        {
            return $C4_payment_attemptModel->first();
        }
        else
        {
            return $C4_payment_attemptModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_payment_attempt'))
{
    
    function getLastC4_payment_attempt($where = null)
    {
        return getC4_payment_attempt($where, 'c4_payment_attempt_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_payment_attempt'))
{

    function updateC4_payment_attempt(array $data, $where = null)
    {

        $C4_payment_attemptModel = new \Agents\Models\C4_payment_attemptModel();

        if (!empty($where))
        {
            $C4_payment_attemptModel->where($where);
        }
        

        $C4_payment_attemptModel->set($data);

        return  $C4_payment_attemptModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_payment_attempt'))
{

    function deleteC4_payment_attempt($where)
    {
        $C4_payment_attemptModel = new \Agents\Models\C4_payment_attemptModel();
        

        if(is_numeric($where))
        {
            return $C4_payment_attemptModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_payment_attemptModel->select('c4_payment_attempt_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_payment_attemptModel->delete($data['c4_payment_attempt_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_payment_attempt'))
{

    function countC4_payment_attempt($where = null)
    {
        $C4_payment_attemptModel = new \Agents\Models\C4_payment_attemptModel();        
        
        //status Field
        $C4_payment_attemptModel->where('status', 1);
        

        if (!empty($where))
        {            
            $C4_payment_attemptModel->where($where);
        }

        return $C4_payment_attemptModel->countAllResults();
    }

}