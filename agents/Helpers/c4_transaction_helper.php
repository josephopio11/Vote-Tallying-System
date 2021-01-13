<?php

//--------------------------------------------------------------------
/**
 * c4_transaction Helper
 *
 * c4_transaction_beforeInsert, c4_transaction_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_transaction_beforeInsert'))
{

    function c4_transaction_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_transaction_afterInsert'))
{

    function c4_transaction_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];

        $InvoiceSystem  = new \App\Libraries\InvoiceSystem\InvoiceSystem();
        $InvoiceSystem->onTransactionInserted($insert_id);
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_transaction_beforeUpdate'))
{

    function c4_transaction_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_transaction_afterUpdate'))
{

    function c4_transaction_afterUpdate(array $data)
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
    
if (!function_exists('c4_transaction_beforeDelete'))
{

    function c4_transaction_beforeDelete(array $data): array
    {
    
        $ids   = $data['id'];
        $purge = $data['purge'];

        if (empty($ids))
        {
            return $data;
        }
        
        if (isset($ids[0]))
        {
            $where = ['c4_transaction_id' => $ids[0]];
        }
        else
        {
            $where = $ids;
        }

        // Keep invoice_id in session for recalculation
        $deletedData    = getC4_transaction($where);
        session()->setFlashdata('deletedTransactionData', $deletedData);
    
        return $data;
    }
}

//--------------------------------------------------------------------
    
if (!function_exists('c4_transaction_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_transactionModel
     * 
     * @param array $data
     */
    function c4_transaction_afterDelete(array $data)
    {
        $ids   = $data['id'];
        $purge = $data['purge'];
    
        if (empty($ids))
        {
            return $data;
        }

        $deletedTransactionData = session()->getFlashdata('deletedTransactionData');

        if (!empty($deletedTransactionData))
        {
            $InvoiceSystem  = new \App\Libraries\InvoiceSystem\InvoiceSystem();
            $InvoiceSystem->onTransactionDeleted($deletedTransactionData);
        }

        if (function_exists('deleteC4_transaction_history_item'))
        {
            foreach ($ids as $id)
            {
                deleteC4_transaction_history_item(['c4_transaction_id' => $id]);
            }
        }
    }

}

//--------------------------------------------------------------------


if (!function_exists('saveC4_transaction'))
{

    function saveC4_transaction(array $data)
    {
        $C4_transactionModel = new \Agents\Models\C4_transactionModel();
        

        if ($C4_transactionModel->save($data) !== false)
        {
            if (empty($data['c4_transaction_id']))
            {
                return $C4_transactionModel->getInsertID();
            }
            else
            {
                return $data['c4_transaction_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_transaction'))
{

    function getAllC4_transaction($where = null, $limit=null, $orderBy = 'c4_transaction_id')
    {
        $C4_transactionModel = new \Agents\Models\C4_transactionModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_transactionModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_transactionModel->whereIn('c4_transaction_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_transactionModel->limit($limit);
        }
        
        $C4_transactionModel->orderBy($orderBy, 'asc');

        return $C4_transactionModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_transaction'))
{

    function getC4_transaction($where = null, $order_by=null, $select='*')
    {
        $C4_transactionModel = new \Agents\Models\C4_transactionModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_transaction_id' => $where];
            }
            
            $C4_transactionModel->where($where);
        }

        $C4_transactionModel->select($select);

        if (empty($order_by))
        {
            return $C4_transactionModel->first();
        }
        else
        {
            return $C4_transactionModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_transaction'))
{
    
    function getLastC4_transaction($where = null)
    {
        return getC4_transaction($where, 'c4_transaction_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_transaction'))
{

    function updateC4_transaction(array $data, $where = null)
    {

        $C4_transactionModel = new \Agents\Models\C4_transactionModel();

        if (!empty($where))
        {
            $C4_transactionModel->where($where);
        }
        

        $C4_transactionModel->set($data);

        return  $C4_transactionModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_transaction'))
{

    function deleteC4_transaction($where)
    {
        $C4_transactionModel = new \Agents\Models\C4_transactionModel();
        

        if(is_numeric($where))
        {
            return $C4_transactionModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_transactionModel->select('c4_transaction_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_transactionModel->delete($data['c4_transaction_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_transaction'))
{

    function countC4_transaction($where = null)
    {
        $C4_transactionModel = new \Agents\Models\C4_transactionModel();        
        
        

        if (!empty($where))
        {            
            $C4_transactionModel->where($where);
        }

        return $C4_transactionModel->countAllResults();
    }

}