<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Creación de clientes
        $clientes = [
            ['nombre' => 'Laura', 'ap' => 'Lua', 'am' => 'García'],
            ['nombre' => 'Axel', 'ap' => 'Medina', 'am' => 'Hernández'],
            ['nombre' => 'Roberto', 'ap' => 'Vega', 'am' => null],
            ['nombre' => 'Carlos', 'ap' => 'Sánchez', 'am' => 'Martínez'],
            ['nombre' => 'Alejandra', 'ap' => 'Gómez', 'am' => 'Rodríguez'],
        ];

        // Inserción de datos de clientes en la tabla 'clientes'
        foreach ($clientes as $cliente) {
            DB::table('clientes')->insert([
                'nombre' => $cliente['nombre'],
                'ap' => $cliente['ap'],
                'am' => $cliente['am'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $emails = [
            1 => 'laura@gmail.com',
            2 => 'axel@empresa.com',
            3 => 'roberto@gmail.com',
            4 => 'carlos@gmail.com',
            5 => 'alejandra@empresa.com',
        ];

        // Generación de órdenes de pago con datos aleatorios
        for ($i = 0; $i < 50; $i++) {
            $clienteId = rand(1, 5);

            DB::table('detalle_ordenes_pagos')->insert([
                'id_cliente' => $clienteId,
                'id_status' => rand(1, 4),
                'id_metodo_pago' => rand(1, 3),
                'email' => $emails[$clienteId],
                'monto' => rand(100, 9999) + (rand(0, 99) / 100),
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}
