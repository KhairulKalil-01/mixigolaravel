<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceJob extends Model
{
    protected $guarded = [];
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'status' => \App\ServiceJobStatus::class,
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function caregiver()
    {
        return $this->belongsTo(Caregiver::class);
    }

    public function prepaidRecord()
    {
        return $this->belongsTo(PrepaidRecord::class);
    }

    public function prepaidDeduction()
    {
        return $this->hasOne(PrepaidDeduction::class);
    }

    // Check overlap helper - returns boolean if overlaps with given range
    public static function hasOverlap($caregiverId, $start, $end)
    {
        return self::where('caregiver_id', $caregiverId)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_datetime', [$start, $end])
                    ->orWhereBetween('end_datetime', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_datetime', '<', $start)
                            ->where('end_datetime', '>', $end);
                    });
            })->exists();
    }
}
