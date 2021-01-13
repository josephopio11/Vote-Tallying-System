<?php
namespace Agents\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_subscription';
    protected $primaryKey     = 'c4_subscription_id';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ["c4_subscription_id","company_id","subscription_status","due_date","plan_duration","trail_start_date","trial_end_date","subscription_start_date","subscription_end_date","created_at","updated_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = '';

}