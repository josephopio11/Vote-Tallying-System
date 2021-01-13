<?php

//--------------------------------------------------------------------
/**
 * c4_file Helper
 *
 * c4_file_beforeInsert, c4_file_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_file_beforeInsert'))
{

    function c4_file_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_file_afterInsert'))
{

    function c4_file_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_file_beforeUpdate'))
{

    function c4_file_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_file_afterUpdate'))
{

    function c4_file_afterUpdate(array $data)
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
    
if (!function_exists('c4_file_beforeDelete'))
{

    function c4_file_beforeDelete(array $data): array
    {
    
        $ids   = $data['id'];
        $purge = $data['purge'];

        if (empty($ids))
        {
            return $data;
        }
        
        if ($purge)
        {
            foreach ($ids as  $fileId)
            {
                $fileData = getC4_file($fileId);
                
                if(empty($fileData)){
                    continue;
                }

                $fullPath = getFullPathFromData($fileData);

                if (is_file($fullPath) && $fileData['extension'] != 'php')
                {
                    unlink($fullPath);
                }

            }
        }
    
        return $data;
    }
}

//--------------------------------------------------------------------
    
if (!function_exists('c4_file_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_fileModel
     * 
     * @param array $data
     */
    function c4_file_afterDelete(array $data)
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


if (!function_exists('saveC4_file'))
{

    function saveC4_file(array $data)
    {
        $C4_fileModel = new \Agents\Models\C4_fileModel();
        

        if ($C4_fileModel->save($data) !== false)
        {
            if (empty($data['c4_file_id']))
            {
                return $C4_fileModel->getInsertID();
            }
            else
            {
                return $data['c4_file_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_file'))
{

    function getAllC4_file($where = null, $limit=null, $orderBy = 'c4_file_id')
    {
        $C4_fileModel = new \Agents\Models\C4_fileModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_fileModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_fileModel->whereIn('c4_file_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_fileModel->limit($limit);
        }
        
        $C4_fileModel->orderBy($orderBy, 'asc');

        return $C4_fileModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_file'))
{

    function getC4_file($where = null, $order_by=null, $select='*')
    {
        $C4_fileModel = new \Agents\Models\C4_fileModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_file_id' => $where];
            }
            
            $C4_fileModel->where($where);
        }

        $C4_fileModel->select($select);

        if (empty($order_by))
        {
            return $C4_fileModel->first();
        }
        else
        {
            return $C4_fileModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_file'))
{
    
    function getLastC4_file($where = null)
    {
        return getC4_file($where, 'c4_file_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_file'))
{

    function updateC4_file(array $data, $where = null)
    {

        $C4_fileModel = new \Agents\Models\C4_fileModel();

        if (!empty($where))
        {
            $C4_fileModel->where($where);
        }
        

        $C4_fileModel->set($data);

        return  $C4_fileModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_file'))
{

    function deleteC4_file($where)
    {
        $C4_fileModel = new \Agents\Models\C4_fileModel();
        

        if(is_numeric($where))
        {
            return $C4_fileModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_fileModel->select('c4_file_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_fileModel->delete($data['c4_file_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_file'))
{

    function countC4_file($where = null)
    {
        $C4_fileModel = new \Agents\Models\C4_fileModel();        
        
        

        if (!empty($where))
        {            
            $C4_fileModel->where($where);
        }

        return $C4_fileModel->countAllResults();
    }

}