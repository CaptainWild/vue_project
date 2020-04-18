<?php

namespace App\Http\Controllers;

use App\HrwChecklist;
use App\Hrw;
use Illuminate\Http\Request;

class HrwChecklistController extends Controller
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
    public function index(Hrw $hrw)
    {
        return response()->json($hrw->hrwchecklists()->orderBy('seq_no','asc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Hrw  $hrw
     * @return \Illuminate\Http\Response
     */
    public function store(Hrw $hrw,Request $request)
    {                
        $request->request->add(['created_by' => auth()->id()]); //add request

        return response()->json($hrw->addChecklist($request->all()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HrwChecklist  $hrwChecklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrwChecklist $hrwchecklist)
    {
        $attributes['description']= $request->description; 
        $attributes['seq_no']     = $request->seq_no; 
        $attributes['updated_by'] = auth()->id();

        $result = $hrwchecklist->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HrwChecklist  $hrwChecklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrwChecklist $hrwchecklist)
    {
        $result = $hrwchecklist->delete();
        return response()->json($result);
    }
}
