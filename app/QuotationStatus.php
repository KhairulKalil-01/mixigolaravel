<?php

namespace App;

enum QuotationStatus: int
{
    case Draft = 0;
    case Pending = 1;
    case Accepted = 2;
    case Cancelled = 3;

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending',
            self::Accepted => 'Accepted',
            self::Cancelled => 'Cancelled',
            default => 'Unknown',
        };
    }
}
