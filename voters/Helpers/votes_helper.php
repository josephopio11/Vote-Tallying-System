<?php

//--------------------------------------------------------------------
/**
 * votes Helper
 *
 * votes_beforeInsert, votes_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('votes_beforeInsert'))
{

    function votes_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('votes_afterInsert'))
{

    function votes_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('votes_beforeUpdate'))
{

    function votes_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('votes_afterUpdate'))
{

    function votes_afterUpdate(array $data)
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
    
if (!function_exists('votes_beforeDelete'))
{

    function votes_beforeDelete(array $data): array
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
    
if (!function_exists('votes_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from VotesModel
     * 
     * @param array $data
     */
    function votes_afterDelete(array $data)
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


if (!function_exists('saveVotes'))
{

    function saveVotes(array $data)
    {
        $VotesModel = new \Voters\Models\VotesModel();
        

        if ($VotesModel->save($data) !== false)
        {
            if (empty($data['id']))
            {
                return $VotesModel->getInsertID();
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
                
if (!function_exists('getAllVotes'))
{

    function getAllVotes($where = null, $limit=null, $orderBy = 'id')
    {
        $VotesModel = new \Voters\Models\VotesModel();
        
        
        //status Field
        $VotesModel->where('status', 1);

        if (!empty($where))
        {
            if(is_array($where))
            {
              $VotesModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $VotesModel->whereIn('id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $VotesModel->limit($limit);
        }
        
        $VotesModel->orderBy($orderBy, 'asc');

        return $VotesModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getVotes'))
{

    function getVotes($where = null, $order_by=null, $select='*')
    {
        $VotesModel = new \Voters\Models\VotesModel();
        
        
        //status Field
        $VotesModel->where('status', 1);

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['id' => $where];
            }
            
            $VotesModel->where($where);
        }

        $VotesModel->select($select);

        if (empty($order_by))
        {
            return $VotesModel->first();
        }
        else
        {
            return $VotesModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastVotes'))
{
    
    function getLastVotes($where = null)
    {
        return getVotes($where, 'id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateVotes'))
{

    function updateVotes(array $data, $where = null)
    {

        $VotesModel = new \Voters\Models\VotesModel();

        if (!empty($where))
        {
            $VotesModel->where($where);
        }
        

        $VotesModel->set($data);

        return  $VotesModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteVotes'))
{

    function deleteVotes($where)
    {
        $VotesModel = new \Voters\Models\VotesModel();
        

        if(is_numeric($where))
        {
            return $VotesModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $VotesModel->select('id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $VotesModel->delete($data['id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countVotes'))
{

    function countVotes($where = null)
    {
        $VotesModel = new \Voters\Models\VotesModel();        
        
        //status Field
        $VotesModel->where('status', 1);
        

        if (!empty($where))
        {            
            $VotesModel->where($where);
        }

        return $VotesModel->countAllResults();
    }

}