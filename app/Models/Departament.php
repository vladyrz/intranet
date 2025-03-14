<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function operations (){
        return $this->hasMany(Operation::class);
    }
}
