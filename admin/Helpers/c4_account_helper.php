<?php

//--------------------------------------------------------------------
/**
 * c4_account Helper
 *
 * c4_account_beforeInsert, c4_account_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_account_beforeInsert'))
{

    function c4_account_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_account_afterInsert'))
{

    function c4_account_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_account_beforeUpdate'))
{

    function c4_account_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_account_afterUpdate'))
{

    function c4_account_afterUpdate(array $data)
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
    
if (!function_exists('c4_account_beforeDelete'))
{

    function c4_account_beforeDelete(array $data): array
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
    
if (!function_exists('c4_account_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_accountModel
     * 
     * @param array $data
     */
    function c4_account_afterDelete(array $data)
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


if (!function_exists('saveC4_account'))
{

    function saveC4_account(array $data)
    {
        $C4_accountModel = new \Admin\Models\C4_accountModel();
        

        if ($C4_accountModel->save($data) !== false)
        {
            if (empty($data['c4_account_id']))
            {
                return $C4_accountModel->getInsertID();
            }
            else
            {
                return $data['c4_account_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_account'))
{

    function getAllC4_account($where = null, $limit=null, $orderBy = 'c4_account_id')
    {
        $C4_accountModel = new \Admin\Models\C4_accountModel();
        
        
        //status Field
        $C4_accountModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_accountModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_accountModel->whereIn('c4_account_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_accountModel->limit($limit);
        }
        
        $C4_accountModel->orderBy($orderBy, 'asc');

        return $C4_accountModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_account'))
{

    function getC4_account($where = null, $order_by=null, $select='*')
    {
        $C4_accountModel = new \Admin\Models\C4_accountModel();
        
        
        //status Field
        $C4_accountModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_account_id' => $where];
            }
            
            $C4_accountModel->where($where);
        }

        $C4_accountModel->select($select);

        if (empty($order_by))
        {
            return $C4_accountModel->first();
        }
        else
        {
            return $C4_accountModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_account'))
{
    
    function getLastC4_account($where = null)
    {
        return getC4_account($where, 'c4_account_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_account'))
{

    function updateC4_account(array $data, $where = null)
    {

        $C4_accountModel = new \Admin\Models\C4_accountModel();

        if (!empty($where))
        {
            $C4_accountModel->where($where);
        }
        

        $C4_accountModel->set($data);

        return  $C4_accountModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_account'))
{

    function deleteC4_account($where)
    {
        $C4_accountModel = new \Admin\Models\C4_accountModel();
        

        if(is_numeric($where))
        {
            return $C4_accountModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_accountModel->select('c4_account_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_accountModel->delete($data['c4_account_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_account'))
{

    function countC4_account($where = null)
    {
        $C4_accountModel = new \Admin\Models\C4_accountModel();        
        
        //status Field
        $C4_accountModel->where('status', 1);
        

        if (!empty($where))
        {            
            $C4_accountModel->where($where);
        }

        return $C4_accountModel->countAllResults();
    }

}