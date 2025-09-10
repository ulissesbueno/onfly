<?php

namespace App\Domain\Entities;

use DateTime;

class TravelOrder
{
    public string $userId;
    public string $requesterName;
    public string $destination;
    public DateTime $departureDate;
    public DateTime $returnDate;
    public string $status;
    public ?int $id = null;

    public function __construct(
        string $requesterName,
        string $destination,
        DateTime $departureDate,
        DateTime $returnDate,
        string $status,
        ?int $id = null
    ) {
        $this->requesterName = $requesterName;
        $this->destination = $destination;
        $this->departureDate = $departureDate;
        $this->returnDate = $returnDate;
        $this->status = $status;
        $this->id = $id;
    }
}
