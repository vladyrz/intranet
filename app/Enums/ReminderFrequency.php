<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReminderFrequency: string implements HasLabel
{
    case Daily = 'daily';
    case Weekly = 'weekly';
    case Monthly = 'monthly';
    case Quarterly = 'quarterly';
    case Yearly = 'yearly';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Daily => 'Diariamente',
            self::Weekly => 'Semanalmente',
            self::Monthly => 'Mensualmente',
            self::Quarterly => 'Trimestralmente',
            self::Yearly => 'Anualmente',
        };
    }
}
