<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HrwChecklist;
use App\PtwChecklistItem;
use App\PtwChecklistItemDetail;
use App\Ptw;
use App\PtwChecklistStatus;
use Carbon\Carbon;
use App\Http\Traits\SignatureTrait;

class PtwChecklistItemController extends Controller
{
    use SignatureTrait;

    /**
     * Apply auth middleware
    */
    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Ptw $ptw) {
        return response()->json($ptw->ptwchecklistitems()->get());
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PtwChecklistItem  $ptwchecklistitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PtwChecklistItem $ptwchecklistitem)
    {
        $attributes['ptw_checklist_status_id'] = $request->ptw_checklist_status_id;
        $attributes['updated_by'] = auth()->id();
        
        //completed
        if($request->ptw_checklist_status_id == 1) {
            $supervisor_signature = $this->decodeAndStore('ptw_checklist_items', $ptwchecklistitem->id,$request->supervisor_signed_path);
            $attributes['remarks'] = $request->remarks;
            $attributes['supervisor_signature_path'] = $supervisor_signature;
            $attributes['supervisor_id'] = auth()->id();
        }

        $this->attachPtwChecklistItemDetails($ptwchecklistitem);
      
        $result = $ptwchecklistitem->update($attributes);
        
        return response()->json($result);
    }

     /**
     * update the ptw-checklist-item-status-id to 3 (no-activity)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param \App\PtwChecklistItem $ptwchecklistitem
     * @return \Illuminate\Http\Response
     */
    public function noact(Request $request, PtwChecklistItem $ptwchecklistitem) 
    {

        $attributes['ptw_checklist_status_id'] = 3;
        $attributes['remarks'] = $request->remarks;
        $attributes['updated_by'] = auth()->id();

        $result = $ptwchecklistitem->update($attributes);

        return response()->json($result);
    }

    /**
     * attach / detach high risk work
     *  @param  \App\PtwChecklistItem $ptwchecklistitem
     */
    private function attachPtwChecklistItemDetails(PtwChecklistItem $ptwchecklistitem)
    {
        $hrw_checklist_ids = request()->hrw_checklist_ids ?? array();
         //ptw - signee(user) - hrw - checklist
         if(!empty($hrw_checklist_ids)) {
            $hrw_checklist_id_requests = json_decode($hrw_checklist_ids);
            
            $ptwhrwchecklists = $ptwchecklistitem->ptwchecklistitemdetails()->where('created_by',auth()->id());
            if($ptwhrwchecklists->count() > 0) {
                
                $ptwhrwchecklists->update(['checked' => 0,'updated_by'=>auth()->id()]);
                
                $ptwhrwchecklists->whereIn('hrw_checklist_id',$hrw_checklist_id_requests)    
                    ->update(['checked' => 1]);
                
            } else {

                $hrw_checklists = $ptwchecklistitem->hrw->hrwchecklists()->get();
                
                foreach($hrw_checklists as $hrw_checklist) {
                    $checked = 0;
                    
                    if(in_array($hrw_checklist->id,$hrw_checklist_id_requests)) {
                        $checked = 1;
                    }
                    
                    $ptwchecklistitem->addPtwChecklistItemDetail([
                        'checked'           => $checked,
                        'created_by'        => auth()->id(),
                        'hrw_checklist_id'  => $hrw_checklist->id,                        
                    ]);
                }   
            }    
        }
    }
}
