<?php

//--------------------------------------------------------------------
/**
 * polllist Helper
 *
 * polllist_beforeInsert, polllist_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('polllist_beforeInsert'))
{

    function polllist_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('polllist_afterInsert'))
{

    function polllist_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('polllist_beforeUpdate'))
{

    function polllist_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('polllist_afterUpdate'))
{

    function polllist_afterUpdate(array $data)
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
    
if (!function_exists('polllist_beforeDelete'))
{

    function polllist_beforeDelete(array $data): array
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
    
if (!function_exists('polllist_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from PolllistModel
     * 
     * @param array $data
     */
    function polllist_afterDelete(array $data)
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


if (!function_exists('savePolllist'))
{

    function savePolllist(array $data)
    {
        $PolllistModel = new \Tally\Models\PolllistModel();
        

        if ($PolllistModel->save($data) !== false)
        {
            if (empty($data['id']))
            {
                return $PolllistModel->getInsertID();
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
                
if (!function_exists('getAllPolllist'))
{

    function getAllPolllist($where = null, $limit=null, $orderBy = 'id')
    {
        $PolllistModel = new \Tally\Models\PolllistModel();
        
        
        //status Field
        $PolllistModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $PolllistModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $PolllistModel->whereIn('id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $PolllistModel->limit($limit);
        }
        
        $PolllistModel->orderBy($orderBy, 'asc');

        return $PolllistModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getPolllist'))
{

    function getPolllist($where = null, $order_by=null, $select='*')
    {
        $PolllistModel = new \Tally\Models\PolllistModel();
        
        
        //status Field
        $PolllistModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['id' => $where];
            }
            
            $PolllistModel->where($where);
        }

        $PolllistModel->select($select);

        if (empty($order_by))
        {
            return $PolllistModel->first();
        }
        else
        {
            return $PolllistModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastPolllist'))
{
    
    function getLastPolllist($where = null)
    {
        return getPolllist($where, 'id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updatePolllist'))
{

    function updatePolllist(array $data, $where = null)
    {

        $PolllistModel = new \Tally\Models\PolllistModel();

        if (!empty($where))
        {
            $PolllistModel->where($where);
        }
        

        $PolllistModel->set($data);

        return  $PolllistModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deletePolllist'))
{

    function deletePolllist($where)
    {
        $PolllistModel = new \Tally\Models\PolllistModel();
        

        if(is_numeric($where))
        {
            return $PolllistModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $PolllistModel->select('id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $PolllistModel->delete($data['id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countPolllist'))
{

    function countPolllist($where = null)
    {
        $PolllistModel = new \Tally\Models\PolllistModel();        
        
        //status Field
        $PolllistModel->where('status', 1);
        

        if (!empty($where))
        {            
            $PolllistModel->where($where);
        }

        return $PolllistModel->countAllResults();
    }

}