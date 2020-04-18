<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HazardCategory;

class HazardCategoryController extends Controller
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
        return response()->json(HazardCategory::orderBy('seq_no')->get());
    }
}
