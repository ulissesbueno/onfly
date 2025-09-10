<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\TravelOrder;

interface TravelOrderRepositoryInterface
{
    public function create(TravelOrder $order): TravelOrder;
}