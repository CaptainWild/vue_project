<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspection;
use App\InspectionDetail;
use Storage;

class InspectionDetailController extends Controller
{
    /**
     * Apply auth middleware
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * @param \App\Inspection $inspection 
     * */ 
    public function itemsByInspectionId(Inspection $inspection) 
    {
        return response()->json($inspection->inspectiondetails()->get());
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
        $attributes['sub_contractor_id'] = $request->sub_contractor_id;                        
        $attributes['block']    = $request->block == 'undefined' ? '' : $request->block;
        $attributes['storey']   = $request->storey == 'undefined' ? '' : $request->storey;            
        $attributes['unit']     = $request->unit  == 'undefined' ? '' : $request->unit;

        $attributes['inspection_type_id'] = $request->inspection_type_id; 
        $attributes['inspection_type_item_id'] = $request->inspection_type_item_id; 
        $attributes['site_observation_id'] = $request->site_observation_id;
        $attributes['hazard_category_id'] = $request->hazard_category_id;
                                
        $attributes['response'] = $request->response;
        $attributes['severity_level'] = $request->severity_level;
        $attributes['photo_remarks'] = $request->photo_remarks;
       
        $s3 = '';
        if($request->hasFile('photo')) {
            $s3 = request()->file('photo')->store("/inspections/{$inspection->id}/inspection_details",'s3');
        }
        $attributes['photo'] = $s3;

        $result = $inspection->addDetails($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionDetail  $inspectiondetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspectionDetail $inspectiondetail)
    {
        $result = $inspectiondetail->delete();
        return response()->json($result);
    }


}
