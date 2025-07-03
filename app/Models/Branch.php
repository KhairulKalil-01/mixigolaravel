<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'branch_name',
        'email',
        'city',
        'state',
        'address',
        'mobileno',
    ];

    public function caregivers()
    {
        return $this->hasMany(Caregiver::class, 'branch_id');
    }
}
