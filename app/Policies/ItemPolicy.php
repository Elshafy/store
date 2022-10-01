<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function editItem(User $user)
    {
        // return backpack_user()->can('edit-item');
        return true;
    }
    public function activeItem(User $user)
    {
        return backpack_user()->can('changeState');
    }
}