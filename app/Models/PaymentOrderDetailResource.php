<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentOrderDetailResource extends JsonResource
{
    // Transforma el modelo de una orden en un formato JSON adecuado para la API
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'email'          => $this->email,
            'monto'          => (float) $this->monto,
            'created_at'     => $this->created_at->toIso8601String(),
            'updated_at'     => $this->updated_at->toIso8601String(),
            'customer'       => [
                'id'     => $this->customer->id,
                'nombre' => $this->customer->nombre,
                'ap'     => $this->customer->ap,
                'am'     => $this->customer->am,
            ],
            'status'         => [
                'id'     => $this->status->id,
                'nombre' => $this->status->nombre,
            ],
            'payment_method' => [
                'id'     => $this->paymentMethod->id,
                'nombre' => $this->paymentMethod->nombre,
            ],
        ];
    }
}
