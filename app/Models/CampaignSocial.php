<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class CampaignSocial extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'campaign_id',
        'platform',
        'language',
        'link',
        'reactions',
        'comments',
        'shares',
        'views',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    protected static function booted()
    {
        static::saved(function ($social) {
            $campaign = $social->campaign;

            if (! $campaign) {
                return;
            }

            if ($campaign->campaign_status === 'to_schedule') {
                return;
            }

            $campaign->load('campaign_socials');

            foreach ($campaign->campaign_socials as $socialRecord) {
                if ($socialRecord->reactions >= 10 && $socialRecord->comments >= 2) {
                    $campaign->update(['campaign_status' => 'to_schedule']);
                    break;
                }
            }
        });
    }
}
