<?php

//--------------------------------------------------------------------
/**
 * c4_payment Helper
 *
 * c4_payment_beforeInsert, c4_payment_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_payment_beforeInsert'))
{

    function c4_payment_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_payment_afterInsert'))
{

    function c4_payment_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];

        $InvoiceSystem  = new \App\Libraries\InvoiceSystem\InvoiceSystem();
        $InvoiceSystem->onPaymentInserted($insert_id);
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_payment_beforeUpdate'))
{

    function c4_payment_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_payment_afterUpdate'))
{

    function c4_payment_afterUpdate(array $data)
    {
        $ids   = $data['id'];
        $updatedData = $data['data'];

        if (empty($ids))
        {
            return $data;
        }

        $InvoiceSystem  = new \App\Libraries\InvoiceSystem\InvoiceSystem();
        $InvoiceSystem->onPaymentUpdated($ids[0]);

    }
}

//--------------------------------------------------------------------
    
if (!function_exists('c4_payment_beforeDelete'))
{

    function c4_payment_beforeDelete(array $data): array
    {
    
        $ids   = $data['id'];
        $purge = $data['purge'];

        if (empty($ids))
        {
            return $data;
        }
        
        // Keep invoice_id in session for recalculation
        $deletedPaymentData    = getC4_payment($ids[0]);
        session()->setFlashdata('deletedPaymentData', $deletedPaymentData);
    
        return $data;
    }
}

//--------------------------------------------------------------------
    
if (!function_exists('c4_payment_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_paymentModel
     * 
     * @param array $data
     */
    function c4_payment_afterDelete(array $data)
    {
        $ids   = $data['id'];
        $purge = $data['purge'];
    
        if (empty($ids))
        {
            return $data;
        }

        $InvoiceSystem  = new \App\Libraries\InvoiceSystem\InvoiceSystem();     
        $InvoiceSystem->onPaymentDeleted(session()->getFlashdata('deletedPaymentData'));
    }

}

//--------------------------------------------------------------------


if (!function_exists('saveC4_payment'))
{

    function saveC4_payment(array $data)
    {
        $C4_paymentModel = new \Agents\Models\C4_paymentModel();
        

        if ($C4_paymentModel->save($data) !== false)
        {
            if (empty($data['c4_payment_id']))
            {
                return $C4_paymentModel->getInsertID();
            }
            else
            {
                return $data['c4_payment_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_payment'))
{

    function getAllC4_payment($where = null, $limit=null, $orderBy = 'c4_payment_id')
    {
        $C4_paymentModel = new \Agents\Models\C4_paymentModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_paymentModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_paymentModel->whereIn('c4_payment_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_paymentModel->limit($limit);
        }
        
        $C4_paymentModel->orderBy($orderBy, 'asc');

        return $C4_paymentModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_payment'))
{

    function getC4_payment($where = null, $order_by=null, $select='*')
    {
        $C4_paymentModel = new \Agents\Models\C4_paymentModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_payment_id' => $where];
            }
            
            $C4_paymentModel->where($where);
        }

        $C4_paymentModel->select($select);

        if (empty($order_by))
        {
            return $C4_paymentModel->first();
        }
        else
        {
            return $C4_paymentModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_payment'))
{
    
    function getLastC4_payment($where = null)
    {
        return getC4_payment($where, 'c4_payment_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_payment'))
{

    function updateC4_payment(array $data, $where = null)
    {

        $C4_paymentModel = new \Agents\Models\C4_paymentModel();

        if (!empty($where))
        {
            $C4_paymentModel->where($where);
        }
        

        $C4_paymentModel->set($data);

        return  $C4_paymentModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_payment'))
{

    function deleteC4_payment($where)
    {
        $C4_paymentModel = new \Agents\Models\C4_paymentModel();
        

        if(is_numeric($where))
        {
            return $C4_paymentModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_paymentModel->select('c4_payment_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_paymentModel->delete($data['c4_payment_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_payment'))
{

    function countC4_payment($where = null)
    {
        $C4_paymentModel = new \Agents\Models\C4_paymentModel();        
        
        

        if (!empty($where))
        {            
            $C4_paymentModel->where($where);
        }

        return $C4_paymentModel->countAllResults();
    }

}