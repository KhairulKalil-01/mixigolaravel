<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalAgent extends Model
{
    protected $guarded = [];

    // commissions

    public function bank()
    {
        return $this->belongsTo(BankList::class, 'bank_id');
    }
}
