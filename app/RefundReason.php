<?php

namespace App;

enum RefundReason: int
{
    
    case Deceased = 1;
    case Dissatisfied = 2;
    case Overpayment = 3;
    case ServiceDowngrade = 4;
    case CaregiverNotAvailable = 5;
    case CaregiverNoShow = 6;
    case CaregiverLeftEarly = 7;
    case Other = 8;

    public function label(): string
    {
        return match ($this) {
            self::Deceased => 'Deceased',
            self::Dissatisfied => 'Dissatisfied',
            self::Overpayment => 'Overpayment',
            self::ServiceDowngrade => 'Service Downgrade',
            self::CaregiverNotAvailable => 'Caregiver Not Available',
            self::CaregiverNoShow => 'Caregiver No Show',
            self::CaregiverLeftEarly => 'Caregiver Left Early',
            self::Other => 'Other',
            default => 'Unknown',
        };
    }
}
