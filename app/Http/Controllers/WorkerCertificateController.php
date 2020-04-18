<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use App\Worker;
use App\WorkerCertificate;

class WorkerCertificateController extends Controller
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
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function index(Worker $worker)
    {
        return response()->json($worker->workercertificates()->orderBy('id','desc')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkerCertificate $workercertificate
     * @return \Illuminate\Http\Response
     */
    public function show(WorkerCertificate $workercertificate)
    {
        return response()->json($workercertificate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkerCertificate  $workercertificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkerCertificate $workercertificate)
    {
        //dd($request);
        $attributes['expiry_at']       = $request->expiry_at; 
        $attributes['description']     = $request->description;         
        $attributes['updated_by'] = auth()->id();

        if(request()->hasfile('full_path')){            
            
            // if(!empty($workercertificate->full_path)) {
            //     Storage::disk('s3')->delete($workercertificate->full_path);
            // }
        
            $folder = "/worker_certificates/{$workercertificate->id}";
            $file = request()->file('full_path');
        
            $s3 = request()->file('full_path')->store($folder,'s3');
    
            $attributes['full_path'] = $s3;
            $attributes['file_name'] = $file->getClientOriginalName();        
            $attributes['folder_name'] = $folder;
            $attributes['mime'] = $file->getMimeType();
        }
       
        $result = $workercertificate->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkerCertificate  $workercertificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkerCertificate $workercertificate)
    {
        $result = $workercertificate->delete();
        return response()->json($result);
    }
    
    public function download(WorkerCertificate $workercertificate)
    {            
        $s3Client = Storage::cloud()->getAdapter()->getClient();

        return $s3Client->getObjectUrl('intelli-safe-bucket', $workercertificate->full_path);
    }
}
