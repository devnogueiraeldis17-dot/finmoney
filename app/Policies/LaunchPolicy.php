<?php

namespace App\Policies;

use App\Models\Launch;
use App\Models\User;

class LaunchPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Launch $launch): bool {
        return $user->isAdmin() || $launch->user_id === $user->id;
    }
    public function create(User $user): bool { return true; }
    public function update(User $user, Launch $launch): bool { return $user->isAdmin(); }
    public function delete(User $user, Launch $launch): bool { return $user->isAdmin(); }
}
