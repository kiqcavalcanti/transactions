<?php

namespace App\Policies;

use App\Domain\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $authUser)
    {
        return $authUser->is_admin;
    }

    public function view(User $authUser, User $user)
    {
        return $authUser->id === $user->id || $authUser->is_admin;
    }

    public function create(?User $user)
    {
        return true;
    }

    public function update(User $authUser, User $user)
    {
        return $authUser->id === $user->id || $authUser->is_admin;
    }

    public function delete(User $authUser, User $user)
    {
        return $authUser->id === $user->id || $authUser->is_admin;
    }

    public function restore(User $authUser, User $user)
    {
        return $authUser->id === $user->id || $authUser->is_admin;
    }
}
