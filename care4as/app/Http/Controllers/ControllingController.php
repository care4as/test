<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ControllingController extends Controller
{
    public function queryHandler(){
        //define global variables
        $project = request('project');
        $startDateString = request('startDate');
        $endDateString = request('endDate'); // retrive enddate from input form

        if ($startDateString == null){
            $startDate = null;
        } else {
            $startDate = Carbon::createFromFormat("Y-m-d", $startDateString); //create PHP date from string
        }
        if ($endDateString == null){
            $endDate = null;
        } else {
            $endDate = Carbon::createFromFormat("Y-m-d", $endDateString); //create PHP date from string
        }

        $differenceDate = Carbon::parse($startDate)->diffInDays($endDate);
                   
        $defaultVariablesArray = array(
            'project' => $project,
            'startdate' => $startDateString,
            'enddate' => $endDateString,
            'difference_date' =>$differenceDate
        );

        for($i=0; $i <= $differenceDate; $i++){
            $currentDate = date('Y-m-d', strtotime($startDate. '+ '.$i.' days'));
            $defaultVariablesArray['days'][] = $currentDate;

            //european date
            $weekDayCount = date('N', strtotime($currentDate));

            if($weekDayCount == 1){
                $defaultVariablesArray['app_data'][$currentDate]['weekday'] = 'MO';
            }elseif($weekDayCount == 2){
                $defaultVariablesArray['app_data'][$currentDate]['weekday'] = 'DI';
            }elseif($weekDayCount == 3){
                $defaultVariablesArray['app_data'][$currentDate]['weekday'] = 'MI';
            }elseif($weekDayCount == 4){
                $defaultVariablesArray['app_data'][$currentDate]['weekday'] = 'DO';
            }elseif($weekDayCount == 5){
                $defaultVariablesArray['app_data'][$currentDate]['weekday'] = 'FR';
            }elseif($weekDayCount == 6){
                $defaultVariablesArray['app_data'][$currentDate]['weekday'] = 'SA';
            }elseif($weekDayCount == 7){
                $defaultVariablesArray['app_data'][$currentDate]['weekday'] = 'SO';
            }

            $defaultVariablesArray['app_data'][$currentDate]['date_european'] = date('d.m.Y', strtotime($currentDate));
        }

        $defaultVariablesArray['industrial_months'] = 0;

        //calculate industrial months (1FTE = 173h)
        $startDay = date('j', strtotime($startDate));
        $startMonth = date('n', strtotime($startDate));
        $startYear = date('Y', strtotime($startDate));
        $endDay = date('j', strtotime($endDate));
        $endMonth = date('n', strtotime($endDate));
        $endYear = date('Y', strtotime($endDate));

        $spanMonths = 0;
        if($startYear == $endYear){
            $spanMonths = $endMonth + 1 - $startMonth;
        } else {
            $spanMonths = (13 - $startMonth) + $endMonth + (($endYear - ($startYear + 1)) * 12);
        }

        if($spanMonths == 1){
            $defaultVariablesArray['industrial_months'] = ($endDay + 1 - $startDay) / date('t', strtotime($startDate));
            
        }elseif($spanMonths == 2){
            $defaultVariablesArray['industrial_months'] = ((date('t', strtotime($startDate)) + 1 - $startDay) / date('t', strtotime($startDate)))
                                                            + ($endDay / date('t', strtotime($endDate)));
            
        }elseif($spanMonths > 2){
            $defaultVariablesArray['industrial_months'] = ((date('t', strtotime($startDate)) + 1 - $startDay) / date('t', strtotime($startDate)))
                                                            + ($endDay / date('t', strtotime($endDate)))
                                                            + ($spanMonths - 2);
        }

        //default project variables
            //revenue should per hour
            $defaultVariablesArray['revenue_hour_should']['1u1_dsl_retention'] = 36;
            $defaultVariablesArray['revenue_hour_should']['1u1_mobile_retention'] = 35;
            $defaultVariablesArray['revenue_hour_should']['1u1_terminationadministration'] = 24.5;
            $defaultVariablesArray['revenue_hour_should']['telefonica_outbound'] = 35;

            //project id
            $defaultVariablesArray['project_id']['1u1_dsl_retention'] = 10;
            $defaultVariablesArray['project_id']['1u1_mobile_retention'] = 7;
            $defaultVariablesArray['project_id']['1u1_terminationadministration'] = 6;
            $defaultVariablesArray['project_id']['telefonica_outbound'] = 14;

        //retrive data depending on choosen project
        if($project == '1u1_dsl_retention' or $project == 'all') {
            $dslSalesDataArray = $this->dslSalesData($defaultVariablesArray);
            $dslWorktimeArray = $this->worktimeReport($defaultVariablesArray, $defaultVariablesArray['revenue_hour_should']['1u1_dsl_retention'], $defaultVariablesArray['project_id']['1u1_dsl_retention']); //(x, y, z, revenue/hour, project id)
            $dslCoreDataArray = $this->dslCoreData($defaultVariablesArray, $dslSalesDataArray, $dslWorktimeArray);
        } else {
            $dslSalesDataArray = 0;
            $dslWorktimeArray = 0;
            $dslCoreDataArray = 0;
        }

        if ($project == '1u1_mobile_retention' or $project == 'all') {
            //$mobileSalesDataArray = $this->mobileSalesReportKDW($startDate, $endDate, $differenceDate);
            $mobileSalesDataArray = $this->mobileSalesReportKDW($defaultVariablesArray);
            $mobileWorktimeArray = $this->worktimeReport($defaultVariablesArray, $defaultVariablesArray['revenue_hour_should']['1u1_mobile_retention'], $defaultVariablesArray['project_id']['1u1_mobile_retention']); //(x, y, z, revenue/hour, project id)
            $mobileCoreDataArray = $this->mobileCoreData($mobileSalesDataArray, $mobileWorktimeArray, $defaultVariablesArray);
        } else {
            $mobileSalesDataArray = 0;
            $mobileWorktimeArray = 0;
            $mobileCoreDataArray = 0;
        }

        if ($project == '1u1_terminationadministration' or $project == 'all') {
            $terminationSalesDataArray = $this->terminationSalesData($defaultVariablesArray);
            $terminationWorktimeArray = $this->worktimeReport($defaultVariablesArray, $defaultVariablesArray['revenue_hour_should']['1u1_terminationadministration'], $defaultVariablesArray['project_id']['1u1_terminationadministration']); //(x, y, z, revenue/hour, project id)
            $terminationCoreDataArray = $this->terminationCoreData($defaultVariablesArray, $terminationSalesDataArray, $terminationWorktimeArray);
        } else {
            $terminationSalesDataArray = 0;
            $terminationWorktimeArray = 0;
            $terminationCoreDataArray = 0;
        }

        if($project == 'telefonica_outbound' or $project == 'all') {
            $telefonicaSalesDataArray = $this->telefonicaSalesData($defaultVariablesArray);
            $telefonicaWorktimeArray = $this->worktimeReport($defaultVariablesArray, $defaultVariablesArray['revenue_hour_should']['telefonica_outbound'], $defaultVariablesArray['project_id']['telefonica_outbound']); //(x, y, z, revenue/hour, project id)
            $telefonicaCoreDataArray = $this->telefonicaCoreData($defaultVariablesArray, $telefonicaSalesDataArray, $telefonicaWorktimeArray);
        } else {
            $telefonicaSalesDataArray = 0;
            $telefonicaWorktimeArray = 0;
            $telefonicaCoreDataArray = 0;
        }

        return view('umsatzmeldung', compact('dslSalesDataArray', 'dslWorktimeArray', 'dslCoreDataArray', 'telefonicaSalesDataArray', 'telefonicaWorktimeArray', 'telefonicaCoreDataArray', 'defaultVariablesArray', 'mobileSalesDataArray', 'mobileWorktimeArray', 'mobileCoreDataArray', 'terminationSalesDataArray', 'terminationWorktimeArray', 'terminationCoreDataArray'));
        
    }

//DSL START
    public function dslSalesData($defaultVariablesArray){
        //define sales parameters
        $dslRetRevenue = 16.00; 
        $dslPreRevenue = 17.00;
        $dslKueRevenue = 5.00;
        $availbenchApporxMinutePrice = 0.439;
        $availbenchApproxAht = 550;

        $dslSalesDataArray['information']['dslRetRebenue'] = $dslRetRevenue;
        $dslSalesDataArray['information']['dslPreRebenue'] = $dslPreRevenue;
        $dslSalesDataArray['information']['dslKueRebenue'] = $dslKueRevenue;
        $dslSalesDataArray['information']['dslRetRebenueString'] = number_format($dslRetRevenue, 2,",",".");
        $dslSalesDataArray['information']['dslPreRebenueString'] = number_format($dslPreRevenue, 2,",",".");
        $dslSalesDataArray['information']['dslKueRebenueString'] = number_format($dslKueRevenue, 2,",",".");

        //define cumulative variables
        $dslSalesDataArray['kdwSalesData']['cumulative']['retSaves'] = 0;
        $dslSalesDataArray['kdwSalesData']['cumulative']['preSaves'] = 0;
        $dslSalesDataArray['kdwSalesData']['cumulative']['kueSaves'] = 0;
        $dslSalesDataArray['kdwSalesData']['cumulative']['sumSaves'] = 0;
        $dslSalesDataArray['kdwSalesData']['cumulative']['calls'] = 0;
        $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveSum'] = 0;
        $dslSalesDataArray['kdwSalesData']['cumulative']['revenueAvailbenchSum'] = 0;
        $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] = 0;
        
        //loop time span
        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $day = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            $salesData = DB::connection('mysqlkdwtracking')
            ->table('1und1_dslr_tracking_inb_new_ebk')
            // ->whereIn('MA_id', $userids)
            ->whereDate('date', '=', $day)
            ->get();

            //dd($salesData)

            //daily
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['retSaves'] = $salesData->sum('ret_de_1u1_rt_save');
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['preSaves'] = $salesData->sum('prev_save_queue_save');
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['kueSaves'] = $salesData->sum('kuerue');
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['sumSaves'] = $dslSalesDataArray['kdwSalesData']['daily'][$day]['retSaves']
                                                                                        + $dslSalesDataArray['kdwSalesData']['daily'][$day]['preSaves']
                                                                                        + $dslSalesDataArray['kdwSalesData']['daily'][$day]['kueSaves'];
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['calls'] = $salesData->sum('calls');
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveSum'] = $dslSalesDataArray['kdwSalesData']['daily'][$day]['retSaves'] * $dslRetRevenue
                                                                                        + $dslSalesDataArray['kdwSalesData']['daily'][$day]['preSaves'] * $dslPreRevenue
                                                                                        + $dslSalesDataArray['kdwSalesData']['daily'][$day]['kueSaves'] * $dslKueRevenue;
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveSumString'] = number_format($dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveSum'], 2,",",".");
            if($dslSalesDataArray['kdwSalesData']['daily'][$day]['sumSaves'] == 0){
                $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSave'] = 0;
            }else{
                $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSave'] = $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveSum'] / $dslSalesDataArray['kdwSalesData']['daily'][$day]['sumSaves'];
            }
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveString'] = number_format($dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSave'], 2,",",".");
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueAvailbenchSum'] = $dslSalesDataArray['kdwSalesData']['daily'][$day]['calls']
                                                                                                    * ($availbenchApproxAht / 60)
                                                                                                    * $availbenchApporxMinutePrice;
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueAvailbenchSumString'] = number_format($dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueAvailbenchSum'], 2,",",".");
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] = $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveSum']
                                                                                        + $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueAvailbenchSum'];
            $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSumString'] = number_format($dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'], 2,",",".");

            //cumulative
            $dslSalesDataArray['kdwSalesData']['cumulative']['retSaves'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['retSaves'];
            $dslSalesDataArray['kdwSalesData']['cumulative']['preSaves'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['preSaves'];
            $dslSalesDataArray['kdwSalesData']['cumulative']['kueSaves'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['kueSaves'];
            $dslSalesDataArray['kdwSalesData']['cumulative']['sumSaves'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['sumSaves'];
            $dslSalesDataArray['kdwSalesData']['cumulative']['calls'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['calls'];
            $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveSum'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveSum'];
            $dslSalesDataArray['kdwSalesData']['cumulative']['revenueAvailbenchSum'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueAvailbenchSum'];
            $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] += $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'];
        }
        if($dslSalesDataArray['kdwSalesData']['cumulative']['sumSaves'] == 0) {
            $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSave'] = 0;
        } else {
            $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSave'] = $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveSum']
                                                                                / $dslSalesDataArray['kdwSalesData']['cumulative']['sumSaves'];
        }
        $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveString'] = number_format($dslSalesDataArray['kdwSalesData']['cumulative']['revenueSave'], 2,",",".");
        $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveSumString'] = number_format($dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveSum'], 2,",",".");
        $dslSalesDataArray['kdwSalesData']['cumulative']['revenueAvailbenchSumString'] = number_format($dslSalesDataArray['kdwSalesData']['cumulative']['revenueAvailbenchSum'], 2,",",".");
        $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSumString'] = number_format($dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'], 2,",",".");

        //dd($dslSalesDataArray);
        return $dslSalesDataArray;
    }

    public function dslCoreData($defaultVariablesArray, $dslSalesDataArray, $dslWorktimeArray){
        if($dslWorktimeArray['cumulative']['paid_hours_int'] == 0) {
            $dslCoreDataArray['cumulative']['revenuePaidHour'] = 0;
        } else {
            $dslCoreDataArray['cumulative']['revenuePaidHour'] = $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $dslWorktimeArray['cumulative']['paid_hours_int'];
        }
        $dslCoreDataArray['cumulative']['revenuePaidHourString'] = number_format($dslCoreDataArray['cumulative']['revenuePaidHour'], 2,",",".");
        $dslCoreDataArray['cumulative']['revenueDelta'] = $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] - $dslWorktimeArray['cumulative']['revenue_should_int'];
        $dslCoreDataArray['cumulative']['revenueDeltaString'] = number_format($dslCoreDataArray['cumulative']['revenueDelta'], 2,",",".");
        if($dslWorktimeArray['cumulative']['revenue_should_int'] == 0) {
            $dslCoreDataArray['cumulative']['attainmeint'] = 0;
        } else {
            $dslCoreDataArray['cumulative']['attainmeint'] = ($dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $dslWorktimeArray['cumulative']['revenue_should_int']) * 100;
        }
        $dslCoreDataArray['cumulative']['attainmeintString'] = number_format($dslCoreDataArray['cumulative']['attainmeint'], 2,",",".");

        $dslCoreDataArray['overview']['revenueShould'] = $dslWorktimeArray['cumulative']['fte_medium_int'] * 173 * $defaultVariablesArray['revenue_hour_should']['1u1_dsl_retention'] * $defaultVariablesArray['industrial_months'];
        $dslCoreDataArray['overview']['revenueShouldString'] = number_format($dslCoreDataArray['overview']['revenueShould'], 2,",",".");
        $dslCoreDataArray['overview']['revenueDelta'] = $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] - $dslCoreDataArray['overview']['revenueShould'];
        $dslCoreDataArray['overview']['revenueDeltaString'] = number_format($dslCoreDataArray['overview']['revenueDelta'], 2,",",".");
        if($dslCoreDataArray['overview']['revenueShould'] == 0) {
            $dslCoreDataArray['overview']['attainment'] = 0;
        } else {
            $dslCoreDataArray['overview']['attainment'] = ($dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $dslCoreDataArray['overview']['revenueShould']) * 100;
        }
        $dslCoreDataArray['overview']['attainmentString'] = number_format($dslCoreDataArray['overview']['attainment'], 2,",",".");
        if ($dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] == 0){
            $dslCoreDataArray['overview']['db2'] = 0;
        } else {
            $dslCoreDataArray['overview']['db2'] = (1 - ($dslCoreDataArray['overview']['revenueShould'] / $dslSalesDataArray['kdwSalesData']['cumulative']['revenueSum'])) * 100;
        }
        $dslCoreDataArray['overview']['db2String'] = number_format($dslCoreDataArray['overview']['db2'], 2,",",".");

        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $day = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            if($dslWorktimeArray[$day]['work_hours'] == 0){
                $dslCoreDataArray['daily'][$day]['revenuePaidHour'] = 0;
            } else {
            $dslCoreDataArray['daily'][$day]['revenuePaidHour'] = ($dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] / $dslWorktimeArray[$day]['work_hours']);
            }
            $dslCoreDataArray['daily'][$day]['revenuePaidHourString'] = number_format($dslCoreDataArray['daily'][$day]['revenuePaidHour'], 2,",",".");
            $dslCoreDataArray['daily'][$day]['revenueDelta'] = $dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] - $dslWorktimeArray[$day]['revenue_should_int'];
            $dslCoreDataArray['daily'][$day]['revenueDeltaString'] = number_format($dslCoreDataArray['daily'][$day]['revenueDelta'], 2,",",".");
            if ($dslWorktimeArray[$day]['revenue_should_int'] == 0) {
                $dslCoreDataArray['daily'][$day]['attainmeint'] = 0;
            } else {
            $dslCoreDataArray['daily'][$day]['attainmeint'] = ($dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] / $dslWorktimeArray[$day]['revenue_should_int']) * 100;
            }
            $dslCoreDataArray['daily'][$day]['attainmeintString'] = number_format($dslCoreDataArray['daily'][$day]['attainmeint'], 2,",",".");
        }

        //dd($dslCoreDataArray);
        return $dslCoreDataArray;
    }


