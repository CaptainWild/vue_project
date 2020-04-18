<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asm;

class AsmController extends Controller
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
        return response()->json(Asm::orderBy('seq_no')->get());
    }
}
