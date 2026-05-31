<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentOrderDetail extends Model
{
    // Vinculación con la tabla detalle_ordenes_pagos
    protected $table = 'detalle_ordenes_pagos';

    protected $fillable = [
        'id_cliente',
        'id_status',
        'id_metodo_pago',
        'email',
        'monto',
    ];

    // Oculta las llaves foráneas de la respuesta JSON
    protected $hidden = [
        'id_cliente',
        'id_status',
        'id_metodo_pago',
    ];

    // Asegura que el monto se devuelva como decimal con 2 decimales
    protected $casts = [
        'monto' => 'decimal:2',
    ];

    // Relaciones con otras tablas
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_cliente');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_metodo_pago');
    }
}