//DSL END
    
//TERMINATION START
    public function terminationSalesData($defaultVariablesArray){
        //dfefine sales parameters
        $kueRevenue = 1.854;
        $brlRevenue = 0.656;
        
        //define tracking to distinctcase ratio (tdr)
        $kueTdr = 0.85;
        $brlTdr = 0.75;
        
        //define salesdata array
        $terminationSalesData['information']['kueRevenue'] = number_format($kueRevenue, 3,",",".");
        $terminationSalesData['information']['brlRevenue'] = number_format($brlRevenue, 3,",",".");
        $terminationSalesData['information']['kueTdr'] = number_format($kueTdr * 100, 2,",","."); 
        $terminationSalesData['information']['brlTdr'] = number_format($brlTdr * 100, 2,",",".");
        //$terminationSalesData['nzrSalesData']['cumulative'] = 'folgt...';
        //$terminationSalesData['nzrSalesData']['daily'] = 'folgt...';

        $terminationSalesData['kdwSalesData']['cumulative']['kueCases'] = 0;
        $terminationSalesData['kdwSalesData']['cumulative']['brlCases'] = 0;
        $terminationSalesData['kdwSalesData']['cumulative']['kueDistinctCases'] = 0;
        $terminationSalesData['kdwSalesData']['cumulative']['brlDistinctCases'] = 0;
        $terminationSalesData['kdwSalesData']['cumulative']['sumDistinctCases'] = 0;

        //loop timespan
        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            $salesData = DB::connection('mysqlkdwtracking')
            ->table('1und1_offline')
            // ->whereIn('MA_id', $userids)
            ->whereDate('date', '=', $currentDate)
            ->get();

            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['kueCases'] = $salesData->sum('fire_value');
            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['brlCases'] = $salesData->sum('letterreturns_value');

            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['kueDistinctCases'] = $terminationSalesData['kdwSalesData']['daily'][$currentDate]['kueCases'] * $kueTdr;
            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['brlDistinctCases'] = $terminationSalesData['kdwSalesData']['daily'][$currentDate]['brlCases'] * $kueTdr;
            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['sumDistinctCases'] = $terminationSalesData['kdwSalesData']['daily'][$currentDate]['kueDistinctCases']
                                                                                                + $terminationSalesData['kdwSalesData']['daily'][$currentDate]['brlDistinctCases'];

            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueSum'] = $terminationSalesData['kdwSalesData']['daily'][$currentDate]['kueDistinctCases'] * $kueRevenue
                                                                                            + $terminationSalesData['kdwSalesData']['daily'][$currentDate]['brlDistinctCases'] * $brlRevenue;
            
            if($terminationSalesData['kdwSalesData']['daily'][$currentDate]['sumDistinctCases'] == 0){
                $terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueCase'] = 0;
            } else {                                                                           
            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueCase'] = $terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueSum'] 
                                                                                            / $terminationSalesData['kdwSalesData']['daily'][$currentDate]['sumDistinctCases'];
            }
        
            $terminationSalesData['kdwSalesData']['cumulative']['kueCases'] += $terminationSalesData['kdwSalesData']['daily'][$currentDate]['kueCases'];
            $terminationSalesData['kdwSalesData']['cumulative']['brlCases'] += $terminationSalesData['kdwSalesData']['daily'][$currentDate]['brlCases'];
            $terminationSalesData['kdwSalesData']['cumulative']['kueDistinctCases'] += $terminationSalesData['kdwSalesData']['daily'][$currentDate]['kueDistinctCases'];
            $terminationSalesData['kdwSalesData']['cumulative']['brlDistinctCases'] += $terminationSalesData['kdwSalesData']['daily'][$currentDate]['brlDistinctCases'];
            $terminationSalesData['kdwSalesData']['cumulative']['sumDistinctCases'] += $terminationSalesData['kdwSalesData']['daily'][$currentDate]['sumDistinctCases'];

            //convert int to string
            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['sumDistinctCasesString'] = number_format($terminationSalesData['kdwSalesData']['daily'][$currentDate]['sumDistinctCases'], 0,",",".");
            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueSumString'] = number_format($terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueSum'], 2,",",".");
            $terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueCaseString'] = number_format($terminationSalesData['kdwSalesData']['daily'][$currentDate]['revenueCase'], 3,",",".");
        

        }
        $terminationSalesData['kdwSalesData']['cumulative']['revenueSum'] = $terminationSalesData['kdwSalesData']['cumulative']['kueDistinctCases'] * $kueRevenue
                                                                            + $terminationSalesData['kdwSalesData']['cumulative']['brlDistinctCases'] * $brlRevenue;
        if($terminationSalesData['kdwSalesData']['cumulative']['sumDistinctCases'] == 0) {
            $terminationSalesData['kdwSalesData']['cumulative']['revenueCase'] = 0;
        } else {
        $terminationSalesData['kdwSalesData']['cumulative']['revenueCase'] = $terminationSalesData['kdwSalesData']['cumulative']['revenueSum'] 
                                                                                / $terminationSalesData['kdwSalesData']['cumulative']['sumDistinctCases'];
        }

        //convert int to string
        $terminationSalesData['kdwSalesData']['cumulative']['revenueSumString'] = number_format($terminationSalesData['kdwSalesData']['cumulative']['revenueSum'], 2,",",".");
        $terminationSalesData['kdwSalesData']['cumulative']['revenueCaseString'] = number_format($terminationSalesData['kdwSalesData']['cumulative']['revenueCase'], 3,",",".");
        $terminationSalesData['kdwSalesData']['cumulative']['sumDistinctCasesString'] = number_format($terminationSalesData['kdwSalesData']['cumulative']['sumDistinctCases'], 0,",",".");

        return $terminationSalesData;
    }

    public function terminationCoreData($defaultVariablesArray, $terminationSalesDataArray, $terminationWorktimeArray) {
        if($terminationWorktimeArray['cumulative']['paid_hours_int'] == 0) {
            $terminationCoreData['cumulative']['revenuePaidHour'] = 0;
        } else {
            $terminationCoreData['cumulative']['revenuePaidHour'] = $terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $terminationWorktimeArray['cumulative']['paid_hours_int'];
        }
        $terminationCoreData['cumulative']['revenuePaidHourString'] = number_format($terminationCoreData['cumulative']['revenuePaidHour'], 2,",",".");
        $terminationCoreData['cumulative']['revenueDelta'] = $terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] - $terminationWorktimeArray['cumulative']['revenue_should_int'];
        $terminationCoreData['cumulative']['revenueDeltaString'] = number_format($terminationCoreData['cumulative']['revenueDelta'], 2,",",".");
        if($terminationWorktimeArray['cumulative']['revenue_should_int'] == 0) {
            $terminationCoreData['cumulative']['attainmeint'] = 0;
        } else {
            $terminationCoreData['cumulative']['attainmeint'] = ($terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $terminationWorktimeArray['cumulative']['revenue_should_int']) * 100;
        }
        $terminationCoreData['cumulative']['attainmeintString'] = number_format($terminationCoreData['cumulative']['attainmeint'], 2,",",".");

        $terminationCoreData['overview']['revenueShould'] = $terminationWorktimeArray['cumulative']['fte_medium_int'] * 173 * $defaultVariablesArray['revenue_hour_should']['1u1_terminationadministration'] * $defaultVariablesArray['industrial_months'];
        $terminationCoreData['overview']['revenueShouldString'] = number_format($terminationCoreData['overview']['revenueShould'], 2,",",".");
        $terminationCoreData['overview']['revenueDelta'] = $terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] - $terminationCoreData['overview']['revenueShould'];
        $terminationCoreData['overview']['revenueDeltaString'] = number_format($terminationCoreData['overview']['revenueDelta'], 2,",",".");
        if($terminationCoreData['overview']['revenueShould'] == 0) {
            $terminationCoreData['overview']['attainment'] = 0;
        } else {
            $terminationCoreData['overview']['attainment'] = ($terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $terminationCoreData['overview']['revenueShould']) * 100;
        }
        $terminationCoreData['overview']['attainmentString'] = number_format($terminationCoreData['overview']['attainment'], 2,",",".");
        if ($terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] == 0){
            $terminationCoreData['overview']['db2'] = 0;
        } else {
            $terminationCoreData['overview']['db2'] = (1 - ($terminationCoreData['overview']['revenueShould'] / $terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSum'])) * 100;
        }
        $terminationCoreData['overview']['db2String'] = number_format($terminationCoreData['overview']['db2'], 2,",",".");

        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            if($terminationWorktimeArray[$currentDate]['work_hours'] == 0){
                $terminationCoreData['daily'][$currentDate]['revenuePaidHour'] = 0;
            } else {
            $terminationCoreData['daily'][$currentDate]['revenuePaidHour'] = ($terminationSalesDataArray['kdwSalesData']['daily'][$currentDate]['revenueSum'] / $terminationWorktimeArray[$currentDate]['work_hours']);
            }
            $terminationCoreData['daily'][$currentDate]['revenuePaidHourString'] = number_format($terminationCoreData['daily'][$currentDate]['revenuePaidHour'], 2,",",".");
            $terminationCoreData['daily'][$currentDate]['revenueDelta'] = $terminationSalesDataArray['kdwSalesData']['daily'][$currentDate]['revenueSum'] - $terminationWorktimeArray[$currentDate]['revenue_should_int'];
            $terminationCoreData['daily'][$currentDate]['revenueDeltaString'] = number_format($terminationCoreData['daily'][$currentDate]['revenueDelta'], 2,",",".");
            if ($terminationWorktimeArray[$currentDate]['revenue_should_int'] == 0) {
                $terminationCoreData['daily'][$currentDate]['attainmeint'] = 0;
            } else {
            $terminationCoreData['daily'][$currentDate]['attainmeint'] = ($terminationSalesDataArray['kdwSalesData']['daily'][$currentDate]['revenueSum'] / $terminationWorktimeArray[$currentDate]['revenue_should_int']) * 100;
            }
            $terminationCoreData['daily'][$currentDate]['attainmeintString'] = number_format($terminationCoreData['daily'][$currentDate]['attainmeint'], 2,",",".");
        }

        //dd($terminationCoreData);
        return $terminationCoreData;
    }
