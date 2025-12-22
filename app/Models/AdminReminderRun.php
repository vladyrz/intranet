<?php

namespace App\Models;

use App\Enums\ReminderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminReminderRun extends Model
{
    protected $fillable = [
        'admin_reminder_id',
        'run_at',
        'status',
        'error_message',
        'error_trace',
        'channel',
        'job_id',
    ];

    protected $casts = [
        'status' => ReminderStatus::class,
        'run_at' => 'datetime',
    ];

    public function reminder(): BelongsTo
    {
        return $this->belongsTo(AdminReminder::class, 'admin_reminder_id');
    }
}
