<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class EmployeeChecklist extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'employee_id',
        'task',
        'easypro_email',
        'easyu_user',
        'bienes_adjudicados_user',
        'intranet_user',
        'email_marketing_group',
        'phone_extension',
        'social_networks',
        'nas_access',
        'email_signature_card',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
