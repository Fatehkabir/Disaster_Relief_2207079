<?php

namespace App\Policies;

use App\Models\ReliefRequest;
use App\Models\User;

class ReliefRequestPolicy
{
    public function update(User $user, ReliefRequest $reliefRequest): bool
    {
        return $user->isAdmin()
            || $user->isOrganization()
            || $user->id === $reliefRequest->user_id;
    }

    public function delete(User $user, ReliefRequest $reliefRequest): bool
    {
        return $user->isAdmin() || $user->id === $reliefRequest->user_id;
    }
}
