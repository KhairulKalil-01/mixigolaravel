<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\CommissionBatchStatus;
use App\Models\CommissionClaim;

class CommissionBatch extends Model
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

    public function commissionRecords()
    {
        return $this->hasMany(CommissionBatchRecord::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->commissions()->sum('amount');
    }

    public function getStatusLabelAttribute(): string
    {
        $status = CommissionBatchStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }
}
