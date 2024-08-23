<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'state_id',
        'name',
        'latitude',
        'longitude',
        'is_active',
    ];

    // Relación con el modelo Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Relación con el modelo State
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
