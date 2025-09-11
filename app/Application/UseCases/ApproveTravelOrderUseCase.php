<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Domain\Repositories\TravelOrderRepositoryInterface;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Application\UseCases\Traits\RulesTravelOrderStatus;

class ApproveTravelOrderUseCase
{
    use RulesTravelOrderStatus;

    private $repository;

    public function __construct(TravelOrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): ?TravelOrder
    {
        $order = $this->repository->findById($id);
        
        if (!$order) {
            throw new Exception("Pedido não encontrado.");
        }

        $user = JWTAuth::parseToken()->authenticate();
        $currentUserId = $user?->id;

        $this->ruleSomeUserCannotChangeOwnRequest($order, $currentUserId);
        $this->ruleOnlyPendingOrdersCanBeUpdated($order);

        $order->setStatus(TravelOrderStatus::APPROVED);
        return $this->repository->update($order);
    }
}