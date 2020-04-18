<?php

namespace App\Listeners;

use App\Events\PtwUpdated;
use App\Notifications\PermitToWorkUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPtwUpdatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PtwUpdated  $event
     * @return void
     */
    public function handle(PtwUpdated $event)
    {
        if($event->ptw->ptw_status_id != 5) {
            //if signatory_id == 0 means it is either approved, halted, resumed, revoked, completed
            if(in_array($event->ptw->ptw_status_id,array(1,4,10,11,12))) {
                $event->ptw->creator->notify(new PermitToWorkUpdated($event->ptw));
            } else {
                $event->ptw->signatory->notify(new PermitToWorkUpdated($event->ptw));
            }            
        }
    }
}
