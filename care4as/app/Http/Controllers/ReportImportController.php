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
        $availbenchDslData = $this->getAvailbench($defaultVariablesArray, 53);
        $availbenchMobileData = $this->getAvailbench($defaultVariablesArray, 54);
        $dailyAgentDslData = $this->getDailyAgent($defaultVariablesArray, 772);
        $dailyAgentMobileData = $this->getDailyAgent($defaultVariablesArray, 1253);
        $optInDslData = $this->getOptin($defaultVariablesArray, 'Care4as Retention DSL Eggebek');
        $optInMobileData = $this->getOptin($defaultVariablesArray, 'KDW Retention Mobile Flensburg');
        $retentionDetailsDslData = $this->getRetDetails($defaultVariablesArray, 'Care4as Retention DSL Eggebek');
        $retentionDetailsMobileData = $this->getRetDetails($defaultVariablesArray, 'Retention Mobile Inbound Care4as Eggebek');
        $retentionDetailsMobileNewData = $this->getRetDetails($defaultVariablesArray, 'KDW Retention Mobile Flensburg');
        $sasDslData = $this->getSas($defaultVariablesArray, 'RT_DSL');
        $sasMobileData = $this->getSas($defaultVariablesArray, 'RT_Mobile');

        $dataTables = array();

        for($i = 0; $i <= $defaultVariablesArray['differenceDate']; $i++){
            $day = date('Y-m-d', strtotime($defaultVariablesArray['startDate']. '+ '.$i.' days'));

            $dataTables[$day]['availbench_dsl'] = 'false';
            $dataTables[$day]['availbench_mobile'] = 'false';
            $dataTables[$day]['daily_agent_dsl'] = 'false';
            $dataTables[$day]['daily_agent_mobile'] = 'false';
            $dataTables[$day]['optin_dsl'] = 'false';
            $dataTables[$day]['optin_mobile'] = 'false';   
            $dataTables[$day]['sas_dsl'] = 'false';
            $dataTables[$day]['sas_mobile'] = 'false';
            $dataTables[$day]['retention_details_dsl'] = 'false';
            $dataTables[$day]['retention_details_mobile'] = 'false';

            foreach($availbenchDslData as $key => $entry){
                if($entry['date_date'] == $day){
                    $dataTables[$day]['availbench_dsl'] = 'true';
                }
            }
            foreach($availbenchMobileData as $key => $entry){
                if($entry['date_date'] == $day){
                    $dataTables[$day]['availbench_mobile'] = 'true';
                }
            }
            foreach($dailyAgentDslData as $key => $entry){
                if($entry == $day){
                    $dataTables[$day]['daily_agent_dsl'] = 'true';
                }
            }
            foreach($dailyAgentMobileData as $key => $entry){
                if($entry == $day){
                    $dataTables[$day]['daily_agent_mobile'] = 'true';
                }
            }
            foreach($optInDslData as $key => $entry){
                if($entry == $day){
                    $dataTables[$day]['optin_dsl'] = 'true';
                }
            }
            foreach($optInMobileData as $key => $entry){
                if($entry == $day){
                    $dataTables[$day]['optin_mobile'] = 'true';
                }
            }
            foreach($retentionDetailsDslData as $key => $entry){
                if($entry['call_date'] == $day){
                    $dataTables[$day]['retention_details_dsl'] = 'true';
                }
            }
            foreach($retentionDetailsMobileData as $key => $entry){
                if($entry['call_date'] == $day){
                    $dataTables[$day]['retention_details_mobile'] = 'true';
                }
            }
            //Weil das Department sich geändert hat
            foreach($retentionDetailsMobileNewData as $key => $entry){
                if($entry['call_date'] == $day){
                    $dataTables[$day]['retention_details_mobile'] = 'true';
                }
            }
            foreach($sasDslData as $key => $entry){
                if($entry['date'] == $day){
                    $dataTables[$day]['sas_dsl'] = 'true';
                }
            }
            foreach($sasMobileData as $key => $entry){
                if($entry['date'] == $day){
                    $dataTables[$day]['sas_mobile'] = 'true';
                }
            }
        }
        //dd($dataTables);

        return $dataTables;
    }

    public function getRetDetails($defaultVariablesArray, $department){
        $data = DB::table('retention_details')
        ->where('call_date', '>=', $defaultVariablesArray['startDate'])
        ->where('call_date', '<=', $defaultVariablesArray['endDate'])
        ->where('department_desc', $department)
        ->distinct()
        ->get('call_date')
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }

    public function getOptin($defaultVariablesArray, $department){
        $data = DB::table('optin')
        ->where('date', '>=', $defaultVariablesArray['startDate'])
        ->where('date', '<=', $defaultVariablesArray['endDate'])
        ->where('department', $department)
        ->distinct()
        ->get('date')
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = date_format(date_create_from_format('Y-m-d G:i:s' ,$entryArray['date']), 'Y-m-d');
        }

        return $data;
    }

    public function getDailyAgent($defaultVariablesArray, $groupId){
        //format date
        $startDate = $defaultVariablesArray['startDatePHP']->setTime(0,0);
        $endDate = $defaultVariablesArray['endDatePHP']->setTime(23,59);

        $data = DB::table('dailyagent')
        ->where('start_time', '>=', $startDate)
        ->where('start_time', '<=', $endDate)
        ->where('agent_group_id', $groupId)
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

    public function getAvailbench($defaultVariablesArray, $forecast){
        $data = DB::table('availbench_report')
        ->where('date_date', '>=', $defaultVariablesArray['startDate'])
        ->where('date_date', '<=', $defaultVariablesArray['endDate'])
        ->where('call_forecast_issue_key', $forecast)
        ->distinct()
        ->get('date_date')
        ->toArray();

        foreach($data as $key => $entry){
            $entryArray = (array) $entry;
            $data[$key] = $entryArray;
        }

        return $data;
    }

    public function getSas($defaultVariablesArray, $topic){
        $data = DB::table('sas')
        ->where('date', '>=', $defaultVariablesArray['startDate'])
        ->where('date', '<=', $defaultVariablesArray['endDate'])
        ->where('topic', $topic)
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
