<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChecklistGroup;
use App\Checklist;
use App\Legend;

class ChecklistController extends Controller
{
    /**
     * Apply auth middleware
     */
    public function __construct() {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json(Checklist::orderBy('created_at','desc')->get());
    }

    /**
     * Display a listing of the resource by Group
     *
     * @return \Illuminate\Http\Response
     */
    public function group(ChecklistGroup $checklistgroup) {
        //return response()->json(Checklist::orderBy('created_at','desc')->get());
        return response()->json($checklistgroup->checklists()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $attributes['name'] = $request->name;
        $attributes['created_by'] = auth()->id();
        $attributes['description']= $request->description; 
        $attributes['checklist_group_id']= $request->checklist_group_id;
        $attributes['is_active']  = 1; 

        $checklist = Checklist::create($attributes);

        return response()->json($checklist);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function show(Checklist $checklist)
    {
        return response()->json($checklist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $checklist)
    {
        $attributes['name']       = $request->name; 
        $attributes['description']= $request->description; 
        $attributes['checklist_group_id']= $request->checklist_group_id; 
        $attributes['version_index']= $checklist->version_index + 1;
        $attributes['updated_by'] = auth()->id();

        $result = $checklist->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checklist  $checklist
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist, $remarks)
    {
        $result = $checklist->update(['delete_remark' => $remarks]);
 
        $result = $checklist->delete();
        return response()->json($result);
    }

     /**
     * Attach / Detach a legend to a checklist
     * 
     * @param \App\Checklist $checklist
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleLegend(Checklist $checklist,Request $request) 
    {
        if($request->value){
            return response()->json($checklist->legends()->attach($request->id));
        } else {
            return response()->json($checklist->legends()->detach($request->id));
        }
    }

     /**
     * Attach / Detach ALL Legend to a Checklist
     * 
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleAllLegends(Checklist $checklist, Request $request)
    {
        $checklist->legends()->detach();

        if($request->value) {
            return response()->json($checklist->legends()->attach(Legend::select('id')->get()));
        } else {
            return response()->json($checklist->legends()->detach());
        }
    }
}
