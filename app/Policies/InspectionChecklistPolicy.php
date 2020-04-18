<?php

namespace App\Policies;

use App\User;
use App\InspectionChecklist;
use Illuminate\Auth\Access\HandlesAuthorization;

class InspectionChecklistPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view any inspection checklists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function inspection_checklist_menu(User $user)
    {
        return $this->permit($user,'inspection_checklist_menu');
    }

      /**
     * Determine whether the user can view the inspection checklist.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionChecklist  $inspectionChecklist
     * @return mixed
     */
    public function view(User $user, InspectionChecklist $inspectionChecklist)
    {
        //
    }

    /**
     * Determine whether the user can create inspection checklists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function inspection_checklist_create(User $user)
    {
        return $this->permit($user,'inspection_checklist_create');
    }

    /**
     * Determine whether the user can update the inspection checklist.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionChecklist  $inspectionchecklist
     * @return mixed
     */
    public function inspection_checklist_edit(User $user, InspectionChecklist $inspectionchecklist)
    {
        return $this->permit($user,'inspection_checklist_edit');
    }

    /**
     * Determine whether the user can delete the inspection checklist.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionChecklist  $inspectionchecklist
     * @return mixed
     */
    public function inspection_checklist_delete(User $user, InspectionChecklist $inspectionchecklist)
    {
        return $this->permit($user,'inspection_checklist_delete');
    }

     /**
     * Determine whether the user can update the inspection checklist.
     *
     * @param  \App\User  $user
     * @param  \App\InspectionChecklist  $inspectionchecklist
     * @return mixed
     */
    public function inspection_checklist_view(User $user, InspectionChecklist $inspectionchecklist)
    {
        return $this->permit($user,'inspection_checklist_view');
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
    //  * Determine whether the user can view any inspection checklists.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the inspection checklist.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\InspectionChecklist  $inspectionChecklist
    //  * @return mixed
    //  */
    // public function restore(User $user, InspectionChecklist $inspectionChecklist)
    // {
    //     //
    // }
}
