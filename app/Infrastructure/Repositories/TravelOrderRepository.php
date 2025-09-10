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
}