<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empleado::create([
            'nombre' => 'Admin',
            'usuario' => 'admin',
            'email'     => 'admin@farmacia.com',
            'foto' => null,
            'password' => bcrypt('12345678'),
            'es_admin' => true,
        ]);
    }
}
