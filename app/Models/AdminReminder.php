<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class AdminReminder extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'user_id',
        'reminder_type',
        'follow_up_date',
        'frequency',
        'task_details',
        'last_sent_at',
        'next_due_at',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'last_sent_at'   => 'datetime',
        'next_due_at'    => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function computeNextDueAt(?Carbon $from = null): Carbon
    {
        $from ??= now();
        $base = $this->follow_up_date instanceof Carbon
            ? $this->follow_up_date->copy()->setTimeFrom($from)
            : Carbon::parse($this->follow_up_date)->setTimeFrom($from);

        return match ($this->frequency) {
            'weekly'        => $this->nextMondayOnOrAfter($from),
            'biweekly'      => $this->nextBiweeklyMonday($from),
            'monthly'       => $this->nextByMonthStep($from, 1, $base->day),
            'quarterly'     => $this->nextByMonthStep($from, 3, $base->day),
            'semiannual'    => $this->nextByMonthStep($from, 6, $base->day),
            'annual'        => $this->nextByMonthStep($from, 12, $base->day),
            default         => $from->copy()->addDay(),
        };
    }

    protected function nextMondayOnOrAfter(Carbon $ref): Carbon
    {
        return $ref->isMonday() ? $ref->copy() : $ref->copy()->next('monday');
    }

    /** Biweekly: 1st and 3rd monday of the month */
    protected function nextBiweeklyMonday(Carbon $ref): Carbon
    {
        $candidate = $this->nthMondaysOfMonth($ref->copy()->startOfMonth());
        foreach ($candidate as $day) {
            if ($day->isSameDay($ref) || $day->greaterThan($ref)) {
                return $day->setTimeFrom($ref);
            }
        }
        $nextMonth = $ref->copy()->addMonthNoOverflow()->startOfMonth();
        $candidate = $this->nthMondaysOfMonth($nextMonth);
        return $candidate[0]->setTimeFrom($ref);
    }

    protected function nthMondaysOfMonth(Carbon $monthStart): array
    {
        $firstMonday = $monthStart->copy()->nextOrSame('monday');
        $thirdMonday = $firstMonday->copy()->addDays(2);
        return [$firstMonday, $thirdMonday];
    }

    protected function nextByMonthStep(Carbon $ref, int $stepMonths, int $targetDay): Carbon
    {
        $candidate = $this->anchorMonthDayOnOrAfter($ref->copy(), $stepMonths, $targetDay);
        if ($candidate->lessThan($ref)) {
            $candidate = $this->anchorMonthDayOnOrAfter(
                $ref->copy()->addMonthsNoOverflow($stepMonths), $stepMonths, $targetDay
            );
        }
        return $candidate->setTimeFrom($ref);
    }

    protected function anchorMonthDayOnOrAfter(Carbon $ref, int $stepMonths, int $targetDay): Carbon
    {
        $monthEnd = $ref->copy()->endOfMonth();
        $day = min($targetDay, (int) $monthEnd->day);
        $candidate = $ref->copy()->day($day);
        if ($candidate->lessThan($ref)) {
            $ref = $ref->copy()->addMonthsNoOverflow($stepMonths)->startOfMonth();
            $monthEnd = $ref->copy()->endOfMonth();
            $day = min($targetDay, (int) $monthEnd->day);
            $candidate = $ref->copy()->day($day);
        }
        return $candidate;
    }

    public function isDueNow(?Carbon $now = null): bool
    {
        $now ??= now();
        if (!$this->next_due_at) return false;

        // “vence hoy” y aún no se ha enviado para este corte
        return $this->next_due_at->isSameDay($now)
            && ($this->last_sent_at?->lt($this->next_due_at) || !$this->last_sent_at);
    }

    public function bumpToNextDue(): void
    {
        $this->next_due_at = $this->computeNextDueAt(now()->addMinute());
        $this->saveQuietly();
    }

    protected static function booted(): void
    {
        static::saving(function (AdminReminder $model) {
            if (!$model->next_due_at) {
                $model->next_due_at = $model->computeNextDueAt();
            }
        });
    }
}
