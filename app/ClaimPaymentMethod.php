<?php

namespace App;

enum ClaimPaymentMethod: int
{
    case PettyCash = 1;
    case BankTransfer = 2;

    public function label(): string
    {
        return match ($this) {
            self::PettyCash => 'Petty Cash',
            self::BankTransfer => 'Bank Transfer',
            default => 'Not Set',
        };
    }
}
