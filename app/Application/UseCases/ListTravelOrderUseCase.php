<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\TravelOrderRepositoryInterface;

class ListTravelOrderUseCase
{
    private $repository;

    public function __construct(TravelOrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $filter = []): array
    {
        return $this->repository->findAll($filter);
    }
}