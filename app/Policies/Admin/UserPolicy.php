<?php

namespace App\Policies\Admin;

use App\Models\User;

class UserPolicy
{
    public function update(User $authUser, User $user): bool
    {
        return $authUser->isNot($user);
    }

    public function delete(User $authUser, User $user): bool
    {
        return $authUser->isNot($user);
    }
}
