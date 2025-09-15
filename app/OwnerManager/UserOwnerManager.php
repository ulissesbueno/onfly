<?php

namespace App\OwnerManager;

use Tymon\JWTAuth\Facades\JWTAuth;

class UserOwnerManager
{
    protected ?string $userId = null;

    public function resolve(): ?string
    {
        if ($this->userId) {
            return $this->userId;
        }

        $user = auth()->user();
        $this->userId = $user?->id;

        return $this->userId;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? $this->resolve();
    }
}
