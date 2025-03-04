<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class PersonalCustomer extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'user_id',
        'prospect_status',
        'full_name',
        'national_id',
        'email',
        'phone_number',
        'customer_need',
        'address',
        'contact_preferences',
        'date_of_birth',
        'customer_type',
        'next_action',
        'next_action_date',
        'budget_usd',
        'budget_crc',
        'financing',
        'expected_commission_usd',
        'expected_commission_crc',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
