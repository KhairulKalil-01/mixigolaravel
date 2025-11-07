<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\StaffPayrollRecordStatus;

class StaffPayrollRecord extends Model
{
    protected $guarded = [];

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

    public function getStatusRecordLabelAttribute()
    {
        $status = StaffPayrollRecordStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }

}
