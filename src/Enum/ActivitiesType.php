<?php
namespace App\Enum;

enum ActivitiesType: string
{
    case Note = "note";
    case Workflow = "workflow";

    public function label(): string
    {
        return match ($this) {
            self::Note => "Note interne",
            self::Workflow => "Statut du véhicule"
        };
    }
}