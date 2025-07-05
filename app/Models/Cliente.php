<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre', 'email', 'password', 'direccion',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
