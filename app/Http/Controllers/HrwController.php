<?php

namespace App\Http\Controllers;

use App\Hrw;
use Illuminate\Http\Request;

class HrwController extends Controller
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
    public function index()
    {
        return response()->json(Hrw::orderBy('name','asc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateHrw();
        
        $attributes['created_by'] = auth()->id();
        $attributes['description']= $request->description; 
        $attributes['checklist_group_id']= $request->checklist_group_id; 
        $attributes['is_active']  = $request->is_active ?? 0; 

        $hrw = Hrw::create($attributes);

        return response()->json($hrw);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hrw  $hrw
     * @return \Illuminate\Http\Response
     */
    public function show(Hrw $hrw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hrw  $hrw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hrw $hrw)
    {
        $attributes = $this->validateHrw();

        $attributes['description']= $request->description; 
        $attributes['checklist_group_id']= $request->checklist_group_id; 
        $attributes['is_active']  = $request->is_active ?? 0; 
        $attributes['updated_by'] = auth()->id();

        $result = $hrw->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hrw  $hrw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hrw $hrw)
    {
        $result = $hrw->delete();
        return response()->json($result);
    }

    /**
     * Validation
     */
    protected function validateHrw() 
    {
        return request()->validate([
            'name'=> ['required']
        ]);
    }
}
