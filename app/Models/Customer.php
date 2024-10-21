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
        'email',
        'phone_number',
        'address',
        'contact_preferences',
        'initial_contact_date',
        'customer_type',
        'interaction_notes',
        'credid_information',
        'budget',
        'financing',
        'expected_commission',
        'internal_notes'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
