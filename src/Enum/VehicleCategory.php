<?php

namespace App\Enum;

enum VehicleCategory: string
{
    case Motorcycle = 'motorcycle';
    case Car = 'car';
    case Van = 'van';
    case Truck = 'truck';

    public function label(): string
    {
        return match ($this) {
            self::Motorcycle => 'Moto',
            self::Car => 'Véhicule léger (VL)',
            self::Van => 'Utilitaire léger (VUL)',
            self::Truck => 'Poids lourd (PL)',
        };
    }
}
