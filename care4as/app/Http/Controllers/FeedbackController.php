<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Feedback;
use App\User;
use DateTime;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function index()
    {
      $feedbacks = Feedback::with(['Creator'],['withUser'])->get();

      dd($feedbacks);

      return view('FeedbackIndex', compact('feedbacks'));
    }

    public function create11($userid = null)
    {
      $year = Carbon::now()->year;
      $start_date = 1;
      $end_date = 1;


      if($userid)
      {
          dd($userid);
      }

      $users = User::where('role','agent')->select('id','surname','lastname','name')->get();

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

      }
      // dd($end_date, $start_date);

      $user = User::where('role','agent')
      ->select('id','surname','lastname','person_id','agent_id','dailyhours','department','ds_id')
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

        if($user->department == '1&1 Mobile Retention')
        {
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

      // dd($weekperformance);
      return view('FeedBackCreate', compact('users', 'user','weekperformance'));
    }
    public function print($userid = null)
    {
      DB::disableQueryLog();
      $year = Carbon::now()->year;

      $users = User::where('role','agent')->select('id','surname','lastname')->get();

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

          if($userreport->agent_id)
          {
            // return $userreport->agent_id;
            $query2->where('agent_id', $userreport->agent_id);
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
        if($userreport->agent_id)
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
}
