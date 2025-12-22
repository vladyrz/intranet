<?php

namespace App\Traits;

use App\Enums\ExpenseCostType;
use App\Enums\ReminderFrequency;
use Carbon\CarbonImmutable;

trait HasFrequency
{
    /**
     * Calculate the next run date based on start date, last run date, and frequency.
     * 
     * @param \DateTimeInterface|string|null $startDate
     * @param \DateTimeInterface|string|null $lastRunDate
     * @param mixed $frequency Enum or string
     * @return CarbonImmutable|null
     */
    public function calculateNextRunDate($startDate, $lastRunDate, $frequency): ?CarbonImmutable
    {
        if (!$startDate) {
            return null;
        }

        $timezone = 'America/Costa_Rica';

        $start = CarbonImmutable::parse($startDate)->setTimezone($timezone);
        $last = $lastRunDate ? CarbonImmutable::parse($lastRunDate)->setTimezone($timezone) : null;

        // Base calculation on the last run, or the start date if never run.
        $baseDate = $last ?: $start;

        // Requirement: Always at 8:00 AM CR
        $targetTime = $baseDate->setTime(8, 0, 0);

        // First Run Conditions (No last run)
        if (!$last) {
            // If the calculated start time (StatDate @ 8am) is in the future, schedule it then.
            if ($targetTime->isFuture()) {
                return $targetTime;
            }

            // If StartDate @ 8am is in the past:

            // For OneTime: Return the past date so the scheduler detects it as "due" immediately.
            if ($this->isOneTime($frequency)) {
                return $targetTime;
            }

            // For Recurrent: We fell behind (e.g. created a weekly reminder with start date yesterday).
            // Logic falls through to add the frequency, effectively scheduling it for the *next* interval.
        }

        // Handle OneTime (already ran)
        if ($this->isOneTime($frequency)) {
            // If we have a last run date, it means it already executed. Stop.
            return null;
        }

        // Recurrent Logic: Add frequency to the base time
        return match (true) {
            // ReminderFrequency cases
            $frequency === ReminderFrequency::Daily || $frequency === 'daily' => $targetTime->addDay(),
            $frequency === ReminderFrequency::Weekly || $frequency === 'weekly' => $targetTime->addWeek(),
            $frequency === ReminderFrequency::Monthly || $frequency === 'monthly' => $targetTime->addMonthNoOverflow(),
            $frequency === ReminderFrequency::Quarterly || $frequency === 'quarterly' => $targetTime->addMonthsNoOverflow(3),
            $frequency === ReminderFrequency::Yearly || $frequency === 'yearly' => $targetTime->addYearNoOverflow(),

            // ExpenseCostType cases
            $frequency === ExpenseCostType::Biweekly || $frequency === 'biweekly' => $targetTime->addWeeks(2),
            $frequency === ExpenseCostType::Monthly => $targetTime->addMonthNoOverflow(),
            $frequency === ExpenseCostType::Quarterly => $targetTime->addMonthsNoOverflow(3),
            $frequency === ExpenseCostType::Semiannual || $frequency === 'semiannual' => $targetTime->addMonthsNoOverflow(6),
            $frequency === ExpenseCostType::Annual => $targetTime->addYearNoOverflow(),

            default => null,
        };
    }

    protected function isOneTime($frequency): bool
    {
        return $frequency === ExpenseCostType::OneTime || $frequency === 'one_time';
    }
}
