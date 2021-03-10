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
      $request->validate([
        // 'from' => 'required',
        // 'to' => 'required',
      ]);

      $bestAgents = 3;
      $worstAgents = 3;
      $from = '2021-01-01';
      $to = '2021-01-31';

      $mailinglist = array(
        'andreas.robrahn@care4as.de',
      );

      $query = RetentionDetail::query();

      $query->where('call_date','>=', $from);
      $query->where('call_date','<=', $to);

      $reports = $query->get();

      $personids = $reports->unique('person_id')->pluck('person_id');

      $users = User::whereIn('person_id',$personids)->get();

      foreach($users as $user)
      {
        $user->performance = ($reports->where('person_id', $user->person_id)->sum('orders') / $reports->where('person_id', $user->person_id)->sum('calls'))*100;

        $user->dailyPerformance = $reports->where('person_id',$user->person_id)->map(function ($item, $key) {
            return $item->only(['call_date', 'orders', 'calls','calls_smallscreen','orders_smallscreen']);
        })->values();
      }

      $sorted = $users->sortBy('performance')->values();

      for ($i=0; $i < $worstAgents; $i++) {
        $worstusers[] = $sorted[$i];
      }
      for ($i=0; $i < $worstAgents; $i++) {
        $bestusers[] = $sorted[(count($sorted)-1) - $i];
      }

      // dd($bestusers);

      $data= array(
        'from' => $from,
        'to' => $to,
        'bestusers' => $bestusers,
        'worstusers' => $worstusers,
      );
      // $mail = new BestWorst($data);
      // return $mail;
      Mail::to('andreas.robrahn@care4as.de')->send(new BestWorst($data));


    }
}
