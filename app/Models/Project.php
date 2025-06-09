<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Project extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'name',
        'employee_id',
        'progress',
        'project_status',
        'priority',
        'expected_benefit',
        'request_date',
        'last_updated_at',
        'observations',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
