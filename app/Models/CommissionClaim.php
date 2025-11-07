<?php

namespace App\Models;

use App\CommissionClaimStatus;
use Illuminate\Database\Eloquent\Model;

class CommissionClaim extends Model
{
    protected $guarded = [];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function externalAgent()
    {
        return $this->belongsTo(ExternalAgent::class, 'external_agent_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function getStatusLabelAttribute(): string
    {
        $status = CommissionClaimStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }

    // Accessor to get the claimer's name 'claimer_name'
    public function getClaimerNameAttribute()
    {
        if ($this->staff_id) {
            return ($this->staff->full_name ?? 'N/A');
        }

        if ($this->external_agent_id) {
            return ($this->externalAgent->name ?? 'N/A');
        }

        return 'N/A';
    }

    // Accessor to get the claimr type 'claimer_type'
    public function getClaimerTypeAttribute()
    {
        if ($this->staff_id) {
            return 'Staff';
        }

        if ($this->external_agent_id) {
            return 'External Agent';
        }

        return 'N/A';
    }

    public function commissionBatchRecord()
    {
        return $this->hasOne(CommissionBatchRecord::class, 'commission_claim_id');
    }
}
