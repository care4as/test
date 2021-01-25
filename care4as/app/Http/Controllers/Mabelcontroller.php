<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mabelcause;

class Mabelcontroller extends Controller
{
    public function showThemAll()
    {
      $stats1 = array();
      $stats2 = array();
      $mabelCs = mabelcause::with('DidIt', 'GotIt')->get();

      $users= \App\User::where('role','agent')
      ->get();

      foreach ($users as $user) {
        // code...
        $count = $mabelCs->where('WhoGotIt', $user->id)->count();
        $stats1[$user->name] = $count;
      }

      $mablers= \App\User::where('role','!=','agent')
      ->get();

      foreach ($mablers as $user) {
        // code...
        $count = $mabelCs->where('WhoDidIt', $user->id)->count();
        $stats2[$user->name] = $count;
      }
      // $whoGotTheMost = $mabelCs->pluck('');
      // dd($count);
      return view('MabelShow', compact('mabelCs', 'stats1', 'stats2'));

    }
    public function showThemAllFiltered(Request $request)
    {
      $query = mabelcause::query();

      if(request('to') == request('from') and request('to'))
      {
        // return 1;
        $query->whereDate('created_at', '=', request('to'));
      }
      else {
        $query->when(request('from'), function ($q) {
            return $q->where('created_at','>=',request('from'));
        });
        $query->when(request('to'), function ($q) {
            return $q->where('created_at','<=',request('to'));
        });
      }

      $mabelCs = $query->get();

      $users= \App\User::where('role','agent')
      ->get();

      foreach ($users as $user) {
        // code...
        $count = $mabelCs->where('WhoGotIt', $user->id)->count();
        $stats1[$user->name] = $count;
      }

      $mablers= \App\User::where('role','!=','agent')
      ->get();

      foreach ($mablers as $user) {
        // code...
        $count = $mabelCs->where('WhoDidIt', $user->id)->count();
        $stats2[$user->name] = $count;
      }

      return view('MabelShow', compact('mabelCs', 'stats1', 'stats2'));

    }
    public function save(Request $request)
    {
      $request->validate([
        'contractnumber' => 'required',
        'whogotit' => 'required',
      ]);

      $mabelC = new mabelcause;
      $mabelC->WhoDidIt = Auth()->user()->id;
      $mabelC->ContractID = $request->contractnumber;
      $mabelC->WhoGotIt = $request->whogotit;
      $mabelC->WhyBro = $request->why;

      $mabelC->save();

      return redirect()->back();
    }
    public function create()
    {
      $users= \App\User::where('role','agent')
      ->get();

      return view('mabelcauseForm', compact('users'));
    }
}
