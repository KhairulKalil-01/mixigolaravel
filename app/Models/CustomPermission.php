<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class CustomPermission extends SpatiePermission
{
    protected $guarded = [''];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
