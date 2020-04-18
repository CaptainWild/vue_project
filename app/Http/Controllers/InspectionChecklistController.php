<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InspectionChecklist;
use App\InspectionChecklistItem;
use Carbon\Carbon;

class InspectionChecklistController extends Controller
{
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
    public function index()
    {
        return response()->json(InspectionChecklist::orderBy('created_at','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes['checklist_id']     = $request->checklist_id;
        $attributes['created_by']       = auth()->id();        
        $attributes['end_date']         = $request->end_date;
        $attributes['end_time']         = $request->end_time == 'null' ? NULL : $request->end_time;
        $attributes['location']         = $request->location ?? '';                
        $attributes['project_id']       = $request->project_id;
        $attributes['remarks']          = $request->remarks ?? '';
        $attributes['start_date']       = $request->start_date;
        $attributes['start_time']       = $request->start_time == 'null' ? NULL : $request->start_time;        
        $attributes['sub_contractor_id']= $request->sub_contractor_id;        
        $attributes['work_to_be_done']  = $request->work_to_be_done ?? '';
        $attributes['supervisor_only']  = $request->supervisor_only;

        $inspectionchecklist = InspectionChecklist::create($attributes);

        if(isset($request->generate) && $request->generate) {
            $this->generateChecklistItem($inspectionchecklist);
        }

        return response()->json($inspectionchecklist);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionChecklist  $inspectionchecklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionChecklist $inspectionchecklist) 
    {
        $attributes['hrw_id']           = $request->hrw_id ?? 0;
        $attributes['updated_by']       = auth()->id();
        $attributes['end_date']         = $request->end_date;
        $attributes['end_time']         = $request->end_time == 'null' ? NULL : $request->end_time;
        $attributes['location']         = $request->location ?? '';
        $attributes['project_id']       = $request->project_id ?? 0;
        $attributes['remarks']          = $request->remarks ?? '';
        $attributes['start_date']       = $request->start_date;
        $attributes['start_time']       = $request->start_time == 'null' ? NULL : $request->start_time;        
        $attributes['sub_contractor_id']= $request->sub_contractor_id ?? 0;        
        $attributes['work_to_be_done']  = $request->work_to_be_done ?? '';
        $attributes['supervisor_only']  = $request->supervisor_only;

        $result = $inspectionchecklist->update($attributes);

        if(isset($request->generate) && $request->generate) {
            $this->generateChecklistItem($inspectionchecklist);
        }

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionChecklist  $inspectionchecklist
     * @return \Illuminate\Http\Response
     */
    public function show(InspectionChecklist $inspectionchecklist)
    {
        return response()->json($inspectionchecklist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionChecklist $inspectionchecklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspectionChecklist $inspectionchecklist)
    {
        $result = $inspectionchecklist->delete();
        return response()->json($result);
    }

    private function generateChecklistItem(InspectionChecklist $inspectionchecklist)
    {       
        $start_date = new Carbon(request()->start_date);
        $end_date   = request()->end_date;
        
        while (strtotime($start_date) <= strtotime($end_date)) {
            $item = [
                'created_by' => auth()->id(),
                'inspection_date' => $start_date                
            ];
            
            $inspectionchecklist->addInspectionChecklistItem($item);
            
            $start_date = $start_date->addDay();                
        }
    }

    

}
