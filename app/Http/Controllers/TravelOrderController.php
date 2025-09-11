<?php

namespace App\Http\Controllers;

use App\Application\UseCases\GetTravelOrderUseCase;
use App\Application\UseCases\ListTravelOrderUseCase;
use App\Application\UseCases\SaveTravelOrderUseCase;
use App\Application\UseCases\UpdateStatusTravelOrderUseCase;
use App\Domain\Enums\TravelOrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Exceptions\ValidationException;
use Dotenv\Validator;

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

    public function updateStatus(int $id, string $status)
    {
        $validator = validator(
            ['status' => $status],
            ['status' => ['in:approved,cancelled']]
        );
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $order = app(UpdateStatusTravelOrderUseCase::class)->execute(
                $id,
                TravelOrderStatus::from($status)
            );
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

    public function index()
    {
        $orders = app(ListTravelOrderUseCase::class)->execute();
        return response()->json($orders, 200);
    }
}
