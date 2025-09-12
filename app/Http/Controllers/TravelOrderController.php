<?php

namespace App\Http\Controllers;

use App\Application\UseCases\ApproveTravelOrderUseCase;
use App\Application\UseCases\CancelTravelOrderUseCase;
use App\Application\UseCases\GetTravelOrderUseCase;
use App\Application\UseCases\ListTravelOrderUseCase;
use App\Application\UseCases\SaveTravelOrderUseCase;
use App\Http\Controllers\Exceptions\ValidationException;
use App\Http\Requests\FilterTravelOrderRequest;
use App\Http\Requests\StoreTravelOrderRequest;
use App\Http\Resources\TravelOrderResource;

class TravelOrderController extends Controller
{
    public function store(StoreTravelOrderRequest $request)
    {
        try {
            $data = $request->validated();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw new ValidationException($e->validator);
        }
        
        $order = app(SaveTravelOrderUseCase::class)->execute($data);

        return new TravelOrderResource($order);
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

        return new TravelOrderResource($order);
    }

    public function index(FilterTravelOrderRequest $request)
    {
        try {
            $request->validate();
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
        return new TravelOrderResource($orders);
    }
}
