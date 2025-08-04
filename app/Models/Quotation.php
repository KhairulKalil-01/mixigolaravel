<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\QuotationStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $status = QuotationStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }
}
