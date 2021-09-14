<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttainmentController extends Controller
{
    public function queryHandler(){
        return view('attainment');
    }
}

