<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
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

    // Relación con el modelo City
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
