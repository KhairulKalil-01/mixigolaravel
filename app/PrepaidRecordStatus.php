<?php

namespace App;

enum PrepaidRecordStatus : int
{
    case Active = 1;
    case Refund = 2;
    case Expired = 3;

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Refund => 'Refund',
            self::Expired => 'Expired',
            default => 'Unknown',
        };
    }
}