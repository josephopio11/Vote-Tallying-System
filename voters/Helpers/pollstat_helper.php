<?php

//--------------------------------------------------------------------
/**
 * pollstat Helper
 *
 * pollstat_beforeInsert, pollstat_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('pollstat_beforeInsert'))
{

    function pollstat_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('pollstat_afterInsert'))
{

    function pollstat_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('pollstat_beforeUpdate'))
{

    function pollstat_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('pollstat_afterUpdate'))
{

    function pollstat_afterUpdate(array $data)
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
    
if (!function_exists('pollstat_beforeDelete'))
{

    function pollstat_beforeDelete(array $data): array
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
    
if (!function_exists('pollstat_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from PollstatModel
     * 
     * @param array $data
     */
    function pollstat_afterDelete(array $data)
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


if (!function_exists('savePollstat'))
{

    function savePollstat(array $data)
    {
        $PollstatModel = new \Voters\Models\PollstatModel();
        

        if ($PollstatModel->save($data) !== false)
        {
            if (empty($data['id']))
            {
                return $PollstatModel->getInsertID();
            }
            else
            {
                return $data['id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllPollstat'))
{

    function getAllPollstat($where = null, $limit=null, $orderBy = 'id')
    {
        $PollstatModel = new \Voters\Models\PollstatModel();
        
        
        //status Field
        $PollstatModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $PollstatModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $PollstatModel->whereIn('id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $PollstatModel->limit($limit);
        }
        
        $PollstatModel->orderBy($orderBy, 'asc');

        return $PollstatModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getPollstat'))
{

    function getPollstat($where = null, $order_by=null, $select='*')
    {
        $PollstatModel = new \Voters\Models\PollstatModel();
        
        
        //status Field
        $PollstatModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['id' => $where];
            }
            
            $PollstatModel->where($where);
        }

        $PollstatModel->select($select);

        if (empty($order_by))
        {
            return $PollstatModel->first();
        }
        else
        {
            return $PollstatModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastPollstat'))
{
    
    function getLastPollstat($where = null)
    {
        return getPollstat($where, 'id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updatePollstat'))
{

    function updatePollstat(array $data, $where = null)
    {

        $PollstatModel = new \Voters\Models\PollstatModel();

        if (!empty($where))
        {
            $PollstatModel->where($where);
        }
        

        $PollstatModel->set($data);

        return  $PollstatModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deletePollstat'))
{

    function deletePollstat($where)
    {
        $PollstatModel = new \Voters\Models\PollstatModel();
        

        if(is_numeric($where))
        {
            return $PollstatModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $PollstatModel->select('id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $PollstatModel->delete($data['id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countPollstat'))
{

    function countPollstat($where = null)
    {
        $PollstatModel = new \Voters\Models\PollstatModel();        
        
        //status Field
        $PollstatModel->where('status', 1);
        

        if (!empty($where))
        {            
            $PollstatModel->where($where);
        }

        return $PollstatModel->countAllResults();
    }

}