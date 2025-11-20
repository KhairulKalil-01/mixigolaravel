<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrepaidDeduction extends Model
{
    protected $guarded = [];

    public function prepaidRecord()
    {
        return $this->belongsTo(PrepaidRecord::class);
    }
}
