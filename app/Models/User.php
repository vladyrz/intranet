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

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function operations(){
        return $this->hasMany(Operation::class);
    }

    public function properties(){
        return $this->hasMany(PropertyAssignment::class);
    }

    public function personalcustomers(){
        return $this->hasMany(PersonalCustomer::class);
    }
}
