<?php

namespace App;

enum StaffPayrollBatchStatus: int
{
    case Pending = 0;
    case Approved = 1;
    case Locked = 2;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Locked => 'Locked',
            default => 'Unknown',
        };
    }
}
