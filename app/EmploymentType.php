<?php

namespace App;

enum EmploymentType: int
{
    case FullTime = 1;
    case PartTime = 2;

    public function label(): string
    {
        return match ($this) {
            self::FullTime => 'Full-time',
            self::PartTime => 'Part-time',
            default => 'Unknown',
        };
    }
}
