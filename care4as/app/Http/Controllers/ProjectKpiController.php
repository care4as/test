<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectKPIController extends Controller
{
    public function load(){
        
        $finalArray = $this->getFinalArray();


        return view('projekt_kpi', compact('finalArray'));
    }

    public function getFinalArray(){
        //Here comes all functions puzzeling the final array together. This is sort of a mini controller

        $testArray = array();

        return $testArray;
    }
}

