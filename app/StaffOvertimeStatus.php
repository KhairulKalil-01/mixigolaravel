<?php

namespace App;

enum StaffOvertimeStatus: int
{
    case Pending = 0;
    case Approved = 1;
    case Rejected = 2;
    case Locked = 3;
    case Completed = 4;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Locked => 'Locked',
            self::Completed => 'Completed',
            default => 'Unknown',
        };
    }
}
