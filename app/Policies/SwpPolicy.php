<?php

namespace App\Policies;

use App\User;
use App\Swp;
use Illuminate\Auth\Access\HandlesAuthorization;

class SwpPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any swps.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function swp_menu(User $user)
    {
        return $this->permit($user, 'swp_menu');
    }

    /**
     * Determine whether the user can create any swp.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function swp_create(User $user)
    {
        return $this->permit($user, 'swp_create');
    }

    /**
     * Determine whether the user can edit any swp.
     *
     * @param  \App\User  $user
     * @param \App\Swp $swp
     * @return mixed
     */
    public function swp_edit(User $user,Swp $swp)
    {
        return $this->permit($user, 'swp_edit');
    }

    /**
     * Determine whether the user can view any swp.
     *
     * @param  \App\User  $user
     * @param \App\Swp $swp
     * @return mixed
     */
    public function swp_view(User $user,Swp $swp)
    {
        return $this->permit($user, 'swp_view');
    }

    /**
     * Determine whether the user can delete any swp.
     *
     * @param  \App\User  $user
     * @param \App\Swp $swp
     * @return mixed
     */
    public function swp_delete(User $user,Swp $swp)
    {
        return $this->permit($user, 'swp_delete');
    }

    /**
     * Determine whether the user can upload any swp.
     *
     * @param  \App\User  $user
     * @param \App\Swp $swp
     * @return mixed
     */
    public function swp_upload(User $user,Swp $swp)
    {
        return $this->permit($user, 'swp_upload');
    }

    /**
     * Determine whether the user can approve any swp.
     *
     * @param  \App\User  $user
     * @param \App\Swp $swp
     * @return mixed
     */
    public function swp_approve(User $user,Swp $swp)
    {
        return $this->permit($user, 'swp_approve');
    }

    /**
     * Determine whether the user can reject any swp.
     *
     * @param  \App\User  $user
     * @param \App\Swp $swp
     * @return mixed
     */
    public function swp_reject(User $user,Swp $swp)
    {
        return $this->permit($user, 'swp_reject');
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
    //  * Determine whether the user can view any swps.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can delete the swp.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Swp  $swp
    //  * @return mixed
    //  */
    // public function delete(User $user, Swp $swp)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the swp.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Swp  $swp
    //  * @return mixed
    //  */
    // public function restore(User $user, Swp $swp)
    // {
    //     //
    // }

}
