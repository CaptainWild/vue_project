<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view role list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function roles(User $user)
    {
        return $this->permit($user,'roles');
    }

    /**
     * Determine whether the user can view role menu.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function role_menu(User $user)
    {
        return $this->permit($user,'role_menu');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function role_view(User $user, Role $role)
    {
        return $this->permit($user,'role_view');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function role_create(User $user)
    {
        return $this->permit($user,'role_create');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function role_edit(User $user, Role $role)
    {
        return $this->permit($user,'role_edit');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function role_delete(User $user, Role $role)
    {
        return $this->permit($user,'role_delete');
    }

    /**
     * Determine whether the user has access a particluar swp feature
     * 
     * @param \App\User $user
     * @param String $access  
     * @return Boolean
     */
    private function permit(User $user,$access) 
    {
        $grant = false;
        foreach($user->role->permissions as $key => $value) {
            if($value->code == $access) {
                $grant = true;

            break;
            }
        }

        return $grant;
    }

    // /**
    //  * Determine whether the user can view any roles.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the role.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Role  $role
    //  * @return mixed
    //  */
    // public function restore(User $user, Role $role)
    // {
    //     //
    // }
}
