<?php

namespace App\Policies;

use App\User;
use App\Equip;
use Illuminate\Auth\Access\HandlesAuthorization;

class EquipPolicy
{
    use HandlesAuthorization;
    
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view equip menu and list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function equipment_menu(User $user)
    {
        return $this->permit($user,'equipment_menu');
    }

    /**
     * Determine whether the user can view the equip.
     *
     * @param  \App\User  $user
     * @param  \App\Equip  $equip
     * @return mixed
     */
    public function equipment_view(User $user, Equip $equip)
    {
        return $this->permit($user,'equipment_view');
    }

    /**
     * Determine whether the user can create equips.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function equipment_create(User $user)
    {
        return $this->permit($user,'equipment_create');
    }

    /**
     * Determine whether the user can update the equip.
     *
     * @param  \App\User  $user
     * @param  \App\Equip  $equip
     * @return mixed
     */
    public function equipment_edit(User $user, Equip $equip)
    {
        return $this->permit($user,'equipment_edit');
    }

    /**
     * Determine whether the user can delete the equip.
     *
     * @param  \App\User  $user
     * @param  \App\Equip  $equip
     * @return mixed
     */
    public function equipment_delete(User $user, Equip $equip)
    {
        return $this->permit($user,'equipment_delete');
    }

    /**
     * Determine whether the user can upload certificates of the equip.
     *
     * @param  \App\User  $user
     * @param  \App\Equip  $equip
     * @return mixed
     */
    public function equipment_upload(User $user, Equip $equip)
    {
        return $this->permit($user,'equipment_upload');
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
    //  * Determine whether the user can restore the equip.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Equip  $equip
    //  * @return mixed
    //  */
    // public function restore(User $user, Equip $equip)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can view any equips.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }
}
