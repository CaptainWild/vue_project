<?php

namespace App\Http\Controllers;

use Storage;
use App\PtwWorkerCertificate;
use App\Worker;
use Illuminate\Http\Request;

class PtwWorkerCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Worker $worker,$ptw_id)
    {
        return response()->json($worker->ptwworkercertificates()->where('ptw_id',$ptw_id)->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PtwWorkerCertificate  $ptwworkercertificate
     * @return \Illuminate\Http\Response
     */
    public function show(PtwWorkerCertificate $ptwworkercertificate)
    {
        return response()->json($ptwworkercertificate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PtwWorkerCertificate  $ptwWorkerCertificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PtwWorkerCertificate $ptwWorkerCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PtwWorkerCertificate  $ptwworkercertificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(PtwWorkerCertificate $ptwworkercertificate)
    {
        $result = $ptwworkercertificate->delete();
        return response()->json($result);
    }

    public function download(PtwWorkerCertificate $ptwworkercertificate)
    {            
        $s3Client = Storage::cloud()->getAdapter()->getClient();

        return $s3Client->getObjectUrl('intelli-safe-bucket', $ptwworkercertificate->full_path);
    }
}
