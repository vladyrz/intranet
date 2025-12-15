<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum ReminderStatus: string implements HasLabel, HasColor
{
    case Success = 'success';
    case Failed = 'failed';
    case Pending = 'pending'; // For run history
    case Skipped = 'skipped'; // For run history if needed

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Success => 'Success',
            self::Failed => 'Failed',
            self::Pending => 'Pending',
            self::Skipped => 'Skipped',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Success => 'success',
            self::Failed => 'danger',
            self::Pending => 'warning',
            self::Skipped => 'gray',
        };
    }
}
