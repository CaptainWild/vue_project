<?php

namespace App\Http\Controllers;

use App\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
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
        return response()->json(Trade::orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateTrade();
        
        $attributes['created_by'] = auth()->id();
        $attributes['description']= $request->description;
        $attributes['is_active']  = $request->is_active ?? 0; 

        $trade = Trade::create($attributes);

        return response()->json($trade);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function show(Trade $trade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trade $trade)
    {
        $attributes = $this->validateTrade();

        $attributes['description']= $request->description; 
        $attributes['is_active']  = $request->is_active ?? 0; 
        $attributes['updated_by'] = auth()->id();

        $result = $trade->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trade  $trade
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trade $trade, $remarks)
    {
        $result = $trade->update(['delete_remark' =>  $remarks]);
 
        $result = $trade->delete();
        return response()->json($result);
    }

    /**
     * Validation
     */
    protected function validateTrade() {
        return request()->validate([
            'name'=> ['required'],
        ]);
    }
}
