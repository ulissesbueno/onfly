<?php

namespace App\Domain\Entities;

use DateTime;

class TravelOrder
{
    public string $requesterName;
    public string $destination;
    public DateTime $departureDate;
    public DateTime $returnDate;
    public string $status;
    public ?User $user = null;
    public ?int $id = null;

    public function __construct(
        string $requesterName,
        string $destination,
        DateTime $departureDate,
        DateTime $returnDate,
        string $status,
        ?User $user = null,
        ?int $id = null
    ) {
        $this->requesterName = $requesterName;
        $this->destination = $destination;
        $this->departureDate = $departureDate;
        $this->returnDate = $returnDate;
        $this->status = $status;
        if ($user) {
            $this->user = $user;
        }
        $this->id = $id;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
