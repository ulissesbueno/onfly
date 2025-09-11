<?php

namespace App\Application\UseCases\Traits;

trait RulesTravelOrderStatus
{
    private function ruleSomeUserCannotChangeOwnRequest($order, $currentUserId): void
    {
        if ($order->userId === $currentUserId) {
            throw new \Exception("O usuário que fez o pedido não pode alterar o status.");
        }
    }

    private function ruleOnlyPendingOrdersCanBeUpdated($order): void
    {
        if ($order->status !== 'pending') {
            throw new \Exception("Apenas pedidos com status 'pendente' podem ser atualizados.");
        }
    }
}