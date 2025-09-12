<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\TravelOrderRepositoryInterface;
use App\Models\TravelOrders;
use App\Domain\Entities\TravelOrder;
use App\Domain\Entities\User;

class TravelOrderRepository implements TravelOrderRepositoryInterface
{
    const PER_PAGE = 10;
    const DEFAULT_ORDER_DIRECTION = 'desc';
    const PAGE = 1;

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
        $order->user = $travelOrder->user ? $this->mapUserModelToEntity($travelOrder->user) : null;

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
            user: $model->user ? $this->mapUserModelToEntity($model->user) : null,
            id: $model->id
        );
    }

    private function mapUserModelToEntity($model): User
    {
        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
        );
    }

    public function findAll(array $filter = []): array
    {
        $query = TravelOrders::query();

        $this->applyFilters($query, $filter);

        $travelOrders = $query->get();

        return $travelOrders->map(function ($model) {
            return $this->mapModelToEntity($model);
        })->toArray();
    }

    private function applyFilters(&$query, array $filter)
    {
        if (!empty($filter['status'])) {
            $query->where('status', $filter['status']);
        }

        if (!empty($filter['destination'])) {
            $query->where('destination', 'like', '%' . $filter['destination'] . '%');
        }

        if (!empty($filter['periodo_start'])) {
            $query->where('departure_date', '>=', $filter['periodo_start']);
        }

        if (!empty($filter['periodo_end'])) {
            $query->where('return_date', '<=', $filter['periodo_end']);
        }

        if (empty($filter['order_direction'])) {
            $filter['order_direction'] = self::DEFAULT_ORDER_DIRECTION;
        }
        
        $query->orderBy('created_at', $filter['order_direction']);

        if (empty($filter['page'])) {
            $filter['page'] = self::PAGE;
        }

        $per_page = self::PER_PAGE;
        $query->skip(($filter['page'] - 1) * $per_page)->take($per_page);
    }
}