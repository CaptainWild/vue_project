<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InspectionType;
use App\InspectionTypeItem;

class InspectionTypeItemController extends Controller
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
        return response()->json(InspectionTypeItem::all());
    }

    public function itemsByType(InspectionType $inspectiontype)
    {
        return response()->json($inspectiontype->inspectiontypeitems()->orderBy('seq_no')->get());
    }
}
