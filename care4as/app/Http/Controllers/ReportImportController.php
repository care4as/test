<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReportImportController extends Controller
{
    public function loadtest(){

        /** request variables from userform */
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
            'startDate' => $startDateString,
            'endDate' => $endDateString,
            'differenceDate' => $differenceDate,
            'startDatePHP' => $startDate,
            'endDatePHP' => $endDate,
            'recordFilterSet' => 'false',
        );

        $datatablesDates = null;

        if($startDate != null && $endDate != null && $endDate > $startDate){
            $defaultVariablesArray['recordFilterSet'] = 'true';
            $datatablesDates = $this->getDatatableDates($defaultVariablesArray);
        } else if (
            ($startDate != null && $endDate == null)
            || ($startDate == null && $endDate != null)
            || ($endDate < $startDate)
        ) {
            $defaultVariablesArray['recordFilterSet'] = 'error';
        }

        $dataTables = DB::table('datatables_timespan')
        ->get()
        ->toArray();

        $refinedDataTables = array();

        foreach($dataTables as $key => $entry){
            $entry = (array) $entry;
            $refinedDataTables[$entry['data_table']]['min_date'] = date_format(date_create_from_format('Y-m-d', $entry['min_date']), 'd.m.Y');
            $refinedDataTables[$entry['data_table']]['max_date'] = date_format(date_create_from_format('Y-m-d', $entry['max_date']), 'd.m.Y');
        }
        // dd($defaultVariablesArray);
        return view('reports.reportImport', compact('refinedDataTables', 'defaultVariablesArray', 'datatablesDates'));
    }

    public function getDatatableDates($defaultVariablesArray){
        //$defaultVariablesArray['startDate'] = date_format(date_create_from_format('Y-m-d', $defaultVariablesArray['startDate']), 'd.m.Y');
        //$defaultVariablesArray['endDate'] = date_format(date_create_from_format('Y-m-d', $defaultVariablesArray['endDate']), 'd.m.Y');
        $availbenchData = $this->getAvailbench($defaultVariablesArray);
        $dailyAgentData = $this->getDailyAgent($defaultVariablesArray);
        $optInData = $this->getOptin($defaultVariablesArray);
        $retentionDetailsData = $this->getRetDetails($defaultVariablesArray);
        $sasData = $this->getSas($defaultVariablesArray);

        $dataTables = array();

        for($i = 0; $i <= $defaultVariablesArray['differenceDate']; $i++){
            $day = date('Y-m-d', strtotime($defaultVariablesArray['startDate']. '+ '.$i.' days'));

            $dataTables[$day]['availbench'] = 'false';
            $dataTables[$day]['daily_agent'] = 'false';
            $dataTables[$day]['optin'] = 'false';
            $dataTables[$day]['retention_details'] = 'false';
            $dataTables[$day]['sas'] = 'false';

            foreach($availbenchData as $key => $entry){
                if($entry['date_date'] == $day){
                    $dataTables[$day]['availbench'] = 'true';
                }
            }
            foreach($dailyAgentData as $key => $entry){
                if($entry == $day){
                    $dataTables[$day]['daily_agent'] = 'true';
                }
            }
            foreach($optInData as $key => $entry){
                if($entry == $day){
                    $dataTables[$day]['optin'] = 'true';
                }
            }
            foreach($retentionDetailsData as $key => $entry){
                if($entry['call_date'] == $day){
                    $dataTables[$day]['retention_details'] = 'true';
                }
            }
            foreach($sasData as $key => $entry){
                if($entry['date'] == $day){
                    $dataTables[$day]['sas'] = 'true';
                }
            }
        }

        return $dataTables;
    }

    public function getRetDetails($defaultVariablesArray){
        $data = DB::table('retention_details')
        ->where('call_date', '>=', $defaultVariablesArray['startDate'])
        ->where('call_date', '<=', $defaultVariablesArray['endDate'])
        ->distinct()
        ->get('call_date')
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }

    public function getOptin($defaultVariablesArray){
        $data = DB::table('optin')
        ->where('date', '>=', $defaultVariablesArray['startDate'])
        ->where('date', '<=', $defaultVariablesArray['endDate'])
        ->distinct()
        ->get('date')
        ->toArray();



        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = date_format(date_create_from_format('Y-m-d G:i:s' ,$entryArray['date']), 'Y-m-d');
        }

        return $data;
    }

    public function getDailyAgent($defaultVariablesArray){
        //format date
        $startDate = $defaultVariablesArray['startDatePHP']->setTime(0,0);
        $endDate = $defaultVariablesArray['endDatePHP']->setTime(23,59);

        $data = DB::table('dailyagent')
        ->where('start_time', '>=', $startDate)
        ->where('start_time', '<=', $endDate)
        ->distinct()
        ->get('start_time')
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = date_format(date_create_from_format('Y-m-d G:i:s' ,$entryArray['start_time']), 'Y-m-d');
        }
        $data = array_unique($data);

        return $data;
    }

    public function getAvailbench($defaultVariablesArray){
        $data = DB::table('availbench_report')
        ->where('date_date', '>=', $defaultVariablesArray['startDate'])
        ->where('date_date', '<=', $defaultVariablesArray['endDate'])
        ->distinct()
        ->get('date_date')
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }

    public function getSas($defaultVariablesArray){
        $data = DB::table('sas')
        ->where('date', '>=', $defaultVariablesArray['startDate'])
        ->where('date', '<=', $defaultVariablesArray['endDate'])
        ->distinct()
        ->get('date')
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }

}
