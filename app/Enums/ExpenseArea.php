<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ExpenseArea: string implements HasLabel
{
    case Technology = 'technology';
    case HumanResources = 'human_resources';
    case Sales = 'sales';
    case Marketing = 'marketing';
    case Operations = 'operations';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Technology => 'Technology',
            self::HumanResources => 'Human Resources',
            self::Sales => 'Sales',
            self::Marketing => 'Marketing',
            self::Operations => 'Operations',
        };
    }
}
