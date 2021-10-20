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
            'differenceDate' =>$differenceDate,
            'startDatePHP' => $startDate,
            'endDatePHP' => $endDate,
            'revenue_sale_dsl' => 16
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

        //sum data
        $finalArray = $this->get1u1DslRetSum($defaultVariablesArray, $finalArray);

        
        
        

        return $finalArray;
    }

    public function get1u1DslRetSum($defaultVariablesArray, $finalArray){
        //availbench data
        $availbenchData = $this->getAvailbench($defaultVariablesArray, 'DE_1u1_RT_Access_1st');
        $finalArray['sum']['revenue_availbench'] = 0;
        foreach($availbenchData as $key => $entry){
            $finalArray['sum']['revenue_availbench'] += $entry['total_costs_per_interval'];
        }

        //initialize variables
        $finalArray['sum']['work_hours'] = 0;
        $finalArray['sum']['productive_hours'] = 0;
        $finalArray['sum']['sick_hours'] = 0;
        $finalArray['sum']['break_hours'] = 0;
        $finalArray['sum']['dsl_calls'] = 0;
        $finalArray['sum']['time_in_call_seconds'] = 0;
        $finalArray['sum']['dsl_saves'] = 0;
        $finalArray['sum']['optin_calls_new'] = 0;
        $finalArray['sum']['optin_calls_possible'] = 0;
        $finalArray['sum']['sas_orders'] = 0;
        $finalArray['sum']['pay_cost'] = 0;
        $finalArray['sum']['rlz_minus'] = 0;
        $finalArray['sum']['rlz_plus'] = 0;

        foreach($finalArray['employees'] as $key => $entry) {
            $finalArray['sum']['work_hours'] += $entry['work_hours'];
            $finalArray['sum']['productive_hours'] += $entry['productive_hours'];
            $finalArray['sum']['sick_hours'] += $entry['sick_hours'];
            $finalArray['sum']['break_hours'] += $entry['break_hours'];
            $finalArray['sum']['dsl_calls'] += $entry['dsl_calls'];
            $finalArray['sum']['time_in_call_seconds'] += $entry['time_in_call_seconds'];
            $finalArray['sum']['dsl_saves'] += $entry['dsl_saves'];
            $finalArray['sum']['optin_calls_new'] += $entry['optin_calls_new'];
            $finalArray['sum']['optin_calls_possible'] += $entry['optin_calls_possible'];
            $finalArray['sum']['sas_orders'] += $entry['sas_orders'];
            $finalArray['sum']['pay_cost'] += $entry['pay_cost'];
            $finalArray['sum']['rlz_minus'] += $entry['rlz_minus'];
            $finalArray['sum']['rlz_plus'] += $entry['rlz_plus'];
        }
        
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['productive_percentage'] = ($finalArray['sum']['productive_hours'] / $finalArray['sum']['work_hours']) * 100;
        } else {
            $finalArray['sum']['productive_percentage'] = 0;
        }

        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['break_percentage'] = ($finalArray['sum']['break_hours'] / $finalArray['sum']['work_hours'] * 100);
        } else {
            $finalArray['sum']['break_percentage'] = 0;
        }

        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['sick_percentage'] = ($finalArray['sum']['sick_hours'] / $finalArray['sum']['work_hours']) * 100;
        } else {
            $finalArray['sum']['sick_percentage'] = 0;
        }

        if($finalArray['sum']['productive_hours'] > 0){
            $finalArray['sum']['calls_per_hour'] = $finalArray['sum']['dsl_calls'] / $finalArray['sum']['productive_hours'];
        } else {
            $finalArray['sum']['calls_per_hour'] = 0;
        }

        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['aht'] = $finalArray['sum']['time_in_call_seconds'] / $finalArray['sum']['dsl_calls'];
        } else {
            $finalArray['sum']['aht'] = 0;
        }

        if($finalArray['sum']['dsl_saves'] > 0){
            $finalArray['sum']['dsl_cr'] = ($finalArray['sum']['dsl_saves'] / $finalArray['sum']['dsl_calls']) * 100;
        } else {
            $finalArray['sum']['dsl_cr'] = 0;
        }

        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['optin_percentage'] = ($finalArray['sum']['optin_calls_new'] / $finalArray['sum']['dsl_calls']) * 100;
        } else {
            $finalArray['sum']['optin_percentage'] = 0;
        }

        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['optin_possible_percentage'] = ($finalArray['sum']['optin_calls_possible'] / $finalArray['sum']['dsl_calls']) * 100;
        } else {
            $finalArray['sum']['optin_possible_percentage'] = 0;
        }

        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['sas_promille'] = ($finalArray['sum']['sas_orders'] / $finalArray['sum']['dsl_calls']) * 1000;
        } else {
            $finalArray['sum']['sas_promille'] = 0;
        }

        if(($finalArray['sum']['rlz_minus'] + $finalArray['sum']['rlz_plus']) > 0){
            $finalArray['sum']['rlz_plus_percentage'] = ($finalArray['sum']['rlz_plus'] / ($finalArray['sum']['rlz_minus'] + $finalArray['sum']['rlz_plus'])) * 100;
        } else {
            $finalArray['sum']['rlz_plus_percentage'] = 0;
        }

        $finalArray['sum']['revenue_sales'] = $finalArray['sum']['dsl_calls'] * $defaultVariablesArray['revenue_sale_dsl']; 
        $finalArray['sum']['revenue_sum'] = $finalArray['sum']['revenue_sales'] + $finalArray['sum']['revenue_availbench'];
        $finalArray['sum']['revenue_delta'] = $finalArray['sum']['revenue_sum'] - $finalArray['sum']['pay_cost'];
        
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['revenue_per_hour_paid'] = $finalArray['sum']['revenue_sum'] / $finalArray['sum']['work_hours'];
        } else {
            $finalArray['sum']['revenue_per_hour_paid'] = 0;
        }

        if($finalArray['sum']['productive_hours'] > 0){
            $finalArray['sum']['revenue_per_hour_productive'] = $finalArray['sum']['revenue_sum'] / $finalArray['sum']['productive_hours'];
        } else {
            $finalArray['sum']['revenue_per_hour_productive'] = 0;
        }
        
        //calculate final employee data
        foreach($finalArray['employees'] as $key => $entry) {
            if($finalArray['sum']['dsl_calls'] > 0){
                $finalArray['employees'][$key]['revenue_availbench'] = ($entry['dsl_calls'] / $finalArray['sum']['dsl_calls']) * $finalArray['sum']['revenue_availbench'];
            }
            $finalArray['employees'][$key]['revenue_sum'] = $finalArray['employees'][$key]['revenue_availbench'] + $finalArray['employees'][$key]['revenue_sales'];
            $finalArray['employees'][$key]['revenue_delta'] = $finalArray['employees'][$key]['revenue_sum'] - $finalArray['employees'][$key]['pay_cost'];
            if($entry['work_hours'] > 0){
                $finalArray['employees'][$key]['revenue_per_hour_paid'] = $finalArray['employees'][$key]['revenue_sum'] / $entry['work_hours'];
            } else {
                $finalArray['employees'][$key]['revenue_per_hour_paid'] = 0;
            }
            if($entry['productive_hours'] > 0){
                $finalArray['employees'][$key]['revenue_per_hour_productive'] = $finalArray['employees'][$key]['revenue_sum'] / $entry['productive_hours'];
            } else {
                $finalArray['employees'][$key]['revenue_per_hour_productive'] = 0;
            }
        }

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
            $refinedPersonList[$personArray['ds_id']]['cosmocom_id'] = $personArray['agent_id'];
        }

        //get kdw data
        $kdwHours = $this->getKdwHours($defaultVariablesArray);

        //get retdetails data
        $retDetailsData = $this->getRetDetails($defaultVariablesArray, 'Care4as Retention DSL Eggebek');

        //get optin data
        $optinData = $this->getOptin($defaultVariablesArray, 'Care4as Retention DSL Eggebek');

        //get sas data
        $sasData = $this->getSas($defaultVariablesArray, 'RT_DSL');

        //get dailyagent data
        $dailyagentData = $this->getDailyAgent($defaultVariablesArray, 'DE_care4as_RT_DSL_Eggebek');

        $refinedEmployees = array();
        foreach($employees as $key => $employee) {
            $employeeArray = (array) $employee; //turn object to array

            $refinedEmployees[$employeeArray['ds_id']]['lastname'] = $employeeArray['familienname'];
            $refinedEmployees[$employeeArray['ds_id']]['firstname'] = $employeeArray['vorname'];
            $refinedEmployees[$employeeArray['ds_id']]['full_name'] = $employeeArray['familienname'] . ', ' . $employeeArray['vorname'];
            $refinedEmployees[$employeeArray['ds_id']]['ds_id'] = $employeeArray['ds_id'];
            $refinedEmployees[$employeeArray['ds_id']]['work_hours'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['sick_hours'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['break_hours'] = 0;

            if(isset($refinedPersonList[$employeeArray['ds_id']]['person_id']) == true) {
                $refinedEmployees[$employeeArray['ds_id']]['person_id'] = $refinedPersonList[$employeeArray['ds_id']]['person_id'];
            }
            if(isset($refinedPersonList[$employeeArray['ds_id']]['cosmocom_id']) == true) {
                $refinedEmployees[$employeeArray['ds_id']]['cosmocom_id'] = $refinedPersonList[$employeeArray['ds_id']]['cosmocom_id'];
            }

            /** save kdw hours in employeedata */
            foreach($kdwHours as $key => $entry) {
                if ($entry['MA_id'] == $employeeArray['ds_id']){
                    //work hours
                    $refinedEmployees[$employeeArray['ds_id']]['work_hours'] += $entry['work_hours'];
                    //sick hours
                    if($entry['state_id'] == 1){
                        $refinedEmployees[$employeeArray['ds_id']]['sick_hours'] += $entry['work_hours'];
                    } else {
                    //break hours
                        $refinedEmployees[$employeeArray['ds_id']]['break_hours'] += $entry['pay_break_hours'];
                    }
                }
                
            }
            $refinedEmployees[$employeeArray['ds_id']]['pay_cost'] = $refinedEmployees[$employeeArray['ds_id']]['work_hours'] * 35;
            
            /** calculate sick and break percentage */
            if($refinedEmployees[$employeeArray['ds_id']]['work_hours'] > 0){
                $refinedEmployees[$employeeArray['ds_id']]['sick_percentage'] = ($refinedEmployees[$employeeArray['ds_id']]['sick_hours'] / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])*100;
                $refinedEmployees[$employeeArray['ds_id']]['break_percentage'] = ($refinedEmployees[$employeeArray['ds_id']]['break_hours'] / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])*100;
            } else {
                $refinedEmployees[$employeeArray['ds_id']]['sick_percentage'] = 0;
                $refinedEmployees[$employeeArray['ds_id']]['break_percentage'] = 0;
            }
            
            /** calculate dailyagent prod. hours and % */
            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['productive_percentage'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] = 0;
            if(isset($refinedEmployees[$employeeArray['ds_id']]['cosmocom_id']) == true){
                foreach($dailyagentData as $key => $entry){
                    if($entry['agent_id'] == $refinedEmployees[$employeeArray['ds_id']]['cosmocom_id']){ //user is in entry
                        if($entry['status'] == 'Available') {
                            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                        }
                        if($entry['status'] == 'In Call') {
                            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                            $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];
                        }
                        if($entry['status'] == 'On Hold') {
                            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                            $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];
                        }
                        if($entry['status'] == 'Wrap Up') {
                            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                            $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];
                        }
                        if($entry['status'] == '05_Occupied') {
                            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                        }
                        if($entry['status'] == '06_Practice') {
                            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                        }
                        if($entry['status'] == '09_Outbound') {
                            $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                        }
                    }
                }
                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] = $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] / 60 / 60;
                $refinedEmployees[$employeeArray['ds_id']]['productive_percentage'] = ($refinedEmployees[$employeeArray['ds_id']]['productive_hours'] / $refinedEmployees[$employeeArray['ds_id']]['work_hours']) * 100;
            }

            /** calculate retdetails data: calls, calls/h, aht, saves, cr, rlz, revenue sales */
            $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['dsl_saves'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['rlz_minus'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] = 0;
            if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){
                foreach($retDetailsData as $key => $entry){
                    if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){
                        $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] += $entry['calls'];
                        $refinedEmployees[$employeeArray['ds_id']]['dsl_saves'] += $entry['orders'];
                        $refinedEmployees[$employeeArray['ds_id']]['rlz_minus'] += $entry['mvlzNeu'];
                        $refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] += $entry['rlzPlus'];
                    }
                }
            }
            if($refinedEmployees[$employeeArray['ds_id']]['productive_hours'] > 0){
                $refinedEmployees[$employeeArray['ds_id']]['calls_per_hour'] = $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] / $refinedEmployees[$employeeArray['ds_id']]['productive_hours'];
            } else{
                $refinedEmployees[$employeeArray['ds_id']]['calls_per_hour'] = 0;
            }
            if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){
                $refinedEmployees[$employeeArray['ds_id']]['aht'] = $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'];
            } else {
                $refinedEmployees[$employeeArray['ds_id']]['aht'] = 0;
            }
            if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){
                $refinedEmployees[$employeeArray['ds_id']]['dsl_cr'] = ($refinedEmployees[$employeeArray['ds_id']]['dsl_saves'] / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls']) *100;
            } else {
                $refinedEmployees[$employeeArray['ds_id']]['dsl_cr'] = 0;
            }
            if(($refinedEmployees[$employeeArray['ds_id']]['rlz_minus'] + $refinedEmployees[$employeeArray['ds_id']]['rlz_plus']) > 0) {
                $refinedEmployees[$employeeArray['ds_id']]['rlz_plus_percentage'] = ($refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] / ($refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] + $refinedEmployees[$employeeArray['ds_id']]['rlz_minus'])) * 100;
            } else {
                $refinedEmployees[$employeeArray['ds_id']]['rlz_plus_percentage'] = 0;
            }
            $refinedEmployees[$employeeArray['ds_id']]['revenue_sales'] = $refinedEmployees[$employeeArray['ds_id']]['dsl_saves'] * $defaultVariablesArray['revenue_sale_dsl'];

            /** calculate optin */
            $refinedEmployees[$employeeArray['ds_id']]['optin_calls_new'] = 0;
            $refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible'] = 0;
            
            if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){
                foreach($optinData as $key => $entry){
                    if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){
                        $refinedEmployees[$employeeArray['ds_id']]['optin_calls_new'] += $entry['Anzahl_OptIn-Erfolg'];
                        $refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible'] += max($entry['Anzahl_Handled_Calls_ohne_Call-OptIn'], $entry['Anzahl_Handled_Calls_ohne_Daten-OptIn']);
                    }
                }
            }
            if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){
                $refinedEmployees[$employeeArray['ds_id']]['optin_percentage'] = ($refinedEmployees[$employeeArray['ds_id']]['optin_calls_new'] / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'])*100;
                $refinedEmployees[$employeeArray['ds_id']]['optin_possible_percentage'] = ($refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible'] / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'])*100;

            } else {
                $refinedEmployees[$employeeArray['ds_id']]['optin_percentage'] = 0;
                $refinedEmployees[$employeeArray['ds_id']]['optin_possible_percentage'] = 0;
            }

            /** calculate sas */
            $refinedEmployees[$employeeArray['ds_id']]['sas_orders'] = 0;
            if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){
                foreach($sasData as $key => $entry){
                    if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){
                        $refinedEmployees[$employeeArray['ds_id']]['sas_orders'] += 1;
                    }
                }
            }
            if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){
                $refinedEmployees[$employeeArray['ds_id']]['sas_promille'] = ($refinedEmployees[$employeeArray['ds_id']]['sas_orders'] / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls']) * 1000;
            } else {
                $refinedEmployees[$employeeArray['ds_id']]['sas_promille'] = 0;
            }
        }
        asort($refinedEmployees); //sort list
        //dd($refinedEmployees);

        return $refinedEmployees; 
    }

    public function getKdwHours($defaultVariablesArray){
        $hours =  DB::connection('mysqlkdw')
        ->table("chronology_work")
        ->where('work_date', '>=', $defaultVariablesArray['startDate'])
        ->where('work_date', '<=', $defaultVariablesArray['endDate'])
        ->get()
        ->toArray();

        foreach($hours as $key => $entry){
            $entryArray = (array) $entry;
            $hours[$key] = $entryArray;
        }
    return $hours;
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
        //dd($data);
        return $data;
    }

    public function getOptin($defaultVariablesArray, $department){
        $data = DB::table('optin')
        ->where('date', '>=', $defaultVariablesArray['startDate'])
        ->where('date', '<=', $defaultVariablesArray['endDate'])
        ->where('department', '=', $department)
        ->get()
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }

    public function getDailyAgent($defaultVariablesArray, $department){
        //format date
        $startDate = $defaultVariablesArray['startDatePHP']->setTime(0,0);
        $endDate = $defaultVariablesArray['endDatePHP']->setTime(23,59);
        
        $data = DB::table('dailyagent')
        ->where('start_time', '>=', $startDate)
        ->where('start_time', '<=', $endDate)
        ->where('agent_group_name', '=', $department)
        ->get()
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }
        //dd($data);
        return $data;
    }

    public function getAvailbench($defaultVariablesArray, $department){
        $data = DB::table('availbench_report')
        ->where('date_date', '>=', $defaultVariablesArray['startDate'])
        ->where('date_date', '<=', $defaultVariablesArray['endDate'])
        ->where('call_forecast_issue', '=', $department)
        ->where('forecast', '>', 0)
        ->get()
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }

    public function getSas($defaultVariablesArray, $department){
        $data = DB::table('sas')
        ->where('date', '>=', $defaultVariablesArray['startDate'])
        ->where('date', '<=', $defaultVariablesArray['endDate'])
        ->where('topic', '=', $department)
        ->get()
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }
}

