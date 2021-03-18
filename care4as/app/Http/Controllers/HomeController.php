<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hoursreport;
use App\RetentionDetail;
use App\DailyAgent;
use Illuminate\Support\Facades\DB;

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

      $modul = 'Userübersicht';

      $start_date = 1;
      $end_date = 1;

      if($request->start_date)
      {
        $start_date = $request->start_date;
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
            $q->where('date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('date','<=',$end_date);
          }
          }])
        ->limit(10);
      }
      else {

        if ($request->department) {
          $department = $request->department;
        }
        else {
          $department = '';
        }

        $users = User::where('role','agent')
        ->where('department', $department)
        ->select('id','surname','lastname','person_id','agent_id','dailyhours','department')
        ->where('agent_id','!=',null)
        ->with(['dailyagent' => function($q) use ($start_date,$end_date){
          $q->select(['id','agent_id','status','time_in_state','date']);
          if($start_date !== 1)
          {
            $q->where('date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('date','<=',$end_date);
          }
        }])
        // ->limit(10)
        ->get();
      }

      foreach ($users as $key => $user) {

        $query = \App\RetentionDetail::query();

        $query->where('person_id',$user->person_id)
        ->orderBY('call_date','DESC');
        // the filter section
        if(request('start_date') != request('end_date'))
        {
          $query->when(request('start_date'), function ($q) {
              return $q->where('call_date', '>=',request('start_date'));
          });
          $query->when(request('end_date'), function ($q) {
              return $q->where('call_date', '<=',request('end_date'));
          });
        }
        else {
          $query->when(request('start_date'), function ($q) {
              return $q->where('call_date', '=',request('start_date'));
          });
        }

        $user->reports = $query->get();

        $reports = $user->reports;
        $sumorders = 0;
        // sum of all calls during the timespan
        $sumcalls = 0;
        $sumNMlz = 0;
        $sumrlz24 = 0;
        $sumSSCCalls = 0;
        $sumBSCCalls = 0;
        $sumPortalCalls = 0;
        $sumSSCOrders = 0;
        $sumBSCOrders = 0;
        $sumPortalOrders = 0;
        $AHT = null;
        $workdays = 0;
        $workedHours = 0;
        $sickHours = 0;
        $sicknessquota = '';

        for($i = 0; $i <= count($reports)-1; $i++)
        {
          if($reports[$i])
          {
            $workdays ++;
            $sumorders += ($reports[$i]->orders);
            $sumcalls += ($reports[$i]->calls);

            $sumSSCCalls += ($reports[$i]->calls_smallscreen);
            $sumBSCCalls += ($reports[$i]->calls_bigscreen);
            $sumPortalCalls += ($reports[$i]->calls_portale);
            $sumSSCOrders += ($reports[$i]->orders_smallscreen);
            $sumBSCOrders += ($reports[$i]->orders_bigscreen);
            $sumPortalOrders += ($reports[$i]->orders_portale);

            $sumrlz24 += ($reports[$i]->rlzPlus);
            $sumNMlz += ($reports[$i]->mvlzNeu);
          }
        }

        if($sumSSCCalls == 0)
        {
          $SSCQouta = 0;
        }
        else {
          $SSCQouta = round(($sumSSCOrders/$sumSSCCalls)*100,2).'%';
        }
        if($sumBSCCalls == 0)
        {
          $BSCQuota = 0;
        }
        else {
          $BSCQuota = round(($sumBSCOrders/$sumBSCCalls)*100,2).'%';
        }
        if($sumPortalCalls == 0)
        {
          $portalQuota = 0;
        }
        else {
          $portalQuota = round(($sumPortalOrders/$sumPortalCalls) *100,2).'%';
        }

        if($sumrlz24 == 0 or $sumNMlz == 0)
        {
          $RLZQouta = 'keine Daten';
        }
        else {
          $RLZQouta = round((($sumrlz24 / ($sumrlz24 + $sumNMlz))*100),2).'%';
        }
        if($sumcalls == 0)
        {
          $gevocr = 'Fehler: keine Calls';
        }
        else
        {
          $gevocr = round(($sumorders/$sumcalls) * 100,2).'%';
        }
        $queryWorktime = Hoursreport::query();
        $queryWorktime->where('user_id',$user->id)
        ->orderBY('date','DESC');

        // the filter section
        $queryWorktime->when(request('start_date'), function ($q) {
            return $q->where('date', '>=',request('start_date'));
        });
        $queryWorktime->when(request('end_date'), function ($q) {
            return $q->where('date', '<=',request('end_date'));
        });

        $workTimeData = $queryWorktime->get();
        // dd($user->workTimeData);
        $workedHours = $workTimeData->sum('IST_Angepasst');
        $sickHours = $workTimeData->sum('sick_Angepasst');

        if($workedHours == 0)
        {
          $sicknessquota = 'keine validen Daten';
        }
        else {
          $sicknessquota =  ($sickHours/$workedHours)*100;
        }


        $payed = round(($user->dailyagent->sum('time_in_state')/3600),2);

        if($payed == 0)
        {
          $payed = 'Fehler: bezahlte Zeit ist 0';
        }

        $productiveStates = array('Wrap Up','Ringing', 'In Call','On Hold','Available','Released (05_occupied)','Released (06_practice)','Released (09_outbound)');

        $productive = $user->dailyagent->whereIn('status', $productiveStates)
        ->sum('time_in_state');

        $productive = round(($productive/3600),2);

        $user->salesdata = array(
          'calls' => $sumcalls,
          'orders' => $sumorders,
          'workedDays' => $workdays,
          'sscQuota' => $SSCQouta,
          'sscOrders' => $sumSSCOrders,
          'bscQuota' =>  $BSCQuota,
          'bscOrders' => $sumBSCOrders,
          'portalQuota' => $portalQuota,
          'portalOrders' => $sumPortalOrders,
          'RLZ24Qouta' => $RLZQouta,
          'GeVo-Cr' => $gevocr,
          'workedHours' => $workedHours,
          'sickHours' => $sickHours,
          'payedtime' => $payed,
          'productive' => $productive,
        );
      }
      // return view('usersIndex', compact('users'));
      return view('presentation', compact('modul', 'users'));
    }
    public function FunctionName($value='')
    {

    }
}
