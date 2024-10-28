<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class OrganizationContact extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'organization_id',
        'contact_type',
        'contact_name',
        'contact_position',
        'contact_phone_number',
        'contact_email',
        'contact_main_method',
        'contact_remarks',
    ];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }
}
