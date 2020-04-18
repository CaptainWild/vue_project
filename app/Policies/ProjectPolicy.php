<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can access projects api.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function projects(User $user)
    {
        return $this->permit($user, 'projects');
    }

    /**
     * Determine whether the user can to projects menu.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function project_menu(User $user)
    {
        return $this->permit($user, 'project_menu');
    }

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function project_view(User $user, Project $project)
    {
        return $this->permit($user, 'project_view');
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function project_create(User $user)
    {
        return $this->permit($user, 'project_create');
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function project_edit(User $user, Project $project)
    {
        return $this->permit($user, 'project_edit');
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function project_delete(User $user, Project $project)
    {
        return $this->permit($user,'project_delete');
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
    //  * Determine whether the user can view any projects.
    //  *
    //  * @param  \App\User  $user
    //  * @return mixed
    //  */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the project.
    //  *
    //  * @param  \App\User  $user
    //  * @param  \App\Project  $project
    //  * @return mixed
    //  */
    // public function restore(User $user, Project $project)
    // {
    //     //
    // }
}
