<?php

namespace Agents\Models;

use CodeIgniter\Model;

class C4_email_trackModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_email_track';
    protected $primaryKey     = 'c4_email_track_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_email_track_id","c4_email_history_id","browser","ip","created_at","updated_at","deleted_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeDelete   = ['beforeDelete'];
    protected $afterDelete    = ['afterDelete'];
    protected $afterFind      = ['afterFind'];

    //--------------------------------------------------------------------

    /**
     * Return DB fields which ones are allowed
     * @return array
     */
    public function getAllowedFields(): array
    {

        return $this->allowedFields;
    }

    //--------------------------------------------------------------------

    protected function beforeInsert(array $data)
    {
        
        if (function_exists('c4_email_track_beforeInsert'))
        {
            return c4_email_track_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_email_track_afterInsert'))
        {
            c4_email_track_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_email_track_beforeUpdate'))
        {
            return c4_email_track_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_email_track_afterUpdate'))
        {
            c4_email_track_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_email_track_beforeDelete'))
        {
            return c4_email_track_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_email_track_afterDelete'))
        {
            c4_email_track_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_email_track_afterFind'))
        {
            return c4_email_track_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}