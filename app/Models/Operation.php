<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Operation extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'user_id',
        'document_id',
        'departament_id',
        'scope',
        'benefits',
        'references',
        'policies',
        'steps',
        'attachments',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function document(){
        return $this->belongsTo(Document::class);
    }

    public function departament(){
        return $this->belongsTo(Departament::class);
    }
}
