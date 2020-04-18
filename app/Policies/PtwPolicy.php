<?php

namespace App\Policies;

use App\User;
use App\Ptw;
use Illuminate\Auth\Access\HandlesAuthorization;

class PtwPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can create ptws.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function ptw_create(User $user)
    {
        return $this->permit($user, 'ptw_create');
    }

    /**
     * Determine whether the user can edit the ptw (button).
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_edit(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_edit');
    }

    /**
     * Determine whether the user can update the ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_update(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_update');
    }

    /**
     * Determine whether the user can view the ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_view(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_view');
    }

    /**
     * Determine whether the user can delete the ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_delete(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_delete');
    }

    /**
     * Determine whether the user can upload an attachment of the ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_upload(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_upload');
    }

    /**
     * Determine whether the user can copy a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_copy(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_copy');

    }

    /**
     * Determine whether the user can endorse a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_endorsed(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_endorsed');
    }

    /**
     * Determine whether the user can verify a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_verify(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_verify');
    }

    /**
     * Determine whether the user can approve a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_approve(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_approve');
    }

    /**
     * Determine whether the user can reject a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_reject(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_reject');
    }

    /**
     * Determine whether the user can revoke a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_revoke(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_revoke');
    }

    /**
     * Determine whether the user can complete / close a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_complete(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_complete');
    }

    /**
     * Determine whether the user can halt a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_halt(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_halt');
    }

    /**
     * Determine whether the user can resume a ptw.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_resume(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_resume');
    }

    /**
     * Determine whether the user can generate a ptw report.
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_report(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_report');
    }

    /**
     * Determine whether the user can access ptw setup menu (for checklist , equipment, manpower, etc...).
     *
     * @param  \App\User  $user
     * @param  \App\Ptw  $ptw
     * @return mixed
     */
    public function ptw_setup_menu(User $user, Ptw $ptw)
    {
        return $this->permit($user, 'ptw_setup_menu');
    }

    /**
     * Determine whether the user has access ptw menu
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function ptw_menu(User $user)
    {    
        return $this->permit($user, 'ptw_menu');
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
    //  * Determine whether the user can view any ptws.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }
    
    // /**
    //  * Determine whether the user can delete the ptw.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Ptw  $ptw
    //  * @return mixed
    //  */
    // public function delete(User $user, Ptw $ptw)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the ptw.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Ptw  $ptw
    //  * @return mixed
    //  */
    // public function restore(User $user, Ptw $ptw)
    // {
    //     //
    // }

}
