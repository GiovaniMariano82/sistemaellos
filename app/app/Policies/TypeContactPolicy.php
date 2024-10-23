<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TypeContact;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypeContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_type::contact');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TypeContact $typeContact): bool
    {
        return $user->can('view_type::contact');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_type::contact');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TypeContact $typeContact): bool
    {
        return $user->can('update_type::contact');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TypeContact $typeContact): bool
    {
        return $user->can('delete_type::contact');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_type::contact');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, TypeContact $typeContact): bool
    {
        return $user->can('force_delete_type::contact');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_type::contact');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, TypeContact $typeContact): bool
    {
        return $user->can('restore_type::contact');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_type::contact');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, TypeContact $typeContact): bool
    {
        return $user->can('replicate_type::contact');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_type::contact');
    }
}
