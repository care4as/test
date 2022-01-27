<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hoursreport;
use App\RetentionDetail;
use App\DailyAgent;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Fgits\CarbonGermanHolidays\CarbonGermanHolidays;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function dashboardAdmin()
    {
      $teamquotas = array();
      $trend = '';

      if(request('employees'))
      {
        // dd(request('employees'));
        $userids = DB::table('intermediate_status')
        ->whereDate('date', Carbon::today())
        ->pluck('1u1_person_id')
        ->toArray();

        $users = User::whereIN('id',request('employees'))
        ->whereIN('1u1_person_id', $userids)
        ->orderBy('name')
        ->get();
      }
      else {
        $userids = DB::table('intermediate_status')
        ->whereDate('date', Carbon::today())
        ->pluck('person_id')
        ->toArray();

        $users = User::whereIn('1u1_person_id', $userids)->orderBy('name')->get();
      }

      $mobileTeamids = DB::table('users')
      ->where('project', '1und1 Retention')
      ->where('status',1)
      ->pluck('1u1_person_id')
      ->toArray();

      $DSLTeamids = DB::table('users')
      ->where('project', '1und1 DSL Retention')
      ->where('status',1)
      ->pluck('1u1_person_id')
      ->toArray();


      $dataMobile= $this->getIVDataPerDay(5,$mobileTeamids);
      // $dataDSL= $this->getIVDataPerDay(5,$DSLTeamids);

      $quotas = $dataMobile[0];
      $times= $dataMobile[1];

      $quotasDSL = $this->getIVDataPerDay(5,$DSLTeamids)[0];

      return view('dashboardtracker',compact('users', 'times','quotas','quotasDSL'));
    }

    public function getIVDataPerDay($days=5, $employeeIDs)
    {
      for($i = 1; $i<=$days; $i++)
      {
        $day = Carbon::today()->subdays($i);
        $intermediatesMobile[$day->format('d.m.Y')] = \App\Intermediate::whereDate('date',$day)->whereIn('person_id',$employeeIDs)->get();
      }

      foreach($intermediatesMobile as $key => $data)
      {
        // dd($intermediates);

        $time = new Carbon($key);
        $time->setTime(8,30,0);

        for($i = 1; $i <= 28; $i++)
        {
          $times[$key][] = $time->copy()->addMinutes(($i-1) * 30);
        }
        foreach($times[$key] as $timestamp)
        {
          $spectrumend = $timestamp->copy()->addMinutes(5)->format('Y-m-d H:i:s');
          $spectrumstart = $timestamp->copy()->subMinutes(5)->format('Y-m-d H:i:s');

          // return $spectrumstart;
          $ivdata = $data->where('date','>', $spectrumstart)->where('date','<',$spectrumend);


          $orders = $ivdata->sum('Orders');
          $calls = $ivdata->sum('Calls');

          if($ivdata)
          {
              // dd($ivdata);
            if ($calls != 0) {
              $quotas[$timestamp->format('Y-m-d')][$timestamp->format('H:i')]['cr'] = round($orders/$calls,2);
              $quotas[$timestamp->format('Y-m-d')][$timestamp->format('H:i')]['calls'] = $calls;
              $quotas[$timestamp->format('Y-m-d')][$timestamp->format('H:i')]['orders'] = $orders;
            }
            else {
              // dd($ivdata);
                $quotas[$timestamp->format('Y-m-d')][$timestamp->format('H:i')]['cr'] = 0;
                $quotas[$timestamp->format('Y-m-d')][$timestamp->format('H:i')]['calls'] = 0;
                $quotas[$timestamp->format('Y-m-d')][$timestamp->format('H:i')]['orders'] = 0;
            }

            // $quotas[$timestamp->format('Y-m-d H:i:s')] = $calls;
          }
          else {
            $quotas[$timestamp->format('Y-m-d')][$timestamp->format('H:i:s')]['cr'] = 0;
          }
        }
      }
      return $data= array($quotas, $times);
    }
    public function presentation(Request $request)
    {
      //turn off the query log to save some time
      DB::disableQueryLog();
      //sets off the limitation of memory an request can handle, bc of the large amount of data
      ini_set('memory_limit', '-1');
      // since the request can last to several minutes, i had to turn off the execution time
      ini_set('max_execution_time', '0'); // for infinite time of execution
      date_default_timezone_set('Europe/Berlin');
      // $modul = 'Userübersicht';

      $productiveStates = array('Wrap Up','Ringing', 'In Call','On Hold','Available','Released (05_occupied)','Released (06_practice)','Released (09_outbound)');
      $avgAHT= 0;
      // all the hours from the "stundenreport"
      $allWorkedHours = 0;
      //all the hours the agent was logged in in the ccu
      $allDAHours = 0;
      $allDAProdHours = 0;
      //all the hours the agent was on one of the productive states
      $allDAProductiveHours = 0;

      $allDailyAgentCalls =0;

      $allGeVoSaves =0;
      $allSSETRackingSaves =0;

      $allSSCCalls = 0;
      $allSSCSaves = 0;
      $allBSCCalls = 0;
      $allBSCSaves = 0;
      $allPortalCalls = 0;
      $allPortalSaves = 0;
      $allRLZ24= 0;
      $allMLZV= 0;
      $allOptinCalls =0;
      $allOptinRequests =0;
      $allGeVoSaves = 0;
      $allAHTSeconds = 0;
      $allSickHours = 0;
      $allSAS = 0;
      $year = Carbon::now()->year;
      $start_date = 1;
      $end_date = 1;

      if($request->start_date)
      {
        $start_date = $request->start_date;
      }
      else {
        $start_date = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
      }
      if ($request->end_date) {
        $end_date = $request->end_date;
      }
      // return $end_date;

      if($request->employees)
      {
        $users = User::
        where('department','Agenten')
        ->where('status',1)
        ->whereIn('id', $request->employees)
        ->select('id','1u1_person_id','1u1_agent_id','project','ds_id')
        ->with(['dailyagent' => function($q) use ($start_date,$end_date){
          $q->select(['id','agent_id','status','time_in_state','date']);
          if($start_date !== 1)
          {
            $datemod = Carbon::parse($start_date)->setTime(2,0,0);
            $q->where('date','>=',$datemod);
          }
          if($end_date !== 1)
          {
            $datemod2 = Carbon::parse($end_date)->setTime(23,59,59);
            $q->where('date','<=',$datemod2);
          }
          }])
        ->with(['retentionDetails' => function($q) use ($start_date,$end_date){
          // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
          if($start_date !== 1)
          {
            $q->where('call_date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('call_date','<=',$end_date);
          }
          }])
          ->with(['hoursReport' => function($q) use ($start_date,$end_date){

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
            if($start_date != 1)
            {
              $q->where('trackingdate','>=',$start_date);
            }
            if($end_date != 1)
            {
              $q->where('trackingdate','<=',$end_date);
            }
          }])
          ->with(['SAS' => function($q) use ($start_date,$end_date){
            if($start_date != 1)
            {
              $q->where('date','>=',$start_date);
            }
            if($end_date != 1)
            {
              $q->where('date','<=',$end_date);
            }
          }])
          ->with(['gevo' => function($q) use ($start_date,$end_date){
            // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
            if($start_date !== 1)
            {
              $q->where('date','>=',$start_date);
            }
            if($end_date !== 1)
            {
              $q->where('date','<=',$end_date);
            }
            }])
          ->with(['Optin' => function($q) use ($start_date,$end_date){
            if($start_date != 1)
            {
              $q->where('date','>=',$start_date);
            }
            if($end_date != 1)
            {
              $q->where('date','<=',$end_date);
            }
          }])
        // ->limit(10)
        ->get();
        // dd($users);
      }
      elseif($request->team)
      {
        // dd($request->team);
        $users = User::where('department','Agenten')
        ->where('status',1)
        ->where('team', $request->team)
        ->select('id','name','1u1_person_id','1u1_agent_id','project','ds_id')
        ->where('1u1_agent_id','!=',null)
        ->with(['dailyagent' => function($q) use ($start_date,$end_date){
          $q->select(['id','agent_id','status','time_in_state','date']);
          if($start_date !== 1)
          {
            $datemod = Carbon::parse($start_date)->setTime(2,0,0);
            $q->where('date','>=',$datemod);
          }
          if($end_date !== 1)
          {
            $datemod2 = Carbon::parse($end_date)->setTime(23,59,59);
            $q->where('date','<=',$datemod2);
          }
          }])
        ->with(['retentionDetails' => function($q) use ($start_date,$end_date){
          // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
          if($start_date !== 1)
          {
            $q->where('call_date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('call_date','<=',$end_date);
          }
          }])
        ->with(['gevo' => function($q) use ($start_date,$end_date){
          // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
          if($start_date !== 1)
          {
            $q->where('date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('date','<=',$end_date);
          }
          }])
          ->with(['hoursReport' => function($q) use ($start_date,$end_date){

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
            if($start_date != 1)
            {
              $q->where('trackingdate','>=',$start_date);
            }
            if($end_date != 1)
            {
              $q->where('trackingdate','<=',$end_date);
            }
          }])
          ->with(['SAS' => function($q) use ($start_date,$end_date){
            if($start_date != 1)
            {
              $q->where('date','>=',$start_date);
            }
            if($end_date != 1)
            {
              $q->where('date','<=',$end_date);
            }
          }])
          ->with(['Optin' => function($q) use ($start_date,$end_date){
            if($start_date != 1)
            {
              $q->where('date','>=',$start_date);
            }
            if($end_date != 1)
            {
              $q->where('date','<=',$end_date);
            }
          }])
        // ->limit(10)
        ->get();
      }
      else {

        // return 'test';
        if ($request->department) {
          $department = $request->department;
        }
        else {
          $department = '';
        }

        // dd($department);
        // return \Carbon\Carbon::parse($start_date)->setTime(2,0,0);
        $users = User::where('department','Agenten')
        ->where('status',1)
        ->where('project', $department)
        ->select('id','name','1u1_person_id','1u1_agent_id','project','ds_id')
        // ->where('1u1_agent_id','!=',null)
        ->with(['dailyagent' => function($q) use ($start_date,$end_date){
          $q->select(['id','agent_id','status','time_in_state','date']);
          if($start_date !== 1)
          {
            $datemod = Carbon::parse($start_date)->setTime(2,0,0);
            $q->where('date','>=',$datemod);
          }
          if($end_date !== 1)
          {
            $datemod2 = Carbon::parse($end_date)->setTime(23,59,59);
            $q->where('date','<=',$datemod2);
          }
          }])
        ->with(['retentionDetails' => function($q) use ($start_date,$end_date){
          // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
          if($start_date !== 1)
          {
            $q->where('call_date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('call_date','<=',$end_date);
          }
          }])
        ->with(['gevo' => function($q) use ($start_date,$end_date){
          // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
          if($start_date !== 1)
          {
            $q->where('date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('date','<=',$end_date);
          }
          }])
        ->with(['hoursReport' => function($q) use ($start_date,$end_date){
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
          if($start_date != 1)
          {
            $q->where('trackingdate','>=',$start_date);
          }
          if($end_date != 1)
          {
            $q->where('trackingdate','<=',$end_date);
          }
          }])
        ->with(['SAS' => function($q) use ($start_date,$end_date){
          if($start_date != 1)
          {
            $q->where('date','>=',$start_date);
          }
          if($end_date != 1)
          {
            $q->where('date','<=',$end_date);
          }
        }])
        ->with(['Optin' => function($q) use ($start_date,$end_date){
          if($start_date != 1)
          {
            $q->where('date','>=',$start_date);
          }
          if($end_date != 1)
          {
            $q->where('date','<=',$end_date);
          }
        }])
        // ->limit(10)
        ->get();
      }

      // dd($users);

      //the days without holiday and weekends and sickdays stuff
      if($start_date != 1)
      {
        $begin = Carbon::parse($start_date)->setTime(2,0,0);
      }
      else {
        $begin = Carbon::parse(Hoursreport::min('work_date'));
        $begin->setTime(2,0,0);
      }

      if($end_date != 1)
      {
        $end =  Carbon::parse($end_date)->setTime(23,59,59);
      }
      else {

        $end = Carbon::parse(Hoursreport::max('work_date'));
        $end->setTime(23,59,59);
      }

      $holidays = [
          //new years day
          Carbon::createFromDate($year, 1, 1)->toDateString(),

          $eastersunday = Carbon::createFromDate($year,3,21)->addDays(easter_days($year))->toDateString(),
          $easterfriday = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)-2)->toDateString(),
          $ascchrist = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)+39)->toDateString(),
          $pentecost = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)+49)->toDateString(),
          $pentecostmonday = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)+50)->toDateString(),
          // 1. Mai
          Carbon::create($year, 5, 1)->toDateString(),
          //erster Weihnachstag
          Carbon::create($year, 12, 25)->toDateString(),
          //zweiter Weihnachstag
          Carbon::create($year, 12, 26)->toDateString(),
          //Tag der deutschen Einheit
          Carbon::create($year, 10, 3)->toDateString(),
      ];

      // return $pentecostmonday;

      $days = $begin->diffInDaysFiltered(function (Carbon $date) use($holidays){

        return $date->isWeekday() && !in_array($date->toDateString(),$holidays);

      }, $end);

      $dayscount = $begin->diffInDays($end);

      $weekenddays = array();

      for ($i=1; $i <= $dayscount; $i++) {

        $day = $begin->copy()->addDays($i);

        if($day->isWeekend())
        {
          $weekenddays[] = $day->format('Y-m-d');
        }
      }
      foreach ($users as $key => $user) {

        $workedHours = 0;
        $sickHours = 0;
        $sicknessquota = '';
        // dd($user);
        $reports = $user->retentionDetails;

        $sumorders = $reports->sum('orders');
        // sum of all calls during the timespan
        $sumcalls = $reports->sum('calls');
        // $sumcalls = $reports->sum('calls');
        $sumNMlz = $reports->sum('mvlzNeu');
        $sumrlz24 = $reports->sum('rlzPlus');
        $sumSSCCalls = $reports->sum('calls_smallscreen');
        $sumBSCCalls = $reports->sum('calls_bigscreen');
        $sumPortalCalls = $reports->sum('calls_portale');
        $sumSSCOrders = $reports->sum('orders_smallscreen');
        $sumBSCOrders = $reports->sum('orders_bigscreen');
        $sumPortalOrders = $reports->sum('orders_portale');

        $ssesaves = $user->SSETracking->where('Tracking_Item1','Save')->count();

        $ahtStates = array('On Hold','Wrap Up','In Call');
        $casetime = $user->dailyagent->whereIn('status', $ahtStates)->sum('time_in_state');

        $calls = $user->dailyagent->where('status', 'Ringing')
        ->count();

        $allSSCCalls += $sumSSCCalls;
        $allSSCSaves += $sumSSCOrders;
        $allBSCCalls += $sumBSCCalls;
        $allBSCSaves += $sumBSCOrders;
        $allPortalCalls += $sumPortalCalls;
        $allPortalSaves += $sumPortalOrders;
        $allRLZ24 += $sumrlz24;
        $allMLZV += $sumNMlz;

        $allGeVoSaves += $user->gevo->where('change_cluster','Upgrade')->count() + $user->gevo->where('change_cluster','Sidegrade')->count() +$user->gevo->where('change_cluster','Downgrade')->count();

        $allAHTSeconds += $casetime;
        $allDailyAgentCalls += $calls;

        if($calls == 0)
        {
          $AHT = 0;
        }
        else {
          $AHT =  round(($casetime/ $calls),0);
        }
        // $workdays = $reports->count();
        if($sumSSCCalls == 0)
        {
          $SSCQouta = 0;
        }
        else {
          $SSCQouta = round(($sumSSCOrders/$sumSSCCalls)*100,2);
        }
        if($sumBSCCalls == 0)
        {
          $BSCQuota = 0;
        }
        else {
          $BSCQuota = round(($sumBSCOrders/$sumBSCCalls)*100,2);
        }
        if($sumPortalCalls == 0)
        {
          $portalQuota = 0;
        }
        else {
          $portalQuota = round(($sumPortalOrders/$sumPortalCalls) *100,2);
        }

        if($sumrlz24 + $sumNMlz == 0)
        {
          $RLZQouta = 0;
        }
        else {
          $RLZQouta = round((($sumrlz24 / ($sumrlz24 + $sumNMlz))*100),2);
        }
        if($sumcalls == 0)
        {
          $gevocr = 0;
        }
        else
        {
          // dd($user,$sumorders,$sumcalls);
          $gevocr = round(($sumorders/$sumcalls) * 100,2);
        }

        //der Teil zum Stundenreport
        $workedHours = $user->hoursReport->sum('work_hours');
        $allWorkedHours += $workedHours;
        //the vacation hours
        $vacationHours = $user->hoursReport->where('state_id',2)->sum('work_hours');
        $pauseHours = $user->hoursReport->sum('pause_hours');
        $paybreakHours = $user->hoursReport->sum('pause_hours');
        $meetingHours = $user->hoursReport->sum('meeting_hours');

        $contracthours = $days * $user->dailyhours;
        $sickHours = $user->hoursReport->whereIn('state_id',array(1,7))->whereNotIn('work_date',$weekenddays)->sum('work_hours');

        if($days == 0)
        {
          $sicknessquota = 'keine validen Daten';
        }
        else {
          // $sicknessquota =  $sickHours.' /d:'.$days.'/dh:'.$user->dailyhours;
          if ($workedHours == 0) {
            $sicknessquota = 0;
          }
          else {
            $sicknessquota =  round(($sickHours/($workedHours))*100,2);
          }
        }
        if ($calls != 0) {

            // dd($user, $calls, $user->gevo->count());
            $gevocr2 = round($user->gevo->count()*100 / $calls,2);
        }
        else {
          // dd($user, $calls, $user->gevo->count());
          $gevocr2 = 0;
        }

        $payed11 = round(($user->dailyagent->sum('time_in_state')/3600),2);

        //all dailyAgent time
        $allDAHours += $payed11;

        $productive = $user->dailyagent->whereIn('status', $productiveStates)
        ->sum('time_in_state');

        $productive = round(($productive/3600),2);

        //all dailyAgent time in productive states
        $allDAProdHours += $productive;

        $user->salesdata = array(
          'calls' => $sumcalls,
          // 'calls' => $calls,
          'orders' => $sumorders,
          'ssesaves' => $ssesaves,
          // 'workedDays' => $workdays,
          'sscQuota' => $SSCQouta,
          'sscOrders' => $sumSSCOrders,
          'bscQuota' =>  $BSCQuota,
          'bscOrders' => $sumBSCOrders,
          'portalQuota' => $portalQuota,
          'portalOrders' => $sumPortalOrders,
          'RLZ24Qouta' => $RLZQouta,
          'GeVo-Cr' => $gevocr,
          'gevocr2' => $gevocr2,
          'workedHours' => $workedHours,
          // 'sickHours' => $sickHours,
          'sicknessquota' => $sicknessquota,
          'payedtime11' => $payed11,
          'productive' => $productive,
          'aht' => $AHT,
          'sickhours' => $sickHours,
          'dailyagentCalls' => $calls,
          'sumSSCCalls' => $sumSSCCalls,
          'sumBSCCalls' => $sumBSCCalls,
          'sumPortalCalls' => $sumPortalCalls,
        );

        $optinCalls = $user->Optin->sum('Anzahl_Handled_Calls');
        $optinRequests = $user->Optin->sum('Anzahl_OptIn-Erfolg');

        $allOptinCalls += $optinCalls;
        $allOptinRequests += $optinRequests;

        // dd($user, $user->Optin);

        if ($optinCalls != 0) {
          $user->optinQuota = round($optinRequests*100/$optinCalls,2);
          }
        else {
            $user->optinQuota = 0;
          }
        $sas = $user->SAS->count();

        $allSAS += $sas;

        $allCalls = $user->retentionDetails->sum('calls');

        if (  $allCalls != 0) {
             $user->sasquota = round($sas*100/$allCalls,2).'%';
          }
        else {
            $user->sasquota = 0;
          }
      }

      $overalldata = array(
        'allSSCCalls' => $allSSCCalls,
        'allSSCSaves' => $allSSCSaves,
        'allBSCCalls' => $allBSCCalls,
        'allBSCSaves' => $allBSCSaves,
        'allPortaleCalls' => $allPortalCalls,
        'allPortaleSaves' => $allPortalSaves,
        'allRLZ24' => $allRLZ24,
        'allMVLZ' => $allMLZV,
        'allOptinCalls' => $allOptinCalls,
        'allOptinRequests' => $allOptinRequests,

      );

      if ($allDailyAgentCalls ==  0) {
        $avgAHT = 0;
      }
      else {
        $avgAHT = round($allAHTSeconds/$allDailyAgentCalls,2);
      }

      $footerdata = array(
        'avgAHT' => $avgAHT,
        'allSSCCalls' => $allSSCCalls,
        'allSSCSaves' => $allSSCSaves,
        'allBSCCalls' => $allBSCCalls,
        'allBSCSaves' => $allBSCSaves,
        'allPortaleCalls' => $allPortalCalls,
        'allPortaleSaves' => $allPortalSaves,
        'allRLZ24' => $allRLZ24,
        'allMVLZ' => $allMLZV,
        'allOptinCalls' => $allOptinCalls,
        'allOptinRequests' => $allOptinRequests,
        'allDailyAgentCalls' => $allDailyAgentCalls,
        'allWorkedHours' => $allWorkedHours,
        'allGeVoSaves' => $allGeVoSaves,
        'allSAS' => $allSAS,
      );

      //dd($overalldata);
      return view('DB', compact('overalldata', 'users','footerdata'));
    }

    public function test($value='')
    {
      $start_date = '2021-02-01';
      $end_date = '2021-02-28';

      $users = User::where('role','Agent')
      ->with(['SSETracking' => function($q) use ($start_date,$end_date){
        if($start_date != 1)
        {
          // echo $datemod ;
          $q->where('trackingdate','>=',$start_date);
        }
        if($end_date != 1)
        {
          $q->where('trackingdate','<=',$end_date);
        }
      }])
      ->get();

      foreach ($users as $key => $user) {
        $user->ssesaves = $user->SSETracking->where('Tracking_Item1','Save')->count();
      }

    }
}
