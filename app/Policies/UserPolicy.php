<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function admin(User $user) {
        return $user->isAdmin();
    }

    public function view(User $request, User $target) {
        return $request->id === $target->id || $request->isAdmin();
    }

    public function update(User $request, User $target) {
        return $request->id === $target->id;
    }
}
