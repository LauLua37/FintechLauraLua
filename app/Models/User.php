<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Vinculación con la tabla 'detalle_usuarios'
    protected $table = 'detalle_usuarios';

    protected $fillable = [
        'id_usuario',
        'email',
        'password',
        'rol',
    ];

    // Oculta campos sensibles en formato JSON o array
    protected $hidden = [
        'password',
    ];

    // Encripta automáticamente el campo 'password' al asignarlo
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
