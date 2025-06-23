<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Offer extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'property_name',
        'property_value_usd',
        'property_value_crc',
        'organization_id',
        'user_id',
        'offer_amount_usd',
        'offer_amount_crc',
        'personal_customer_id',
        'offer_files',
        'offer_status',
        'rejection_reason',
    ];

    protected $casts = [
        'offer_files' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function personal_customer(){
        return $this->belongsTo(PersonalCustomer::class);
    }
}
