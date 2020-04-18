<?php

namespace App\Http\Controllers;

use App\Swp;
use App\SwpCategory;
use Illuminate\Http\Request;

class SwpCategoryController extends Controller
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
        return response()->json(SwpCategory::orderBy('seq_no','asc')->get());
    }

    public function swps(SwpCategory $swpcategories) 
    {
        return response()->json($swpcategories->swps()->approved()->get());
    }

}
