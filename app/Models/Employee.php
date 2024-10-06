<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contract_status',
        'progress_status',
        'job_position',
        'national_id',
        'phone_number',
        'personal_email',
        'profession',
        'license_plate',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'birthday',
        'marital_status',
        'credid',
        'contract'
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function locationState(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function locationCity(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
