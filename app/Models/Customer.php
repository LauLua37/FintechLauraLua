<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Vinculación con la tabla 'clientes'
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'ap',
        'am',
    ];

    // Oculta campos sensibles en formato JSON o array
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Se define la relación con las órdenes de pago
    public function orders()
    {
        return $this->hasMany(PaymentOrderDetail::class, 'id_cliente');
    }
}
