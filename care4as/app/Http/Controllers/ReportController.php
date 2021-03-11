<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RetentionDetail;
use App\Mail\BestWorst;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function allReports()
    {
      return view('reports');

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
        $from = \Carbon\Carbon::parse(RetentionDetail::min('call_date'))->format('Y-m-d');
      }

      if($request->to)
      {
        $to = $request->to;
      }
      else {
        $to = \Carbon\Carbon::parse(RetentionDetail::max('call_date'))->format('Y-m-d');
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


      // $query->where('call_date','>=', $from);
      // $query->where('call_date','<=', $to);
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

        foreach($mailinglist as $adress)
        {
          Mail::to($adress)->send($mail);
        }

        return redirect()->back();
      }
      else {
        return $mail;
      }
    }
}
