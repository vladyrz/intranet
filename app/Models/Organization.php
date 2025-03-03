<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Organization extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'organization_type',
        'organization_name',
        'asset_update_dates',
        'sugef_report',
        'offer_form',
        'catalog_or_website',
        'vehicles_page',
    ];

    public function contacts() {
        return $this->hasMany(OrganizationContact::class);
    }

    public function sales() {
        return $this->hasMany(Sale::class);
    }

    public function customers() {
        return $this->hasMany(Customer::class);
    }

    public function properties() {
        return $this->hasMany(PropertyAssignment::class);
    }
}
