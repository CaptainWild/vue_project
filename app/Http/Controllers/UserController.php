<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
        return response()->json(User::orderBy('name','desc')->get());
    }

    /**
     * Get active users with role of safety assessors
     * that does not belong to any sub-contractor     
     * @return \Illuminate\Http\Response
     */
    public function mainConAssessors()
    {
        return response()->json(User::whereHas('role', 
            function($query) {
                $query->where('role_id', 3);
            })
            ->where(['is_active' => 1, 'sub_contractor_id' => 0])
            ->orderBy('name','desc')->get()
        );
    }

    /**
     * Get active users with role of authorize managers
     * that does not belong to any sub-contractor     
     * @return \Illuminate\Http\Response
     */
    public function mainConManagers()
    {
        return response()->json(User::whereHas('role', 
            function($query) {
                $query->where('role_id', 2);
            })
            ->where(['is_active' => 1, 'sub_contractor_id' => 0])
            ->orderBy('name','desc')->get()
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
        $attributes = $this->validateUser();
        
        $attributes['created_by'] = auth()->id();    
        $attributes['is_active']  = 1; 

        $password = $this->randomPassword();
        //if($request->is_active){
            $attributes['password'] = bcrypt($password);    
        //}

        $user = User::create($attributes);

        if($user) {
            // temporarily show password (it can be sent through email or through whatsapp)            
            return response()->json(['email' =>$request['email'],'password'=>$password]);
        } else {
            return response()->json($user);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $attributes = $this->validateUser();
        
        $attributes['updated_by'] = auth()->id();
        $attributes['is_active']  = 1; 

        $result = $user->update($attributes);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @param String @remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,$remarks)
    {
        $result = $user->update(['delete_remark' =>  $remarks]);
 
        $result = $user->delete();
        return response()->json($result);
    }

    /**
     * @param  \App\User  $user
     * @return JSON email and password
     */
    public function reset(Request $request, User $user) {

        $attributes['updated_by'] = auth()->id();

        $password = $this->randomPassword();
        $attributes['password'] = bcrypt($password);   

        $user->update($attributes);

        return response()->json(['email' =>$request['email'],'password'=>$password]);
    }

    /**
     * change password by the user
     * 
     * @param \App\User $user
     * @param \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function change(Request $request, User $user) {
        $attributes = $this->passwordRule();
        
        $attributes['force_password']= 0;
        $attributes['updated_by']    = auth()->id();

        $result = $user->update($attributes);

        return response()->json($result);
    }

    /**
     * random generation of password
     */
    protected function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 9; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    /**
     * Validation
     */
    protected function validateUser() {
        return request()->validate([
            'name'=> 'required',
            'email'=> 'required|email',
            'mobile_no'=> 'required',
        ]);
    }

    /**
     * Validation for password
     */
    protected function passwordRule() {
       $pwd = request()->validate([
                'password' => ['required', 'string', 'min:9','alpha_num', 'confirmed'],
        ]);
        
        if(is_object($pwd)){
            return $pwd;
        } else {
            return ['password' => bcrypt($pwd['password'])];
        }
    }
}
