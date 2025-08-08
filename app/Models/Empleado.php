<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Empleado extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'usuario',
        'email',
        'password',
        'foto',
        'es_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
