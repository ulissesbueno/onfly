<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TravelOrder;
use App\Domain\Repositories\TravelOrderRepositoryInterface;

class GetTravelOrderUseCase
{
    private $repository;

    public function __construct(TravelOrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): ?TravelOrder
    {
        return $this->repository->findById($id);
    }
}