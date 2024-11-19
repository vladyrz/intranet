<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Sale extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'property_name',
        'user_id',
        'organization_id',
        'offer_amount_usd',
        'offer_amount_crc',
        'status',
        'client_name',
        'client_email',
        'offer_date',
        'comission_percentage',
        'offer_currency',
        'commission_amount_usd',
        'commission_amount_crc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
