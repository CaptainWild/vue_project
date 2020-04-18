<?php

namespace App\Http\Controllers;

use App\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
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
        return response()->json(Worker::orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateWorker();
        
        $attributes['created_by'] = auth()->id();
        $attributes['remarks'] = $request->remarks;
        $attributes['sub_contractor_id'] = $request->sub_contractor_id;        
        $attributes['is_active']  = $request->is_active ?? 0; 

        $worker = Worker::create($attributes);

        
        $role_ids = $request->roleIds ?? array();
        //worker certificate
        if(!empty($role_ids)) {
           $role_id_requests = json_decode($role_ids);

           foreach($role_id_requests as $role_id_request) {
                $worker->addCertificate([
                    'role_id' => $role_id_request,
                    'created_by' => auth()->id()
                ]);
           }
        }
        
        return response()->json($worker);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function show(Worker $worker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worker $worker)
    {
        $attributes = $this->validateWorker();

        $attributes['is_active']  = $request->is_active ?? 0; 
        $attributes['remarks'] = $request->remarks;
        $attributes['sub_contractor_id'] = $request->sub_contractor_id;        
        $attributes['updated_by'] = auth()->id();

        $result = $worker->update($attributes);

        $role_ids = $request->roleIds ?? array();
        //worker certificate
        if(!empty($role_ids)) {
           $role_id_requests = json_decode($role_ids);

           $workercertificates = $worker->workercertificates();
            
           if($workercertificates->count() > 0) {
               $worker_cerificates = $workercertificates->get();
               foreach($worker_cerificates as $worker_cerificate) {
                   
                   if(!in_array($worker_cerificate->role_id,$role_id_requests)) {
                        $worker_cerificate->delete();                        
                   } else {
                        $key = array_search($worker_cerificate->role_id, $role_id_requests);
                        unset($role_id_requests[$key]);
                   }
               }
           } 
           
           foreach($role_id_requests as $role_id_request) {
                $worker->addCertificate([
                    'role_id' => $role_id_request,
                    'created_by' => auth()->id()
                ]);
           }
        } else {
            $worker->workercertificates->each->delete();
        }


        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Worker  $worker
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worker $worker, $remarks)
    {
        $result = $worker->update(['delete_remark' =>  $remarks]);

        $result = $worker->delete();
        return response()->json($result);
    }

    /**
     * Validation
     */
    protected function validateWorker() {
        return request()->validate([
            'name'=> ['required'],
            'emp_no'=> ['required']
        ]);
    }
}
