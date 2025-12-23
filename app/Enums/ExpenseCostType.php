<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ExpenseCostType: string implements HasLabel
{
    case OneTime = 'one_time';
    case Biweekly = 'biweekly';
    case Monthly = 'monthly';
    case Quarterly = 'quarterly';
    case Semiannual = 'semiannual';
    case Annual = 'annual';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OneTime => 'Único',
            self::Biweekly => 'Quincenal (Cada 2 semanas)',
            self::Monthly => 'Mensual',
            self::Quarterly => 'Trimestral',
            self::Semiannual => 'Semestral (Cada 6 meses)',
            self::Annual => 'Anual',
        };
    }
}
