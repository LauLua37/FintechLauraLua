<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        // Validación de los datos del Login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Correo electrónico o contraseña incorrectas.'],
            ]);
        }

        // Generación del token de acceso para el usuario autenticado
        $user = Auth::user();

        /** @var \App\Models\User $user */
        $token = $user->createToken('fintech-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'rol' => $user->rol,
            ]
        ]);
    }

    // Cierra la sesión del usuario eliminando el token de acceso actual
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada exitosamente.']);
    }
}
