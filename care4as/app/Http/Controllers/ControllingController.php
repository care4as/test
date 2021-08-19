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

        //$tag = '02';
        //$startdate2 = date_create('2021-08' . '-' . $tag);
        //dd($startdate2);

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
            'enddate' => $endDateString
        );

        for($i=0; $i <= $differenceDate; $i++){
            $currentDate = date('Y-m-d', strtotime($startDate. '+ '.$i.' days'));
            $defaultVariablesArray['days'][] = $currentDate;
        }

        //retrive data depending on choosen project
        if ($project == '1u1_mobile_retention') {
            $mobileSalesDataArray = $this->mobileSalesReportKDW($startDate, $endDate, $differenceDate);
            $mobileWorktimeArray = $this->mobileWorktimeReport($startDate, $endDate, $differenceDate);
            $mobileCoreDataArray = $this->mobileCoreData($startDate, $endDate, $differenceDate, $mobileSalesDataArray, $mobileWorktimeArray);
        } else {
            $mobileSalesDataArray = 0;
            $mobileWorktimeArray = 0;
            $mobileCoreDataArray = 0;
        }

        //dd($mobileWorktimeArray);

        return view('umsatzmeldung', compact('defaultVariablesArray', 'mobileSalesDataArray', 'mobileWorktimeArray', 'mobileCoreDataArray'));
    }
    public function mobileCoreData($startDate, $endDate, $differenceDate, $mobileSalesDataArray, $mobileWorktimeArray){
        //dd($mobileWorktimeArray);
        $medianFTE = array_sum(array_column($mobileWorktimeArray, 'FTE_int')) / count($mobileWorktimeArray);

       
        $mobileCoreDataArray = array(
            'sum_FTE_int' => array_sum(array_column($mobileWorktimeArray, 'FTE_int')),
            'median_FTE_string' => number_format($medianFTE, 3,",","."),
            'sum_work_hours_int' => array_sum(array_column($mobileWorktimeArray, 'work_hours')),
            'sum_work_hours_string' => number_format(array_sum(array_column($mobileWorktimeArray, 'work_hours')), 2,",","."),
            'sum_revenue_should_int' => array_sum(array_column($mobileWorktimeArray, 'revenue_should_int')),
            'sum_revenue_should_string' => number_format(array_sum(array_column($mobileWorktimeArray, 'revenue_should_int')), 2,",","."),
            'revenue_should_int' => $medianFTE * 173 * 35,
            'revenue_should_string' => number_format($medianFTE * 173 * 35, 2,",",".")
        );


        //dd($mobileSalesDataArray);
        $mobileCoreDataArray['revenue_delta_int'] = $mobileSalesDataArray[0]['total_performance']['sum_total_revenue_int'] - $mobileCoreDataArray['revenue_should_int']; 
        $mobileCoreDataArray['revenue_delta_string'] = number_format($mobileCoreDataArray['revenue_delta_int'], 2,",",".");
        $mobileCoreDataArray['db2_int'] = (1 - ($mobileCoreDataArray['revenue_should_int'] / $mobileSalesDataArray[0]['total_performance']['sum_total_revenue_int']))*100;
        $mobileCoreDataArray['db2_string'] = number_format($mobileCoreDataArray['db2_int'], 2,",",".");
        $mobileCoreDataArray['attainment_int'] = $mobileSalesDataArray[0]['total_performance']['sum_total_revenue_int'] / $mobileCoreDataArray['revenue_should_int'] * 100;
        $mobileCoreDataArray['attainment_string'] = number_format($mobileCoreDataArray['attainment_int'], 2,",",".");

        for($i=0; $i <= $differenceDate; $i++){
            $currentDate = date('Y-m-d', strtotime($startDate. '+ '.$i.' days'));
            if($mobileWorktimeArray[$currentDate]['revenue_should_int'] == 0){
                $mobileCoreDataArray['daily_performance'][$currentDate]['attainment_int'] = 0;
            }
            else{
                $mobileCoreDataArray['daily_performance'][$currentDate]['attainment_int'] = ($mobileSalesDataArray[0]['daily_performance'][$currentDate]['total_revenue_int'] / $mobileWorktimeArray[$currentDate]['revenue_should_int']) * 100;
            }   
            $mobileCoreDataArray['daily_performance'][$currentDate]['attainment_string'] = number_format($mobileCoreDataArray['daily_performance'][$currentDate]['attainment_int'], 2,",",".");
            $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_delta_int'] = $mobileSalesDataArray[0]['daily_performance'][$currentDate]['total_revenue_int'] - $mobileWorktimeArray[$currentDate]['revenue_should_int'];
            $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_delta_string'] = number_format($mobileCoreDataArray['daily_performance'][$currentDate]['revenue_delta_int'], 2,",",".");
            if ($mobileWorktimeArray[$currentDate]['work_hours'] == 0){
                $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_int'] = 0;
            }
            else{
                $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_int'] = $mobileSalesDataArray[0]['daily_performance'][$currentDate]['total_revenue_int'] / $mobileWorktimeArray[$currentDate]['work_hours'];
            };
            $mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_string'] = number_format($mobileCoreDataArray['daily_performance'][$currentDate]['revenue_payed_hour_int'], 2,",",".");
        }

        // $mobileSalesDataArray[0]['total_performance']['sum_total_revenue_int'] <-- Umsatz IST
        // $mobileCoreDataArray['sum_revenue_should_int']  <-- Umsatz SOLL
        // $mobileCoreDataArray['sum_work_hours_int'] <-- Std. bezahlt



        $mobileCoreDataArray['duration_revenue_payed_hour_int'] = $mobileSalesDataArray[0]['total_performance']['sum_total_revenue_int'] / $mobileCoreDataArray['sum_work_hours_int'];
        $mobileCoreDataArray['duration_revenue_payed_hour_string'] = number_format($mobileCoreDataArray['duration_revenue_payed_hour_int'], 2,",",".");
        $mobileCoreDataArray['duration_attainment_int'] = ($mobileSalesDataArray[0]['total_performance']['sum_total_revenue_int'] / $mobileCoreDataArray['sum_revenue_should_int']) * 100;
        $mobileCoreDataArray['duration_attainment_string'] = number_format($mobileCoreDataArray['duration_attainment_int'], 2,",",".");
        $mobileCoreDataArray['duration_revenue_delta_int'] = $mobileSalesDataArray[0]['total_performance']['sum_total_revenue_int'] - $mobileCoreDataArray['sum_revenue_should_int'];
        $mobileCoreDataArray['duration_revenue_delta_string'] = number_format($mobileCoreDataArray['duration_revenue_delta_int'], 2,",",".");

        
        //dd($mobileWorktimeArray);
        //dd($mobileCoreDataArray);
        return $mobileCoreDataArray;
    }


    public function mobileWorktimeReport($startDate, $endDate, $differenceDate){
        
        $revenue_should_hour = 35; 

        $mobileProjectMA = DB::connection('mysqlkdw')
        ->table('MA')
        ->where('projekt_id', '=', 7) //7: Project-ID for Mobile Retention
        ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
        ->pluck('ds_id');

        $mobileWorktimeSumData = array(); 

        for($i=0; $i <= $differenceDate; $i++){

            $currentDate = date('Y-m-d', strtotime($startDate. '+ '.$i.' days'));

            //Get WorktimeData
            $mobileWorktimeData = DB::connection('mysqlkdw')
            ->table('chronology_work')
            ->whereDate('work_date', '=', $currentDate)
            ->where(function($query){
                $query
                ->where('state_id', null)
                ->orWhereNotIn('state_id', array(13, 15, 16, 24));
            })
            ->whereIn('MA_id', $mobileProjectMA)
            ->get();

            $mobileWorktimeSumData[$currentDate]['work_hours'] = $mobileWorktimeData->sum('work_hours');
            $mobileWorktimeSumData[$currentDate]['work_hours_string'] = number_format($mobileWorktimeSumData[$currentDate]['work_hours'],2,",",".");
            $mobileWorktimeSumData[$currentDate]['revenue_should_int'] = $mobileWorktimeSumData[$currentDate]['work_hours'] * $revenue_should_hour;
            $mobileWorktimeSumData[$currentDate]['revenue_should_string'] = number_format($mobileWorktimeSumData[$currentDate]['revenue_should_int'],2,",",".");

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
            ->whereIn('agent_ds_id', $mobileProjectMA)
            ->pluck('agent_ds_id');

            //Get FTE Data
            $mobileFTEData = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('projekt_id', '=', 7) //7: Project-ID for Mobile Retention
            ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
            ->whereDate('eintritt', '<=', $currentDate)
            ->where(function($query) use ($currentDate){
                $query
                ->where('austritt', '=', null)
                ->orWhere('austritt', '>', $currentDate);
            })
            ->whereNotIn('ds_id', $unproductiveEmployees)
            ->get();

            //dd($mobileFTEData);

            $mobileWorktimeSumData[$currentDate]['contract_hours'] = $mobileFTEData->sum('soll_h_day');
 
            $mobileWorktimeSumData[$currentDate]['heads'] = $mobileFTEData->count('soll_h_day');
            $mobileWorktimeSumData[$currentDate]['FTE_int'] = $mobileWorktimeSumData[$currentDate]['contract_hours'] * 5 / 40;
            $mobileWorktimeSumData[$currentDate]['FTE_string'] = number_format($mobileWorktimeSumData[$currentDate]['contract_hours'] * 5 / 40, 3,",",".");


            //get employment
            $mobileEmploymentData = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('projekt_id', '=', 7) //7: Project-ID for Mobile Retention
            ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
            ->whereDate('eintritt', '=', $currentDate)
            ->get();

            foreach($mobileEmploymentData as $user)
            {
                $mobileWorktimeSumData[$currentDate]['employment'][] = $user->vorname . ' ' . $user->familienname;
            }

            //unemployment
            $mobileUnemploymentData = DB::connection('mysqlkdw')
            ->table('MA')
            ->where('projekt_id', '=', 7) //7: Project-ID for Mobile Retention
            ->where('abteilung_id', '=', 10) //10: Department-ID for Agents
            ->whereDate('austritt', '=', $currentDate)
            ->get();

            foreach($mobileUnemploymentData as $user)
            {
                $mobileWorktimeSumData[$currentDate]['unemployment'][] = $user->vorname . ' ' . $user->familienname;
            }
        }

        return $mobileWorktimeSumData;
    }



    public function mobileSalesReportKDW($startDate, $endDate, $differenceDate){
        //Default variables
        $total_mobile_sum_sales = 0;
        $total_mobile_sum_revenue = 0;
        $sum_availbench_kdw_int = 0;
        $sum_total_revenue_int = 0;

        if(request('startDate') && request('endDate'))
        {

        $currentDate = $startDate;

        for($i=0; $i <= $differenceDate; $i++){

            $currentDate = date('Y-m-d', strtotime($startDate. '+ '.$i.' days'));

            $mobileSalesData = DB::connection('mysqlkdwtracking')
            ->table('1und1_mr_tracking_inb_new_ebk')
            // ->whereIn('MA_id', $userids)
            ->whereDate('date', '=', $currentDate)
            ->get();
    
            $salesData = $mobileSalesData;

            $ret_ssc_contract_save = $salesData->sum('ret_ssc_contract_save');
            $ret_bsc_contract_save = $salesData->sum('ret_bsc_contract_save');
            $ret_portal_save = $salesData->sum('ret_portal_save');
            $prev_ssc_contract_save = $salesData->sum('prev_ssc_contract_save');
            $prev_bsc_contract_save = $salesData->sum('prev_bsc_contract_save');
            $prev_portal_save = $salesData->sum('prev_portal_save');
            $kuerue_ssc_contract_save = $salesData->sum('kuerue_ssc_contract_save');
            $kuerue_bsc_contract_save = $salesData->sum('kuerue_bsc_contract_save');
            $kuerue_portal_save = $salesData->sum('kuerue_portal_save');
            $calls_ssc = $salesData->sum('calls_ssc');
            $calls_bsc = $salesData->sum('calls_bsc');
            $calls_portal = $salesData->sum('calls_portal');
            $calls_ptb = $salesData->sum('calls_ptb');

            $sum_ssc_ret_saves = $ret_ssc_contract_save + $ret_portal_save;
            $sum_ssc_pre_saves = $prev_ssc_contract_save + $prev_portal_save;
            $sum_kuerue_saves = $kuerue_ssc_contract_save + $kuerue_bsc_contract_save + $kuerue_portal_save;
            $sum_sales = $ret_ssc_contract_save + $ret_bsc_contract_save + $ret_portal_save + $prev_ssc_contract_save + $prev_bsc_contract_save + $prev_portal_save + $sum_kuerue_saves;
            $revenue_sales = $ret_ssc_contract_save * 16 + $ret_bsc_contract_save * 11 + $ret_portal_save * 16 + $prev_ssc_contract_save * 12.5 + $prev_bsc_contract_save * 8.5 + $prev_portal_save * 12.5 + $sum_kuerue_saves * 5;
            $revenue_sales_sum = $revenue_sales;
            if ($sum_sales == 0) {
                $median_revenue_sales = 0;
            } else {
                $median_revenue_sales = $revenue_sales / $sum_sales;
            }
            $sum_calls = $calls_ssc + $calls_bsc + $calls_portal + $calls_ptb;
            
            $median_revenue_sum = number_format($median_revenue_sales, 2,",",".");
            $revenue_sales_sum = number_format($revenue_sales_sum, 2,",",".");

            $total_mobile_sum_sales += $sum_sales;
            $total_mobile_sum_revenue += $revenue_sales;


            $mobileSalesDataArray['daily_performance'][$currentDate] = array(
                'SSC_RET_Saves' => $ret_ssc_contract_save,
                'SSC_PRE_Saves' => $prev_ssc_contract_save,
                'Portal_RET_Saves' => $ret_portal_save,
                'Portal_PRE_Saves' => $prev_portal_save,
                'BSC_RET_Saves' => $ret_bsc_contract_save,
                'BSC_PRE_Saves' => $prev_bsc_contract_save,
                'Kuerue_Saves' => $sum_kuerue_saves,
                'Sum_Sales' => $sum_sales,
                'Median_Revenue_Sum' => $median_revenue_sum,
                'Revenue_Sales_Sum' => $revenue_sales_sum,
                'Sum_Calls' => $sum_calls,
                'Availbench_KDW_int' => $sum_calls*600/60*0.42,
                'Availbench_KDW_string' => number_format($sum_calls*600/60*0.42, 2,",",".")
            );

            $mobileSalesDataArray['daily_performance'][$currentDate]['total_revenue_int'] = $revenue_sales + $mobileSalesDataArray['daily_performance'][$currentDate]['Availbench_KDW_int'];
            $mobileSalesDataArray['daily_performance'][$currentDate]['total_revenue_string'] = number_format($mobileSalesDataArray['daily_performance'][$currentDate]['total_revenue_int'], 2,",",".");
            
            $sum_availbench_kdw_int += $mobileSalesDataArray['daily_performance'][$currentDate]['Availbench_KDW_int'];
            $sum_total_revenue_int += $mobileSalesDataArray['daily_performance'][$currentDate]['total_revenue_int'];
        }
        

    }
    else{
        $mobileSalesDataArray = array();
    }
        //Calculate variables spanning full period
        if ($total_mobile_sum_sales == 0) {
            $total_mobile_median_revenue = 0;
        } else {
            $total_mobile_median_revenue = $total_mobile_sum_revenue / $total_mobile_sum_sales;
        }
        $total_mobile_median_revenue = number_format($total_mobile_median_revenue, 2,",","."); //Calculting variabe and converting sum(int) -> string
        $total_mobile_sum_revenue = number_format($total_mobile_sum_revenue, 2,",","."); //Converting sum(int) -> string


        $mobileSalesDataArray['total_performance']['total_mobile_median_revenue'] = $total_mobile_median_revenue;
        $mobileSalesDataArray['total_performance']['total_mobile_sum_revenue'] = $total_mobile_sum_revenue;
        $mobileSalesDataArray['total_performance']['total_mobile_sum_sales'] = $total_mobile_sum_sales;
        $mobileSalesDataArray['total_performance']['sum_availbench_kdw_int'] = $sum_availbench_kdw_int;
        $mobileSalesDataArray['total_performance']['sum_availbench_kdw_string'] = number_format($sum_availbench_kdw_int, 2,",",".");
        $mobileSalesDataArray['total_performance']['sum_total_revenue_int'] = $sum_total_revenue_int;
        $mobileSalesDataArray['total_performance']['sum_total_revenue_string'] = number_format($sum_total_revenue_int, 2,",",".");

        return $dataArray = array($mobileSalesDataArray);
    }
}
