<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equip;

class EquipController extends Controller
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
        return response()->json(Equip::orderBy('created_at','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes['brand'] = $request->brand;
        $attributes['capacity'] = $request->capacity;
        $attributes['created_by'] = auth()->id();
        $attributes['description']= $request->description;
        $attributes['sub_contractor_id'] = $request->sub_contractor_id;
        $attributes['equip_category_id'] = $request->equip_category_id;
        $attributes['equip_status_id'] = $request->equip_status_id;        
        $attributes['lm_no'] = $request->lm_no;
        $attributes['model'] = $request->model;        
        $attributes['name'] = $request->name;        
        $attributes['vrn'] = $request->vrn;        
        $attributes['qty'] = 1;

        $equip = Equip::create($attributes);

        return response()->json($equip);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equip  $equip
     * @return \Illuminate\Http\Response
     */
    public function show(Equip $equip)
    {
        return response()->json($equip);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equip  $equip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equip $equip)
    {
        $attributes['brand'] = $request->brand;
        $attributes['capacity'] = $request->capacity;
        $attributes['description']= $request->description;
        $attributes['sub_contractor_id'] = $request->sub_contractor_id;
        $attributes['equip_category_id'] = $request->equip_category_id;
        $attributes['equip_status_id'] = $request->equip_status_id;
        $attributes['lm_no'] = $request->lm_no;
        $attributes['model'] = $request->model;        
        $attributes['name'] = $request->name;        
        $attributes['vrn'] = $request->vrn;        
        $attributes['updated_by'] = auth()->id();

        $result = $equip->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equip  $equip
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equip $equip, $remarks)
    {
        $result = $equip->update(['delete_remark' =>  $remarks]);
       
        $result = $equip->delete();
        return response()->json($result);
    }
}
