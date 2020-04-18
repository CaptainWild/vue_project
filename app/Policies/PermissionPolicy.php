<?php

namespace App\Policies;

use App\User;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view the permission menu and list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function permission_menu(User $user)
    {
        return $this->permit($user,'permission_menu');
    }

    /**
     * Determine whether the user can view the permission.
     *
     * @param  \App\User  $user
     * @param  \App\Permission  $permission
     * @return mixed
     */
    public function permission_view(User $user, Permission $permission)
    {
        return $this->permit($user, 'permission_view');
    }

    /**
     * Determine whether the user can create permissions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function permission_create(User $user)
    {
        return $this->permit($user, 'permission_create');
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param  \App\User  $user
     * @param  \App\Permission  $permission
     * @return mixed
     */
    public function permission_edit(User $user, Permission $permission)
    {
        return $this->permit($user, 'permission_edit');
    }

    /**
     * Determine whether the user can delete the permission.
     *
     * @param  \App\User  $user
     * @param  \App\Permission  $permission
     * @return mixed
     */
    public function permission_delete(User $user, Permission $permission)
    {
        return  $this->permit($user, 'permission_delete');
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
    //  * Determine whether the user can view any permissions.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the permission.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Permission  $permission
    //  * @return mixed
    //  */
    // public function restore(User $user, Permission $permission)
    // {
    //     //
    // }
}
