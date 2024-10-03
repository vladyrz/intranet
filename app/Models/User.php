<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'state',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'postal_code',
        'state',
        'progress_status',
        'job_position',
        'national_id',
        'marital_status',
        'profession',
        'phone_number',
        'personal_email',
        'license_plate',
        'contract_status',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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

    public function calendars(){
        return $this->belongsToMany(Calendar::class);
    }

    public function departaments(){
        return $this->belongsToMany(Departament::class);
    }

    public function holidays(){
        return $this->hasMany(Holiday::class);
    }

    public function timesheets(){
        return $this->hasMany(Timesheet::class);
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }
}
