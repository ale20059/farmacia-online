<?php

// app/Models/Empleado.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Empleado extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'password', 'foto'];

    protected $hidden = ['password', 'remember_token'];
}
