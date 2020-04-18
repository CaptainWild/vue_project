<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InspectionChecklistItem;

class InspectionChecklistItemController extends Controller
{
    /**
     * Apply auth middleware
    */
    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    /**
     * update the inspection-checklist-item-status-id to 4 to no-activity
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param \App\InspectionChecklistItem $inspectionchecklistitem
     * @return \Illuminate\Http\Response
     */
    public function noact(Request $request, InspectionChecklistItem $inspectionchecklistitem) 
    {

        $attributes['inspection_checklist_item_status_id'] = 4;
        $attributes['remarks'] = $request->remarks;
        $attributes['updated_by'] = auth()->id();

        $result = $inspectionchecklistitem->update($attributes);

        return response()->json($result);
    }

    
}
