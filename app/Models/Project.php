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
        'responsible',
        'progress',
        'project_status',
        'priority',
        'expected_benefit',
        'last_updated_at',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];
}
