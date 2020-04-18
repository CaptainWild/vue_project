<?php

namespace App\Http\Controllers;

use App\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
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
        $archives = Archive::with(['attachments' => function ($query) {
            $query->where(['is_primary' => 1,'reference_table' => 'archives']);
        }])->orderBy('created_at','desc')->get();

        return response()->json($archives);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateArchive();
        
        $attributes['created_by'] = auth()->id();
        $attributes['description']= $request->description; 

        $archive = Archive::create($attributes);

        return response()->json($archive);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function show(Archive $archive)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archive $archive)
    {
        $attributes = $this->validateArchive();

        $attributes['description']= $request->description; 
        $attributes['updated_by'] = auth()->id();

        $result = $archive->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        $result = $archive->delete();
        return response()->json($result);
    }

     /**
     * Validation
     */
    protected function validateArchive() {
        return request()->validate([
            'name'=> ['required']            
        ]);
    }
}
