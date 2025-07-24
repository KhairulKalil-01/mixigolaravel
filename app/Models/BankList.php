<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankList extends Model
{
    protected $guarded = [];

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
