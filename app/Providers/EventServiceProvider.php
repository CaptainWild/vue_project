<?php

namespace App\Providers;

use App\Events\PtwUpdated;
use App\Events\EquipmentUpdated;
use App\Events\EquipmentDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendPtwUpdatedNotification;
use App\Listeners\SendEquipStatusNotification;
use App\Listeners\SendEquipRemovalNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        PtwUpdated::class => [
            SendPtwUpdatedNotification::class,
        ],

        EquipmentUpdated::class => [
            SendEquipStatusNotification::class,
        ],

        EquipmentDeleted::class => [
            SendEquipRemovalNotification::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
