<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Customer extends Model
{
    use HasFactory;

    use HasFilamentComments;

    protected $fillable = [
        'user_id',
        'full_name',
        'national_id',
        'email',
        'phone_number',
        'property_name',
        'organization_id',
        'address',
        'contact_preferences',
        'initial_contact_date',
        'customer_type',
        'credid_information',
        'budget_usd',
        'budget_crc',
        'financing',
        'expected_commission_usd',
        'expected_commission_crc',
        'state'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
