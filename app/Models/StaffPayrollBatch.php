<?php

namespace App\Models;

use App\StaffPayrollBatchStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class StaffPayrollBatch extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($batch) {
            if (! $batch->month) {
                $batch->month = now()->month;
            }

            $year = $batch->year ?? now()->year;
            $month = $batch->month;

            // End date = 27th of current batch month
            $batch->period_end = Carbon::create($year, $month, 27);

            // Start date = 28th of previous month
            $batch->period_start = $batch->period_end->copy()->subMonthNoOverflow()->day(28);
        });
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function salaryAdvances()
    {
        return $this->hasMany(StaffSalaryAdvance::class, 'payroll_id');
    }

    public function records()
    {
        return $this->hasMany(StaffPayrollRecord::class);
    }

    public function getStatusLabelAttribute()
    {
        $status = StaffPayrollBatchStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }
}
