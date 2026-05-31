<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // Vinculación con la tabla 'status'
    protected $table = 'status';

    // Desactiva la búsqueda de columnas 'created_at' y 'updated_at'
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
