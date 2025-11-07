<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPayrollRecordItem extends Model
{
    protected $guarded = [];

    public function record()
    {
        return $this->belongsTo(StaffPayrollRecord::class);
    }

}
