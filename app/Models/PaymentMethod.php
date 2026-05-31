<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    // Vinculación con la tabla 'metodos_pago'
    protected $table = 'metodos_pagos';

    // Desactiva la búsqueda de columnas 'created_at' y 'updated_at'
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
