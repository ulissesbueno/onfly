<?php

namespace App\Http\Controllers;

use App\Application\UseCases\ApproveTravelOrderUseCase;
use App\Application\UseCases\CancelTravelOrderUseCase;
use App\Application\UseCases\GetTravelOrderUseCase;
use App\Application\UseCases\ListTravelOrderUseCase;
use App\Application\UseCases\SaveTravelOrderUseCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Exceptions\ValidationException;

class TravelOrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'requester_name' => 'required|string',
                'destination'     => 'required|string|max:255',
                'departure_date'  => 'required|date|after_or_equal:today',
                'return_date'     => 'required|date|after_or_equal:departure_date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw new ValidationException($e->validator);
        }
        
        $order = app(SaveTravelOrderUseCase::class)->execute($data);

        return response()->json($order, 201);
    }

    public function approve(int $id)
    {   
        try {
            $order = app(ApproveTravelOrderUseCase::class)->execute($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json($order, 200);
    }

    public function cancel(int $id)
    {   
        try {
            $order = app(CancelTravelOrderUseCase::class)->execute($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json($order, 200);
    }
    

    public function show(int $id)
    {
        $order = app(GetTravelOrderUseCase::class)->execute($id);

        if (!$order) {
            return response()->json(['error' => 'Pedido não encontrado.'], 404);
        }

        return response()->json($order, 200);
    }

    public function index(Request $request)
    {

        try {
            $request->validate([
                'status' => 'in:pending,approved,canceled',
                'destination' => 'string|max:255',
                'periodo_start' => 'date',
                'periodo_end' => 'date',
                'page' => 'numeric',
                'order_direction' => 'in:asc,desc',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw new ValidationException($e->validator);
        }

        $filter = $request->only([
            'status',
            'destination',
            'periodo_start',
            'periodo_end',
            'page',
            'per_page',
            'order_direction'
        ]);

        $orders = app(ListTravelOrderUseCase::class)->execute($filter);
        return response()->json($orders, 200);
    }
}
