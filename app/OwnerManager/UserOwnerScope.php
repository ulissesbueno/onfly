<?php

namespace App\OwnerManager;
use Illuminate\Database\Eloquent\Scope;

class UserOwnerScope implements Scope
{
    protected UserOwnerManager $userOwnerManager;

    public function __construct(UserOwnerManager $userOwnerManager)
    {
        $this->userOwnerManager = $userOwnerManager;
    }

    public function apply($builder, $model)
    {
        if ($userId = $this->userOwnerManager->getUserId()) {
            $builder->where($model->getTable() . '.user_id', $userId);
        }
    }
}