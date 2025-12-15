<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum ReminderType: string implements HasLabel, HasColor
{
    case General = 'general';
    case Billing = 'billing';
    case FollowUp = 'follow_up';
    case Ops = 'ops';
    case System = 'system';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::General => 'General',
            self::Billing => 'Billing',
            self::FollowUp => 'Follow Up',
            self::Ops => 'Operations',
            self::System => 'System',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::General => 'gray',
            self::Billing => 'danger',
            self::FollowUp => 'warning',
            self::Ops => 'info',
            self::System => 'success',
        };
    }
}
