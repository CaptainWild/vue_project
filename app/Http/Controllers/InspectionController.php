<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspection;
use Storage;
use Carbon\Carbon;
use App\Http\Traits\SignatureTrait;


class InspectionController extends Controller
{
    use SignatureTrait;
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
        return response()->json(Inspection::orderBy('created_at','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $attributes['created_by'] = auth()->id();        
        $attributes['project_id'] = $request->project_id;  
        $attributes['inspector_id'] = auth()->id();
        $attributes['inspection_date'] = $request->inspection_date;
        $attributes['location'] = $request->location;
        $attributes['status'] = 'Draft';        

        $inspection = Inspection::create($attributes);

        return response()->json($inspection);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function show(Inspection $inspection)
    {
        return response()->json($inspection);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inspection $inspection)
    {             
        $attributes['project_id'] = $request->project_id;  
        $attributes['inspection_date'] = $request->inspection_date;
        $attributes['location'] = $request->location;        
        
        $attributes['updated_by'] = auth()->id();

        $result = $inspection->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Inspection $inspection)
    {
        $result = $inspection->update([
            'delete_remark' =>  $request->delete_remark,
        ]);
 
        $result = $inspection->delete();
        return response()->json($result);
    }
     
    /**
     * Send to Sub-Contractor and mark as Incomplete the specified resource from storage.
     *
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function incomplete(Inspection $inspection)
    {
        $result = $inspection->update(['status'=>'Open']);
        return response()->json($result);
    }

    /**
     * Close the specified resource from storage.
     *
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request,Inspection $inspection)
    {

        $signature = $this->decodeAndStore('inspections',$inspection->id,$request->inspector_sign_path);

        $result = $inspection->update([
            'status'=>'Closed', 
            'closed_at'=> Carbon::now(),
            'inspector_sign_path' => $signature,
            'verifier_id' => $request->verifier_id
        ]);

        return response()->json($result);
    }

}
