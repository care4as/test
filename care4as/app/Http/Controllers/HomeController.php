<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
      $modul = 'Userübersicht';

      $users = User::where('role','agent')->get();

      foreach ($users as $key => $user) {

        $query = \App\RetentionDetail::query();

        $query->where('person_id',$user->person_id)
        ->orderBY('call_date','DESC');
        // the filter section
        $query->when(request('start_date'), function ($q) {
            return $q->where('call_date', '>=',request('start_date'));
        });
        $query->when(request('end_date'), function ($q) {
            return $q->where('call_date', '<=',request('end_date'));
        });

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
          $SSCQouta = ($sumSSCOrders/$sumSSCCalls)*100;
        }
        if($sumBSCCalls == 0)
        {
          $BSCQuota = 0;
        }
        else {
          $BSCQuota = ($sumBSCOrders/$sumBSCCalls)*100;
        }
        if($sumPortalCalls == 0)
        {
          $portalQuota = 0;
        }
        else {
          $portalQuota = ($sumPortalOrders/$sumPortalCalls) *100;
        }

        $user->salesdata = array(
          'calls' => $sumSSCCalls + $sumBSCCalls +$sumPortalCalls,
          'workedDays' => $workdays,
          'sscCalls' => $sumSSCCalls,
          'sscOrders' => $sumSSCOrders,
          'bscCalls' =>  $sumBSCCalls,
          'bscOrders' => $sumBSCOrders,
          'portalCalls' => $sumPortalCalls,
          'portalOrders' => $sumPortalOrders );
      }

      // dd($users);
      // return view('usersIndex', compact('users'));
      return view('presentation', compact('modul', 'users'));
    }
    public function FunctionName($value='')
    {

    }
}
