<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Segment extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'employee_id',
        'experience',
        'location',
        'availability_status',
        'assigned_active_properties',
        'coordinated_visits',
        'active_leads_follow_up',
        'closed_deals',
        'additional_skills',
    ];

    protected $casts = [
        'additional_skills' => 'array',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
