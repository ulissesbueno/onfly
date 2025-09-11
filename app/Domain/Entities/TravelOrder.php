<?php

namespace App\Domain\Entities;

use App\Domain\Enums\TravelOrderStatus;
use DateTime;

class TravelOrder
{
    public string $requesterName;
    public string $destination;
    public DateTime $departureDate;
    public DateTime $returnDate;
    public string $status;
    public ?int $userId = null;
    public ?int $id = null;

    public function __construct(
        string $requesterName,
        string $destination,
        DateTime $departureDate,
        DateTime $returnDate,
        string $status,
        ?int $userId = null,
        ?int $id = null
    ) {
        $this->requesterName = $requesterName;
        $this->destination = $destination;
        $this->departureDate = $departureDate;
        $this->returnDate = $returnDate;
        $this->status = $status;
        if ($userId) {
            $this->userId = $userId;
        }
        $this->id = $id;
    }

    public function setStatus(TravelOrderStatus $status): void
    {
        $this->status = $status->value;
    }
}
