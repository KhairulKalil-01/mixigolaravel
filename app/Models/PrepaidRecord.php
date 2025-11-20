<?php

namespace App\Models;

use App\Prepaid;
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

    //calculated 
    public function totalDeductedHour()
    {
        return $this->prepaidDeductions()->sum('deducted_hour');
    }

    public function balanceHour()
    {
        return $this->package_hour - $this->totalDeductedHour();
    }

    // getter
    public function getStatusLabelAttribute(): string
    {
        $status = PrepaidRecordStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }


}
