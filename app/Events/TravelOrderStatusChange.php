<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Domain\Entities\TravelOrder;

class TravelOrderStatusChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TravelOrder $travelOrder;
    /**
     * Create a new event instance.
     */
    public function __construct(
        TravelOrder $travelOrder
    )
    {
        $this->travelOrder = $travelOrder;
    }
}
