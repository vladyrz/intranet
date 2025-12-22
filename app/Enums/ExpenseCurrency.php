<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ExpenseCurrency: string implements HasLabel
{
    case CRC = 'crc';
    case USD = 'usd';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CRC => 'CRC (Colones)',
            self::USD => 'USD (Dollars)',
        };
    }
}
