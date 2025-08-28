<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAllowance extends Model
{
    protected $table = 'staff_allowances';
    protected $guarded = [];

    public function salaryStructure()
    {
        return $this->belonngsTo(SalaryStructure::class);
    }
}
