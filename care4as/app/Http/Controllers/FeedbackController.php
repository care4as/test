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
      $feedbacks = Feedback::all();

      return view('FeedbackIndex', compact('feedbacks'));
    }
    public function create()
    {
      $users = User::where('role','agent')->get();
      return view('FeedBackCreate', compact('users'));
    }
    public function print($userid = null)
    {
      DB::disableQueryLog();
      $year = 2021;

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
          $query = \App\RetentionDetail::query();
          $query->where('person_id',$userreport->person_id);

          $queryDepartment = \App\RetentionDetail::query();
          // $queryDepartment->where('person_id','!=',$userreport->person_id);

          if($userreport->department == '1&1 Mobile Retention')
          {
            $department = 'Retention Mobile Inbound Care4as Eggebek';
          }
          else
          {
            $department = 'Care4as Retention DSL Eggebek';
          }

          $queryDepartment->where('department_desc',$department);

          $start_date = Carbon::now();
          $end_date = Carbon::now();

          $start_date->setISODate($year,$kwi,1)->format('Y-m-d');
          $start_date->setTime(0,0);
          // return $start_date;
          $end_date->setISODate($year,$kwi,7)->format('Y-m-d');
          $end_date->setTime(23,59,59);

          $query->where('call_date','>=', $start_date);
          $query->where('call_date','<=', $end_date);

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
          $kwdata[$kwi] = $query->get();

          $queryDepartment->where('call_date','>=', $start_date);
          $queryDepartment->where('call_date','<=', $end_date);

          $teamdata[$kwi] = $queryDepartment->get();
        }

        $activestatus = array('Wrap Up','Ringing', 'In Call','On Hold','Available');
        // dd($teamdata);
        if($userreport->agent_id)
        {

          foreach ($kwworkdata as $key => $DAweek) {

          $totaltime = $DAweek->sum('time_in_state');

          $occutime = $DAweek->where('status','Released (05_occupied)')->sum('time_in_state');

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
            'nacharbeit' => $occutime,
            'aht' => $aht
          );
          }
        }
        else {
          abort(403,'user: '.$userreport->name.' hat keine agent ID');
          }

        foreach ($kwdata as $kwn => $RETday) {

          //userperformance
          $calls = $kwdata[$kwn]->sum('calls');
          $savesssc = $kwdata[$kwn]->sum('orders_smallscreen');
          $savesbsc = $kwdata[$kwn]->sum('orders_bigscreen');
          $savesportal = $kwdata[$kwn]->sum('orders_portale');
          $mvlzneu = $kwdata[$kwn]->sum('mvlzNeu');
          $rlzPlus = $kwdata[$kwn]->sum('rlzPlus');

          //enduserperformance

          //teamperformance including user
          $teamcalls = $teamdata[$kwn]->sum('calls');
          $sscTeam = $teamdata[$kwn]->sum('orders_smallscreen');
          $bscTeam = $teamdata[$kwn]->sum('orders_bigscreen');
          $portalTeam = $teamdata[$kwn]->sum('orders_portale');
          //end teamperformance

          $weekperformance[] = array(
            'name' => $kwn,
            'calls' => $calls,
            'savesssc' => $savesssc,
            'savesbsc' => $savesbsc,
            'savesportal' => $savesportal,
            'mvlzneu' => $mvlzneu,
            'rlzPlus' => $rlzPlus,
            'callsTeam' => $teamcalls,
            'sscTeam' => $sscTeam,
            'bscTeam' => $bscTeam,
            'portalTeam' => $portalTeam,
          );

        }
        // dd($workdata);
        return view('FeedBackPrint', compact('users','userreport','weekperformance','workdata'));
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
