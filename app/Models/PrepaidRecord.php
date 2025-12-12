<?php

namespace App\Models;

use App\PrepaidRecordStatus;
use Illuminate\Database\Eloquent\Model;

class PrepaidRecord extends Model
{
    protected $guarded = [];

    public function prepaidDeductions()
    {
        return $this->hasMany(PrepaidDeduction::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function quotationItem()
    {
        return $this->belongsTo(QuotationItem::class);
    }

    public function serviceJobs()
    {
        return $this->hasMany(ServiceJob::class);
    }

    //calculated 
    public function getRemainingHourAttribute()
    {
        return $this->package_hour - $this->prepaidDeductions()->sum('deducted_hour');
    }

    public function totalDeductedHour()
    {
        return $this->prepaidDeductions()->sum('deducted_hour');
    }

    public function balanceHour()
    {
        return $this->package_hour - $this->totalDeductedHour();
    }

    public function getStatusLabelAttribute(): string
    {
        $status = PrepaidRecordStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }


}
