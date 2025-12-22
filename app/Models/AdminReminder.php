<?php

namespace App\Models;

use App\Enums\ReminderFrequency;
use App\Enums\ReminderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminReminder extends Model
{
    protected $fillable = [
        'user_id',
        'frequency',
        'type',
        'content',
        'is_active',
        'starts_at',
        'ends_at',
        'last_sent_at',
        'next_run_at',
        'failure_count',
        'last_error_message',
        'last_error_trace',
        'last_failed_at',
    ];

    protected $casts = [
        'frequency' => ReminderFrequency::class,
        'type' => ReminderType::class,
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'last_sent_at' => 'datetime',
        'next_run_at' => 'datetime',
        'last_failed_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function (AdminReminder $reminder) {
            if (!$reminder->next_run_at && $reminder->starts_at) {
                $reminder->next_run_at = $reminder->calculateNextRunAt();
            }
        });
    }

    public function calculateNextRunAt(): ?\Carbon\CarbonImmutable
    {
        $timezone = 'America/Costa_Rica';
        $now = now($timezone);

        // Base calculation on starts_at or last_sent_at
        // If never sent, use starts_at. If sent, calculate next from last_sent_at.
        // However, if starts_at is in future, wait until then.

        $baseDate = $this->last_sent_at
            ? $this->last_sent_at->setTimezone($timezone)
            : $this->starts_at->setTimezone($timezone);

        // If we haven't sent it yet, but starts_at is in the past, scheduling should probably happen "now" or "tomorrow 8am" depending on logic.
        // Requirement: "Siempre a las 8:00 AM CR".

        $targetTime = \Carbon\CarbonImmutable::parse($baseDate)->setTime(8, 0, 0);

        // If it's the first run (no last_sent_at), we respect starts_at date but force 8am.
        if (!$this->last_sent_at) {
            // Ensure we don't schedule in the past if starts_at is today 7am and now is 9am.
            if ($targetTime->isPast() && $this->starts_at->isPast()) {
                // If starts_at was "yesterday", and we create it today, should we run "tomorrow"?
                // Let's assume we run "next valid slot".
                // But for simplified logic: Just use starts_at date at 8am.
                // If that point is past, add frequency.
                // Actually better:
                // Check if starts_at is today/future.
                if ($targetTime->isFuture()) {
                    return $targetTime;
                }
                // If targetTime is past, we need to advance it using frequency until future.
            } else {
                // Future starts_at
                return $targetTime;
            }
        }

        // Logic for "Next" occurencce
        return match ($this->frequency) {
            ReminderFrequency::Daily => $targetTime->addDay(),
            ReminderFrequency::Weekly => $targetTime->addWeek(),
            ReminderFrequency::Monthly => $targetTime->addMonthNoOverflow(),
            ReminderFrequency::Quarterly => $targetTime->addMonthsNoOverflow(3),
            ReminderFrequency::Yearly => $targetTime->addYearNoOverflow(),
        };
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function runs(): HasMany
    {
        return $this->hasMany(AdminReminderRun::class);
    }
}
