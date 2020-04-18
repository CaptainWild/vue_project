<?php

namespace App\Policies;

use App\User;
use App\SubContractor;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubContractorPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can to projects menu.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function subcontractor_menu(User $user)
    {
        return $this->permit($user, 'subcontractor_menu');
    }

    /**
     * Determine whether the user can view the subcontractor.
     *
     * @param  \App\User  $user
     * @param  \App\SubContractor $subcontractor
     * @return mixed
     */
    public function subcontractor_view(User $user, SubContractor $subcontractor)
    {
        return $this->permit($user, 'subcontractor_view');
    }

    /**
     * Determine whether the user can create subcontractor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function subcontractor_create(User $user)
    {
        return $this->permit($user, 'subcontractor_create');
    }

    /**
     * Determine whether the user can update the sub contractor.
     *
     * @param  \App\User  $user
     * @param  \App\SubContractor  $subcontractor
     * @return mixed
     */
    public function subcontractor_edit(User $user, SubContractor $subcontractor)
    {
        return $this->permit($user, 'subcontractor_edit');
    }

    /**
     * Determine whether the user can delete the subcontractor.
     *
     * @param  \App\User  $user
     * @param  \App\SubContractor  $subcontractor
     * @return mixed
     */
    public function subcontractor_delete(User $user, SubContractor $subcontractor)
    {
        return $this->permit($user,'subcontractor_delete');
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
    //  * Determine whether the user can view any sub contractors.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the sub contractors.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\SubContractor  $subContractor
    //  * @return mixed
    //  */
    // public function restore(User $user, SubContractor $subContractor)
    // {
    //     //
    // }

}
