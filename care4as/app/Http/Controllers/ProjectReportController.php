<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectReportController extends Controller
{
    public function load(){
        /** request variables from userform */
        $project = request('project');
        $startDateString = request('startDate');
        $endDateString = request('endDate');

        /** create php-date from string */
        if ($startDateString == null){ //test for string
            $startDate = null;
        } else {
            $startDate = Carbon::createFromFormat("Y-m-d", $startDateString); //create PHP date from string
        }
        if ($endDateString == null){ //test for string
            $endDate = null;
        } else {
            $endDate = Carbon::createFromFormat("Y-m-d", $endDateString); //create PHP date from string
        }

        /** calculate days between start and end */
        $differenceDate = Carbon::parse($startDate)->diffInDays($endDate);
        
        /** save variables in array */
        $defaultVariablesArray = array(
            'project' => $project,
            'startDate' => $startDateString,
            'endDate' => $endDateString,
            'differenceDate' =>$differenceDate
        );

        $dataArray = array();
        if($defaultVariablesArray['project'] == '1u1_dsl_ret'){
            $dataArray = $this->get1u1DslRet($defaultVariablesArray);
        }

        //dd($defaultVariablesArray);
        return view('projectReport', compact('defaultVariablesArray', 'dataArray'));
    }

    public function get1u1DslRet($defaultVariablesArray){
        /** create data array */
        $finalArray = array();

        //get relevant data
        $finalArray['employees'] = $this->get1u1DslRetEmployees($defaultVariablesArray);

        //dd($finalArray);

        return $finalArray;
    }

    public function get1u1DslRetEmployees($defaultVariablesArray){
        $employees = DB::connection('mysqlkdw')
        ->table('MA')
        ->where(function($query) {
            $query
            ->where('abteilung_id', '=', 10) //Agenten
            ->orWhere('abteilung_id', '=', 10); //Linesteuerung
        })
        ->where('projekt_id', '=', 10)
        ->where(function($query) use($defaultVariablesArray){ 
            $query
            ->where('austritt', '=', null)
            ->orWhere('austritt', '>', $defaultVariablesArray['startDate']);})
        ->where('eintritt', '<=', $defaultVariablesArray['startDate'])
        ->get()
        ->toArray();

        //save 1u1 person_id in array
        $personList = DB::table('users')
        ->get()
        ->toArray();

        $refinedPersonList = array();

        foreach($personList as $key => $person){
            $personArray = (array) $person;
            $refinedPersonList[$personArray['ds_id']]['ds_id'] = $personArray['ds_id'];
            $refinedPersonList[$personArray['ds_id']]['person_id'] = $personArray['person_id'];
        }

        $refinedEmployees = array();
        foreach($employees as $key => $employee) {
            $employeeArray = (array) $employee; //turn object to array

            $refinedEmployees[$employeeArray['ds_id']]['lastname'] = $employeeArray['familienname'];
            $refinedEmployees[$employeeArray['ds_id']]['firstname'] = $employeeArray['vorname'];
            $refinedEmployees[$employeeArray['ds_id']]['full_name'] = $employeeArray['familienname'] . ', ' . $employeeArray['vorname'];
            $refinedEmployees[$employeeArray['ds_id']]['ds_id'] = $employeeArray['ds_id'];

            if(isset($refinedPersonList[$employeeArray['ds_id']]['person_id']) == true) {
                $refinedEmployees[$employeeArray['ds_id']]['person_id'] = $refinedPersonList[$employeeArray['ds_id']]['person_id'];
            }
        }

        asort($refinedEmployees);

        return $refinedEmployees; 
    }
}

