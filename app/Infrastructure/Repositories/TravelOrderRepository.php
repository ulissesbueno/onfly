<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\TravelOrderRepositoryInterface;
use App\Models\TravelOrders;
use App\Domain\Entities\TravelOrder;

class TravelOrderRepository implements TravelOrderRepositoryInterface
{
    public function create(TravelOrder $order): TravelOrder
    {
        $travelOrder = new TravelOrders();
        $travelOrder->requester_name = $order->requesterName;
        $travelOrder->destination = $order->destination;
        $travelOrder->departure_date = $order->departureDate->format('Y-m-d');
        $travelOrder->return_date = $order->returnDate->format('Y-m-d');
        $travelOrder->status = $order->status;
        $travelOrder->save();

        $order->id = $travelOrder->id;
        $order->userId = $travelOrder->user_id;

        return $order;
    }

    public function findById(int $id): ?TravelOrder
    {
        $travelOrder = TravelOrders::find($id);
        if (!$travelOrder) {
            return null;
        }

        return $this->mapModelToEntity($travelOrder);
    }

    public function update(TravelOrder $order): TravelOrder
    {
        $travelOrder = TravelOrders::find($order->id);
        if (!$travelOrder) {
            throw new \DomainException("Pedido não encontrado.");
        }

        $travelOrder->requester_name = $order->requesterName;
        $travelOrder->destination = $order->destination;
        $travelOrder->departure_date = $order->departureDate->format('Y-m-d');
        $travelOrder->return_date = $order->returnDate->format('Y-m-d');
        $travelOrder->status = $order->status;
        $travelOrder->save();

        return $order;
    }

    private function mapModelToEntity(TravelOrders $model): TravelOrder
    {
        return new TravelOrder(
            requesterName: $model->requester_name,
            destination: $model->destination,
            departureDate: new \DateTime($model->departure_date),
            returnDate: new \DateTime($model->return_date),
            status: $model->status,
            userId: $model->user_id,
            id: $model->id
        );
    }

    public function findAll(): array
    {
        $travelOrders = TravelOrders::all();
        return $travelOrders->map(function ($model) {
            return $this->mapModelToEntity($model);
        })->toArray();
    }
}