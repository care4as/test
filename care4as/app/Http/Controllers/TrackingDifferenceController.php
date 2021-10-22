<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrackingDifferenceController extends Controller
/**PROBLEM:
 * Die Trackingdaten aus dem KDW-Tool für das Mobile Projekt sind zwar zugänglich,
 * jedoch werden nicht die üblichen ds_id's genutzt, sondern spezielle der KDW-Gruppe.
 * Deshalb muss eine neue Zuordnung erstellt werden und in den Nutzern gespeichert werden.
 * Die Zurodnungstabelle liegt jedoch in einem neuen Workspace, fpr den es noch keine Zuordnung gibt,
 * diese muss also erst erstellt werden. 
 */
{
    public function load(){
        $startDateString = request('startDate');
        $endDateString = request('endDate');

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
            'startDate' => $startDateString,
            'endDate' => $endDateString,
            'differenceDate' =>$differenceDate,
            'startDatePHP' => $startDate,
            'endDatePHP' => $endDate,
            'revenue_sale_dsl' => 16
        );
        if($startDate != null && $endDate != null){
            $emploeyeeData = $this->getEmployeeData($defaultVariablesArray);
        } else {
            $emploeyeeData = null;
        }

        return view('1u1_mobile_retention.trackingDifference', compact('defaultVariablesArray'));
    }

    public function getEmployeeData($defaultVariablesArray){
        $employees = DB::connection('mysqlkdw')
        ->table('MA')
        ->where(function($query) {
            $query
            ->where('abteilung_id', '=', 10); //Agenten
        })
        ->where('projekt_id', '=', 7)
        ->where(function($query) use($defaultVariablesArray){ 
            $query
            ->where('austritt', '=', null)
            ->orWhere('austritt', '>', $defaultVariablesArray['startDate']);})
        ->where('eintritt', '<=', $defaultVariablesArray['startDate'])
        ->get()
        ->toArray();

        //save 1u1 person_id in array
        $personList = DB::table('userlist')
        ->get()
        ->toArray();

        $refinedPersonList = array();

        foreach($personList as $key => $person){
            $personArray = (array) $person;
            $refinedPersonList[$personArray['ds_id']]['ds_id'] = $personArray['ds_id'];
            $refinedPersonList[$personArray['ds_id']]['person_id'] = $personArray['1u1_person_id'];
        }

        //Get Retention Details
        $retDetailsData = $this->getRetDetails($defaultVariablesArray, 'KDW Retention Mobile Flensburg');

        //Get KDW Sales
        $kdwSalesData = $this->getKdwSalesData($defaultVariablesArray);

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

            //calc kdw sales





            //calc ret details
            $refinedEmployees[$employeeArray['ds_id']]['ssc_retDetails_calls'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['bsc_retDetails_calls'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['portal_retDetails_calls'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['ssc_retDetails_saves'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['bsc_retDetails_saves'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['portal_retDetails_saves'] = 0;
            if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){
                foreach($retDetailsData as $key => $entry){
                    if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){
                        $refinedEmployees[$employeeArray['ds_id']]['ssc_retDetails_calls'] += $entry['calls_smallscreen'];
                        $refinedEmployees[$employeeArray['ds_id']]['bsc_retDetails_calls'] += $entry['calls_bigscreen'];
                        $refinedEmployees[$employeeArray['ds_id']]['portal_retDetails_calls'] += $entry['calls_portale'];
                        $refinedEmployees[$employeeArray['ds_id']]['ssc_retDetails_saves'] += $entry['orders_smallscreen'];
                        $refinedEmployees[$employeeArray['ds_id']]['bsc_retDetails_saves'] += $entry['orders_bigscreen'];
                        $refinedEmployees[$employeeArray['ds_id']]['portal_retDetails_saves'] += $entry['orders_portale'];
                    }
                }
            }


        }

    
        dd($refinedEmployees);
    }

    public function getRetDetails($defaultVariablesArray, $department){
        $data = DB::table('retention_details')
        ->where('call_date', '>=', $defaultVariablesArray['startDate'])
        ->where('call_date', '<=', $defaultVariablesArray['endDate'])
        ->where('department_desc', '=', $department)
        ->get()
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }
        return $data;
    }

    public function getKdwSalesData($defaultVariablesArray){
        $data = DB::connection('mysqlkdwtracking')
        ->table('1und1_mr_tracking_inb_new_ebk')
        // ->whereIn('MA_id', $userids)
        ->where('date', '>=', $defaultVariablesArray['startDate'])
        ->where('date', '<=', $defaultVariablesArray['endDate'])
        ->get()
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }
}

