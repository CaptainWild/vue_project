<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
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
        return response()->json(Role::orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateRole();
        
        $attributes['created_by'] = auth()->id();
        $attributes['description']= $request->description;
        $attributes['is_active']  = $request->is_active ?? 0; 

        $role = Role::create($attributes);

        return response()->json($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $attributes = $this->validateRole();

        $attributes['description']= $request->description; 
        $attributes['is_active']  = $request->is_active ?? 0; 
        $attributes['updated_by'] = auth()->id();

        $result = $role->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role,$remarks)
    {
        $result = $role->update(['delete_remark' =>  $remarks]);
 
        $result = $role->delete();
        return response()->json($result);
    }

    /**
     * Validation
     */
    protected function validateRole() {
        return request()->validate([
            'name'=> ['required'],
        ]);
    }

    /**
     * Attach / Detach a permission to a Role
     * 
     * @param \App\Role $role
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, Role $role) 
    {
        if($request->value){
            return response()->json($role->permissions()->attach($request->id));
        } else {
            return response()->json($role->permissions()->detach($request->id));
        }
    }

    /**
     * Attach / Detach ALL Permissions to a Role
     * 
     * @param \App\Role $role
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleAll(Role $role, Request $request)
    {
        $role->permissions()->detach();
        
        if($request->value) {
            return response()->json($role->permissions()->attach(Permission::select('id')->get()));
        } else {
            return response()->json($role->permissions()->detach());
        }
    }

}
