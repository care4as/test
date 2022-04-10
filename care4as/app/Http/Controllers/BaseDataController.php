<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BaseDataController extends Controller
{
    public function main(){
        
        $data = array();
        $data['employees'] = $this->getAllEmployees();
        $data['projects'] = $this->getAllProjects();

        return view('usermanagement.baseDataChange', compact('data'));
    }

    public function getParameters(){
        $data = array();

        return $data;
    }

    public function saveEntry(){
        $entries = array();
    }

    public function getAllEmployees(){
        $data =  DB::connection('mysqlkdw')                            
        ->table('MA')
        ->where(function($query){
            $query
            ->where('austritt', null)
            ->orWhere('austritt', '>=', date('Y-m-d')); 
        })
        ->get(['ds_id', 'vorname', 'familienname'])
        ->sortBy('familienname');

        return $data;
    }

    public function getAllProjects(){
        $data =  DB::connection('mysqlkdw')                            
        ->table('projekte')
        ->where('in_progress', 1)
        ->get(['ds_id', 'bezeichnung'])
        ->sortBy('bezeichnung');

        return $data;
    }



}