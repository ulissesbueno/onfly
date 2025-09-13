<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Domain\Repositories\TravelOrderRepositoryInterface;
use App\Application\UseCases\Traits\RulesTravelOrderStatus;
use App\Application\UseCases\Exceptions\TravelOrderExceptions;
use App\Events\TravelOrderStatusChange;

class ApproveTravelOrderUseCase
{
    use RulesTravelOrderStatus;

    private $repository;

    public function __construct(
        TravelOrderRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function execute(int $id, int $currentUserId): ?TravelOrder
    {
        $order = $this->repository->findById($id);
        
        if (!$order) {
            throw TravelOrderExceptions::orderNotFound();
        }

        $this->ruleSomeUserCannotChangeOwnRequest($order->user->id, $currentUserId);
        $this->ruleOnlyPendingOrdersCanBeUpdated($order->getStatus());

        $order->setStatus(TravelOrderStatus::APPROVED);
        $order = $this->repository->update($order);
        TravelOrderStatusChange::dispatch($order);

        return $order;
    }
}