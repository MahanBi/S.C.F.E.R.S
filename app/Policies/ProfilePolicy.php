<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProfilePolicy
{
    public function update(User $user, User $profileUser): bool
    {
        // هر کاربری می‌تواند پروفایل خود را ویرایش کند
        return $user->id === $profileUser->id;
    }

    public function updatePassword(User $user, User $profileUser): bool
    {
        return $user->id === $profileUser->id;
    }

    public function updateAvatar(User $user, User $profileUser): bool
    {
        return $user->id === $profileUser->id;
    }
}