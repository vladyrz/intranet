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
            self::OneTime => 'One Time',
            self::Biweekly => 'Biweekly (Every 2 Weeks)',
            self::Monthly => 'Monthly',
            self::Quarterly => 'Quarterly',
            self::Semiannual => 'Semiannual (Every 6 Months)',
            self::Annual => 'Annual',
        };
    }
}
