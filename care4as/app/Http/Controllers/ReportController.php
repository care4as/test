<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RetentionDetail;
use App\Mail\BestWorst;
use App\Mail\FAMail;
use App\User;
use App\DailyAgent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function allReports()
    {
      return view('reports');
    }

    public function FaMail(Request $request)
    {

    }
    public function updateHoursReport($value='')
    {
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0');

      $insertData=array();

      $userids =   DB::table('users')
      ->where('role','Agent')
      ->pluck('ds_id');

      $chronology = DB::connection('mysqlkdw')
      ->table('chronology_work')
      ->whereIn('MA_id', $userids)
      ->whereDate('work_date', '>', Carbon::today()->startOfWeek()->subWeeks(10))
      ->get()
      ->toArray();

      for ($i = 0; $i <= count($chronology)-1; $i++) {

        $data = $chronology[$i];

        $checkData[$i] = [

          'work_date' => $data->work_date,
          'MA_id' => $data->MA_id,
        ];

        $insertData[$i] = [

          'state_id' => $data->state_id,
          'work_time_begin' => $data->work_time_begin,
          'work_time_end' => $data->work_time_end,
          'work_hours' => $data->work_hours,
          'pause_hours' => $data->pause_hours,
          'pay_break_hours' => $data->pay_break_hours,
          'over_time_hours' => $data->over_time_hours,
          'pay_hours' => $data->pay_hours,
          'meeting_hours' => $data->meeting_hours,
          'wc_hours' => $data->wc_hours,
          'drink_hours' => $data->drink_hours,
          'smok_hours' => $data->smok_hours,
          'lunch_hours' => $data->lunch_hours,
          'contacts_hours' => $data->contacts_hours,
        ];
      }


      $insertData = array_chunk($insertData, 3500);
      $checkData = array_chunk($checkData, 3500);

      for($i=0; $i <= count($insertData)-1; $i++)
      {
        for ($j=0; $j < count($insertData[$i])-1; $j++) {
          DB::table('hours_report_imitation')->updateOrInsert(
            $checkData[$i][$j],
            $insertData[$i][$j],
          );
        }
      }

      return redirect()->back();
    }
    public function bestWorstReport(Request $request)
    {
      // dd($request);
      $request->validate([
        'best' => 'required_without:worst',
        'worst' => 'required_without:best',
        // 'from' => 'required',
        // 'to' => 'required',
      ]);

      if($request->from)
      {
        $from = $request->from;
      }
      else {
        $from = Carbon::parse(RetentionDetail::min('call_date'))->format('Y-m-d');
      }

      if($request->to)
      {
        $to = $request->to;
      }
      else {
        $to = Carbon::parse(RetentionDetail::max('call_date'))->format('Y-m-d');
      }

      $bestAgents = $request->best;
      $worstAgents = $request->worst;

      $query = RetentionDetail::query();

      $query->when(request('from'), function ($q,$from) {
        return $q->where('call_date','>=', $from);
      });
      $query->when(request('to'), function ($q, $to) {
        return $q->where('call_date','<=', $to);
      });
      $query->when(request('mobile') && request('dsl') == null, function ($q) {
        return $q->where('department_desc','=', 'Retention Mobile Inbound Care4as Eggebek');
      });
      $query->when(request('dsl') && request('mobile') == null, function ($q) {
        return $q->where('department_desc','=', 'Care4as Retention DSL Eggebek');
      });

      $reports = $query->get();

      $personids = $reports->unique('person_id')->pluck('person_id');

      $users = User::whereIn('person_id',$personids)
      ->get();

      if(request('employees'))
      {
        $users = User::whereIn('person_id',$personids)
        ->where('role','agent')
        ->whereNotIn('id', request('employees'))
        ->get();
      }
      else {
        $users = User::whereIn('person_id',$personids)
        ->where('role','agent')
        ->get();
      }

      foreach($users as $user)
      {
        $user->performance = ($reports->where('person_id', $user->person_id)->sum('orders') / $reports->where('person_id', $user->person_id)->sum('calls'))*100;

        $user->dailyPerformance = $reports->where('person_id',$user->person_id)->map(function ($item, $key) {
            return $item->only(['call_date', 'orders', 'calls','calls_smallscreen','orders_smallscreen']);
        })->values();
      }

      // dd($users);
      $sorted = $users->sortBy('performance')->values();

      if( $users->count() < $worstAgents || $users->count() < $bestAgents)
      {
        return view('reports')->withErrors('Zu wenige User');
      }
      else {
        for ($i=0; $i < $worstAgents; $i++) {
          $worstusers[] = $sorted[$i];
        }
        for ($i=0; $i < $bestAgents; $i++) {
          $bestusers[] = $sorted[(count($sorted)-1) - $i];
        }
      }

      // dd($bestusers);

      $data= array(
        'best' => $bestAgents,
        'worst' => $worstAgents,
        'from' => $from,
        'to' => $to,
        'bestusers' => $bestusers,
        'worstusers' => $worstusers,
      );

      $mail = new BestWorst($data);

      if($request->asEmail)
      {
        $mailinglist = explode(';',$request->mailinglist);
        Mail::to($mailinglist)->send($mail);

        return redirect()->back();
      }
      else {
        return $mail;
      }
    }

    public function AHTdaily()
    {
      ini_set('memory_limit', '-1');

      $casetime = 0;
      $calls = 0;

      $department = 'DE_care4as_KBM_RT_Eggebek';

      $end_date = Carbon::today()->format('Y-m-d H:i:s');

      if(request('start_date'))
      {
        $start_date = request('start_date');
      }
      else {
        $start_date = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
        $start_date = '2021-03-01';
      }
      if (request('end_date')) {
        $end_date = request('end_date');
      }
      else {
        $end_date = Carbon::today();
      }

      // return $end_date;
      $reports = DailyAgent::whereDate('date','>=',$start_date)
      ->whereDate('date','<=', $end_date)
      ->select('date','status','time_in_state','agent_group_name')
      ->get();

      // dd($reports);
      $repMobile = $reports->where('agent_group_name','DE_care4as_KBM_RT_Eggebek');
      $repDSL = $reports->where('agent_group_name','DE_care4as_RT_DSL_Eggebek');


      $dailyValues2 = array();

      function getValues($reports)
      {
        $dailyValues = array();
        $ahtStates = array('On Hold','Wrap Up','In Call');
        $finalValues = array();

        // dd($reports);
        foreach ($reports as $key => $value) {

          $dailyValues[$value->date->format('Y-m-d')][] = $value;
        }

        // dd($dailyValues);
        foreach ($dailyValues as $key => $array) {
          $casetime = 0;
          $calls = 0;

          foreach ($array as $value) {

            if(in_array($value['status'],$ahtStates))

              $casetime = $casetime + $value['time_in_state'];

              if($value['status'] == 'Ringing')
              {
                $calls++;
              }

          }
          $finalValues[$key] = array($casetime,$calls);
        }
        return $finalValues;
      }

      $finalValuesMob = getValues($repMobile);
      $finalValuesDSL = getValues($repDSL);

      // dd($finalValues);
      return view('reports.AHTdaily', compact('finalValuesMob','finalValuesDSL'));
    }
}
