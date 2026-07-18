<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\User;

class DonationPolicy
{
    public function delete(User $user, Donation $donation): bool
    {
        return $user->isAdmin() || $user->id === $donation->donor_id;
    }
}
