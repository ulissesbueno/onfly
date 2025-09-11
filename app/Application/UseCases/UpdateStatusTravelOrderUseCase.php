<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Domain\Repositories\TravelOrderRepositoryInterface;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateStatusTravelOrderUseCase
{
    private $repository;

    public function __construct(TravelOrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id, TravelOrderStatus $status): ?TravelOrder
    {
        $order = $this->repository->findById($id);
        
        if (!$order) {
            throw new Exception("Pedido não encontrado.");
        }

        $user = JWTAuth::parseToken()->authenticate();
        $currentUserId = $user?->id;

        $this->ruleSomeUserCannotChangeOwnRequest($order, $currentUserId);
        $this->ruleOnlyPendingOrdersCanBeUpdated($order);

        $order->setStatus($status);
        return $this->repository->update($order);
    }

    private function ruleSomeUserCannotChangeOwnRequest(TravelOrder $order, ?int $currentUserId): void
    {
        if ($order->userId === $currentUserId) {
            throw new Exception("O usuário que fez o pedido não pode alterar o status.");
        }
    }

    private function ruleOnlyPendingOrdersCanBeUpdated(TravelOrder $order): void
    {
        if ($order->status !== TravelOrderStatus::PENDING) {
            throw new Exception("Apenas pedidos com status 'pendente' podem ser atualizados.");
        }
    }
}