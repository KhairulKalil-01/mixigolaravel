<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staffs';
    protected $guarded = [];
    protected $casts = [
        'joining_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function salaryStructure()
    {
        return $this->hasOne(SalaryStructure::class);
    }

    public function claims()
    {
        return $this->hasMany(StaffClaim::class);
    }

    public function overtimes()
    {
        return $this->hasMany(StaffOvertime::class);
    }

    public function payrolls()
    {
        return $this->hasMany(StaffPayrollBatch::class);
    }
}
