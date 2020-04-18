<?php

namespace App\Http\Controllers;

use Storage;
use App\Swp;
use App\Http\Traits\AttachmentsTrait;
use Illuminate\Http\Request;

class SwpController extends Controller
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
    public function index()
    {
        return response()->json(Swp::with(['swpcategory','swpstatus'])->orderBy('created_at','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateSwp();
        
        $attributes['created_by'] = auth()->id();

        if(isset($request->swp_status_id) && !empty($request->swp_status_id)) {
            $attributes['swp_status_id']  = 2; // for approval
        }
        
        $swp = Swp::create($attributes);

        //create a thread
        if($request->swp_status_id == 2) {
            
        }
       
        return response()->json($swp);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Swp  $swp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Swp $swp)
    {
        $attributes = $this->validateSwp();

        if(isset($request->swp_status_id) && !empty($request->swp_status_id)) {
            $attributes['swp_status_id']  = 2; 
        } else if ($swp->swp_status_id == 2){
            $attributes['swp_status_id']  = 0; 
        }

        $attributes['updated_by'] = auth()->id();

        $result = $swp->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Swp  $swp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Swp $swp, $remarks)
    {
        $result = $swp->update(['delete_remark' => $remarks]);
 
        $result = $swp->delete();
        return response()->json($result);
    }

    public function storeFile(Request $request, Swp $swp)
    {
        if(!empty($swp->procedure_path)) {
            Storage::disk('s3')->delete($swp->procedure_path);
        }

        $s3 = request()->file('procedure_path')->store("/swps",'s3');
        
        $attributes['procedure_path']= $s3;
        $attributes['updated_by']    = auth()->id();

        $result = $swp->update($attributes);

        return response()->json($result);        
    }

    public function downloadFile(Swp $swp)
    {        
        $s3Client = Storage::cloud()->getAdapter()->getClient();

        return $s3Client->getObjectUrl('intelli-safe-bucket', $swp->procedure_path);
    }

    /**
     * Validation
     */
    protected function validateSwp() {
        return request()->validate([
            'activity'=> ['required'],
            'ref_no'=> ['required'],
            'swp_category_id'=> ['required'],
        ]);
    }

}
