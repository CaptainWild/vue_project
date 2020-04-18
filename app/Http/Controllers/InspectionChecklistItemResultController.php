<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InspectionChecklistItemResult;
use App\InspectionChecklistItem;
use App\InspectionChecklist;
use App\Http\Traits\SignatureTrait;

class InspectionChecklistItemResultController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\InspectionChecklistItem $inspectionchecklistitem
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, InspectionChecklistItem $inspectionchecklistitem)
    {        
        $checklist_item_ids = json_decode($request->checklist_item_ids);
        $result_legend_ids  = json_decode($request->legend_ids,true);
        $result_remarks     = json_decode($request->remarks,true);
        
        foreach($checklist_item_ids as $checklist_item_id) {
           
            $attributes['checklist_item_id']            = $checklist_item_id->id;
            $attributes['created_by']                   = auth()->id();
            $attributes['inspection_checklist_item_id'] = $inspectionchecklistitem->id;            
            $attributes['legend_id']                    = $result_legend_ids[$checklist_item_id->id] ?? 0;
            $attributes['remarks']                      = $result_remarks[$checklist_item_id->id] ?? '';

            InspectionChecklistItemResult::create($attributes);
        }
        
        //update inspection checklist item
        $itemattributes['inspection_checklist_item_status_id'] = $request->inspection_checklist_item_status_id;
        $itemattributes['updated_by'] = auth()->id();
        
        if($request->inspection_checklist_item_status_id != 2) { //not incomplete
            
            $operator_signature = $this->decodeAndStore('inspection_checklist_items', $inspectionchecklistitem->id,$request->operator_signed_path);
            $supervisor_signature = $this->decodeAndStore('inspection_checklist_items', $inspectionchecklistitem->id,$request->supervisor_signed_path);
            
            $itemattributes['operator_signed_path']   = $operator_signature;
            $itemattributes['operator_id']            = $request->operator_id;
            $itemattributes['remarks']                = $request->remark;
            $itemattributes['supervisor_signed_path'] = $supervisor_signature;
            $itemattributes['supervisor_id']          = auth()->id();
        }

        $inspectionchecklistitem->update($itemattributes);
    
        return response()->json($inspectionchecklistitem);
    }

     /**
     * Update the specified resource in storage.
     * update InspectionChecklistItemResult
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionChecklist  $inspectionchecklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionChecklistItem $inspectionchecklistitem) 
    {
        $checklist_item_ids = json_decode($request->checklist_item_ids);
        $result_legend_ids  = json_decode($request->legend_ids,true);
        $result_remarks     = json_decode($request->remarks,true);

        $inspectionchecklistitemresults = $inspectionchecklistitem->inspectionchecklistitemresults()->get();

        foreach($inspectionchecklistitemresults as $inspectionchecklistitemresult) {
            $checklist_item_id = $inspectionchecklistitemresult->checklist_item_id;
            
            if(isset($result_legend_ids[$checklist_item_id])){
                $attributes['legend_id'] = $result_legend_ids[$checklist_item_id];
            }

            if(isset($result_remarks[$checklist_item_id])) {
                $attributes['remarks'] = $result_remarks[$checklist_item_id];
            }

            $attributes['updated_by'] = auth()->id();

            $inspectionchecklistitemresult->update($attributes);
        }
        
        $itemattributes['inspection_checklist_item_status_id'] = $request->inspection_checklist_item_status_id;
        $itemattributes['updated_by'] = auth()->id();

         //update inspection checklist item
        if($request->inspection_checklist_item_status_id != 2) { //not incomplete
            
            $operator_signature = $this->decodeAndStore('inspection_checklist_items', $inspectionchecklistitem->id,$request->operator_signed_path);
            $supervisor_signature = $this->decodeAndStore('inspection_checklist_items', $inspectionchecklistitem->id,$request->supervisor_signed_path);
            
            $itemattributes['operator_signed_path']   = $operator_signature;
            $itemattributes['operator_id']            = $request->operator_id;
            $itemattributes['remarks']                = $request->remark;
            $itemattributes['supervisor_signed_path'] = $supervisor_signature;
            $itemattributes['supervisor_id']          = auth()->id();
    
        }

        $inspectionchecklistitem->update($itemattributes);

        return response()->json($inspectionchecklistitem);        
    }

    
}
