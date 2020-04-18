<?php

namespace App\Http\Controllers;

use App\Project;
use App\SubContractor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
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
        return response()->json(Project::orderBy('created_at','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateProject();
        
        $attributes['created_by'] = auth()->id();
        $attributes['description']= $request->description;
        $attributes['started_at']= $request->started_at;
        $attributes['ends_at']= $request->ends_at;
        $attributes['is_active']  = $request->is_active ?? 0; 

        $project = Project::create($attributes);

        $this->attachDetachUsers($project);

        return response()->json($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return reponse()->json($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $attributes = $this->validateProject();

        $attributes['description']= $request->description;         
        $attributes['ends_at']= $request->ends_at;
        $attributes['is_active']  = $request->is_active ?? 0; 
        $attributes['started_at']= $request->started_at;
        $attributes['updated_by'] = auth()->id();

        $result = $project->update($attributes);

        $this->attachDetachUsers($project);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project,$remarks)
    {
        $result = $project->update(['delete_remark' => $remarks]);
 
        $result = $project->delete();
        return response()->json($result);
    }

    /**
     * @param \App\Project $project
     * @param Date $date
     * @return \Illuminate\Http\Response
     */
    public function ptwsByDate(Project $project,$date) {

        $result = $project->ptws()
            ->whereRaw('"'.$date .'" between ptws.start_date and ptws.end_date')
            ->where('ptw_status_id',1)
            ->get();

        return response()->json($result);
    }

    /**
     * Get sub-contractors tied to this project
     * 
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function subContractors(Project $project)
    {        
        return response()->json($project->subcontractors()->get());        
    }

    /**
     * Attach / Detach ALL Sub-Contractors to a Project
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleAllSubContractors(Project $project, Request $request)
    {
        $project->subcontractors()->detach();
        
        if($request->value) {
            return response()->json($project->subcontractors()->attach(SubContractor::select('id')->get()));
        } else {
            return response()->json($project->subcontractors()->detach());
        }
    }

    /**
     * Validation
     */
    protected function validateProject() 
    {
        return request()->validate([
            'title'=> ['required'],
            'code'=> ['required'],            
        ]);
    }

    private function attachDetachUsers(Project $project)
    {
        $sa_ids = request()->saIds ?? array();
        $am_ids = request()->amIds ?? array();

        //project - users attach
        $project->users()->detach(); // all

        if(!empty($sa_ids)) {
            $project->attachUsers($sa_ids, true);
        }

        if(!empty($am_ids)) {
            $project->attachUsers($am_ids, true);
        }

        return response()->json($project);
     }
}
