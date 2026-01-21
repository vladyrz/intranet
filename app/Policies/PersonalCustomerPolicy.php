<?php

namespace App\Policies;

use App\Models\PersonalCustomer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PersonalCustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Users can view their own list
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PersonalCustomer $personalCustomer): bool
    {
        return $user->id === $personalCustomer->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PersonalCustomer $personalCustomer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PersonalCustomer $personalCustomer): bool
    {
        return false;
    }
}