//TERMINATION END

//MOBILE START
    public function mobileCoreData($mobileSalesDataArray, $mobileWorktimeArray, $defaultVariablesArray){
        $medianFTE = $mobileWorktimeArray['cumulative']['fte_medium_int'];

        $mobileCoreDataArray = array(
            'sum_FTE_int' => array_sum(array_column($mobileWorktimeArray, 'FTE_int')),
            'median_FTE_string' => number_format($medianFTE, 3,",","."),
            'sum_work_hours_int' => array_sum(array_column($mobileWorktimeArray, 'work_hours')),
            'sum_work_hours_string' => number_format(array_sum(array_column($mobileWorktimeArray, 'work_hours')), 2,",","."),
            'sum_revenue_should_int' => $mobileWorktimeArray['cumulative']['revenue_should_int'],
            'sum_revenue_should_string' => number_format($mobileWorktimeArray['cumulative']['revenue_should_int'], 2,",","."),
            'revenue_should_int' => $medianFTE * 173 * $defaultVariablesArray['revenue_hour_should']['1u1_mobile_retention'] * $defaultVariablesArray['industrial_months'],
            'revenue_should_string' => number_format($medianFTE * 173 * $defaultVariablesArray['revenue_hour_should']['1u1_mobile_retention'] * $defaultVariablesArray['industrial_months'], 2,",",".")
        );


        //dd($mobileSalesDataArray);
        $mobileCoreDataArray['revenue_delta_int'] = $mobileSalesDataArray['total_performance']['sum_revenue_int'] - $mobileCoreDataArray['revenue_should_int']; 
        $mobileCoreDataArray['revenue_delta_string'] = number_format($mobileCoreDataArray['revenue_delta_int'], 2,",",".");
        if($mobileSalesDataArray['total_performance']['sum_revenue_int'] == 0){
            $mobileCoreDataArray['db2_int'] = 0;
        } else {
            $mobileCoreDataArray['db2_int'] = (1 - ($mobileCoreDataArray['revenue_should_int'] / $mobileSalesDataArray['total_performance']['sum_revenue_int']))*100;
        }
        $mobileCoreDataArray['db2_string'] = number_format($mobileCoreDataArray['db2_int'], 2,",",".");
        if($mobileCoreDataArray['revenue_should_int'] == 0) {
            $mobileCoreDataArray['attainment_int'] = 0;
        } else {
            $mobileCoreDataArray['attainment_int'] = $mobileSalesDataArray['total_performance']['sum_revenue_int'] / $mobileCoreDataArray['revenue_should_int'] * 100;
        }
        $mobileCoreDataArray['attainment_string'] = number_format($mobileCoreDataArray['attainment_int'], 2,",",".");

        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));
            if($mobileWorktimeArray[$currentDate]['revenue_should_int'] == 0){
                $mobileCoreDataArray['daily_performance'][$currentDate]['attainment_int'] = 0;
            }
            else{
                $mobileCoreDataArray['daily_performance'][$currentDate]['attainment_int'] = ($mobileSalesDataArray['daily_performance'][$currentDate]['total_revenue_int'] / $mobileWorktimeArray[$currentDate]['revenue_should_int']) * 100;
            }   
            $mobileCoreDataArray['daily_performance'][$currentDate]['attainment_string'] = number_format($mobileCoreDataArray['daily_performance'][$currentDate]['attainment_int'], 2,",",".");
            $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_delta_int'] = $mobileSalesDataArray['daily_performance'][$currentDate]['total_revenue_int'] - $mobileWorktimeArray[$currentDate]['revenue_should_int'];
            $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_delta_string'] = number_format($mobileCoreDataArray['daily_performance'][$currentDate]['revenue_delta_int'], 2,",",".");
            if ($mobileWorktimeArray[$currentDate]['work_hours'] == 0){
                $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_int'] = 0;
            }
            else{
                $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_int'] = $mobileSalesDataArray['daily_performance'][$currentDate]['total_revenue_int'] / $mobileWorktimeArray[$currentDate]['work_hours'];
            };
            $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_string'] = number_format($mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_int'], 2,",",".");

            

        }

        $mobileCoreDataArray['duration_revenue_payed_hour_int'] = $mobileSalesDataArray['total_performance']['sum_revenue_int'] / $mobileCoreDataArray['sum_work_hours_int'];
        $mobileCoreDataArray['duration_revenue_payed_hour_string'] = number_format($mobileCoreDataArray['duration_revenue_payed_hour_int'], 2,",",".");
        $mobileCoreDataArray['duration_attainment_int'] = ($mobileSalesDataArray['total_performance']['sum_revenue_int'] / $mobileCoreDataArray['sum_revenue_should_int']) * 100;
        $mobileCoreDataArray['duration_attainment_string'] = number_format($mobileCoreDataArray['duration_attainment_int'], 2,",",".");
        $mobileCoreDataArray['duration_revenue_delta_int'] = $mobileSalesDataArray['total_performance']['sum_revenue_int'] - $mobileCoreDataArray['sum_revenue_should_int'];
        $mobileCoreDataArray['duration_revenue_delta_string'] = number_format($mobileCoreDataArray['duration_revenue_delta_int'], 2,",",".");

        //dd($mobileWorktimeArray);
        //dd($mobileCoreDataArray);
        return $mobileCoreDataArray;
    }

    public function mobileSalesReportKDW($defaultVariablesArray){
        //initialize data array
        $salesReportDataKDW = array();
        //initialize core variables
        $salesReportDataKDW['total_performance']['median_revenue_int'] = 0;
        $salesReportDataKDW['total_performance']['sum_revenue_int'] = 0;
               
        //define parameters
        $ret_SSC_Revenue    = 16.00;
        $ret_BSC_Revenue    = 11.00;
        $ret_Portal_Revenue = 16.00;
        $pre_SSC_Revenue    = 12.50;
        $pre_BSC_Revenue    = 8.50;
        $pre_Portal_Revenue = 12.50;
        $kuerue_Revenue     = 5.00;
        $availbench_aprrox_minute_price = 0.42;

        //define total variables
        $salesReportDataKDW['total_performance']['total_mobile_sum_revenue'] = 0;
        $salesReportDataKDW['total_performance']['total_mobile_sum_sales'] = 0;
        $salesReportDataKDW['total_performance']['sum_availbench_kdw_int'] = 0;
        $salesReportDataKDW['total_performance']['sum_sales_revenue_int'] = 0;

        //loop timespan
        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            //initialize datatable connection
            $salesData = DB::connection('mysqlkdwtracking')
            ->table('1und1_mr_tracking_inb_new_ebk')
            // ->whereIn('MA_id', $userids)
            ->whereDate('date', '=', $currentDate)
            ->get();

            //retrieve mobile sales data
            $salesReportDataKDW['daily_performance'][$currentDate]['SSC_RET_Saves']             = $salesData->sum('ret_ssc_contract_save');
            $salesReportDataKDW['daily_performance'][$currentDate]['SSC_PRE_Saves']             = $salesData->sum('prev_ssc_contract_save');
            $salesReportDataKDW['daily_performance'][$currentDate]['BSC_RET_Saves']             = $salesData->sum('ret_bsc_contract_save');
            $salesReportDataKDW['daily_performance'][$currentDate]['BSC_PRE_Saves']             = $salesData->sum('prev_bsc_contract_save');
            $salesReportDataKDW['daily_performance'][$currentDate]['Portal_RET_Saves']          = $salesData->sum('ret_portal_save');
            $salesReportDataKDW['daily_performance'][$currentDate]['Portal_PRE_Saves']          = $salesData->sum('prev_portal_save');
            $salesReportDataKDW['daily_performance'][$currentDate]['Kuerue_Saves']              = $salesData->sum('kuerue_ssc_contract_save')
                                                                                                    + $salesData->sum('kuerue_bsc_contract_save')
                                                                                                    + $salesData->sum('kuerue_portal_contract_save');
            $salesReportDataKDW['daily_performance'][$currentDate]['Sum_Sales']                 = $salesReportDataKDW['daily_performance'][$currentDate]['SSC_RET_Saves']
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['SSC_PRE_Saves']
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['BSC_RET_Saves']
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['BSC_PRE_Saves']
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['Portal_RET_Saves']
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['Portal_PRE_Saves']
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['Kuerue_Saves'];
            $salesReportDataKDW['daily_performance'][$currentDate]['Sum_Calls']                 = $salesData->sum('calls_ssc')
                                                                                                    + $salesData->sum('calls_bsc')
                                                                                                    + $salesData->sum('calls_portal')
                                                                                                    + $salesData->sum('calls_ptb');
            $salesReportDataKDW['daily_performance'][$currentDate]['Revenue_Sales_Sum_int']     = $salesReportDataKDW['daily_performance'][$currentDate]['SSC_RET_Saves'] * $ret_SSC_Revenue
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['SSC_PRE_Saves'] * $pre_SSC_Revenue
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['BSC_RET_Saves'] * $ret_BSC_Revenue
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['BSC_PRE_Saves'] * $pre_BSC_Revenue
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['Portal_RET_Saves'] * $ret_Portal_Revenue
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['Portal_PRE_Saves'] * $pre_Portal_Revenue
                                                                                                    + $salesReportDataKDW['daily_performance'][$currentDate]['Kuerue_Saves'] * $kuerue_Revenue;
            $salesReportDataKDW['daily_performance'][$currentDate]['Revenue_Sales_Sum_string']  = number_format($salesReportDataKDW['daily_performance'][$currentDate]['Revenue_Sales_Sum_int'], 2, ",", ".");
            $salesReportDataKDW['daily_performance'][$currentDate]['Availbench_KDW_int']        = $salesReportDataKDW['daily_performance'][$currentDate]['Sum_Calls'] * 600 / 60 * $availbench_aprrox_minute_price;
            $salesReportDataKDW['daily_performance'][$currentDate]['Availbench_KDW_string']     = number_format($salesReportDataKDW['daily_performance'][$currentDate]['Availbench_KDW_int'], 2, ",", ".");

            if($salesReportDataKDW['daily_performance'][$currentDate]['Sum_Sales'] == 0){
                $salesReportDataKDW['daily_performance'][$currentDate]['Median_Revenue_Sum']    = 0 ;
            }else{
                $salesReportDataKDW['daily_performance'][$currentDate]['Median_Revenue_Sum']    = number_format($salesReportDataKDW['daily_performance'][$currentDate]['Revenue_Sales_Sum_int'] / $salesReportDataKDW['daily_performance'][$currentDate]['Sum_Sales'], 2, ",", ".");
            }
            
            $salesReportDataKDW['daily_performance'][$currentDate]['total_revenue_int'] = $salesReportDataKDW['daily_performance'][$currentDate]['Revenue_Sales_Sum_int'] 
                                                                                            + $salesReportDataKDW['daily_performance'][$currentDate]['Availbench_KDW_int'];
            $salesReportDataKDW['daily_performance'][$currentDate]['total_revenue_string'] = number_format($salesReportDataKDW['daily_performance'][$currentDate]['total_revenue_int'], 2,",",".");
            
            $salesReportDataKDW['total_performance']['sum_revenue_int']             += $salesReportDataKDW['daily_performance'][$currentDate]['total_revenue_int'];
            $salesReportDataKDW['total_performance']['sum_sales_revenue_int']       += $salesReportDataKDW['daily_performance'][$currentDate]['Revenue_Sales_Sum_int'];
            $salesReportDataKDW['total_performance']['total_mobile_sum_sales']      += $salesReportDataKDW['daily_performance'][$currentDate]['Sum_Sales'];
            $salesReportDataKDW['total_performance']['sum_availbench_kdw_int']      += $salesReportDataKDW['daily_performance'][$currentDate]['Availbench_KDW_int'];

        }
        //sum and calculate total variables
        if($salesReportDataKDW['total_performance']['total_mobile_sum_sales'] == 0){
            $salesReportDataKDW['total_performance']['median_revenue_int'] = 0;
        }else{
            $salesReportDataKDW['total_performance']['median_revenue_int'] = $salesReportDataKDW['total_performance']['sum_sales_revenue_int'] / $salesReportDataKDW['total_performance']['total_mobile_sum_sales'];
        }
        $salesReportDataKDW['total_performance']['sum_availbench_kdw_string'] = number_format($salesReportDataKDW['total_performance']['sum_availbench_kdw_int'], 2,",",".");
        $salesReportDataKDW['total_performance']['sum_sales_revenue_string'] = number_format($salesReportDataKDW['total_performance']['sum_sales_revenue_int'], 2,",",".");
    
        //convert final int to string
        $salesReportDataKDW['total_performance']['median_revenue_string'] = number_format($salesReportDataKDW['total_performance']['median_revenue_int'], 2,",",".");
        $salesReportDataKDW['total_performance']['sum_revenue_string'] = number_format($salesReportDataKDW['total_performance']['sum_revenue_int'], 2,",",".");
        
        //return array
        return $salesReportDataKDW;
    }
