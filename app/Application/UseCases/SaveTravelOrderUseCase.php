<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TravelOrder;
use App\Domain\Repositories\TravelOrderRepositoryInterface;

class SaveTravelOrderUseCase
{
    private $repository;

    public function __construct(TravelOrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(TravelOrder $order): TravelOrder
    {
        return $this->repository->create($order);
    }
}