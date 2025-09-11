<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\TravelOrder;

interface TravelOrderRepositoryInterface
{
    public function create(TravelOrder $order): TravelOrder;
    public function findById(int $id): ?TravelOrder;
    public function update(TravelOrder $order): TravelOrder;
    public function findAll(array $filter = []): array;
}