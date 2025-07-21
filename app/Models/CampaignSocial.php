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
        'link',
        'reactions',
        'comments',
        'shares',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
