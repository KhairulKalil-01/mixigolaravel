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

    public function bank()
    {
        return $this->belongsTo(BankList::class, 'bank_id');
    }

    public function salaryStructures()
    {
        return $this->hasMany(SalaryStructure::class);
    }

    public function currentSalaryStructure()
    {
        $today = now()->format('Y-m-d');

        return $this->hasOne(SalaryStructure::class)
            ->where('effective_from', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', $today);
            })
            ->latestOfMany();
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

    public function payrollRecords()
    {
        return $this->hasMany(StaffPayrollRecord::class);
    }

    public function salaryAdvances()
    {
        return $this->hasMany(StaffSalaryAdvance::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function commissionClaims()
    {
        return $this->hasMany(CommissionClaim::class);
    }

    public function commissionBatchRecords()
    {
        return $this->hasMany(CommissionBatchRecord::class);
    }

}
