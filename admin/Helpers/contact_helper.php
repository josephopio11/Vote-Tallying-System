<?php

//--------------------------------------------------------------------
/**
 * contact Helper
 *
 * contact_beforeInsert, contact_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('contact_beforeInsert'))
{

    function contact_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('contact_afterInsert'))
{

    function contact_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('contact_beforeUpdate'))
{

    function contact_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('contact_afterUpdate'))
{

    function contact_afterUpdate(array $data)
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
    
if (!function_exists('contact_beforeDelete'))
{

    function contact_beforeDelete(array $data): array
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
    
if (!function_exists('contact_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from ContactModel
     * 
     * @param array $data
     */
    function contact_afterDelete(array $data)
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


if (!function_exists('saveContact'))
{

    function saveContact(array $data)
    {
        $ContactModel = new \Admin\Models\ContactModel();
        

        if ($ContactModel->save($data) !== false)
        {
            if (empty($data['contact_id']))
            {
                return $ContactModel->getInsertID();
            }
            else
            {
                return $data['contact_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllContact'))
{

    function getAllContact($where = null, $limit=null, $orderBy = 'contact_id')
    {
        $ContactModel = new \Admin\Models\ContactModel();
        
        
        //status Field
        $ContactModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $ContactModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $ContactModel->whereIn('contact_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $ContactModel->limit($limit);
        }
        
        $ContactModel->orderBy($orderBy, 'asc');

        return $ContactModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getContact'))
{

    function getContact($where = null, $order_by=null, $select='*')
    {
        $ContactModel = new \Admin\Models\ContactModel();
        
        
        //status Field
        $ContactModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['contact_id' => $where];
            }
            
            $ContactModel->where($where);
        }

        $ContactModel->select($select);

        if (empty($order_by))
        {
            return $ContactModel->first();
        }
        else
        {
            return $ContactModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastContact'))
{
    
    function getLastContact($where = null)
    {
        return getContact($where, 'contact_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateContact'))
{

    function updateContact(array $data, $where = null)
    {

        $ContactModel = new \Admin\Models\ContactModel();

        if (!empty($where))
        {
            $ContactModel->where($where);
        }
        

        $ContactModel->set($data);

        return  $ContactModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteContact'))
{

    function deleteContact($where)
    {
        $ContactModel = new \Admin\Models\ContactModel();
        

        if(is_numeric($where))
        {
            return $ContactModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $ContactModel->select('contact_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $ContactModel->delete($data['contact_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countContact'))
{

    function countContact($where = null)
    {
        $ContactModel = new \Admin\Models\ContactModel();        
        
        //status Field
        $ContactModel->where('status', 1);
        

        if (!empty($where))
        {            
            $ContactModel->where($where);
        }

        return $ContactModel->countAllResults();
    }

}