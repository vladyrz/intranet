<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class PropertyAssignment extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'user_id',
        'property_info',
        'organization_id',
        'property_observations',
        'property_images',
        'property_assignment_status',
    ];

    protected $casts = [
        'property_images' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
