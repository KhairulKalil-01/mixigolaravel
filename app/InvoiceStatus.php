<?php

namespace App;

enum InvoiceStatus: int
{
    case Unpaid = 0;
    case Paid = 1;
    case Cancelled = 2;
    case Refunded = 100;

    public function label(): string
    {
        return match ($this) {
            self::Unpaid => 'Unpaid',
            self::Paid => 'Paid',
            self::Cancelled => 'Cancelled',
            self::Refunded => 'Refunded',
            default => 'Unknown',
        };
    }
}