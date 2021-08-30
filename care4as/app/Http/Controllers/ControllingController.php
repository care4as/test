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
        if ($project == '1u1_mobile_retention') {
            //$mobileSalesDataArray = $this->mobileSalesReportKDW($startDate, $endDate, $differenceDate);
            $mobileSalesDataArray = $this->mobileSalesReportKDW($defaultVariablesArray);
            $mobileWorktimeArray = $this->worktimeReport($defaultVariablesArray, $defaultVariablesArray['revenue_hour_should']['1u1_mobile_retention'], $defaultVariablesArray['project_id']['1u1_mobile_retention']); //(x, y, z, revenue/hour, project id)
            $mobileCoreDataArray = $this->mobileCoreData($mobileSalesDataArray, $mobileWorktimeArray, $defaultVariablesArray);
        } else {
            $mobileSalesDataArray = 0;
            $mobileWorktimeArray = 0;
            $mobileCoreDataArray = 0;
        }

        if ($project == '1u1_terminationadministration') {
            $terminationSalesDataArray = 0;
            $terminationWorktimeArray = $this->worktimeReport($defaultVariablesArray, $defaultVariablesArray['revenue_hour_should']['1u1_terminationadministration'], $defaultVariablesArray['project_id']['1u1_terminationadministration']); //(x, y, z, revenue/hour, project id)
            $terminationCoreDataArray = 0;
        } else {
            $terminationSalesDataArray = 0;
            $terminationWorktimeArray = 0;
            $terminationCoreDataArray = 0;
        }
        //dd($defaultVariablesArray);
        return view('umsatzmeldung', compact('defaultVariablesArray', 'mobileSalesDataArray', 'mobileWorktimeArray', 'mobileCoreDataArray', 'terminationSalesDataArray', 'terminationWorktimeArray', 'terminationCoreDataArray'));
        
    }


    
//TERMINATION START
//TERMINATION END

//MOBILE START
    public function mobileCoreData($mobileSalesDataArray, $mobileWorktimeArray, $defaultVariablesArray){
        $medianFTE = array_sum(array_column($mobileWorktimeArray, 'FTE_int')) / count($mobileWorktimeArray);

        $mobileCoreDataArray = array(
            'sum_FTE_int' => array_sum(array_column($mobileWorktimeArray, 'FTE_int')),
            'median_FTE_string' => number_format($medianFTE, 3,",","."),
            'sum_work_hours_int' => array_sum(array_column($mobileWorktimeArray, 'work_hours')),
            'sum_work_hours_string' => number_format(array_sum(array_column($mobileWorktimeArray, 'work_hours')), 2,",","."),
            'sum_revenue_should_int' => array_sum(array_column($mobileWorktimeArray, 'revenue_should_int')),
            'sum_revenue_should_string' => number_format(array_sum(array_column($mobileWorktimeArray, 'revenue_should_int')), 2,",","."),
            'revenue_should_int' => $medianFTE * 173 * $defaultVariablesArray['revenue_hour_should']['1u1_mobile_retention'] * $defaultVariablesArray['industrial_months'],
            'revenue_should_string' => number_format($medianFTE * 173 * $defaultVariablesArray['revenue_hour_should']['1u1_mobile_retention'] * $defaultVariablesArray['industrial_months'], 2,",",".")
        );


        //dd($mobileSalesDataArray);
        $mobileCoreDataArray['revenue_delta_int'] = $mobileSalesDataArray['total_performance']['sum_revenue_int'] - $mobileCoreDataArray['revenue_should_int']; 
        $mobileCoreDataArray['revenue_delta_string'] = number_format($mobileCoreDataArray['revenue_delta_int'], 2,",",".");
        $mobileCoreDataArray['db2_int'] = (1 - ($mobileCoreDataArray['revenue_should_int'] / $mobileSalesDataArray['total_performance']['sum_revenue_int']))*100;
        $mobileCoreDataArray['db2_string'] = number_format($mobileCoreDataArray['db2_int'], 2,",",".");
        $mobileCoreDataArray['attainment_int'] = $mobileSalesDataArray['total_performance']['sum_revenue_int'] / $mobileCoreDataArray['revenue_should_int'] * 100;
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

        //loop full timespan
        for($i=0; $i <= $defaultVariablesArray['difference_date']; $i++){

            //set $currentDate according to loop
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startdate']. '+ '.$i.' days'));

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


            //get employment
            $employmentData = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('projekt_id', '=', $projectID) 
            ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
            ->whereDate('eintritt', '=', $currentDate)
            ->get();

            foreach($employmentData as $user)
            {
                $worktimeArray[$currentDate]['employment'][] = $user->vorname . ' ' . $user->familienname;
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
                $worktimeArray[$currentDate]['unemployment'][] = $user->vorname . ' ' . $user->familienname;
            }
        }
        return $worktimeArray;
    }
//GENERAL FUNCTIONS END
}