//MOBILE END

//TELEFONIA START
    public function telefonicaSalesData($defaultVariablesArray){
        //define sales parameters
        $takeRevenue = 90.00 ;

        //define salesDataArray
        $telefonicaSalesDataArray['information']['salesRevenue'] = number_format($takeRevenue, 2,",",".");

        //define cumulative variables
        $telefonicaSalesDataArray['kdwSalesData']['cumulative']['sumTakes'] = 0;
        $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueTakes'] = 0;
        $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenuePerTake'] = 0;
        $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] = 0;

        //loop time span
        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $day = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            $salesData = DB::connection('mysqlkdwtracking')
            ->table('telefonica')
            // ->whereIn('MA_id', $userids)
            ->whereDate('date', '=', $day)
            ->get();

            //daily variables
            $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['sumTakes'] = $salesData->sum('positiv');
            $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueTakes'] = $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['sumTakes'] * $takeRevenue;
            $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueTakesString'] = number_format($telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueTakes'], 2,",",".");
            if($telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['sumTakes'] == 0){
                $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenuePerTake'] = 0;
            } else {
                $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenuePerTake'] = $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueTakes'] / $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['sumTakes'];
            }
            
            $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenuePerTakeString'] = number_format($telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenuePerTake'], 2,",",".");
            //CHANGE ACCORDING TO QUALITYBONUS
            $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] = $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueTakes'];
            $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSumString'] = number_format($telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'], 2,",",".");

            //cumulative variables
            $telefonicaSalesDataArray['kdwSalesData']['cumulative']['sumTakes'] += $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['sumTakes'];
            $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueTakes'] += $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueTakes'];
            $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] += $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'];
        }

        if($telefonicaSalesDataArray['kdwSalesData']['cumulative']['sumTakes'] == 0){
            $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenuePerTake'] = 0;
        } else {
            $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenuePerTake'] = $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueTakes'] / $telefonicaSalesDataArray['kdwSalesData']['cumulative']['sumTakes'];
        }

        $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueTakesString'] = number_format($telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueTakes'], 2,",",".");
        $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenuePerTakeString'] = number_format($telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenuePerTake'], 2,",",".");
        $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSumString'] = number_format($telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'], 2,",",".");

        return $telefonicaSalesDataArray;
    }

    public function telefonicaCoreData($defaultVariablesArray, $telefonicaSalesDataArray, $telefonicaWorktimeArray){
        if($telefonicaWorktimeArray['cumulative']['paid_hours_int'] == 0) {
            $telefonicaCoreDataArray['cumulative']['revenuePaidHour'] = 0;
        } else {
            $telefonicaCoreDataArray['cumulative']['revenuePaidHour'] = $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $telefonicaWorktimeArray['cumulative']['paid_hours_int'];
        }
        $telefonicaCoreDataArray['cumulative']['revenuePaidHourString'] = number_format($telefonicaCoreDataArray['cumulative']['revenuePaidHour'], 2,",",".");
        $telefonicaCoreDataArray['cumulative']['revenueDelta'] = $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] - $telefonicaWorktimeArray['cumulative']['revenue_should_int'];
        $telefonicaCoreDataArray['cumulative']['revenueDeltaString'] = number_format($telefonicaCoreDataArray['cumulative']['revenueDelta'], 2,",",".");
        if($telefonicaWorktimeArray['cumulative']['revenue_should_int'] == 0) {
            $telefonicaCoreDataArray['cumulative']['attainmeint'] = 0;
        } else {
            $telefonicaCoreDataArray['cumulative']['attainmeint'] = ($telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $telefonicaWorktimeArray['cumulative']['revenue_should_int']) * 100;
        }
        $telefonicaCoreDataArray['cumulative']['attainmeintString'] = number_format($telefonicaCoreDataArray['cumulative']['attainmeint'], 2,",",".");

        $telefonicaCoreDataArray['overview']['revenueShould'] = $telefonicaWorktimeArray['cumulative']['fte_medium_int'] * 173 * $defaultVariablesArray['revenue_hour_should']['telefonica_outbound'] * $defaultVariablesArray['industrial_months'];
        $telefonicaCoreDataArray['overview']['revenueShouldString'] = number_format($telefonicaCoreDataArray['overview']['revenueShould'], 2,",",".");
        $telefonicaCoreDataArray['overview']['revenueDelta'] = $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] - $telefonicaCoreDataArray['overview']['revenueShould'];
        $telefonicaCoreDataArray['overview']['revenueDeltaString'] = number_format($telefonicaCoreDataArray['overview']['revenueDelta'], 2,",",".");
        if($telefonicaCoreDataArray['overview']['revenueShould'] == 0) {
            $telefonicaCoreDataArray['overview']['attainment'] = 0;
        } else {
            $telefonicaCoreDataArray['overview']['attainment'] = ($telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] / $telefonicaCoreDataArray['overview']['revenueShould']) * 100;
        }
        $telefonicaCoreDataArray['overview']['attainmentString'] = number_format($telefonicaCoreDataArray['overview']['attainment'], 2,",",".");
        if ($telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'] == 0){
            $telefonicaCoreDataArray['overview']['db2'] = 0;
        } else {
            $telefonicaCoreDataArray['overview']['db2'] = (1 - ($telefonicaCoreDataArray['overview']['revenueShould'] / $telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSum'])) * 100;
        }
        $telefonicaCoreDataArray['overview']['db2String'] = number_format($telefonicaCoreDataArray['overview']['db2'], 2,",",".");

        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){
            $day = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            if($telefonicaWorktimeArray[$day]['work_hours'] == 0){
                $telefonicaCoreDataArray['daily'][$day]['revenuePaidHour'] = 0;
            } else {
            $telefonicaCoreDataArray['daily'][$day]['revenuePaidHour'] = ($telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] / $telefonicaWorktimeArray[$day]['work_hours']);
            }
            $telefonicaCoreDataArray['daily'][$day]['revenuePaidHourString'] = number_format($telefonicaCoreDataArray['daily'][$day]['revenuePaidHour'], 2,",",".");
            $telefonicaCoreDataArray['daily'][$day]['revenueDelta'] = $telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] - $telefonicaWorktimeArray[$day]['revenue_should_int'];
            $telefonicaCoreDataArray['daily'][$day]['revenueDeltaString'] = number_format($telefonicaCoreDataArray['daily'][$day]['revenueDelta'], 2,",",".");
            if ($telefonicaWorktimeArray[$day]['revenue_should_int'] == 0) {
                $telefonicaCoreDataArray['daily'][$day]['attainmeint'] = 0;
            } else {
            $telefonicaCoreDataArray['daily'][$day]['attainmeint'] = ($telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSum'] / $telefonicaWorktimeArray[$day]['revenue_should_int']) * 100;
            }
            $telefonicaCoreDataArray['daily'][$day]['attainmeintString'] = number_format($telefonicaCoreDataArray['daily'][$day]['attainmeint'], 2,",",".");
        }

        //dd($telefonicaCoreDataArray);
        return $telefonicaCoreDataArray;
    }
