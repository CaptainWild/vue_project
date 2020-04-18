<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\Policies\PtwPolicy;
use App\Policies\SwpPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SubContractorPolicy;
use App\Policies\EquipPolicy;
use App\Policies\WorkerPolicy;
use App\Policies\ChecklistPolicy;
use App\Policies\InspectionPolicy;
use App\Policies\InspectionDetailPolicy;
use App\Policies\InspectionChecklistPolicy;
use App\Policies\InspectionChecklistItemPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Ptw' => 'App\Policies\PtwPolicy',
        'App\Swp' => 'App\Policies\SwpPolicy',
        'App\Project' => 'App\Policies\ProjectPolicy',
        'App\SubContractor' => 'App\Policies\SubContractorPolicy',
        'App\Equip' => 'App\Policies\EquipPolicy',
        'App\Worker' => 'App\Policies\WorkerPolicy',
        'App\Checklist' => 'App\Policies\ChecklistPolicy',
        'App\Inspection' => 'App\Policies\InspectionPolicy',
        'App\InspectionDetail' => 'App\Policies\InspectionDetailPolicy',
        'App\InspectionChecklist' => 'App\Policies\InspectionChecklistPolicy',
        'App\InspectionChecklistItem' => 'App\Policies\InspectionChecklistItemPolicy',
        'App\InspectionChecklistItemResult' => 'App\Policies\InspectionChecklistItemPolicy',
        'App\Role' => 'App\Policies\RolePolicy',        
        'App\User' => 'App\Policies\UserPolicy',
        'App\Permission' => 'App\Policies\PermissionPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
