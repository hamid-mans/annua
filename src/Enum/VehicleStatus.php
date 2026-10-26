<?php

namespace App\Enum;

enum VehicleStatus: string
{
    case Active = 'active';
    case InMaintenance = 'in_maintenance';
    case Retired = 'retired';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'En service',
            self::InMaintenance => 'En maintenance',
            self::Retired => 'Sorti du parc',
        };
    }
}
