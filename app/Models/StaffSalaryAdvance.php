<?php

namespace App\Models;

use App\SalaryAdvanceStatus;
use Illuminate\Database\Eloquent\Model;

class StaffSalaryAdvance extends Model
{
    protected $guarded = [];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payroll()
    {
        return $this->belongsTo(StaffPayrollBatch::class, 'payroll_id');
    }

    public function getStatusLabelAttribute(): string
    {
        $status = SalaryAdvanceStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }
}
