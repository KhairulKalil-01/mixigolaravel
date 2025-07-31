<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $guarded =[];
    protected $table = 'nationalities';

    public function caregivers()
    {
        return $this->hasMany(Caregiver::class);
    }
}
