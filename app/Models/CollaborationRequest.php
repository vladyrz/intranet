<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class CollaborationRequest extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'user_id',
        'personal_customer_id',
        'client_budget',
        'areas_of_interest',
        'search_details',
    ];

    protected $casts = [
        'client_budget' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personal_customer()
    {
        return $this->belongsTo(PersonalCustomer::class);
    }
}
