<?php

//--------------------------------------------------------------------
/**
 * company Helper
 *
 * company_beforeInsert, company_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('company_beforeInsert'))
{

    function company_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('company_afterInsert'))
{

    function company_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('company_beforeUpdate'))
{

    function company_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('company_afterUpdate'))
{

    function company_afterUpdate(array $data)
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
    
if (!function_exists('company_beforeDelete'))
{

    function company_beforeDelete(array $data): array
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
    
if (!function_exists('company_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from CompanyModel
     * 
     * @param array $data
     */
    function company_afterDelete(array $data)
    {
        $ids   = $data['id'];
        $purge = $data['purge'];
    
        if (empty($ids))
        {
            return $data;
        }

        if(function_exists('deleteUser'))
        {
            foreach ($ids as $id)
            {
                deleteUser(['company_id' => $id]);
            }
        }        
    }

}

//--------------------------------------------------------------------


if (!function_exists('saveCompany'))
{

    function saveCompany(array $data)
    {
        $CompanyModel = new \Admin\Models\CompanyModel();
        

        if ($CompanyModel->save($data) !== false)
        {
            if (empty($data['company_id']))
            {
                return $CompanyModel->getInsertID();
            }
            else
            {
                return $data['company_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllCompany'))
{

    function getAllCompany($where = null, $limit=null, $orderBy = 'company_id')
    {
        $CompanyModel = new \Admin\Models\CompanyModel();
        
        
        //status Field
        $CompanyModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $CompanyModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $CompanyModel->whereIn('company_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $CompanyModel->limit($limit);
        }
        
        $CompanyModel->orderBy($orderBy, 'asc');

        return $CompanyModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getCompany'))
{

    function getCompany($where = null, $order_by=null, $select='*')
    {
        $CompanyModel = new \Admin\Models\CompanyModel();
        
        
        //status Field
        $CompanyModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['company_id' => $where];
            }
            
            $CompanyModel->where($where);
        }

        $CompanyModel->select($select);

        if (empty($order_by))
        {
            return $CompanyModel->first();
        }
        else
        {
            return $CompanyModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastCompany'))
{
    
    function getLastCompany($where = null)
    {
        return getCompany($where, 'company_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateCompany'))
{

    function updateCompany(array $data, $where = null)
    {

        $CompanyModel = new \Admin\Models\CompanyModel();

        if (!empty($where))
        {
            $CompanyModel->where($where);
        }
        

        $CompanyModel->set($data);

        return  $CompanyModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteCompany'))
{

    function deleteCompany($where)
    {
        $CompanyModel = new \Admin\Models\CompanyModel();
        

        if(is_numeric($where))
        {
            return $CompanyModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $CompanyModel->select('company_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $CompanyModel->delete($data['company_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countCompany'))
{

    function countCompany($where = null)
    {
        $CompanyModel = new \Admin\Models\CompanyModel();        
        
        //status Field
        $CompanyModel->where('status', 1);
        

        if (!empty($where))
        {            
            $CompanyModel->where($where);
        }

        return $CompanyModel->countAllResults();
    }

}