<?php

namespace App\Http\Controllers;

use Storage;
use App\Attachment;
use Illuminate\Http\Request;
use App\Http\Traits\AttachmentsTrait;

class AttachmentController extends Controller
{
    use AttachmentsTrait;
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
    public function index($refence_id,$reference_table)
    {
        return response()->json(
            Attachment::where([
                'reference_id'=> $refence_id,
                'reference_table'=>$reference_table
            ])
            ->orderBy('created_at','desc')
            ->get()
        );
    }

    public function indexBySrcMod($refence_id,$reference_table, $src_mod) 
    {
        return response()->json(
            Attachment::where([
                'reference_id' => $refence_id,
                'reference_table' => $reference_table,
                'src_mod' => $src_mod
            ])
            ->orderBy('created_at','desc')
            ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $folder = $request->folder_name."/".$request->reference_id;
        
        $s3 = request()->file('full_path')->store($folder,'s3');

        $attached = $request->full_path;

        $attributes['created_by']      = auth()->id();
        $attributes['description']     = $request->description;
        $attributes['expiry_at']       = $request->expiry_at;
        $attributes['file_name']       = $attached->getClientOriginalName();        
        $attributes['folder_name']     = $folder;
        $attributes['full_path']       = $s3;
        $attributes['mime']            = $attached->getMimeType();
        $attributes['reference_id']    = $request->reference_id;
        $attributes['reference_table'] = $request->reference_table;
        $attributes['src_mod']         = $request->src_mod;

        $attachment = Attachment::create($attributes);

        return response()->json($attachment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMultiple(Request $request)
    {
        // multiple attachments
        if($request->hasFile('full_path')) {
            $attachment = $this->storeAttachment($request->reference_table,$request->reference_id,$request->file('full_path'));
        }

        return response()->json($attachment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        //
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        //update all attachments to zero
        Attachment::where([
            'reference_id'=> $request->reference_id,
            'reference_table'=> $request->reference_table
        ])->update(['is_primary'=> 0]);

        $attributes['is_primary'] = $request->is_primary; 
        $attributes['updated_by'] = auth()->id();

        $result = $attachment->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        $result = $attachment->delete();
        return response()->json($result);
    }

    public function download(Attachment $attachment)
    {        
        $s3Client = Storage::cloud()->getAdapter()->getClient();

        return $s3Client->getObjectUrl('intelli-safe-bucket', $attachment->full_path);
    }
}
