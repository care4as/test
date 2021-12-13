<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttainmentController extends Controller
{
    public function queryHandler(){
        /** request variables from userform */
        $attainment = request('attainment');
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
            'attainment' => $attainment,
            'startDate' => $startDateString,
            'endDate' => $endDateString,
            'differenceDate' =>$differenceDate
        );

        $attainmentArray = null;

        /** functionhandler for attainments */
        if(($defaultVariablesArray['attainment'] == 'dsl_interval_attainment') || ($defaultVariablesArray['attainment'] == 'dsl_forecast_attainment')){
            $attainmentArray = $this->wfmDslAttainment($defaultVariablesArray);
        } elseif ($defaultVariablesArray['attainment'] == 'employee_surcharge') {
            $attainmentArray = $this->getEmployeeSurcharge($defaultVariablesArray);
        }

        //dd($attainmentArray);
        return view('attainment', compact('defaultVariablesArray', 'attainmentArray'));
    }

    public function wfmDslAttainment($defaultVariablesArray){
        $employees = $this->getEmployees($defaultVariablesArray, 10, 20); //20: Linesteuerung, 10: 1u1 DSL Ret
        $dateIntervalList = $this->getDateIntervalList($defaultVariablesArray);
        $refinedDateIntervalList = $this->addEmployeesToInterval($employees, $dateIntervalList);
           
        return $refinedDateIntervalList;
    }

    /** creates an array containing each day and 48 intervalls */
    public function getDateIntervalList($defaultVariablesArray){
        $dateList = array();
        
        for($i=0; $i <= $defaultVariablesArray['differenceDate']; $i++){
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startDate']. '+ '.$i.' days'));    //calculate current day

            $dateList['interval_list'][$currentDate]['europeanDate'] = date('d.m.Y', strtotime($currentDate));   //save european date in array as key

            //WEITERE FILTER HINZUFÜGEN (DSL FC, FC>0)
            $availbenchData = DB::table('availbench_report')                        //create database connection
            ->whereDate('date_date', '=', $currentDate)                             //filter for date equals currentdate
            ->where('call_forecast_issue', '=', 'DE_1u1_RT_Access_1st')             //filter for dsl forecast
            ->where('forecast', '>', 0)                                             //filter for relevant forecast
            ->get()                                                                 //save data in object
            ->toArray();                                                            //convert object to array

            foreach($availbenchData as $key => $availbenchDataEntry){
                $dataEntry = (array) $availbenchDataEntry;
                $dateList['interval_list'][$currentDate]['intervals'][$dataEntry['call_date_interval_start_time']]['forecast'] = $dataEntry['call_forecast_issue'];
                $dateList['interval_list'][$currentDate]['intervals'][$dataEntry['call_date_interval_start_time']]['interval_start_time'] = strtotime($dataEntry['call_date_interval_start_time']);
                
                if($dataEntry['malus_interval'] == 0){
                    $dateList['interval_list'][$currentDate]['intervals'][$dataEntry['call_date_interval_start_time']]['fulfilled'] = 'yes';
                } else {
                    $dateList['interval_list'][$currentDate]['intervals'][$dataEntry['call_date_interval_start_time']]['fulfilled'] = 'no';
                }
                $dateList['interval_list'][$currentDate]['intervals'][$dataEntry['call_date_interval_start_time']]['forecast_calls'] = $dataEntry['forecast'];
                $dateList['interval_list'][$currentDate]['intervals'][$dataEntry['call_date_interval_start_time']]['handled_calls'] = $dataEntry['handled'];
            }            
        }
        return $dateList;
    }

    public function getEmployees($defaultVariablesArray, $projectId, $departmentId){
        $employees = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('abteilung_id', '=', $departmentId)
            ->where('projekt_id', '=', $projectId)
            ->where(function($query) use($defaultVariablesArray){ 
                $query
                ->where('austritt', '=', null)
                ->orWhere('austritt', '>', $defaultVariablesArray['startDate']);})
            ->get()
            ->toArray();

        return $employees;
    }

    public function addEmployeesToInterval($employees, $dateArray){
        //save employees once
        foreach($employees as $employee){
            $initialEmployees = (array) $employee;
                $dateArray['employees'][$initialEmployees['ds_id']]['ds_id'] = $initialEmployees['ds_id'];
                $dateArray['employees'][$initialEmployees['ds_id']]['lastname'] = $initialEmployees['familienname'];
                $dateArray['employees'][$initialEmployees['ds_id']]['firstname'] = $initialEmployees['vorname'];
                $dateArray['employees'][$initialEmployees['ds_id']]['count_considered_interval'] = 0;
                $dateArray['employees'][$initialEmployees['ds_id']]['count_is_fullfilled'] = 0;
                $dateArray['employees'][$initialEmployees['ds_id']]['count_is_not_fullfilled'] = 0;
                $dateArray['employees'][$initialEmployees['ds_id']]['interval_fullfillment_ratio'] = 0;
                $dateArray['employees'][$initialEmployees['ds_id']]['count_forecast_calls'] = 0;
                $dateArray['employees'][$initialEmployees['ds_id']]['count_handled_calls'] = 0;
                $dateArray['employees'][$initialEmployees['ds_id']]['forecast_fullfillment_ratio'] = 0;
        }
        $dateArray['sum']['count_considered_interval'] = 0;
        $dateArray['sum']['count_is_fullfilled'] = 0;
        $dateArray['sum']['count_is_not_fullfilled'] = 0;
        $dateArray['sum']['interval_fullfillment_ratio'] = 0;
        $dateArray['sum']['count_forecast_calls'] = 0;
        $dateArray['sum']['count_handled_calls'] = 0;
        $dateArray['sum']['forecast_fullfillment_ratio'] = 0;

        //loop all days
        foreach($dateArray['interval_list'] as $day => $currentDay) {
            $dailyEmployees = array();

            //loop employees
            foreach($employees as $employee) {
                $currentEmployee = (array) $employee;
                $dailyEmployees[$currentEmployee['ds_id']]['ds_id'] = $currentEmployee['ds_id'];
                $dailyEmployees[$currentEmployee['ds_id']]['lastname'] = $currentEmployee['familienname'];
                $dailyEmployees[$currentEmployee['ds_id']]['firstname'] = $currentEmployee['vorname'];

                //login 
                $loginTime = DB::connection('mysqlkdw')
                    ->table('chronology_book')
                    ->where('MA_id', '=', $currentEmployee['ds_id'])
                    ->where('book_date', '=', $day)
                    ->where('acd_state_id', '=', 2)
                    ->first();

                $loginTime = (array) $loginTime;
                if(isset($loginTime['book_time']) == true){
                    $dailyEmployees[$currentEmployee['ds_id']]['login'] = $loginTime['book_time'];
                }

                //logout
                $logoutTime = DB::connection('mysqlkdw')
                    ->table('chronology_book')
                    ->where('MA_id', '=', $currentEmployee['ds_id'])
                    ->where('book_date', '=', $day)
                    ->where('acd_state_id', '=', 1)
                    ->first();

                $logoutTime = (array) $logoutTime;
                if(isset($logoutTime['book_time']) == true) {
                    $dailyEmployees[$currentEmployee['ds_id']]['logout'] = $logoutTime['book_time'];
                }
            }

            if(isset($currentDay['intervals']) == true){

                //loop all intervals
                foreach($currentDay['intervals'] as $interval => $currentInterval){
                    
                    //loop employees
                    foreach($dailyEmployees as $employee){
                        $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['lastname'] = $employee['lastname'];
                        $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['firstname'] = $employee['firstname'];
                        if(isset($employee['login']) == true){
                            $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['login'] = $employee['login'];
                            $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['login_seconds'] = strtotime($day . $employee['login']);
                        }
                        if(isset($employee['logout']) == true){
                            $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['logout'] = $employee['logout'];
                            $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['logout_seconds'] = strtotime($day . $employee['logout']);
                        }
                        if((isset($employee['login']) == true) && (isset($employee['logout']) == true)){
                            if(($dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['login_seconds'] < ($currentInterval['interval_start_time'] + 900)) && ($dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['logout_seconds'] > ($currentInterval['interval_start_time'] + 900))){
                                $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['present'] = 'yes';
                            } else {
                                $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['present'] = 'no';
                            }
                        } else {
                            $dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['present'] = 'no';
                        }

                        if($dateArray['interval_list'][$day]['intervals'][$interval]['workforcer'][$employee['ds_id']]['present'] == 'yes') {
                            $dateArray['employees'][$employee['ds_id']]['count_considered_interval'] += 1;
                            
                            if($currentInterval['fulfilled'] == 'yes') {
                                $dateArray['employees'][$employee['ds_id']]['count_is_fullfilled'] += 1;
                            } else {
                                $dateArray['employees'][$employee['ds_id']]['count_is_not_fullfilled'] += 1;
                            }

                            $dateArray['employees'][$employee['ds_id']]['count_forecast_calls'] += $currentInterval['forecast_calls'];
                            $dateArray['employees'][$employee['ds_id']]['count_handled_calls'] += $currentInterval['handled_calls'];

                        }
                    }
                    //add to sum intervals
                    $dateArray['sum']['count_considered_interval'] += 1;
                    if($currentInterval['fulfilled'] == 'yes') {
                        $dateArray['sum']['count_is_fullfilled'] += 1;
                    } else {
                        $dateArray['sum']['count_is_not_fullfilled'] += 1;
                    }

                    $dateArray['sum']['count_forecast_calls'] += $currentInterval['forecast_calls'];
                    $dateArray['sum']['count_handled_calls'] += $currentInterval['handled_calls'];
                }
            }
        }
        if($dateArray['sum']['count_is_fullfilled'] != 0){
            $dateArray['sum']['interval_fullfillment_ratio'] = $dateArray['sum']['count_is_fullfilled'] / $dateArray['sum']['count_considered_interval'];
        }
        $dateArray['sum']['interval_fullfillment_ratio'] = number_format(($dateArray['sum']['interval_fullfillment_ratio'] * 100), 2,",",".");

        if($dateArray['sum']['count_handled_calls'] != 0){
            $dateArray['sum']['forecast_fullfillment_ratio'] = $dateArray['sum']['count_handled_calls'] / $dateArray['sum']['count_forecast_calls'];
        } else {
            $dateArray['sum']['forecast_fullfillment_ratio'] = 0;
        }
        $dateArray['sum']['forecast_fullfillment_ratio'] = number_format(($dateArray['sum']['forecast_fullfillment_ratio'] * 100), 2,",",".");
        
        foreach($dateArray['employees'] as $employee) {
            if($dateArray['employees'][$employee['ds_id']]['count_is_fullfilled'] != 0){
                $dateArray['employees'][$employee['ds_id']]['interval_fullfillment_ratio'] = $dateArray['employees'][$employee['ds_id']]['count_is_fullfilled'] / $dateArray['employees'][$employee['ds_id']]['count_considered_interval'];
            } else {
                $dateArray['employees'][$employee['ds_id']]['interval_fullfillment_ratio'] = 0;
            }
            $dateArray['employees'][$employee['ds_id']]['interval_fullfillment_ratio'] = number_format(($dateArray['employees'][$employee['ds_id']]['interval_fullfillment_ratio'] * 100), 2,",",".");

            if($dateArray['employees'][$employee['ds_id']]['count_handled_calls'] != 0){
                $dateArray['employees'][$employee['ds_id']]['forecast_fullfillment_ratio'] = $dateArray['employees'][$employee['ds_id']]['count_handled_calls'] / $dateArray['employees'][$employee['ds_id']]['count_forecast_calls'];
            } else {
                $dateArray['employees'][$employee['ds_id']]['forecast_fullfillment_ratio'] = 0;
            }
            $dateArray['employees'][$employee['ds_id']]['forecast_fullfillment_ratio'] = number_format(($dateArray['employees'][$employee['ds_id']]['forecast_fullfillment_ratio'] * 100), 2,",",".");

        }

        return $dateArray;
    }

    public function getEmployeeSurcharge($defaultVariablesArray){
        $data = array();

        $hours =  DB::connection('mysqlkdw')                            // Verbindung zur externen Datenbanl 'mysqlkdw' wird hergestellt
        ->table("chronology_work")                                      // Aus der Datenbank soll auf die Tabelle 'chronology_work' zugegriffen werden
        ->where('work_date', '>=', $defaultVariablesArray['startDate']) // Datum muss größergleich dem Startdatum sein
        ->where('work_date', '<=', $defaultVariablesArray['endDate'])   // Datum muss kleinergleich dem Enddatum sein
        ->where('state_id', null)
        ->get();                    

        $employees = DB::connection('mysqlkdw')
        ->table('MA')
        ->where(function($query) {   
            $query
            ->where('projekt_id', '=', 10)
            ->orWhere('projekt_id', '=', 7);
        })
        ->where('abteilung_id', '=', 10)
        ->where(function($query) use($defaultVariablesArray){
            $query
            ->where('austritt', '=', null)
            ->orWhere('austritt', '>', $defaultVariablesArray['startDate']);}) 
        ->where('eintritt', '<=', $defaultVariablesArray['endDate'])            
        ->get(['ds_id', 'familienname', 'vorname'])                                                                 
        ->toArray();
        
        $userlist = array();
        foreach($employees as $key => $entry){
            $entry = (array) $entry;
            $userlist[$entry['ds_id']]['information']['ds_id'] = $entry['ds_id'];
            $userlist[$entry['ds_id']]['information']['name'] = $entry['familienname'] . ', ' . $entry['vorname'];

            for($i = 0; $i <= $defaultVariablesArray['differenceDate']; $i++){
                $date = Carbon::createFromFormat("Y-m-d", $defaultVariablesArray['startDate'])->modify('+' . $i . 'days');
                $dateStr = date_format($date, "Y-m-d");

    
                $userlist[$entry['ds_id']]['dates'][$dateStr]['hours'] = 0;
                $userlist[$entry['ds_id']]['dates'][$dateStr]['provision'] = 0;
            }
        }

        $data['employees'] = $userlist;


        for($i = 0; $i <= $defaultVariablesArray['differenceDate']; $i++){
            $date = Carbon::createFromFormat("Y-m-d", $defaultVariablesArray['startDate'])->modify('+' . $i . 'days');
            $dateStr = date_format($date, "Y-m-d");



            
            
            
            
            
            $data['sum'][$dateStr] = $dateStr;
        }

        $employeesObject = null; // DB ABFRAGE MIT FILTER AUF BERECHTIGTE GRUPPEN
        //FOREACH SCHLEIFE ÜBER ALLE MA -> IN EMPLOYEES SPEICHERN: DATA, DAYS
        //IN DATA DIE DS_ID UND DEN NAMEN SPEICHERN
        //IN DAYS EIN ARRAY ERSTELLEN MIT EINEM EINTRAG PRO TAG
        //FÜR JEDEN TAG EINEN STUNDENWERT UND EINEN EUROWERT BERECHNEN
        
        dd($hours);
        dd($data);
        return $data;
    }

}

