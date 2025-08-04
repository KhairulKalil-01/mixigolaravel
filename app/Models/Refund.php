<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\RefundStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    protected $guarded =[];
    use SoftDeletes; 

    public function invoice()
    {
        return $this->belongsTo((Invoice::class));
    }

    public function client()
    {
        return $this->belongsTo((Client::class));
    }

    public function creditNote()
    {
        return $this->belongsTo((CreditNote::class));
    }

    public function bank()
    {
        return $this->belongsTo((BankList::class));
    }

    public function getStatusLabelAttribute(): string
    {
        $status = RefundStatus::tryFrom($this->status);
        return $status?->label() ?? 'Unknown';
    }
}
