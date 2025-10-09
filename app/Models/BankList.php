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

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'bank_id');
    }

    public function externalAgents()
    {
        return $this->hasMany((ExternalAgent::class), 'bank_id');
    }
}
