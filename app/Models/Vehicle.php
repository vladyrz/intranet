<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Vehicle extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'license_plate',
        'brand',
        'style',
        'year',
        'vehicle_status',
    ];

    public function movements(){
        return $this->hasMany(Movement::class);
    }

    public function maintenances(){
        return $this->hasMany(Maintenance::class);
    }
}
