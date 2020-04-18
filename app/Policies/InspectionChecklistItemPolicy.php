<?php

namespace App\Policies;

use App\User;
use App\InspectionChecklistItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class InspectionChecklistItemPolicy
{
    use HandlesAuthorization;
    
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the inspection checklist item as no acitivity.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionChecklistItem  $inspectionchecklistitem
     * @return mixed
     */
    public function inspection_checklist_item_noact(User $user, InspectionChecklistItem $inspectionchecklistitem)
    {
        return $this->permit($user, 'inspection_checklist_item_noact');
    }

    /**
     * Determine whether the user can create an inspection checklist item result.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionChecklistItem  $inspectionchecklistitem
     * @return mixed
     */
    public function inspection_checklist_item_create(User $user, InspectionChecklistItem $inspectionchecklistitem)
    {
        return $this->permit($user, 'inspection_checklist_item_create');
    }

    /**
     * Determine whether the user can update an inspection checklist item result.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionChecklistItem  $inspectionchecklistitem
     * @return mixed
     */
    public function inspection_checklist_item_edit(User $user, InspectionChecklistItem $inspectionchecklistitem)
    {
        return $this->permit($user, 'inspection_checklist_item_edit');
    }

    // /**
    //  * Determine whether the user can create inspection checklist items.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function create(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can update the inspection checklist item.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionChecklistItem  $inspectionChecklistItem
    //  * @return mixed
    //  */
    // public function update(User $user, InspectionChecklistItem $inspectionChecklistItem)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can delete the inspection checklist item.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionChecklistItem  $inspectionChecklistItem
    //  * @return mixed
    //  */
    // public function delete(User $user, InspectionChecklistItem $inspectionChecklistItem)
    // {
    //     //
    // }

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
    //  * Determine whether the user can view any inspection checklist items.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the inspection checklist item.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionChecklistItem  $inspectionChecklistItem
    //  * @return mixed
    //  */
    // public function restore(User $user, InspectionChecklistItem $inspectionChecklistItem)
    // {
    //     //
    // }
}
