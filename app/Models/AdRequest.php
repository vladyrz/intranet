<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class AdRequest extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'user_id',
        'platform',
        'ad_url',
        'target_age',
        'target_location',
        'start_date',
        'end_date',
        'additional_info',
        'investment_amount',
        'payment_receipt',
        'status',
        'messages_received',
        'views',
        'reach',
        'link_clicks',
    ];

    protected $casts = [
        'payment_receipt' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
