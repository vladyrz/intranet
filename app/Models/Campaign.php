<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Campaign extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'title',
        'campaign_status',
        'user_id',
        'post_date',
        'marketplace_link',
        'results_observations',
        'start_date',
        'end_date',
        'social_network',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign_socials()
    {
        return $this->hasMany(CampaignSocial::class);
    }
}
