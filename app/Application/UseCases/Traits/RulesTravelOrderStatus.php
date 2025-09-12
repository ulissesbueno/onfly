<?php

namespace App\Application\UseCases\Traits;

use App\Application\UseCases\Exceptions\TravelOrderExceptions;

trait RulesTravelOrderStatus
{
    const STATUS_PENDING = 'pending';

    private function ruleSomeUserCannotChangeOwnRequest($order, $currentUserId): void
    {
        if ($order->userId === $currentUserId) {
            throw TravelOrderExceptions::userCannotChangeOwnRequest();
        }
    }

    private function ruleOnlyPendingOrdersCanBeUpdated($order): void
    {
        if ($order->status !== self::STATUS_PENDING) {
            throw TravelOrderExceptions::onlyPendingOrdersCanBeUpdated();
        }
    }
}