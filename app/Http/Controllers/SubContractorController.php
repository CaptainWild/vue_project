<?php

namespace App\Http\Controllers;

use App\Project;
use App\SubContractor;
use Illuminate\Http\Request;

class SubContractorController extends Controller
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
        return response()->json(SubContractor::with('trade','projects')->orderBy('created_at','desc')->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateSubContractor();
        
        $attributes['created_by'] = auth()->id();
        $attributes['main_contact_email']= $request->main_contact_email;
        $attributes['main_contact_email2']= $request->main_contact_email2;
        $attributes['main_contact_email3']= $request->main_contact_email3;
        $attributes['main_contact_email4']= $request->main_contact_email4;
        $attributes['main_contact']= $request->main_contact;
        $attributes['location']= $request->location;
        $attributes['remarks']= $request->remarks;
        $attributes['trade_id']  = $request->trade_id ?? 0; 
        $attributes['is_active']  = $request->is_active ?? 0; 

        $subContractor = SubContractor::create($attributes);

        return response()->json($subContractor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubContractor  $subContractor
     * @return \Illuminate\Http\Response
     */
    public function show(SubContractor $subContractor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubContractor  $subcontractor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubContractor $subcontractor)
    {

        $attributes = $this->validateSubContractor();

        $attributes['location']     = $request->location; 
        $attributes['main_contact_email']= $request->main_contact_email;
        $attributes['main_contact_email2']= $request->main_contact_email2;
        $attributes['main_contact_email3']= $request->main_contact_email3;
        $attributes['main_contact_email4']= $request->main_contact_email4;
        $attributes['main_contact']= $request->main_contact;
        $attributes['remarks']= $request->remarks;
        $attributes['trade_id']     = $request->trade_id ?? 0; 
        $attributes['is_active']    = $request->is_active ?? 0; 
        $attributes['updated_by']   = auth()->id();

        $result = $subcontractor->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubContractor  $subcontractor
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubContractor $subcontractor, $remarks)
    {
        $result = $subcontractor->update(['delete_remark' => $remarks]);
 
        $result = $subcontractor->delete();
        return response()->json($result);
    }

    /**
     * Get active sub-contractor users with role of assessors
     * 
     * @param \App\SubContractor $subcontractor
     * @return \Illuminate\Http\Response
     */
    public function assessors(SubContractor $subcontractor)
    {
        //$subcontractor->users()->active()->assessor()
        return response()->json($subcontractor->users()->assessor()->active()->get());
    }

    /**
     * Get users which are checkers under this sub-contractor
     * 
     * @param \App\SubContractor $subcontractor
     * @return \Illuminate\Http\Response
     */
    public function checkers(SubContractor $subcontractor)
    {
        $checkerUser = [];
        $checkers = $subcontractor->ptwcheckers()->get();

        foreach($checkers as $checker) {
            array_push($checkerUser,$checker->user);
        }

        return response()->json($checkerUser);
    }

    /**
     *  Get active sub-contractor users with role of Authorized Manager / Project Manager
     * 
     * @param \App\SubContractor $subcontractor
     * @return \Illuminate\Http\Response
     */
    public function authorizemgrs(SubContractor $subcontractor) {
        return response()->json($subcontractor->users()->authorizemgr()->active()->get());
    }
    
    /**
     * Get Active sub-contractor workers
     * 
     * @param \App\SubContractor $subcontractor
     * @return \Illumiate\Http\Response
     */
    public function workers(SubContractor $subcontractor)
    {
        return response()->json($subcontractor->workers()->active()->get());
    }

    /**
     * Get Active sub-contractor equipment
     * 
     * @param \App\SubContractor $subcontractor
     * @return \Illumiate\Http\Response
     */
    public function equipment(SubContractor $subcontractor)
    {
        return response()->json($subcontractor->equips()->get());
    }

    /**
     * Attach / Detach a project to a sub-contractor
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleSubContractor(Request $request) 
    {
        $subcon = SubContractor::find($request->id);
        if($request->value){
            return response()->json($subcon->projects()->attach($request->project_id));
        } else {
            return response()->json($subcon->projects()->detach($request->project_id));
        }
    }

    /**
     * Validation
     */
    protected function validateSubContractor() 
    {
        return request()->validate([
            'name'=> ['required'],
        ]);
    }

}
