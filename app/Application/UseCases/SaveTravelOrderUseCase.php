<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Domain\Repositories\TravelOrderRepositoryInterface;

class SaveTravelOrderUseCase
{
    private $repository;

    public function __construct(TravelOrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute($data): TravelOrder
    {
        $order = new TravelOrder(
            requesterName: $data['requester_name'],
            destination: $data['destination'],
            departureDate: new \DateTime($data['departure_date']),
            returnDate: new \DateTime($data['return_date']),
            status: TravelOrderStatus::PENDING
        );

        return $this->repository->create($order);
    }
}