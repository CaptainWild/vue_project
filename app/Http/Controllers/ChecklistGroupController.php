<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChecklistGroup;

class ChecklistGroupController extends Controller
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
        return response()->json(ChecklistGroup::orderBy('name')->get());
    }
}
