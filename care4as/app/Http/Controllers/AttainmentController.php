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
        if( $defaultVariablesArray['attainment'] == 'wfm_dsl_availbench'){
            $attainmentArray = $this->wfmDslAttainment($defaultVariablesArray);
        }

        //dd($attainmentArray);
        return view('attainment', compact('defaultVariablesArray', 'attainmentArray'));
    }

    public function wfmDslAttainment($defaultVariablesArray){
        $wfmDslArray = $this->getDateIntervalList($defaultVariablesArray);

        return $wfmDslArray;
    }

    /** creates an array containing each day and 48 intervalls */
    public function getDateIntervalList($defaultVariablesArray){
        $dateList = array();
        
        for($i=0; $i <= $defaultVariablesArray['differenceDate']; $i++){
            $currentDate = date('Y-m-d', strtotime($defaultVariablesArray['startDate']. '+ '.$i.' days'));

            for($j=0; $j<24; $j++){
                $dateList[$currentDate]['europeanDate'] = date('d.m.Y', strtotime($currentDate));
                $dateList[$currentDate]['interval'][$j . ':00'] = null;
                $dateList[$currentDate]['interval'][$j . ':30'] = null;
            }

        }

        return $dateList;
    }

    public function getWorkforcer($defaultVariablesArray, $projectId){
        $defaultVariablesArray['workforcer'] = $this->getWorkforcer($defaultVariablesArray);
    }

}

