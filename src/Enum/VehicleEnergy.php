<?php

namespace App\Enum;

enum VehicleEnergy: string
{
    case Petrol = 'petrol';
    case Diesel = 'diesel';
    case Electric = 'electric';
    case Hybrid = 'hybrid';
    case Lpg = 'lpg';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Petrol => 'Essence',
            self::Diesel => 'Diesel',
            self::Electric => 'Électrique',
            self::Hybrid => 'Hybride',
            self::Lpg => 'GPL',
            self::Other => 'Autre',
        };
    }
}
