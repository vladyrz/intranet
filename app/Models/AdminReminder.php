<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class AdminReminder extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'user_id',
        'reminder_type',
        'follow_up_date',
        'frequency',
        'task_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
