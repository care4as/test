<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Feedback;
use App\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
  public function index()
  {
    $feedbacks = Feedback::with(['Creator'],['withUser'])->get();

    // dd($feedbacks);

    return view('FeedbackIndex', compact('feedbacks'));
  }

  public function showfeedback(){

    $loggedUser = DB::connection('mysqlkdw')->table('MA')->where('ds_id', Auth::User()->ds_id)->value('familienname') . ', ' . DB::connection('mysqlkdw')->table('MA')->where('ds_id', Auth::User()->ds_id)->value('vorname');

    $feedbackArray['userformSelection'] = array(
      'selected_project' => request('project'),
      'selected_user' => request('userSelection'),
      'selected_startDate' => request('week'),
      'current_user' => $loggedUser,
    );

    $feedbackArray['projects'] = $this->getProjects();
    $feedbackArray['users'] = $this->getUsers($feedbackArray['projects']);

    //dd($feedbackArray);

    /** Startdatum, falls nicht gesetzt, auf Montag vor 2 Wochen festlegen */
    if($feedbackArray['userformSelection']['selected_startDate'] == null){
      $feedbackArray['timespan'] = array(
        'first_week_number' => date_format((new DateTime())->modify('monday this week')->modify('-2 weeks'), 'W'),
        'first_week_start_date' => date_format((new DateTime())->modify('monday this week')->modify('-2 weeks'), 'Y-m-d'),
        'first_week_end_date' => date_format((new DateTime())->modify('sunday this week')->modify('-2 weeks'), 'Y-m-d'),
        'last_week_number' => date_format((new DateTime())->modify('monday this week')->modify('-1 weeks'), 'W'),
        'last_week_start_date' => date_format((new DateTime())->modify('monday this week')->modify('-1 weeks'), 'Y-m-d'),
        'last_week_end_date'=> date_format((new DateTime())->modify('sunday this week')->modify('-1 weeks'), 'Y-m-d'),
      );
      $feedbackArray['userformSelection']['selected_startDate'] = date_format(new DateTime('today'), 'Y-m-d');
    } else {
      $feedbackArray['timespan'] = array(
        'first_week_number' => date_format((new DateTime($feedbackArray['userformSelection']['selected_startDate']))->modify('monday this week')->modify('-2 weeks'), 'W'),
        'first_week_start_date' => date_format((new DateTime($feedbackArray['userformSelection']['selected_startDate']))->modify('monday this week')->modify('-2 weeks'), 'Y-m-d'),
        'first_week_end_date' => date_format((new DateTime($feedbackArray['userformSelection']['selected_startDate']))->modify('sunday this week')->modify('-2 weeks'), 'Y-m-d'),
        'last_week_number' => date_format((new DateTime($feedbackArray['userformSelection']['selected_startDate']))->modify('monday this week')->modify('-1 weeks'), 'W'),
        'last_week_start_date' => date_format((new DateTime($feedbackArray['userformSelection']['selected_startDate']))->modify('monday this week')->modify('-1 weeks'), 'Y-m-d'),
        'last_week_end_date'=> date_format((new DateTime($feedbackArray['userformSelection']['selected_startDate']))->modify('sunday this week')->modify('-1 weeks'), 'Y-m-d'),
      );
      $feedbackArray['userformSelection']['selected_startDate'] = date_format(new DateTime($feedbackArray['userformSelection']['selected_startDate']), 'Y-m-d');
    }

    $feedbackArray['data'] = $this->getFeedbackArrayData($feedbackArray);

    //dd($feedbackArray);

    return view('FeedBackShowView', compact('feedbackArray'));
  }

  public function getFeedbackArrayData($feedbackArray){
    $firstWeekRawData = array(
      'retention_details' => $this->getRetDetails($feedbackArray['timespan']['first_week_start_date'], $feedbackArray['timespan']['first_week_end_date']),
      'daily_agent' => $this->getDailyAgent($feedbackArray['timespan']['first_week_start_date'], $feedbackArray['timespan']['first_week_end_date']),
      'optin' => $this->getOptin($feedbackArray['timespan']['first_week_start_date'], $feedbackArray['timespan']['first_week_end_date']),
    );

    $lastWeekRawData = array(
      'retention_details' => $this->getRetDetails($feedbackArray['timespan']['last_week_start_date'], $feedbackArray['timespan']['last_week_end_date']),
      'daily_agent' => $this->getDailyAgent($feedbackArray['timespan']['last_week_start_date'], $feedbackArray['timespan']['last_week_end_date']),
      'optin' => $this->getOptin($feedbackArray['timespan']['last_week_start_date'], $feedbackArray['timespan']['last_week_end_date']),
    );


    $data = array(
      'first_week' => array(
        'user_data' => $this->getFeedbackArrayUserData($feedbackArray, $firstWeekRawData),
      ),
      'last_week' => array(
        'user_data' => $this->getFeedbackArrayUserData($feedbackArray, $lastWeekRawData),
      ),
    );
    $data['first_week']['project_data'] = $this->getFeedbackArrayProjectData($feedbackArray, $data['first_week']['user_data']);
    $data['last_week']['project_data'] = $this->getFeedbackArrayProjectData($feedbackArray, $data['last_week']['user_data']);

    //dd($data);
    return $data;
  }

  public function getFeedbackArrayUserData($feedbackArray, $rawData){
    $data = array();
    foreach($feedbackArray['projects'] as $projectKey => $projectEntry){
      foreach($feedbackArray['users'][$projectKey] as $userKey => $userEntry){
        $data[$projectKey][$userEntry['ds_id']]['calls_dsl'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('calls');
        $data[$projectKey][$userEntry['ds_id']]['calls_ssc'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('calls_smallscreen');
        $data[$projectKey][$userEntry['ds_id']]['calls_bsc'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('calls_bigscreen');
        $data[$projectKey][$userEntry['ds_id']]['calls_portale'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('calls_portale');
        $data[$projectKey][$userEntry['ds_id']]['calls_sum'] = $data[$projectKey][$userEntry['ds_id']]['calls_dsl'] + $data[$projectKey][$userEntry['ds_id']]['calls_ssc'] + $data[$projectKey][$userEntry['ds_id']]['calls_bsc'] + $data[$projectKey][$userEntry['ds_id']]['calls_portale'];
        $data[$projectKey][$userEntry['ds_id']]['orders_dsl'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('orders');
        $data[$projectKey][$userEntry['ds_id']]['orders_ssc'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('orders_smallscreen');
        $data[$projectKey][$userEntry['ds_id']]['orders_bsc'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('orders_bigscreen');
        $data[$projectKey][$userEntry['ds_id']]['orders_portale'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('orders_portale');
        if($data[$projectKey][$userEntry['ds_id']]['calls_dsl'] > 0){
          $data[$projectKey][$userEntry['ds_id']]['cr_dsl'] = number_format($data[$projectKey][$userEntry['ds_id']]['orders_dsl'] / $data[$projectKey][$userEntry['ds_id']]['calls_dsl'] * 100, 2,",",".");
        } else {
          $data[$projectKey][$userEntry['ds_id']]['cr_dsl'] = 0;
        }
        if($data[$projectKey][$userEntry['ds_id']]['calls_ssc'] > 0){
          $data[$projectKey][$userEntry['ds_id']]['cr_ssc'] = number_format($data[$projectKey][$userEntry['ds_id']]['orders_ssc'] / $data[$projectKey][$userEntry['ds_id']]['calls_ssc'] * 100, 2,",",".");
        } else {
          $data[$projectKey][$userEntry['ds_id']]['cr_ssc'] = 0;
        }
        if($data[$projectKey][$userEntry['ds_id']]['calls_bsc'] > 0){
          $data[$projectKey][$userEntry['ds_id']]['cr_bsc'] = number_format($data[$projectKey][$userEntry['ds_id']]['orders_bsc'] / $data[$projectKey][$userEntry['ds_id']]['calls_bsc'] * 100, 2,",",".");
        } else {
          $data[$projectKey][$userEntry['ds_id']]['cr_bsc'] = 0;
        }
        if($data[$projectKey][$userEntry['ds_id']]['calls_portale'] > 0){
          $data[$projectKey][$userEntry['ds_id']]['cr_portale'] = number_format($data[$projectKey][$userEntry['ds_id']]['orders_portale'] / $data[$projectKey][$userEntry['ds_id']]['calls_portale'] * 100, 2,",",".");
        } else {
          $data[$projectKey][$userEntry['ds_id']]['cr_portale'] = 0;
        }
        //Optin
        $data[$projectKey][$userEntry['ds_id']]['optin_handled_calls'] = $rawData['optin']->where('person_id', $userEntry['person_id'])->sum('Anzahl_Handled_Calls');
        $data[$projectKey][$userEntry['ds_id']]['optin_new'] = $rawData['optin']->where('person_id', $userEntry['person_id'])->sum('Anzahl_OptIn-Erfolg');;
        if($data[$projectKey][$userEntry['ds_id']]['optin_handled_calls'] > 0){
          $data[$projectKey][$userEntry['ds_id']]['optin_cr'] = number_format($data[$projectKey][$userEntry['ds_id']]['optin_new'] / $data[$projectKey][$userEntry['ds_id']]['optin_handled_calls'] * 100, 2,",",".");
        } else {
          $data[$projectKey][$userEntry['ds_id']]['optin_cr'] = 0;
        }
        //RLZ+24
        $data[$projectKey][$userEntry['ds_id']]['rlz_count_plus'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('rlzPlus');
        $data[$projectKey][$userEntry['ds_id']]['rlz_count_minus'] = $rawData['retention_details']->where('person_id', $userEntry['person_id'])->sum('mvlzNeu');
        $data[$projectKey][$userEntry['ds_id']]['rlz_count_all'] = $data[$projectKey][$userEntry['ds_id']]['rlz_count_minus'] + $data[$projectKey][$userEntry['ds_id']]['rlz_count_plus'];
        if($data[$projectKey][$userEntry['ds_id']]['rlz_count_all'] > 0){
          $data[$projectKey][$userEntry['ds_id']]['rlz_plus_percentage'] = number_format($data[$projectKey][$userEntry['ds_id']]['rlz_count_plus'] / $data[$projectKey][$userEntry['ds_id']]['rlz_count_all'] * 100, 2,",",".");
        } else {
          $data[$projectKey][$userEntry['ds_id']]['rlz_plus_percentage'] = 0;
        }
        //AHT
        $data[$projectKey][$userEntry['ds_id']]['time_in_call'] = $rawData['daily_agent']->where('agent_id', $userEntry['agent_id'])->whereIn('status', ['In Call', 'On Hold', 'Wrap Up'])->sum('time_in_state');

        if($data[$projectKey][$userEntry['ds_id']]['calls_dsl'] > 0){
          $data[$projectKey][$userEntry['ds_id']]['aht'] = number_format($data[$projectKey][$userEntry['ds_id']]['time_in_call'] / $data[$projectKey][$userEntry['ds_id']]['calls_dsl'], 0,",",".");
        } else {
          $data[$projectKey][$userEntry['ds_id']]['aht'] = 0;
        }

      }
    }
    //dd($data);
    return $data;


  }

  public function getFeedbackArrayProjectData($feedbackArray, $userData){
    $data = array();
    foreach($feedbackArray['projects'] as $projectKey => $projectEntry){
      //Variablen anlegen, um diese später zu füllen
      $data[$projectKey]['calls_dsl'] = 0;
      $data[$projectKey]['calls_ssc'] = 0;
      $data[$projectKey]['calls_bsc'] = 0;
      $data[$projectKey]['calls_portale'] = 0;
      $data[$projectKey]['calls_sum'] = 0;
      $data[$projectKey]['orders_dsl'] = 0;
      $data[$projectKey]['orders_ssc'] = 0;
      $data[$projectKey]['orders_bsc'] = 0;
      $data[$projectKey]['orders_portale'] = 0;
      $data[$projectKey]['cr_dsl'] = 0;
      $data[$projectKey]['cr_ssc'] = 0;
      $data[$projectKey]['cr_bsc'] = 0;
      $data[$projectKey]['cr_portale'] = 0;
      $data[$projectKey]['optin_handled_calls'] = 0;
      $data[$projectKey]['optin_new'] = 0;
      $data[$projectKey]['optin_cr'] = 0;
      $data[$projectKey]['rlz_count_plus'] = 0;
      $data[$projectKey]['rlz_count_minus'] = 0;
      $data[$projectKey]['rlz_count_all'] = 0;
      $data[$projectKey]['rlz_plus_percentage'] = 0;
      $data[$projectKey]['time_in_call'] = 0;
      $data[$projectKey]['aht'] = 0;

      foreach($userData[$projectKey] as $userKey => $userEntry){
        $data[$projectKey]['calls_dsl'] += $userEntry['calls_dsl'];
        $data[$projectKey]['calls_ssc'] += $userEntry['calls_ssc'];
        $data[$projectKey]['calls_bsc'] += $userEntry['calls_bsc'];
        $data[$projectKey]['calls_portale'] += $userEntry['calls_portale'];
        $data[$projectKey]['calls_sum'] += $userEntry['calls_sum'];
        $data[$projectKey]['orders_dsl'] += $userEntry['orders_dsl'];
        $data[$projectKey]['orders_ssc'] += $userEntry['orders_ssc'];
        $data[$projectKey]['orders_bsc'] += $userEntry['orders_bsc'];
        $data[$projectKey]['orders_portale'] += $userEntry['orders_portale'];
        $data[$projectKey]['optin_handled_calls'] += $userEntry['optin_handled_calls'];
        $data[$projectKey]['optin_new'] += $userEntry['optin_new'];
        $data[$projectKey]['rlz_count_plus'] += $userEntry['rlz_count_plus'];
        $data[$projectKey]['rlz_count_minus'] += $userEntry['rlz_count_minus'];
        $data[$projectKey]['rlz_count_all'] += $userEntry['rlz_count_all'];
        $data[$projectKey]['time_in_call'] += $userEntry['time_in_call'];
      }
      // In If-Bedingung zwecks Division
      if($data[$projectKey]['calls_dsl'] > 0){
        $data[$projectKey]['cr_dsl'] = number_format($data[$projectKey]['orders_dsl'] / $data[$projectKey]['calls_dsl'] * 100, 2,",",".");
      } else {
        $data[$projectKey]['cr_dsl'] = 0;
      }

      if($data[$projectKey]['calls_ssc'] > 0){
        $data[$projectKey]['cr_ssc'] = number_format($data[$projectKey]['orders_ssc'] / $data[$projectKey]['calls_ssc'] * 100, 2,",",".");
      } else {
        $data[$projectKey]['cr_ssc'] = 0;
      }

      if($data[$projectKey]['calls_bsc'] > 0){
        $data[$projectKey]['cr_bsc'] = number_format($data[$projectKey]['orders_bsc'] / $data[$projectKey]['calls_bsc'] * 100, 2,",",".");
      } else {
        $data[$projectKey]['cr_bsc'] = 0;
      }

      if($data[$projectKey]['calls_portale'] > 0){
        $data[$projectKey]['cr_portale'] = number_format($data[$projectKey]['orders_portale'] / $data[$projectKey]['calls_portale'] * 100, 2,",",".");
      } else {
        $data[$projectKey]['cr_portale'] = 0;
      }

      if($data[$projectKey]['optin_handled_calls'] > 0){
        $data[$projectKey]['optin_cr'] = number_format($data[$projectKey]['optin_new'] / $data[$projectKey]['optin_handled_calls'] * 100, 2,",",".");
      } else {
        $data[$projectKey]['optin_cr'] = 0;
      }

      if($data[$projectKey]['rlz_count_all'] > 0){
        $data[$projectKey]['rlz_plus_percentage'] = number_format($data[$projectKey]['rlz_count_plus'] / $data[$projectKey]['rlz_count_all'] * 100, 2,",",".");
      } else {
        $data[$projectKey]['rlz_plus_percentage'] = 0;
      }

      if($data[$projectKey]['calls_dsl'] > 0){
        $data[$projectKey]['aht'] = number_format($data[$projectKey]['time_in_call'] / $data[$projectKey]['calls_dsl'], 0,",",".");
      } else {
        $data[$projectKey]['aht'] = 0;
      }

    }
    //dd($data);
    return $data;
  }

  public function getProjects(){
    $projects = array(
        '1und1 DSL Retention' => [
          'id' => 10,
          'name' => '1und1 DSL Retention'
        ],
        '1und1 Retention' => [
          'id' => 7,
          'name' => '1und1 Mobile Retention'
        ],
      );
    return $projects;
  }

  public function getUsers($projects){
    $users = array();
    foreach($projects as $key => $entry){
      $users[$key] = DB::connection('mysqlkdw')
      ->table('MA')
      ->where('projekt_id', $entry['id'])
      ->where(function($query) {
        $query
        ->where('abteilung_id', '=', 10)
        ->orWhere('abteilung_id', '=', 19);
      })
      ->where(function($query){
        $query
        ->where('austritt', '=', null)
        ->orWhere('austritt', '>', date('Y-m-d', time()));
      })
      ->where('eintritt', '<=', date('Y-m-d', time()))
      ->get(['ds_id', 'familienname', 'vorname'])
      ->toArray();

      foreach($users[$key] as $subKey => $subEntry){
        $data = (array) $subEntry;
        $refinedData = array(
          'name' => $data['familienname'] . ', ' . $data['vorname'],
          'ds_id' => $data['ds_id'],
          'person_id' => DB::table('users')->where('ds_id', $data['ds_id'])->value('1u1_person_id'),
          'agent_id' => DB::table('users')->where('ds_id', $data['ds_id'])->value('1u1_agent_id'),
        );
        $users[$key][$subKey] = $refinedData;
      }
      asort($users[$key]);
      $users[$key] = array_values($users[$key]);
    }

    return $users;
  }

  public function create11($userid = null)
  {

    $year = Carbon::now()->year;
    $start_date = 1;
    $end_date = 1;

    $userid = request('userid');

    if($userid)
    {

      // $year = Carbon::now()->year;
      $start_date = 1;
      $end_date = 1;

      $userid = request('userid');

      $users = User::where('role','agent')
      ->where('status',1)
      ->select('id','name')
      ->orderBy('name')
      ->get();

      $kw = date("W");

      for ($i= 1 ; $i <= 4; $i++) {
        $kws[] = $kw - $i;
        if ($i == 1) {
          $end_date = Carbon::now();
          $end_date->setISODate($year,$kw - $i,7)->format('Y-m-d');
        }
        if($i == 4)
        {
          $start_date = Carbon::now();
          $start_date->setISODate($year,$kw - $i,1)->format('Y-m-d');
        }

    $user = User::where('role','Agent_Mobile')
    ->select('id','name','1u1_person_id','1u1_agent_id','project','ds_id')
    ->with(['dailyagent' => function($q) use ($start_date,$end_date){
      if($start_date !== 1)
      {
        $datemod = Carbon::parse($start_date)->setTime(2,0,0);
        $q->where('date','>=',$datemod);
      }}]);
      // dd($end_date, $start_date);

      $user = User::where('role','Agent_Mobile')
      ->select('id','name','1u1_person_id','1u1_agent_id','project','ds_id')
      ->with(['dailyagent' => function($q) use ($start_date,$end_date){
        if($start_date !== 1)
        {
          $datemod = Carbon::parse($start_date)->setTime(2,0,0);
          $q->where('date','>=',$datemod);
        }
        // dd($end_date, $start_date);

        $user = User::where('id',$userid)
        ->with(['dailyagent' => function($q) use ($start_date,$end_date){
          if($start_date !== 1)
          {
            $q->where('work_date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('work_date','<=',$end_date);
          }
          }])
        ->with(['SSETracking' => function($q) use ($start_date,$end_date){
          if($start_date !== 1)
          {
            $q->where('trackingdate','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('trackingdate','<=',$end_date);
          }
        }])
      // ->limit(10)
      ->first();

      // dd($user);
      foreach($kws as $kwi)
      {
        $query = null;
        //determin the date from monday 00:00:00 to sunday 23:59:59
        $start_date = Carbon::now();
        $end_date = Carbon::now();

        $start_date->setISODate($year,$kwi,1)->format('Y-m-d');
        $start_date->setTime(0,0);
        // return $start_date;
        $end_date->setISODate($year,$kwi,7)->format('Y-m-d');
        $end_date->setTime(23,59,59);

        if($user->project == null)
        {
          $department = null;
        }
        else if($user->project == '1und1 Retention') {
          $department = 'Retention Mobile Inbound Care4as Eggebek';
        }
        else {
          $department = 'Care4as Retention DSL Eggebek';
        }

        $weekstats =  $user->retentionDetails
        ->where('call_date','>=', $start_date)
        ->where('call_date','<=', $end_date);

        $calls = $weekstats->sum('calls');
        $callsssc = $weekstats->sum('calls_smallscreen');
        $callsbsc = $weekstats->sum('calls_bigscreen');
        $callsportale = $weekstats->sum('calls_portale');

        $saves = $weekstats->sum('orders');
        $sscSaves = $weekstats->sum('orders_smallscreen');
        $bscSaves = $weekstats->sum('orders_bigscreen');
        $portaleSaves = $weekstats->sum('orders_portale');

        $teamcalls = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('calls');

        $teamcalls_ssc = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('calls_smallscreen');

        $teamcalls_bsc = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('calls_bigscreen');

        $teamcalls_portale = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('calls_portale');

        $teamsaves = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('orders');

        $teamsaves_ssc = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('orders_smallscreen');

        $teamsaves_bsc = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('orders_bigscreen');

        $teamsaves_portale = DB::table('retention_details')
        ->where('call_date','>=',$start_date)
        ->where('call_date','<=',$end_date)
        ->where('department_desc',$department)
        ->sum('orders_portale');

        $statsArray = array(

        'calls' => $calls,
        'callsssc' => $callsssc,
        'callsbsc' => $callsbsc,
        'callsportale' => $callsportale,
        'saves' => $saves,
        'sscSaves' => $sscSaves,
        'bscSaves' => $bscSaves,
        'portalSaves' => $portaleSaves,
        'teamcalls' => $teamcalls,
        'teamcalls_ssc' => $teamcalls_ssc,
        'teamcalls_bsc' => $teamcalls_bsc,
        'teamcalls_portale' => $teamcalls_portale,
        'teamsaves' => $teamsaves,
        'teamsaves_ssc' => $teamsaves_ssc,
        'teamsaves_bsc' => $teamsaves_bsc,
        'teamsaves_portale' => $teamsaves_portale,
        );

        $weekperformance[$kwi] =  $statsArray;

      }
    }

    // dd($weekperformance);

    return view('FeedBackCreate', compact('users', 'user','weekperformance'));

  }
  }


  public function print($userid = null)
  {
    DB::disableQueryLog();
    $year = Carbon::now()->year;

    $users = User::where('role','agent')
    ->where('status',1)
    // ->select('id','name',)
    ->get();

    if(request('userid'))
    {
      // return 1;
      $userreport = User::where('id',request('userid'))->first();
      $kw = date("W");
      for ($i= 1 ; $i <= 4; $i++) {
        $kws[] = $kw - $i;
      }
        // return 1;
      foreach($kws as $kwi)
      {
        $query = null;
        //determin the date from monday 00:00:00 to sunday 23:59:59
        $start_date = Carbon::now();
        $end_date = Carbon::now();

        $start_date->setISODate($year,$kwi,1)->format('Y-m-d');
        $start_date->setTime(0,0);
        // return $start_date;
        $end_date->setISODate($year,$kwi,7)->format('Y-m-d');
        $end_date->setTime(23,59,59);

        $weekperformance[] = $userreport->getSalesDataInTimespan($start_date,$end_date);

        // dd($userreport->getSalesDataInTimespan($start_date,$end_date));
        if($userreport->department == '1&1 Mobile Retention')
        {
          $department = 'Retention Mobile Inbound Care4as Eggebek';
        }
        else
        {
          $department = 'Care4as Retention DSL Eggebek';
        }
        $queryDepartment = \App\RetentionDetail::query();
        $queryDepartment->where('department_desc',$department);

        $query2 = \App\DailyAgent::query();

        if($userreport->{'1u1_agent_id'})
        {
          // return $userreport->agent_id;
          $query2->where('agent_id', $userreport->{'1u1_agent_id'});
          $query2->where('date','>=', $start_date);
          $query2->where('date','<=', $end_date);
          $kwworkdata[$kwi] = $query2->get();
        }
        else {
          $kwworkdata[$kwi] = 'keine agent_id';
        }

        $queryDepartment->where('call_date','>=', $start_date);
        $queryDepartment->where('call_date','<=', $end_date);

        $teamdata[$kwi] = $queryDepartment->get();
      }

      $activestatus = array('Wrap Up','Ringing', 'In Call','On Hold');

      foreach($teamdata as $data)
      {
        $teamcalls = $data->sum('calls');
        $sscTeam = $data->sum('orders_smallscreen');
        $bscTeam = $data->sum('orders_bigscreen');
        $portalTeam = $data->sum('orders_portale');

        $teamweekperformance[] =  array(
          'callsTeam' => $teamcalls,
          'sscTeam' => $sscTeam,
          'bscTeam' => $bscTeam,
          'portalTeam' => $portalTeam,
        );
      }

      // dd($teamweekperformance);
      if($userreport->{'1u1_agent_id'})
      {

        foreach ($kwworkdata as $key => $DAweek) {

        $totaltime = $DAweek->sum('time_in_state');

        $afterwork = $DAweek->where('status','Wrap Up')->sum('time_in_state');

        $pausestatus = array('Released (01_screen break)','Released (03_away)','Released (02_lunch break)');

        $pause = $DAweek->whereIn('status',$pausestatus)->sum('time_in_state');

        $active = $DAweek->whereIn('status',$activestatus)
        ->sum('time_in_state');

        $calls = $DAweek->where('status','Ringing')->count();
        if($calls == 0)
        {
          $aht = 0;
        }
        else {
          $aht = $active/$calls;
        }
        $workdata[] = array(
          'gesamt' => $totaltime,
          'aktiv' => $active,
          'nacharbeit' => $afterwork,
          'aht' => $aht,
          'pause' => $pause,
        );
        }
      }
      else {
        abort(403,'user: '.$userreport->name.' hat keine agent ID');
        }

      // dd($weekperformance);
      return view('FeedBackPrint', compact('users','userreport','workdata','weekperformance','teamweekperformance'));
    }

    return view('FeedBackPrint', compact('users'));
  }

  public function store(Request $request)
  {
    // dd($request);
    $request->validate([

      'title' => 'required',
      'goals' => 'required',
      'with_user' => 'required',
      'content' => 'required',
      // 'title' => 'required',
    ]);

    $feedback = new Feedback;
    $feedback->title = $request->title;
    $feedback->goals = $request->goals;
    $feedback->with_user = $request->with_user;
    $feedback->content = $request->content;
    $feedback->creator = Auth()->id();
    $feedback->lead_by = Auth()->id();

    $feedback->save();

    return redirect()->back();
  }
  public function update(Request $request)
  {
    // dd($request);
    $request->validate([

      'feedbackid' => 'required',
      // 'goals' => 'required',
      // 'with_user' => 'required',
      // 'content' => 'required',
      // 'title' => 'required',
    ]);

    $feedback = new Feedback;
    $feedback->title = $request->title;
    $feedback->goals = $request->goals;
    $feedback->with_user = $request->with_user;
    $feedback->content = $request->content;
    $feedback->creator = $request->creator;
    $feedback->lead_by = $request->lead_by;

    $feedback->save();
    return redirect()->back();
  }
  public function show($id='')
  {
    // return $id;
    $feedback = Feedback::where('id',$id)->with('Creator','withUser')->first();
    $users = User::where('role','agent')->get();

    // dd($feedback);
    return view('FeedBackShow', compact('feedback','users'));
  }

  public function newFeedback(){
  }

  public function getDailyAgent($startDate, $endDate){
    /** Diese Funktion greift auf die DailyAgent-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen.
     * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */

    $startDate = date_create_from_format('Y-m-d', $startDate);
    $endDate = date_create_from_format('Y-m-d', $endDate);

    $startDate = $startDate->setTime(0,0);
    $endDate = $endDate->setTime(23,59);

    $data = DB::table('dailyagent')                 // Verbindung zur Tabelle 'dailyagent' wird hergestellt
    ->where('start_time', '>=', $startDate)         // Datum muss größergleich dem Startdatum sein
    ->where('start_time', '<=', $endDate)           // Datum muss kleinergleich dem Enddatum sein
    ->get();                                        // Tabelle wird unter berücksichtigung der Filter geholt

    return $data; // Das Datenarray wird zurückgegeben
  }

  public function getOptin($startDate, $endDate){
    /** Diese Funktion greift auf die OptIn-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen.
     * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */

    $data = DB::table('optin')         // Verbindung zur Tabelle 'optin' wird hergestellt
    ->where('date', '>=', $startDate)  // Datum muss größergleich dem Startdatum sein
    ->where('date', '<=', $endDate)    // Datum muss kleinergleich dem Enddatum sein
    ->get();                           // Tabelle wird unter berücksichtigung der Filter geholt

    return $data; // Das Datenarray wird zurückgegeben
  }

  public function getRetDetails($startDate, $endDate){
    /** Diese Funktion greift auf die RetentionDetails-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen.
     * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */

    $data = DB::table('retention_details')   // Verbindung zur Tabelle 'retention_details' wird hergestellt
    ->where('call_date', '>=', $startDate)   // Datum muss größergleich dem Startdatum sein
    ->where('call_date', '<=', $endDate)     // Datum muss kleinergleich dem Enddatum sein
    ->get();                                 // Tabelle wird unter berücksichtigung der Filter geholt

    //dd($data);
    return $data; // Das Datenarray wird zurückgegeben
  }
}
