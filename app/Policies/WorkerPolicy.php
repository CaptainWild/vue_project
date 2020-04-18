<?php

namespace App\Policies;

use App\User;
use App\Worker;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkerPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view the workers menu.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function manpower_menu(User $user)
    {
        return $this->permit($user, 'manpower_menu');
    }

    /**
     * Determine whether the user can create workers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function manpower_create(User $user)
    {
        return $this->permit($user, 'manpower_create');
    }

    /**
     * Determine whether the user can update the worker.
     *
     * @param  \App\User  $user
     * @param  \App\Worker  $worker
     * @return mixed
     */
    public function manpower_edit(User $user, Worker $worker)
    {
        return $this->permit($user, 'manpower_edit');
    }

    /**
     * Determine whether the user can view the worker.
     *
     * @param  \App\User  $user
     * @param  \App\Worker  $worker
     * @return mixed
     */
    public function manpower_view(User $user, Worker $worker)
    {
        return $this->permit($user, 'manpower_view'); 
    }

    /**
     * Determine whether the user can delete the worker.
     *
     * @param  \App\User  $user
     * @param  \App\Worker  $worker
     * @return mixed
     */
    public function manpower_delete(User $user, Worker $worker)
    {
        return $this->permit($user, 'manpower_delete');
    }

    /**
     * Determine whether the user can upload certificates of the equip.
     *
     * @param  \App\User  $user
     * @param  \App\Worker  $worker
     * @return mixed
     */
    public function manpower_upload(User $user, Worker $worker)
    {
        return $this->permit($user,'manpower_upload');
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
    //  * Determine whether the user can view any workers.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the worker.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Worker  $worker
    //  * @return mixed
    //  */
    // public function restore(User $user, Worker $worker)
    // {
    //     //
    // }
}
