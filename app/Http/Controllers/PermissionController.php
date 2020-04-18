<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;

class PermissionController extends Controller
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
        return response()->json(Permission::orderBy('created_at','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {            
        $attributes['action'] = $request->action;         
        $attributes['code'] = $request->code;         
        $attributes['description'] = $request->description;        
        $attributes['mod_group'] = $request->mod_group;         
        $attributes['name'] = $request->name;              

        $permission = Permission::create($attributes);

        return response()->json($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return reponse()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $attributes['action']= $request->action;         
        $attributes['code'] = $request->code;         
        $attributes['description'] = $request->description;        
        $attributes['mod_group'] = $request->mod_group;         
        $attributes['name'] = $request->name;

        $result = $permission->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Permission $permission)
    {
        return response()->json($permission->delete());
    }

}
