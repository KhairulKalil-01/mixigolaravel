<?php

namespace App\Models;

use App\StaffOvertimeStatus;
use Illuminate\Database\Eloquent\Model;

class StaffOvertime extends Model
{
    protected $table = 'staff_overtimes';
    protected $guarded = [];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusLabelAttribute()
    {
        $status = StaffOvertimeStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }

    public function getDateLabelAttribute()
    {
        return $this->overtime_date ? $this->overtime_date->format('Y-m-d') : null;
    }
}
