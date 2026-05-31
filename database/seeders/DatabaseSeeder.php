<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Creación de un nuevo usuario
        $usuarioId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Vertilux',
            'ap' => 'Portal',
            'am' => null,
        ]);

        DB::table('detalle_usuarios')->insert([
            'id_usuario' => $usuarioId,
            'email' => 'admin@test.com',
            'password' => Hash::make('123456'),
            'rol' => 'operador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Llamar al seeder de órdenes para la creación de datos de prueba
        $this->call(PaymentOrderSeeder::class);
    }
}
