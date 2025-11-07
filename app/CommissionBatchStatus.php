<?php

namespace App;

enum CommissionBatchStatus: int
{
    case Pending = 0;
    case Completed = 1;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Completed => 'Completed',
            default => 'Unknown',
        };
    }
}
