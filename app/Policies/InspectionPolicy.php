<?php

namespace App\Policies;

use App\User;
use App\Inspection;
use Illuminate\Auth\Access\HandlesAuthorization;

class InspectionPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view inspection  menu and list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function inspection_menu(User $user)
    {
        return $this->permit($user,'inspection_menu');
    }

    /**
     * Determine whether the user can view the inspection.
     *
     * @param  \App\User  $user
     * @param  \App\Inspection  $inspection
     * @return mixed
     */
    public function inspection_view(User $user, Inspection $inspection)
    {
        return $this->permit($user, 'inspection_view');
    }

    /**
     * Determine whether the user can create inspections.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function inspection_create(User $user)
    {
        return $this->permit($user, 'inspection_create');
    }

    /**
     * Determine whether the user can update the inspection.
     *
     * @param  \App\User  $user
     * @param  \App\Inspection  $inspection
     * @return mixed
     */
    public function inspection_edit(User $user, Inspection $inspection)
    {
        return $this->permit($user, 'inspection_edit');
    }

    /**
     * Determine whether the user can delete the inspection.
     *
     * @param  \App\User  $user
     * @param  \App\Inspection  $inspection
     * @return mixed
     */
    public function inspection_delete(User $user, Inspection $inspection)
    {
        return $this->permit($user, 'inspection_delete');
    }

    /**
     * Determine whether the user can mark the inspection incomplete.
     *
     * @param  \App\User  $user
     * @param  \App\Inspection  $inspection
     * @return mixed
     */
    public function inspection_incomplete(User $user, Inspection $inspection)
    {
        return $this->permit($user, 'inspection_incomplete');
    }

    /**
     * Determine whether the user can mark the inspection complete.
     *
     * @param  \App\User  $user
     * @param  \App\Inspection  $inspection
     * @return mixed
     */
    public function inspection_complete(User $user, Inspection $inspection)
    {
        return $this->permit($user, 'inspection_complete');
    }

    /**
     * Determine whether the user has access a particluar ptw feature
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
    //  * Determine whether the user can view any inspections.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the inspection.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Inspection  $inspection
    //  * @return mixed
    //  */
    // public function restore(User $user, Inspection $inspection)
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the inspection.
     *
     * @param  \App\User  $user
     * @param  \App\Inspection  $inspection
     * @return mixed
     */
    public function forceDelete(User $user, Inspection $inspection)
    {
        //
    }
}
