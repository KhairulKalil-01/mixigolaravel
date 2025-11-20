<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\InvoiceStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(ClientPayment::class);
    }

    public function creditNotes()
    {
        return $this->hasMany(CreditNote::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $status = InvoiceStatus::tryFrom($this->payment_status);
        return $status?->label() ?? 'Unknown';
    }

    public function commissionClaim()
    {
        return $this->hasOne(commissionClaim::class);
    }

    public function prepaidRecords()
    {
        return $this->hasMany(PrepaidRecord::class);
    }

}
