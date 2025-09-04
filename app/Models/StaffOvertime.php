<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffOvertime extends Model
{
    protected $guarded = [];
    protected $casts = [
        'overtime_date' => 'date',
        'hours' => 'integer',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
