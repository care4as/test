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
        $data['unfiltered_employees'] = $this->getAllEmployees();
        $data['projects'] = $this->getAllProjects();
        $data['entries'] = $this->getDbEntries($data['unfiltered_employees'], $data['projects']);

        return view('usermanagement.baseDataChange', compact('data'));
    }

    public function getParameters(){
        $data = array();

        return $data;
    }

    public function newEntry(){
        $date = request('date');
        $type = request('type');
        $employee = request('employee');
        if ($type == 'project_change'){
            $valueOld = request('value_old_project');
            $valueNew = request('value_new_project');
        } else if ($type == 'contract_hours'){
            $valueOld = request('value_old_contract');
            $valueNew = request('value_new_contract');
        }

        DB::table('basedatachange')->insert(
            [
            'date' => $date,
            'ds_id' => $employee,
            'type' => $type,
            'value_old' => $valueOld,
            'value_new' => $valueNew,
            ]
        );

        return redirect()->back();
    }

    public function deleteEntry($id)
    {
        DB::table('basedatachange')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function getAllEmployees(){
        $data = DB::connection('mysqlkdw')                            
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

    public function getUnfilteredEmployees(){
        $data = DB::connection('mysqlkdw')                            
        ->table('MA')
        ->get(['ds_id', 'vorname', 'familienname'])
        ->sortBy('familienname');

        return $data;
    }

    public function getAllProjects(){
        $data = DB::connection('mysqlkdw')                            
        ->table('projekte')
        ->where('in_progress', 1)
        ->get(['ds_id', 'bezeichnung'])
        ->sortBy('bezeichnung');

        return $data;
    }

    public function getDbEntries($employees, $projects){
       
        $data = DB::table('basedatachange')
        ->get();      

        // Werte lesbar machen
        foreach($data as $key => $entry){
            if($entry->type == 'contract_hours'){
                $entry->type = 'Wechsel: Vertragsstunden';
            } else if($entry->type == 'project_change'){
                $entry->type = 'Wechsel: Projekt';

                $entry->value_old = $projects->where('ds_id', $entry->value_old)->first()->bezeichnung;
                $entry->value_new = $projects->where('ds_id', $entry->value_new)->first()->bezeichnung;
            }
            dd($entry);
            $entry->ds_id = $employees->where('ds_id', $entry->ds_id)->first()->familienname . ', ' . $employees->where('ds_id', $entry->ds_id)->first()->vorname;
        }


        return $data;
    }



}