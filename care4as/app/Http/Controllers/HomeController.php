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
    public function presentation(Request $request)
    {
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      date_default_timezone_set('Europe/Berlin');

      $modul = 'Userübersicht';

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

        $users = User::where('role','agent')
        ->whereIn('id', $request->employees)
        ->select('id','surname','lastname','person_id','agent_id','dailyhours','department')
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
          // $q->select(['id','person_id','calls','time_in_state','call_date']);
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
        // ->limit(10)
        ->get();
      }
      else {

        if ($request->department) {
          $department = $request->department;
        }
        else {
          $department = '';
        }
        // return \Carbon\Carbon::parse($start_date)->setTime(2,0,0);
        $users = User::where('role','agent')
        ->where('department', $department)
        ->select('id','surname','lastname','person_id','agent_id','dailyhours','department','ds_id')
        ->where('agent_id','!=',null)
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
          // $q->select(['id','person_id','calls','time_in_state','call_date']);
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
        // ->limit(10)
        ->get();
      }

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

        $reports = $user->retentionDetails;
        $sumorders = $reports->sum('orders');
        // sum of all calls during the timespan
        $sumcalls = $reports->sum('calls');
        $sumcalls = $reports->sum('calls');
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

        if($calls == 0)
        {
          $AHT = 0;
        }
        else {
          $AHT =  round(($casetime/ $calls),0);
        }

        // $workdays = $reports->count();
        $workedHours = 0;
        $sickHours = 0;
        $sicknessquota = '';

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

        if($sumrlz24 == 0 or $sumNMlz == 0)
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
          $gevocr = round(($sumorders/$sumcalls) * 100,2);
        }

        //der Teil zum Stundenreport

        $workedHours = $user->hoursReport->sum('work_hours');
        $contracthours = $days * $user->dailyhours;
        $sickHours = $user->hoursReport->whereIn('state_id',array(1,7))->whereNotIn('work_date',$weekenddays)->sum('work_hours');

        if($days == 0)
        {
          $sicknessquota = 'keine validen Daten';
        }
        else {
          // $sicknessquota =  $sickHours.' /d:'.$days.'/dh:'.$user->dailyhours;
          if (!$user->dailyhours) {
            $sicknessquota = 0;
          }
          else {
            $sicknessquota =  round(($sickHours/($contracthours))*100,2);
          }
        }

        $payed11 = round(($user->dailyagent->sum('time_in_state')/3600),2);

        $productiveStates = array('Wrap Up','Ringing', 'In Call','On Hold','Available','Released (05_occupied)','Released (06_practice)','Released (09_outbound)');

        $productive = $user->dailyagent->whereIn('status', $productiveStates)
        ->sum('time_in_state');

        $productive = round(($productive/3600),2);

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
          'workedHours' => $workedHours,
          // 'sickHours' => $sickHours,
          'sicknessquota' => $sicknessquota,
          'payedtime11' => $payed11,
          'productive' => $productive,
          'aht' => $AHT,
          'sickhours' => $sickHours,
        );
      }
      // dd($users->where('id',26));
      // return view('usersIndex', compact('users'));
      return view('presentation', compact('modul', 'users'));
    }
    public function test($value='')
    {
      $start_date = '2021-02-01';
      $end_date = '2021-02-28';

      $users = User::where('role','agent')
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
