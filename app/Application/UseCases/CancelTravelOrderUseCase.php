<?php

namespace App\Application\UseCases;

use App\Application\UseCases\Exceptions\TravelOrderExceptions;
use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Domain\Repositories\TravelOrderRepositoryInterface;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Application\UseCases\Traits\RulesTravelOrderStatus;
use App\Events\TravelOrderStatusChange;

class CancelTravelOrderUseCase
{
    use RulesTravelOrderStatus;

    private $repository;

    public function __construct(
        TravelOrderRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function execute(int $id): ?TravelOrder
    {
        $order = $this->repository->findById($id);
        
        if (!$order) {
            throw TravelOrderExceptions::orderNotFound();
        }

        $user = JWTAuth::parseToken()->authenticate();
        $currentUserId = $user?->id;

        $this->ruleSomeUserCannotChangeOwnRequest($order, $currentUserId);
        $this->ruleOnlyPendingOrdersCanBeUpdated($order);

        $order->setStatus(TravelOrderStatus::CANCELLED);
        $order = $this->repository->update($order);
        TravelOrderStatusChange::dispatch($order);

        return $order;
    }
}