<?php

namespace App\Models;

use App\Enums\ExpenseArea;
use App\Enums\ExpenseCostType;
use App\Enums\ExpenseCurrency;
use App\Enums\ExpenseStatus;
use App\Traits\HasFrequency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseControl extends Model
{
    use HasFrequency;

    protected $fillable = [
        'country_id',
        'status',
        'cost_type',
        'payment_date',
        'next_run_at',
        'currency',
        'amount',
        'area',
        'description',
        'details',
        'last_sent_at',
        'failure_count',
        'last_error_message',
        'last_error_trace',
        'last_failed_at',
    ];

    protected $casts = [
        'status' => ExpenseStatus::class,
        'cost_type' => ExpenseCostType::class,
        'currency' => ExpenseCurrency::class,
        'area' => ExpenseArea::class,
        'payment_date' => 'date',
        'next_run_at' => 'datetime',
        'last_sent_at' => 'datetime',
        'last_failed_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function (ExpenseControl $expense) {
            // Initial next_run_at calculation
            if (!$expense->next_run_at && $expense->status === ExpenseStatus::Active) {
                // If payment_date is set, that's our starts_at equivalent
                $expense->next_run_at = $expense->calculateNextRunAt();
            }
        });
    }

    public function calculateNextRunAt(): ?\Carbon\CarbonImmutable
    {
        return $this->calculateNextRunDate(
            $this->payment_date,
            $this->last_sent_at,
            $this->cost_type
        );
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ExpenseStatus::Active);
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExpensePayment::class);
    }
}
