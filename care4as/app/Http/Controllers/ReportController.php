<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RetentionDetail;
use App\Mail\BestWorst;
use App\Mail\FAMail;
use App\User;
use App\DailyAgent;
use App\Hoursreport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\Intermediate;

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
      ini_set('memory_limit', '-1');
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
        $from = Carbon::today()->subDays(7)->format('Y-m-d');
      }

      if($request->to)
      {
        $to = $request->to;
      }
      else {
        $to = Carbon::today()->format('Y-m-d');
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

      $department = 'beides';

      if (request('mobile') && request('dsl') == null) {
        $department = 'mobile';
      }
      else {
          $department = 'dsl';
      }

      $reports = $query->get();

      $personids = $reports->unique('person_id')->pluck('person_id');

      $users = User::whereIn('person_id',$personids)
      ->get();

      if(request('employees'))
      {
        $users = User::whereIn('person_id',$personids)
        ->where('role','agent')
        ->whereNotIn('id', request('employees'))
        ->with('dailyAgent')
        ->with(['hoursReport' => function($q) use ($from,$to){

          if($from !== 1)
          {
            $q->where('work_date','>=',$from);
          }
          if($to !== 1)
          {
            $q->where('work_date','<=',$to);
          }
          }])
        ->get();
      }
      else {
        $users = User::whereIn('person_id',$personids)
        ->where('role','agent')
        ->with('dailyAgent')
        ->with(['hoursReport' => function($q) use ($from,$to){

          if($from !== 1)
          {
            $q->where('work_date','>=',$from);
          }
          if($to !== 1)
          {
            $q->where('work_date','<=',$to);
          }
          }])
        ->get();
      }

      foreach($users as $user)
      {
        $user->performance = ($reports->where('person_id', $user->person_id)->sum('orders') / $reports->where('person_id', $user->person_id)->sum('calls'))*100;

        $user->dailyPerformance = $reports->where('person_id',$user->person_id)->map(function ($item, $key) {
            return $item->only(['call_date', 'orders', 'calls','calls_smallscreen','orders_smallscreen']);
        })->values();

        $user->hrsPayed = $user->hoursReport->sum('work_hours');
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
        'department' => $department,
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
    public function sendIntermediateMail($value='')
    {
      App\Jobs\SendCRMail::dispatch()->onConnection('sync');
    }
    public function getIntermediate($value='')
    {
      Intermediate::dispatch('nonsync')->onQueue('intermediate')->onConnection('sync');
      return redirect()->back();
    }
    public function capacitysuiteReport(Request $request)
    {
      // dd($request);
      $request->validate([
        'department' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
      ]);

      $from = Carbon::parse($request->start_date);
      $to = Carbon::parse($request->end_date);

      $diff_in_days = $to->diffInDays($from);

      // dd($diff_in_days);

      $department = array();

      if ($request->department == 'Mobile') {
        $department = 7;
      }
      else {
          $department = 10;
      }
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      $days = 0;
      $sichknessquota = 0.08;

      if ($request->sickQ) {
        $sichknessquota = $request->sickQ;
      }

      $vacationquota = 0.08;

      if ($request->vacQ) {
        $vacationquota = $request->vacQ;
      }

      $trainingquota = 0.02;

      if ($request->trainQ) {
        $trainingquota = $request->trainQ;
      }

      $meetingquota = 0.01;

      if ($request->meetQ) {
        $meetingquota = $request->meetQ;
      }

      $otherabsencequota = 0.25;

      if ($request->oAQ) {
        $otherabsencequota = $request->oAQ;
      }

      $oparray = array();

      $headarray = array(
        'target_date',
        'duration_days',
        'workgroup_name',
        'agent_id',
        'agent_login_name',
        'contract_leaving_date',
        'heads',
        'new_in_contract_heads',
        'new_in_workgroup_heads',
        'leaving_contract_heads',
        'leaving_workgroup_heads',
        'avg_contract_hrs',
        'avg_min_hrs',
        'avg_max_hrs',
        'staffed_hrs',
        'sickness_hrs',
        'vacation_hrs',
        'training_hrs',
        'meeting_hrs',
        'bank_holiday_hrs',
        'other_absence_hrs',
        'net_hrs',
        'unpaid_hrs',
        'shift_1_start',
        'shift_1_stop',
        'shift_2_start',
        'shift_2_stop',
        'shift_3_start',
        'shift_3_stop',
        'shift_4_start',
        'shift_4_stop',
        'comment'
      );

      $users = DB::connection('mysqlkdw')
      ->table('MA')
      ->where('projekt_id', $department)
      ->whereNull('austritt')
      ->whereNotNull('ext_reference_1')
      ->orderBy('familienname','ASC')
      ->get();


      // $users = App\User::all();
      // dd($users);

      $oparray[] = $headarray;

      for ($i=0; $i <= $diff_in_days + 1; $i++) {

        if ($i == 0) {
          $day = $from->copy()->subDays(1)->format('d.m.Y');
        }
        elseif ($i == 1) {
          $day = $from->format('d.m.Y');
        }
        else {
          $day = $from->copy()->addDays($i-1)->format('d.m.Y');
        }

        foreach($users as $user)
        {
          if($user->soll_h_day)
          {

            $valuearray = array();

            $valuearray[] = $day;
            $valuearray[] = 1;

            if ($user->projekt_id == 7) {

              $valuearray[] = 'WG_CARE4AS_SL_RETENTIONMOBILE_I';
            }
            else {

              $valuearray[] = 'WG_CARE4AS_FL_RETENTIONDSL_I';
            }

            $valuearray[] = $user->ds_id;
            $valuearray[] = $user->ext_reference_1;
            $valuearray[] = null;
            $valuearray[] = 1;
            $valuearray[] = 0;
            $valuearray[] = 0;
            $valuearray[] = 0;
            $valuearray[] = 0;
            $valuearray[] = $user->soll_h_day*5;
            $valuearray[] = $user->soll_h_day*4;
            $valuearray[] = $user->soll_h_day*6;

            //staffed_hours
            $valuearray[] = $user->soll_h_day;
            //sickness
            $valuearray[] = $sh = $user->soll_h_day * $sichknessquota;
            //vacation
            $valuearray[] = $vh = $user->soll_h_day * $vacationquota;
            //training
            $valuearray[] = $th = $user->soll_h_day * $trainingquota;
            //meeting
            $valuearray[] = $mh = $user->soll_h_day * $meetingquota;
            //bank holidays
            $valuearray[] = null;
            //other absence
            $valuearray[] = number_format($voa = $user->soll_h_day * $otherabsencequota, 2, ',', '.');

            //net hrs
            $valuearray[] = number_format($user->soll_h_day - $sh -$vh-$th-$mh-$voa, 2, ',', '.');

            //unpaid hrs
            $valuearray[] = 0;
            //shift_1_start
            $valuearray[] = null;
            //shift_1_stop
            $valuearray[] = null;
            //shift_2_start
            $valuearray[] = null;
            //shift_2_stop
            $valuearray[] = null;
            //shift_3_start
            $valuearray[] = null;
            //shift_3_stop
            $valuearray[] = null;
            //shift_4_strt
            $valuearray[] = null;
            //shift_4_stop
            $valuearray[] = null;
            $valuearray[] = 'Tagesbericht';

            $oparray[] = $valuearray;
          }
        }
      }
      //
      // dd('test');

      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="sample.csv"');

      $fp = fopen('php://output', 'wb');

      foreach ( $oparray as $line ) {

        fputcsv($fp, $line);
      }

      fclose($fp);
    }
    public function dailyAgentDataStatus()
    {
      return array($min = Carbon::parse(DailyAgent::min('date'))->format('d.m.Y H:i:s'), $max= Carbon::parse(DailyAgent::max('date'))->format('d.m.Y H:i:s'));
    }
    public function HRDataStatus()
    {
      return array($min = Carbon::parse(Hoursreport::min('work_date'))->format('d.m.Y'), $max= Carbon::parse(Hoursreport::max('work_date'))->format('d.m.Y'));
    }
    public function RDDataStatus()
    {
      return array($min = Carbon::parse(RetentionDetail::min('call_date'))->format('d.m.Y'), $max= Carbon::parse(RetentionDetail::max('call_date'))->format('d.m.Y'));
    }
}
