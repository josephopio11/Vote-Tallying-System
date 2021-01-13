<?php
namespace App\Log;

use CodeIgniter\Model;

class LogModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_log';
    protected $primaryKey     = 'c4_log_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_log_id", "level", "message", "ip", 'userAgent', 'uri', 'session', 'get', 'post', "created_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = null;
    protected $deletedField   = null;

    public function deleteExperidData(int $expiredPeriod = null)
    {
        //%20 percentage to delete experidData 
        if (rand(1, 100) < 21)
        {
            $this->where('created_at <', date('Y-m-d H:i:s', time() - $expiredPeriod))->delete();
        }
    }
}
