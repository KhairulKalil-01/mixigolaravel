<?php

namespace App\Models;

use App\StaffClaimStatus;
use App\ClaimPaymentMethod;
use Illuminate\Database\Eloquent\Model;

class StaffClaim extends Model
{
    protected $guarded = [];
    protected $casts = [
        'claim_date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo((Staff::class));
    }

    public function getStatusLabelAttribute(): string
    {
        $status = StaffClaimStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        $payment_method = ClaimPaymentMethod::tryFrom($this->payment_method);
        return $payment_method?->label() ?? 'Unknown';
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
