<?php

namespace App;

enum ClaimPaymentMethod: int
{
    case PettyCash = 1;
    case BankTransfer = 2;
    case Payroll = 3;

    public function label(): string
    {
        return match ($this) {
            self::PettyCash => 'Petty Cash',
            self::BankTransfer => 'Bank Transfer',
            self::Payroll => 'Payroll',
            default => 'Not Set',
        };
    }
}
