<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackEvent;
use App\TrackCalls;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AgentTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function userIndex()
    {

      // $monthSP = TrackEvent::where('created_by',Auth()->id())->get();
      //get userdata from kdw tool
      $userdata = DB::connection('mysqlkdw')->table('MA')->where('ds_id',Auth()->user()->ds_id)->first();
      //get vacation days within this month
      $startOfMonth = new \Carbon\Carbon('first day of this month');


      $userVacation = DB::connection('mysqlkdw')
      ->table('chronology_work')
      ->where('MA_id',Auth()->user()->ds_id)
      ->where('state_id',2)
      ->where('work_date','>', $startOfMonth)
      ->sum('work_hours');


      // dd($userVacation->sum('work_hours'));

      $monthSP = Auth()->user()->load('TrackingOverall')->TrackingOverall;
      $trackcalls = Auth()->user()->load('TrackingCallsToday')->TrackingCallsToday;
      $trackcallsM = Auth()->user()->load('TrackingCallsMonth')->TrackingCallsMonth;

      $history = Auth()->user()->load('TrackingToday')->TrackingToday;
      // $history = $monthSP->where('created_at', Carbon::today());
      // dd($userdata);
      return view('trackingMobile', compact('history','trackcalls','monthSP','userdata','trackcallsM','userVacation'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request);
        $request->validate([
          'contract_number' => 'required',
          'product_category' => 'required',
          'event_category' => 'required',
          'optin' => 'required',
          'runtime' => 'required',
          'backoffice' => 'required',
        ]);

        // $request->contract_number= 1312123;
        // $request->product_category= 'SSC';
        // $request->event_category= 'Cancel';
        // $request->optin= 1;
        // $request->runtime= 1;
        // $request->backoffice= 1;
        // $request->target_tarif= 'testtarif';

        $trackevent = new TrackEvent;

        $additionalProperties = array('created_by' => Auth()->id());

        $tranformed = request()->except(['_token']);
        // dd($tranformed);

        $trackevent->TranformRequestToModel($tranformed,$additionalProperties);
        // $trackevent->contract_number = $request->contract_number;
        // $trackevent->product_category = $request->product_category;
        // $trackevent->event_category = $request->event_category;
        // $trackevent->optin = $request->optin;
        // $trackevent->runtime = $request->runtime;
        // $trackevent->backoffice = $request->backoffice;
        // $trackevent->target_tariff = $request->target_tariff;
        // $trackevent->created_by = Auth()->id();
        // $trackevent->save();

        // dd($trackevent);
        return redirect()->back();
    }
    public function AdminIndex()
    {
      $history = TrackEvent::with('createdBy')
      ->orderBy('created_at','DESC')
      ->get();

      $users = User::with('TrackingToday','TrackingCallsToday')
      ->where('status', 1)
      ->where('project','1und1 Retention')
      ->get();

      foreach ($users as $key => $user) {
        if ($user->id == 408) {
          // dd($user);
        }

      }
      // $trackcalls = TrackCalls::all();

      // dd($users, $users[34]);
      return view('trackingMobileAdmin', compact('history', 'users'));
    }

    public function TrackingJson()
    {
      $start = 1;
      // $start = "2021-12-23";
      $end = 0;
      // $end = "2021-12-23";

      if (request('start')) {
        $start = request('start');
      }
      if (request('end')) {
        $end = request('end');
      }


      $users = User::
      with(['TrackingAllCalls' => function($q) use ($start,$end){
        // $q->select(['id','person_id','calls','time_in_state','call_date']);
        if($start == $end)
        {

          $q->whereDate('created_at','=',$start);
        }
        else
        {
          if($start !== 1)
          {
            $q->where('created_at','>=',$start);
          }
          if($end !== 0)
          {
            $q->where('created_at','<=',$end);
          }
        }
        }])
      ->with(['TrackingAll' => function($q) use ($start,$end){
        // $q->select(['id','person_id','calls','time_in_state','call_date']);
        if($start == $end)
        {
          $q->whereDate('created_at','=',$start);
        }
        else {
          if($start !== 1)
          {
            $q->where('created_at','>=',$start);
          }
          if($end !== 0)
          {
            $q->where('created_at','<=',$end);
          }
        }

        }])
      ->where('status', 1)
      ->where('project','1und1 Retention')
      ->get();

      // dd($start, $users);

      foreach ($users as $key => $user) {
        if ($user->TrackingAll->first()) {
          // dd($start, $user);
        }

        $insertarray = array(
          $user->name,
          $callsU = $user->TrackingAllCalls->sum('calls'),
          $user->TrackingAll->where('event_category','Cancel')->count(),
          $user->TrackingAll->where('event_category','Service')->count(),
          $sscCalls = $user->TrackingAllCalls->where('category',1)->sum('calls'),
          $sscSaves = $user->TrackingAll->where('product_category','SSC')->where('event_category','Save')->count(),
          $sscSaves_PBO = $user->TrackingAll->where('product_category','SSC')->where('event_category','Save')->where('backoffice',0)->count(),
          $sscCalls_NBO = $user->TrackingAll->where('product_category','SSC')->where('event_category','Save')->where('backoffice',1)->count(),
          $user->TrackingAllCalls->where('product_category','SSC')->where('event_category','KüRü')->count(),
          $user->TrackingAllCalls->where('product_category','SSC')->where('event_category','Cancel')->count(),
          $user->TrackingAllCalls->where('product_category','SSC')->where('event_category','Service')->count(),
          $this->roundUp($sscCalls,$sscSaves_PBO),
          $this->roundUp($sscCalls,$sscSaves),
          $bscCalls = $user->TrackingAllCalls->where('category',2)->sum('calls'),
          $bscSaves = $user->TrackingAll->where('product_category','BSC')->where('event_category','Save')->count(),
          $bscSaves_PBO = $user->TrackingAll->where('product_category','BSC')->where('event_category','Save')->where('backoffice',0)->count(),
          $user->TrackingAll->where('product_category','BSC')->where('event_category','Save')->where('backoffice',1)->count(),
          $user->TrackingAllCalls->where('product_category','BSC')->where('event_category','KüRü')->count(),
          $user->TrackingAll->where('product_category','BSC')->where('event_category','Cancel')->count(),
          $user->TrackingAllCalls->where('product_category','BSC')->where('event_category','Service')->count(),
          $this->roundUp($bscCalls,$bscSaves_PBO),
          $this->roundUp($bscCalls,$sscSaves),
          $portalCalls= $user->TrackingAllCalls->where('category',3)->sum('calls'),
          $portalSaves = $user->TrackingAll->where('product_category','Portale')->where('event_category','Save')->count(),
          $user->TrackingAll->where('product_category','Portale')->where('event_category','Save')->where('backoffice',0)->count(),
          $user->TrackingAll->where('product_category','Portale')->where('event_category','Save')->where('backoffice',1)->count(),
          $portalSaves_NBO = $user->TrackingAllCalls->where('product_category','Portale')->where('event_category','KüRü')->count(),
          $user->TrackingAllCalls->where('product_category','Portale')->where('event_category','Cancel')->count(),
          $user->TrackingAllCalls->where('product_category','Portale')->where('event_category','Service')->count(),
          $this->roundUp($portalCalls,$portalSaves_NBO),
          $this->roundUp($portalCalls,$portalSaves),
          $callsWoS = $user->TrackingAllCalls->where('category',4)->sum('calls'),
          $optins = $user->TrackingAll->where('optin',1)->count(),
          $this->roundUp(($callsU - $callsWoS) ,$optins),
        );

        $finalarray['trackingdata'][] = $insertarray;
      }
      $footerdata = array(
        $allCalls = $users->sum(function ($user) {
              return $user->TrackingAllCalls->sum('calls');
          }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('event_category','Cancel')->count();
          }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('event_category','Service')->count();
            }),
          $allSSCCalls = $users->sum(function ($user) {
              return $user->TrackingAllCalls->where('category',1)->sum('calls');
            }),
          $allSSCSaves = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','SSC')->where('event_category','Save')->count();
          }),
          $allSSCSaves_NBO = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','SSC')->where('event_category','Save')->where('backoffice',0)->count();
          }),
          $allSSCSaves_PBO = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','SSC')->where('event_category','Save')->where('backoffice',1)->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','SSC')->where('event_category','KüRü')->count();
          }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','SSC')->where('event_category','Cancel')->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','SSC')->where('event_category','Service')->count();
            }),
          $this->roundUp($allSSCCalls,$allSSCSaves_NBO),
          $this->roundUp($allSSCCalls,$allSSCSaves),
          $allBSCCalls = $users->sum(function ($user) {
              return $user->TrackingAllCalls->where('category',2)->sum('calls');
            }),
          $allBSCSaves = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','BSC')->where('event_category','Save')->count();
            }),
          $allBSCSaves_NBO = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','BSC')->where('event_category','Save')->where('backoffice',0)->count();
            }),
          $allBSCSaves_PBO = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','BSC')->where('event_category','Save')->where('backoffice',1)->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','BSC')->where('event_category','KüRü')->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','BSC')->where('event_category','Cancel')->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','BSC')->where('event_category','Service')->count();
            }),
          $this->roundUp($allBSCCalls,$allBSCSaves_NBO),
          $this->roundUp($allBSCCalls,$allBSCSaves),
          $allPortalCalls = $users->sum(function ($user) {
              return $user->TrackingAllCalls->where('category',3)->sum('calls');
            }),
          $allPortalSaves = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','Portale')->where('event_category','Save')->count();
            }),
          $allPortalSaves_NBO = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','Portale')->where('event_category','Save')->where('backoffice',0)->count();
            }),
          $allPortalSaves_PBO = $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','Portale')->where('event_category','Save')->where('backoffice',1)->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','Portale')->where('event_category','KüRü')->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','Portale')->where('event_category','Cancel')->count();
            }),
          $users->sum(function ($user) {
              return $user->TrackingAll->where('product_category','Portale')->where('event_category','Service')->count();
            }),
          $this->roundUp($allPortalCalls,$allPortalSaves_NBO),
          $this->roundUp($allPortalCalls,$allPortalSaves),
          $allETCCalls = $users->sum(function ($user) {
              return $user->TrackingAllCalls->where('category',4)->sum('calls');
            }),
          $allOptins = $users->sum(function ($user) {
              return $user->TrackingAll->where('optin',1)->count();
            }),
          $this->roundUp($allCalls,$allOptins),
        );

      $finalarray['footer'] = $footerdata;
      // $trackcalls = TrackCalls::all();

      // dd($users, $users[34]);
      return response()->json($finalarray);
    }
    function roundUp($calls,$quotient)
    {
      if($calls == 0)
      {
        $quota = 0;
      }
      else
      {
        $quota = round($quotient*100/$calls, 2);
      }

      return $quota;
    }
    public function trackCall($type, $updown)
    {
      // dd($type);

      if (TrackCalls::where('user_id', Auth()->id())->where('category', $type)->whereDate('created_at', Carbon::today())->exists())
      {
        $trackcalls = TrackCalls::where('user_id', Auth()->id())
        ->where('category', $type)
        ->whereDate('created_at', Carbon::today())
        ->first();
      }
      else {
        $trackcalls = new TrackCalls;

        $trackcalls->category = $type;
        $trackcalls->calls = 0;
        $trackcalls->user_id = Auth()->id();

      }

      // dd($trackcalls,$type, $updown);

      if($updown == '1')
      {
        $trackcalls->calls = $trackcalls->calls+1;
        $trackcalls->save();

      }
      else {
        if ($trackcalls->calls > 0) {
          $trackcalls->calls = $trackcalls->calls-1;
          $trackcalls->save();
        }

      }


      return redirect()->back();
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = TrackEvent::find($id);
        return response()->json($event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // dd($request);
        $model = TrackEvent::where('id',$request->trackid)->first();

        // dd($model);

        $requestX =  request()->except(['_token','trackid']);
        $model->TranformRequestToModel($requestX);
        $model->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Trackevent::where('id',$id)->delete();

        return redirect()->back();
    }
}
