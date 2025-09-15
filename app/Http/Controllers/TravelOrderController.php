<?php

namespace App\Http\Controllers;

use App\Application\UseCases\ApproveTravelOrderUseCase;
use App\Application\UseCases\CancelTravelOrderUseCase;
use App\Application\UseCases\GetTravelOrderUseCase;
use App\Application\UseCases\ListTravelOrderUseCase;
use App\Application\UseCases\SaveTravelOrderUseCase;
use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Http\Requests\FilterTravelOrderRequest;
use App\Http\Requests\StoreTravelOrderRequest;
use App\Http\Resources\TravelOrderResource;

class TravelOrderController extends Controller
{
    const HTTP_STATUS_SUCCESS = 200;
    const HTTP_STATUS_ERROR = 400;
    const ERROR_PROPERTY = 'error';

    public function store(StoreTravelOrderRequest $request)
    {
        $data = $request->validated();

        $order = app(SaveTravelOrderUseCase::class)->execute(
            new TravelOrder(
                requesterName: $data['requester_name'],
                destination: $data['destination'],
                departureDate: new \DateTime($data['departure_date']),
                returnDate: new \DateTime($data['return_date']),
                status: TravelOrderStatus::PENDING
            )
        );
        return new TravelOrderResource($order);
    }

    public function update(int $id)
    {   
        $user = auth()->user();
        $currentUserId = $user?->id;

        try {
            $order = app(ApproveTravelOrderUseCase::class)->execute($id, $currentUserId);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), $e->getCode());
        }

        return response()->json($order, self::HTTP_STATUS_SUCCESS);
    }

    public function destroy(int $id)
    {   
        $user = auth()->user();
        $currentUserId = $user?->id;

        try {
            $order = app(CancelTravelOrderUseCase::class)->execute($id, $currentUserId);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), $e->getCode());
        }

        return response()->json($order, 200);
    }
    

    public function show(int $id)
    {
        try {
            $order = app(GetTravelOrderUseCase::class)->execute($id);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), $e->getCode());
        }

        return new TravelOrderResource($order);
    }

    public function index(FilterTravelOrderRequest $request)
    {
        $filter = $request->only([
            'status',
            'destination',
            'departure_date',
            'return_date',
            'page',
            'per_page',
            'order_direction'
        ]);

        $orders = app(ListTravelOrderUseCase::class)->execute($filter);
        return new TravelOrderResource($orders);
    }

    private function respondWithError($message, $code = self::HTTP_STATUS_ERROR)
    {
        return response()->json([self::ERROR_PROPERTY => $message], $code);
    }
}
