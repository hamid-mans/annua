<?php
namespace App\Enum;

enum VehicleUsage: string
{
    case Service = "service";
    case Fonction = "fonction";

    public function label(): string
    {
        return match ($this) {
            self::Service => "Véhicule de service",
            self::Fonction => "Véhicule de fonction",
        };
    }
}
