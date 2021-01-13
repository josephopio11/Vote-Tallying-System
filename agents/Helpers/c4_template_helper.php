<?php

//--------------------------------------------------------------------
/**
 * c4_template Helper
 *
 * c4_template_beforeInsert, c4_template_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_template_beforeInsert'))
{

    function c4_template_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_template_afterInsert'))
{

    function c4_template_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_template_beforeUpdate'))
{

    function c4_template_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_template_afterUpdate'))
{

    function c4_template_afterUpdate(array $data)
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
    
if (!function_exists('c4_template_beforeDelete'))
{

    function c4_template_beforeDelete(array $data): array
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
    
if (!function_exists('c4_template_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_templateModel
     * 
     * @param array $data
     */
    function c4_template_afterDelete(array $data)
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


if (!function_exists('saveC4_template'))
{

    function saveC4_template(array $data)
    {
        $C4_templateModel = new \Agents\Models\C4_templateModel();
        

        if ($C4_templateModel->save($data) !== false)
        {
            if (empty($data['c4_template_id']))
            {
                return $C4_templateModel->getInsertID();
            }
            else
            {
                return $data['c4_template_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_template'))
{

    function getAllC4_template($where = null, $limit=null, $orderBy = 'c4_template_id')
    {
        $C4_templateModel = new \Agents\Models\C4_templateModel();
        
        
        //status Field
        $C4_templateModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_templateModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_templateModel->whereIn('c4_template_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_templateModel->limit($limit);
        }
        
        $C4_templateModel->orderBy($orderBy, 'asc');

        return $C4_templateModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_template'))
{

    function getC4_template($where = null, $order_by=null, $select='*')
    {
        $C4_templateModel = new \Agents\Models\C4_templateModel();
        
        
        //status Field
        $C4_templateModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_template_id' => $where];
            }
            
            $C4_templateModel->where($where);
        }

        $C4_templateModel->select($select);

        if (empty($order_by))
        {
            return $C4_templateModel->first();
        }
        else
        {
            return $C4_templateModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_template'))
{
    
    function getLastC4_template($where = null)
    {
        return getC4_template($where, 'c4_template_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_template'))
{

    function updateC4_template(array $data, $where = null)
    {

        $C4_templateModel = new \Agents\Models\C4_templateModel();

        if (!empty($where))
        {
            $C4_templateModel->where($where);
        }
        

        $C4_templateModel->set($data);

        return  $C4_templateModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_template'))
{

    function deleteC4_template($where)
    {
        $C4_templateModel = new \Agents\Models\C4_templateModel();
        

        if(is_numeric($where))
        {
            return $C4_templateModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_templateModel->select('c4_template_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_templateModel->delete($data['c4_template_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_template'))
{

    function countC4_template($where = null)
    {
        $C4_templateModel = new \Agents\Models\C4_templateModel();        
        
        //status Field
        $C4_templateModel->where('status', 1);
        

        if (!empty($where))
        {            
            $C4_templateModel->where($where);
        }

        return $C4_templateModel->countAllResults();
    }

}