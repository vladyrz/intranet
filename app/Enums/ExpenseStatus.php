<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ExpenseStatus: string implements HasLabel, HasColor
{
    case Active = 'active';
    case Cancelled = 'cancelled';
    case Suspended = 'suspended';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Vigente',
            self::Cancelled => 'Cancelado',
            self::Suspended => 'Suspendido',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Active => 'success',
            self::Cancelled => 'danger',
            self::Suspended => 'warning',
        };
    }
}
