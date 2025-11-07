<?php

namespace App;

enum StaffPayrollRecordStatus:int
{
    case Pending = 0;
    case Approved = 1;
    case Paid = 2;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Paid => 'Paid',
            default => 'Unknown',
        };
    }
}

