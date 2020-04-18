<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Swp;
use App\SwpStatusHistory;

class SwpStatusHistoryController extends Controller
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
     * @param \App\Swp $swp
     * @return \Illuminate\Http\Response
     */
    public function index(Swp $swp)
    {
        return response()->json($swp->swpstatushistory()->orderBy('created_at','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \App\Swp $swp
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Swp $swp)
    {        
        $request->request->add(['created_by' => auth()->id()]); //add request
        
        $swp->update([
            'swp_status_id' => $request->swp_status_id,        
            'updated_by' => auth()->id()
        ]);

        return response()->json($swp->addHistory($request->all()));
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SwpStatusHistory $swpstatushistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SwpStatusHistory $swpstatushistory)
    {
        $attributes['comments']     = $request->comments;
        $attributes['updated_by']   = auth()->id();

        $result = $swpstatushistory->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SwpStatusHistory $swpstatushistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SwpStatusHistory $swpstatushistory)
    {
        $result = $swpstatushistory->delete();
        return response()->json($result);
    }

}
