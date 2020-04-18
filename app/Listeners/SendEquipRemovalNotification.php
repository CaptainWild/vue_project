<?php

namespace App\Listeners;

use App\Events\EquipmentDeleted;
use App\Notifications\EquipmentRemoved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class SendEquipRemovalNotification
{
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
     * @param  EquipmentDeleted  $event
     * @return void
     */
    public function handle(EquipmentDeleted $event)
    {
        $date = Carbon::now()->toDateString();
        
        $ptws = $event->equip->ptws()->whereRaw('"'.$date .'" between ptws.start_date and ptws.end_date')->get();

         //1 = approved , 5 = draft, 6 = endorsed, 8 = pending, 12 = resumed
         foreach($ptws as $ptw)
         {            
            if(in_array($ptw->ptw_status_id, array(1,5,6,8,12)))
            {
                $ptw->creator->notify(new EquipmentRemoved($event->equip,$ptw));
            //  if($ptw->ptw_status_id == 8 || $ptw->ptw_status_id == 6) 
            //  {
            //      $ptw->signatory->notify(new EquipmentNonOperationalUpdate($event->equip,$ptw));
            //  }
            }
         }
    }
}
