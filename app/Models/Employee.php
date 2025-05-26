<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Employee extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'user_id',
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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function locationState(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function locationCity(){
        return $this->belongsTo(City::class, 'city_id');
    }

    public function employeeChecklists(){
        return $this->hasMany(EmployeeChecklist::class);
    }

    public function segments(){
        return $this->hasMany(Segment::class);
    }

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
