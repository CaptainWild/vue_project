<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checklist;
use App\ChecklistItem;

class ChecklistItemController extends Controller
{
    /**
     * Apply auth middleware
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function store(Checklist $checklist,Request $request)
    {
        $checklist->version_index = $checklist->version_index + 1;
        $checklist->save();

        $request->request->add(['created_by' => auth()->id()]); //add request

        return response()->json($checklist->addItem($request->all()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChecklistItem  $checklistitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChecklistItem $checklistitem)
    {        
        $attributes['header']= $request->header;
        $attributes['sub_header']= $request->sub_header;
        $attributes['description']= $request->description; 
        $attributes['seq_no']     = $request->seq_no; 
        $attributes['updated_by'] = auth()->id();

        $result = $checklistitem->update($attributes);

        $checklist = Checklist::find($checklistitem->checklist_id);
        $checklist->version_index =  $checklist->version_index + 1;
        $checklist->save();

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChecklistItem  $checklistitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChecklistItem $checklistitem)
    { 
        $result = $checklistitem->delete();

        $checklist = Checklist::find($checklistitem->checklist_id);
        $checklist->version_index =  $checklist->version_index + 1;
        $checklist->save();

        return response()->json($result);
    }
}
