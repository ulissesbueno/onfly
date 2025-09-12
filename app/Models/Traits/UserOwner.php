<?php

namespace App\Models\Traits;

use App\OwnerManager\UserOwnerManager;
use App\OwnerManager\UserOwnerScope;

trait UserOwner
{
    protected static function bootUserOwner()
    {
        static::addGlobalScope(
            new UserOwnerScope(app(UserOwnerManager::class))
        );

        static::creating(function ($model) {
            $userOwnerManager = app(UserOwnerManager::class);
            if ($userOwnerManager->getUserId()) {
                $model->user_id = $userOwnerManager->getUserId();
            }
        });
    }
}