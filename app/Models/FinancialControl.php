<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'user_id',
        'status',
        'type',
        'currency',
        'amount',
        'debtor',
        'invoice_number',
        'responsible_person',
        'description',
        'entry_date',
        'observations',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(FinancialMovement::class);
    }
}
