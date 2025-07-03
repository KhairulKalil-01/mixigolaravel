<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use App\EmploymentType;

class Caregiver extends Model
{
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function bank()
    {
        return $this->belongsTo(BankList::class, 'bank_list_id');
    }

    public function getEmploymentTypeLabelAttribute(): string
    {
        $employmentType = EmploymentType::tryFrom($this->employment_type);

        return $employmentType?->label() ?? 'Unknown';
    }
}
