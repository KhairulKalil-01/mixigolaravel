<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class CustomPermission extends SpatiePermission
{
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
