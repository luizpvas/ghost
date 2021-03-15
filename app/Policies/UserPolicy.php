<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Users can only edit themselves.
     * 
     * @param  User $user
     * @param  User $target
     * @return boolean
     */
    function edit(User $user, User $target)
    {
        return $user->id == $target->id;
    }
}
