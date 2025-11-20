<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\StaffPayrollRecordStatus;

class StaffPayrollRecord extends Model
{
    protected $guarded = [];
    protected $appends = [
        'overtime_total',
        'allowances_total',
        'deductions_total',
        'net_salary',
        'status_record_label'
    ];

    public function batch()
    {
        return $this->belongsTo(StaffPayrollBatch::class, 'staff_payroll_batch_id');
    }

    public function items()
    {
        return $this->hasMany(StaffPayrollRecordItem::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // getters
    public function getStatusRecordLabelAttribute()
    {
        $status = StaffPayrollRecordStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }

    public function getOvertimeTotalAttribute()
    {
        return (float) $this->items()->where('description', 'like', 'Overtime%')->sum('amount') ?? 0;
    }

    public function getAllowancesTotalAttribute()
    {
        return (float) $this->items()->where('description', 'like', 'Allowance:%')->sum('amount') ?? 0;
    }

    public function getDeductionsTotalAttribute()
    {
        return (float) $this->items()->where('type', 2)->sum('amount');
    }

    public function getNetSalaryAttribute()
    {
        $earnings = (float) $this->items()->where('type', 1)->sum('amount');
        $deductions = (float) $this->items()->where('type', 2)->sum('amount');
        return $earnings - $deductions;
    }
}
