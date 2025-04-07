<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Maintenance extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'maintenance_type',
        'maintenance_date',
        'vehicle_id',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