//TELEFONIA END

//ALL START
    public function allCoreData(){

    }
//ALL END

//GENERAL FUNCTIONS START
    public function worktimeReport($defaultVariablesArray, $revenueShouldHour, $projectID){
        //get all employee id's from project
        $projectMA = DB::connection('mysqlkdw')
        ->table('MA')
        ->where('projekt_id', '=', $projectID)
        ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
        ->pluck('ds_id');

        //initialize data containing array
        $worktimeArray = array(); 
        $worktimeArray['cumulative']['fte_sum_int'] = 0;
        $worktimeArray['cumulative']['paid_hours_int'] = 0;
        $worktimeArray['cumulative']['revenue_should_int'] = 0;

        //loop full timespan
        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){

            //set $currentDate according to loop
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

            $s = $i -1;
            $currentDateMinusOne = date('Y-m-d', strtotime($currentDate. '- 1 days'));
            //get worktime
            $worktimeData = DB::connection('mysqlkdw')
            ->table('chronology_work')
            ->whereDate('work_date', '=', $currentDate)
            ->where(function($query){ //filter for unpayed status
                $query
                ->where('state_id', null)
                ->orWhereNotIn('state_id', array(13, 15, 16, 24));
            })
            ->whereIn('MA_id', $projectMA) //filter for project
            ->get();

            $worktimeArray[$currentDate]['work_hours'] = $worktimeData->sum('work_hours');
            $worktimeArray[$currentDate]['work_hours_string'] = number_format($worktimeArray[$currentDate]['work_hours'],2,",",".");
            $worktimeArray[$currentDate]['revenue_should_int'] = $worktimeArray[$currentDate]['work_hours'] * $revenueShouldHour;
            $worktimeArray[$currentDate]['revenue_should_string'] = number_format($worktimeArray[$currentDate]['revenue_should_int'],2,",",".");

            $unproductiveEmployees = DB::connection('mysqlkdw') //Gives back an Array with all unproductive employees on a given date
            ->table('history_state')
            ->where(function($query) use($currentDate){
                $query
                ->where('date_begin', '<=', $currentDate)
                ->where('date_end', '>=', $currentDate);
            })
            ->where(function($query){
                $query
                ->where('state_id', '=', 13) //"Krank o.Lfz"
                ->orWhere('state_id', '=', 15) //"Mutterschutz"
                ->orWhere('state_id', '=', 16) //"Erziehungsurlaub"
                ->orWhere('state_id', '=', 24); //"Beschäftigungsverbot"
            })
            ->whereIn('agent_ds_id', $projectMA)
            ->pluck('agent_ds_id');


            //Get FTE Data
            $FTEData = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('projekt_id', '=', $projectID)
            ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
            ->whereDate('eintritt', '<=', $currentDate)
            ->where(function($query) use ($currentDate){
                $query
                ->where('austritt', '=', null)
                ->orWhere('austritt', '>', $currentDate);
            })
            ->whereNotIn('ds_id', $unproductiveEmployees)
            ->get();

            $worktimeArray[$currentDate]['contract_hours'] = $FTEData->sum('soll_h_day');
            $worktimeArray[$currentDate]['heads'] = $FTEData->count('soll_h_day');
            $worktimeArray[$currentDate]['FTE_int'] = $worktimeArray[$currentDate]['contract_hours'] * 5 / 40;
            $worktimeArray[$currentDate]['FTE_string'] = number_format($worktimeArray[$currentDate]['contract_hours'] * 5 / 40, 3,",",".");

            $worktimeArray['cumulative']['fte_sum_int'] += $worktimeArray[$currentDate]['FTE_int'];
            $worktimeArray['cumulative']['paid_hours_int'] += $worktimeArray[$currentDate]['work_hours'];
            $worktimeArray['cumulative']['revenue_should_int'] += $worktimeArray[$currentDate]['revenue_should_int'];

            //get employment
            $employmentData = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('projekt_id', '=', $projectID) 
            ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
            ->whereDate('eintritt', '=', $currentDate)
            ->get();

            foreach($employmentData as $user)
            {
                $worktimeArray[$currentDate]['employment'][] = $user->agent_id;
            }

            //unemployment
            $unemploymentData = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('projekt_id', '=', $projectID) 
            ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
            ->whereDate('austritt', '=', $currentDate)
            ->get();

            foreach($unemploymentData as $user)
            {
                $worktimeArray[$currentDate]['unemployment'][] = $user->agent_id;
            }

            //get unproductive employees on given date
            $unproductiveEmployeesExtended = DB::connection('mysqlkdw') 
            ->table('history_state')
            ->where(function($query) use($currentDate, $currentDateMinusOne){
                $query
                ->where('date_begin', '=', $currentDate)
                ->orWhere('date_end', '=', $currentDateMinusOne);
            })
            ->where(function($query){
                $query
                ->where('state_id', '=', 13) //"Krank o.Lfz"
                ->orWhere('state_id', '=', 15) //"Mutterschutz"
                ->orWhere('state_id', '=', 16) //"Erziehungsurlaub"
                ->orWhere('state_id', '=', 24); //"Beschäftigungsverbot"
            })
            ->whereIn('agent_ds_id', $projectMA)
            ->get();

            foreach($unproductiveEmployeesExtended as $user){
                if($user->date_begin == $currentDate){
                    if($user->state_id == 13){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Start Krank o. Lfz: ' . $user->agent_id;
                    }
                    if($user->state_id == 15){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Start Mutterschutz: ' . $user->agent_id;
                    }
                    if($user->state_id == 16){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Start Erziehungsurlaub: ' . $user->agent_id;
                    }
                    if($user->state_id == 24){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Start Beschäftigungsverbot: ' . $user->agent_id;
                    }
                }
                if($user->date_end == $currentDateMinusOne){
                    if($user->state_id == 13){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Ende Krank o. Lfz: ' . $user->agent_id;
                    }
                    if($user->state_id == 15){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Ende Mutterschutz: ' . $user->agent_id;
                    }
                    if($user->state_id == 16){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Ende Erziehungsurlaub: ' . $user->agent_id;
                    }
                    if($user->state_id == 24){
                        $worktimeArray[$currentDate]['unproductive'][] = 'Ende Beschäftigungsverbot: ' . $user->agent_id;
                    }
                }
            }
        }
        
        $worktimeArray['cumulative']['paid_hours_string'] = number_format($worktimeArray['cumulative']['paid_hours_int'], 2,",",".");
        $worktimeArray['cumulative']['revenue_should_string'] = number_format($worktimeArray['cumulative']['revenue_should_int'], 2,",",".");
        $worktimeArray['cumulative']['fte_medium_int'] = $worktimeArray['cumulative']['fte_sum_int'] / ($defaultVariablesArray['difference_date'] + 1);
        $worktimeArray['cumulative']['fte_medium_string'] = number_format($worktimeArray['cumulative']['fte_medium_int'], 3,",",".");


        //dd($worktimeArray);

        return $worktimeArray;
    }
//GENERAL FUNCTIONS END
}
