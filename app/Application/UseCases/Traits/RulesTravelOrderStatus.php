<?php

namespace App\Application\UseCases\Traits;

use App\Application\UseCases\Exceptions\TravelOrderExceptions;

trait RulesTravelOrderStatus
{
    const STATUS_PENDING = 'pending';

    private function ruleSomeUserCannotChangeOwnRequest(int $orderUserId, int $currentUserId): void
    {
        if ($orderUserId === $currentUserId) {
            throw TravelOrderExceptions::userCannotChangeOwnRequest();
        }
    }

    private function ruleOnlyPendingOrdersCanBeUpdated(string $status): void
    {
        if ($status !== self::STATUS_PENDING) {
            throw TravelOrderExceptions::onlyPendingOrdersCanBeUpdated();
        }
    }
}