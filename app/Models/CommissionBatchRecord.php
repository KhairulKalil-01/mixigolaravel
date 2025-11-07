<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionBatchRecord extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function commissionBatch()
    {
        return $this->belongsTo(CommissionBatch::class, 'commission_batch_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function externalAgent()
    {
        return $this->belongsTo(ExternalAgent::class, 'external_agent_id');

    }

    public function commissionClaim()
    {
        return $this->belongsTo(CommissionClaim::class, 'commission_claim_id');
    }

}
