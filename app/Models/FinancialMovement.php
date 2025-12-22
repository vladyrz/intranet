<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_control_id',
        'currency',
        'amount',
        'movement_date',
        'balance',
        'observation',
    ];

    public function financialControl()
    {
        return $this->belongsTo(FinancialControl::class);
    }
}
