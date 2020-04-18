<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PtwAsmChecklistController extends Controller
{
     /**
     * Apply auth middleware
    */
    public function __construct() 
    {
        $this->middleware('auth:api');
    }
}
