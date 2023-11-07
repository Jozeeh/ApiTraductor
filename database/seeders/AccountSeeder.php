<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $cuentas = [
            [
                'nombre' => 'José',
                'apellido' => 'Mejia',
                'telefono' => '12345678',
                'foto' => '/fotos-user/no-existe.png',
                'tipo_usuario' => 'Usuario',
                'correo' => 'jose@gmail.com',
                'password' => bcrypt('itca123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Medina',
                'telefono' => '12345678',
                'foto' => '/fotos-user/no-existe.png',
                'tipo_usuario' => 'Moderador',
                'correo' => 'juan@gmail.com',
                'password' => bcrypt('itca123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Lucia',
                'apellido' => 'Lopez',
                'telefono' => '12345678',
                'foto' => '/fotos-user/no-existe.png',
                'tipo_usuario' => 'Administrador',
                'correo' => 'lucia@gmail.com',
                'password' => bcrypt('itca123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('users')->insert($cuentas);
    }
}
