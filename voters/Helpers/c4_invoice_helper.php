<?php

//--------------------------------------------------------------------
/**
 * c4_invoice Helper
 *
 * c4_invoice_beforeInsert, c4_invoice_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_invoice_beforeInsert'))
{

    function c4_invoice_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_invoice_afterInsert'))
{

    function c4_invoice_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_invoice_beforeUpdate'))
{

    function c4_invoice_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_invoice_afterUpdate'))
{

    function c4_invoice_afterUpdate(array $data)
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
    
if (!function_exists('c4_invoice_beforeDelete'))
{

    function c4_invoice_beforeDelete(array $data): array
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
    
if (!function_exists('c4_invoice_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_invoiceModel
     * 
     * @param array $data
     */
    function c4_invoice_afterDelete(array $data)
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


if (!function_exists('saveC4_invoice'))
{

    function saveC4_invoice(array $data)
    {
        $C4_invoiceModel = new \Voters\Models\C4_invoiceModel();
        

        if ($C4_invoiceModel->save($data) !== false)
        {
            if (empty($data['c4_invoice_id']))
            {
                return $C4_invoiceModel->getInsertID();
            }
            else
            {
                return $data['c4_invoice_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_invoice'))
{

    function getAllC4_invoice($where = null, $limit=null, $orderBy = 'c4_invoice_id')
    {
        $C4_invoiceModel = new \Voters\Models\C4_invoiceModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_invoiceModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_invoiceModel->whereIn('c4_invoice_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_invoiceModel->limit($limit);
        }
        
        $C4_invoiceModel->orderBy($orderBy, 'asc');

        return $C4_invoiceModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_invoice'))
{

    function getC4_invoice($where = null, $order_by=null, $select='*')
    {
        $C4_invoiceModel = new \Voters\Models\C4_invoiceModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_invoice_id' => $where];
            }
            
            $C4_invoiceModel->where($where);
        }

        $C4_invoiceModel->select($select);

        if (empty($order_by))
        {
            return $C4_invoiceModel->first();
        }
        else
        {
            return $C4_invoiceModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_invoice'))
{
    
    function getLastC4_invoice($where = null)
    {
        return getC4_invoice($where, 'c4_invoice_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_invoice'))
{

    function updateC4_invoice(array $data, $where = null)
    {

        $C4_invoiceModel = new \Voters\Models\C4_invoiceModel();

        if (!empty($where))
        {
            $C4_invoiceModel->where($where);
        }
        

        $C4_invoiceModel->set($data);

        return  $C4_invoiceModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_invoice'))
{

    function deleteC4_invoice($where)
    {
        $C4_invoiceModel = new \Voters\Models\C4_invoiceModel();
        

        if(is_numeric($where))
        {
            return $C4_invoiceModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_invoiceModel->select('c4_invoice_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_invoiceModel->delete($data['c4_invoice_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_invoice'))
{

    function countC4_invoice($where = null)
    {
        $C4_invoiceModel = new \Voters\Models\C4_invoiceModel();        
        
        

        if (!empty($where))
        {            
            $C4_invoiceModel->where($where);
        }

        return $C4_invoiceModel->countAllResults();
    }

}