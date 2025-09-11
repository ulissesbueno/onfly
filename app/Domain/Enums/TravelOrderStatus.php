<?php

namespace App\Domain\Enums;

class TravelOrderStatus
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const CANCELLED = 'cancelled';

    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function from(string $value): self
    {
        return match ($value) {
            self::PENDING => new self(self::PENDING),
            self::APPROVED => new self(self::APPROVED),
            self::CANCELLED => new self(self::CANCELLED),
            default => throw new \InvalidArgumentException("Invalid status: $value"),
        };
    }

    public function value(): string
    {
        return $this->value;
    }
}
