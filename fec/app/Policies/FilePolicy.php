<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */

    public function viewShared(User $user, File $file): bool
    {
        $owner = User::find($file->owner_id);
        if ($owner && $user->friends()->where('friend_id', $owner->id)->exists()) {
            return $file->fileAccess()->where('user_id', $user->id)->exists();
        }

        return false;
    }
    
    public function view(User $user, File $file): bool
    {
        if ($user->id === $file->owner_id || $file->is_public) {
            return true;
        }

        if ($this->viewShared($user, $file)) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isUser();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, File $file): bool
    {
        if($user->id === $file->owner_id) {
            return true;
        }

        $owner = User::find($file->owner_id);
        if ($owner && $user->friends()->where('friend_id', $owner->id)->exists()) {
            return $file->fileAccess()
                ->where('user_id', $user->id)
                ->where('can_edit', true)
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, File $file): bool
    {
        if($user->id === $file->owner_id) {
            return true;
        }

        $owner = User::find($file->owner_id);
        if ($owner && $user->friends()->where('friend_id', $owner->id)->exists()) {
            return $file->fileAccess()
                ->where('user_id', $user->id)
                ->where('can_edit', true)
                ->exists();
        }

        return false;
    }

    public function manageAccess(User $user, File $file): bool
    {
        return $user->id === $file->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, File $file): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, File $file): bool
    {
        return false;
    }

    public function before(User $user, string $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
