<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomPermission;

class Module extends Model
{
    public function permissions()
    {
        return $this->hasMany(CustomPermission::class);
    }
}
