<?php

namespace App\Models;

use App\Enums\ExpenseCurrency;
use App\Enums\ExpensePaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpensePayment extends Model
{
    protected $fillable = [
        'expense_control_id',
        'user_id',
        'status',
        'currency',
        'amount',
        'paid_at',
    ];

    protected $casts = [
        'status' => ExpensePaymentStatus::class,
        'currency' => ExpenseCurrency::class,
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function expenseControl(): BelongsTo
    {
        return $this->belongsTo(ExpenseControl::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
