<?php

namespace App\Policies;

use App\User;
use App\InspectionDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class InspectionDetailPolicy
{
    use HandlesAuthorization;
    
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }
     
    /**
     * Determine whether the user can delete the inspection detail.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionDetail  $inspectiondetail
     * @return mixed
     */
    public function inspection_details_delete(User $user, InspectionDetail $inspectiondetail)
    {
        return $this->permit($user,'inspection_details_delete');
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
    //  * Determine whether the user can view any inspection details.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can view the inspection detail.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionDetail  $inspectionDetail
    //  * @return mixed
    //  */
    // public function view(User $user, InspectionDetail $inspectionDetail)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can create inspection details.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function create(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can update the inspection detail.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionDetail  $inspectionDetail
    //  * @return mixed
    //  */
    // public function update(User $user, InspectionDetail $inspectionDetail)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can delete the inspection detail.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionDetail  $inspectionDetail
    //  * @return mixed
    //  */
    // public function delete(User $user, InspectionDetail $inspectionDetail)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the inspection detail.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionDetail  $inspectionDetail
    //  * @return mixed
    //  */
    // public function restore(User $user, InspectionDetail $inspectionDetail)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the inspection detail.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionDetail  $inspectionDetail
    //  * @return mixed
    //  */
    // public function forceDelete(User $user, InspectionDetail $inspectionDetail)
    // {
    //     //
    // }
}
