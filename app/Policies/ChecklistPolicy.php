<?php

namespace App\Policies;

use App\User;
use App\Checklist;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChecklistPolicy
{
    use HandlesAuthorization;
    
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view checklist menu and list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function checklist_menu(User $user)
    {
        return $this->permit($user,'checklist_menu');
    }

    /**
     * Determine whether the user can view the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function checklist_view(User $user, Checklist $checklist)
    {
        return $this->permit($user,'checklist_view');
    }

    /**
     * Determine whether the user can create checklists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function checklist_create(User $user)
    {
        return $this->permit($user,'checklist_create');
    }

    /**
     * Determine whether the user can update the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function checklist_edit(User $user, Checklist $checklist)
    {
        return $this->permit($user,'checklist_edit');
    }

    /**
     * Determine whether the user can delete the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function checklist_delete(User $user, Checklist $checklist)
    {
        return $this->permit($user,'checklist_delete');
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
    //  * Determine whether the user can view any checklists.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the checklist.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Checklist  $checklist
    //  * @return mixed
    //  */
    // public function restore(User $user, Checklist $checklist)
    // {
    //     //
    // }
}
