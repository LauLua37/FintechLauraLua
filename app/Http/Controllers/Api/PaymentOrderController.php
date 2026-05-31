<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentOrderDetailResource;
use App\Models\PaymentOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentOrderController extends Controller
{
    // GET /api/orders
    // Retorna la lista de órdenes con filtros, búsqueda y paginación
    public function index(Request $request)
    {
        // Número de registros por página (máximo 100)
        $perPage = $request->input('per_page', 15);
        if ($perPage > 100) {
            $perPage = 100;
        }

        // Iniciamos la consulta con las relaciones necesarias
        $query = PaymentOrderDetail::with(['customer', 'status', 'paymentMethod']);

        // Filtro por búsqueda (ID, email o nombre del cliente)
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {

                // Búsqueda por ID si el valor es numérico
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }

                $q->orWhere('email', 'ilike', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('nombre', 'ilike', "%{$search}%")
                            ->orWhere('ap', 'ilike', "%{$search}%");
                    });
            });
        }

        // Filtro por status (paid, pending, failed, refunded)
        if ($request->status) {
            $status = $request->status;
            $query->whereHas('status', function ($q) use ($status) {
                $q->where('nombre', $status);
            });
        }

        // Filtro por método de pago (Tarjeta, PayPal, SPEI)
        if ($request->payment_method) {
            $method = $request->payment_method;
            $query->whereHas('paymentMethod', function ($q) use ($method) {
                $q->where('nombre', $method);
            });
        }

        // Ordenamiento de datos
        $allowedColumns = ['created_at', 'monto', 'email', 'id'];
        $sortBy = $request->input('sort_by', 'created_at');
        $direction = $request->input('direction', 'desc');

        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }

        if ($direction !== 'asc' && $direction !== 'desc') {
            $direction = 'desc';
        }

        $query->orderBy($sortBy, $direction);

        // Paginar y retornar resultados
        $orders = $query->paginate($perPage);

        return PaymentOrderDetailResource::collection($orders);
    }

    //GET /api/orders/{id}
    // Retorna el detalle de una orden específica
    public function show(int $id): PaymentOrderDetailResource|JsonResponse
    {
        $order = PaymentOrderDetail::with(['customer', 'status', 'paymentMethod'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada.'], 404);
        }

        return new PaymentOrderDetailResource($order);
    }

    // GET /api/orders/stats
    // Retorna los totales para las cards del dashboard
    public function stats(): JsonResponse
    {
        // Total de órdenes
        $totalOrders = PaymentOrderDetail::count();

        // Total de revenue (solo órdenes pagadas)
        $totalRevenue = PaymentOrderDetail::whereHas('status', function ($q) {
            $q->where('nombre', 'paid');
        })->sum('monto');

        // Total de órdenes fallidas
        $failedCount = PaymentOrderDetail::whereHas('status', function ($q) {
            $q->where('nombre', 'failed');
        })->count();

        // Total de órdenes pendientes
        $pendingCount = PaymentOrderDetail::whereHas('status', function ($q) {
            $q->where('nombre', 'pending');
        })->count();

        return response()->json([
            'total_orders'    => $totalOrders,
            'total_revenue'   => (float) $totalRevenue,
            'failed_count'    => $failedCount,
            'pending_count'   => $pendingCount,
        ]);
    }
}
