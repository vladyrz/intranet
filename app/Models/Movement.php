<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Movement extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'movement_type',
        'movement_date',
        'vehicle_id',
        'initial_mileage',
        'final_mileage',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
