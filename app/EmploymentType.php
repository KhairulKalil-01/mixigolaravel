<?php

namespace App;

enum EmploymentType: int
{
    case FullTime = 1;
    case PartTime = 2;
    case Permanent = 3;

    public function label(): string
    {
        return match ($this) {
            self::FullTime => 'Full-time',
            self::PartTime => 'Part-time',
            self::Permanent => 'Permanent',
            default => 'Unknown',
        };
    }
}
