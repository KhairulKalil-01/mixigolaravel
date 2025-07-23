<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditNote extends Model
{
    use SoftDeletes;

    protected $guarded =[];
    protected $table = 'credit_notes';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function clientPayment()
    {
        return $this->belongsTo(ClientPayment::class);
    }

    public function refund()
    {
        return $this->hasOne(Refund::class);
    }
}
