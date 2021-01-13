<?php

//--------------------------------------------------------------------
/**
 * c4_invoice_item Helper
 *
 * c4_invoice_item_beforeInsert, c4_invoice_item_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_invoice_item_beforeInsert'))
{

    function c4_invoice_item_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_invoice_item_afterInsert'))
{

    function c4_invoice_item_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_invoice_item_beforeUpdate'))
{

    function c4_invoice_item_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_invoice_item_afterUpdate'))
{

    function c4_invoice_item_afterUpdate(array $data)
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
    
if (!function_exists('c4_invoice_item_beforeDelete'))
{

    function c4_invoice_item_beforeDelete(array $data): array
    {
    
        $ids   = $data['id'];
        $purge = $data['purge'];

        if (empty($ids))
        {
            return $data;
        }
        
        // Keep invoice_id in session for recalculation
        $deletedInvoiceItemData   = getC4_invoice_item($ids[0]);
        session()->setFlashdata('deletedInvoiceItemData', $deletedInvoiceItemData);
    
        return $data;
    }
}

//--------------------------------------------------------------------
    
if (!function_exists('c4_invoice_item_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_invoice_itemModel
     * 
     * @param array $data
     */
    function c4_invoice_item_afterDelete(array $data)
    {
        $ids   = $data['id'];
        $purge = $data['purge'];
    
        if (empty($ids))
        {
            return $data;
        }

        $deletedInvoiceItemData = session()->getFlashdata('deletedInvoiceItemData');

        if(!empty($deletedInvoiceItemData))
        {
            $c4_invoice_id  = $deletedInvoiceItemData['c4_invoice_id'];
            $InvoiceSystem  = new \App\Libraries\InvoiceSystem\InvoiceSystem();
            $InvoiceSystem->read($c4_invoice_id);
            $InvoiceSystem->update($InvoiceSystem->getInvoiceData());
        }
    }

}

//--------------------------------------------------------------------


if (!function_exists('saveC4_invoice_item'))
{

    function saveC4_invoice_item(array $data)
    {
        $C4_invoice_itemModel = new \Tally\Models\C4_invoice_itemModel();
        

        if ($C4_invoice_itemModel->save($data) !== false)
        {
            if (empty($data['c4_invoice_item_id']))
            {
                return $C4_invoice_itemModel->getInsertID();
            }
            else
            {
                return $data['c4_invoice_item_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_invoice_item'))
{

    function getAllC4_invoice_item($where = null, $limit=null, $orderBy = 'c4_invoice_item_id')
    {
        $C4_invoice_itemModel = new \Tally\Models\C4_invoice_itemModel();
        
        
        //status Field
        $C4_invoice_itemModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_invoice_itemModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_invoice_itemModel->whereIn('c4_invoice_item_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_invoice_itemModel->limit($limit);
        }
        
        $C4_invoice_itemModel->orderBy($orderBy, 'asc');

        return $C4_invoice_itemModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_invoice_item'))
{

    function getC4_invoice_item($where = null, $order_by=null, $select='*')
    {
        $C4_invoice_itemModel = new \Tally\Models\C4_invoice_itemModel();
        
        
        //status Field
        $C4_invoice_itemModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_invoice_item_id' => $where];
            }
            
            $C4_invoice_itemModel->where($where);
        }

        $C4_invoice_itemModel->select($select);

        if (empty($order_by))
        {
            return $C4_invoice_itemModel->first();
        }
        else
        {
            return $C4_invoice_itemModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_invoice_item'))
{
    
    function getLastC4_invoice_item($where = null)
    {
        return getC4_invoice_item($where, 'c4_invoice_item_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_invoice_item'))
{

    function updateC4_invoice_item(array $data, $where = null)
    {

        $C4_invoice_itemModel = new \Tally\Models\C4_invoice_itemModel();

        if (!empty($where))
        {
            $C4_invoice_itemModel->where($where);
        }
        

        $C4_invoice_itemModel->set($data);

        return  $C4_invoice_itemModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_invoice_item'))
{

    function deleteC4_invoice_item($where)
    {
        $C4_invoice_itemModel = new \Tally\Models\C4_invoice_itemModel();
        

        if(is_numeric($where))
        {
            return $C4_invoice_itemModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_invoice_itemModel->select('c4_invoice_item_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_invoice_itemModel->delete($data['c4_invoice_item_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_invoice_item'))
{

    function countC4_invoice_item($where = null)
    {
        $C4_invoice_itemModel = new \Tally\Models\C4_invoice_itemModel();        
        
        //status Field
        $C4_invoice_itemModel->where('status', 1);
        

        if (!empty($where))
        {            
            $C4_invoice_itemModel->where($where);
        }

        return $C4_invoice_itemModel->countAllResults();
    }

}