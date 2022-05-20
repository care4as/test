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
    public function userIndex($department=1)
    {

      //get userdata from kdw tool
      $userdata = DB::connection('mysqlkdw')->table('MA')->where('ds_id',Auth()->user()->ds_id)->first();
      //get vacation days within this month
      $startOfWeek = new \Carbon\Carbon('Monday this week');

      $userVacation = DB::connection('mysqlkdw')
      ->table('chronology_work')
      ->where('MA_id',Auth()->user()->ds_id)
      ->whereIn('state_id', [2, 11])
      ->where('work_date','>', $startOfWeek)
      ->sum('work_hours');
      // dd($userVacation->sum('work_hours'));

      $startOfMonth = new \Carbon\Carbon('First day of this month');
      $userVacationM = DB::connection('mysqlkdw')
      ->table('chronology_work')
      ->where('MA_id',Auth()->user()->ds_id)
      ->whereIn('state_id', [2, 11])
      ->where('work_date','>', $startOfMonth)
      ->sum('work_hours');
      // dd($userVacation->sum('work_hours'));

      $weekSP = Auth()->user()->load('TrackingOverall')->TrackingOverall;
      $monthSP = Auth()->user()->load('TrackingOverallMonth')->TrackingOverallMonth;
      $trackcalls = Auth()->user()->load('TrackingCallsToday')->TrackingCallsToday;
      $trackcallsW = Auth()->user()->load('TrackingCallsWeek')->TrackingCallsWeek;
      $trackcallsM = Auth()->user()->load('TrackingCallsMonth')->TrackingCallsMonth;

      $history = Auth()->user()->load('TrackingToday')->TrackingToday;

      $history2 = TrackEvent::where('created_by',Auth()
      ->user()->id)
      ->orderBy('created_at','Desc')
      ->limit(1000)
      ->get();

      // $history = $monthSP->where('created_at', Carbon::today());
      // dd($monthSP->where('event_category','Save'));

      // dd($history2[1]);
      if ($department != 1) {
        return view('trackingDSL', compact('history','history2','trackcalls','monthSP','weekSP', 'userdata','trackcallsW','trackcallsM','userVacation','userVacationM'));
      }
      else {
        return view('trackingMobile', compact('history','history2','trackcalls','monthSP','weekSP','userdata','trackcallsW','trackcallsM','userVacation','userVacationM'));
      }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
      $request->validate([
        'contract_number' => 'required',
        'product_category' => 'required',
        'event_category' => 'required',
        'optin' => 'required',
        'runtime' => 'required',
        'backoffice' => 'required',
      ]);

      $trackevent = new TrackEvent;
      $additionalProperties = array('created_by' => Auth()->id());
      // dd(request()->except(['_token']));
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

    public function AdminIndex($department = 'Mobile')
    {
      if($department == 'DSL')
      {
        $department ='1und1 DSL Retention';
      }
      elseif ($department == 'Mobile') {
        $department = '1und1 Retention';
        // dd($department);
      }
      else {
        $department == 'all';
      }


      $users = User::with('TrackingToday','TrackingCallsToday')
      ->where('status', 1)
      // ->where('project','1und1 Retention')
      ->where('project',$department)
      ->where('department','Agenten')
      ->get();

      // $ids = $users->pluck('id');

      $history = TrackEvent::
      // with(['createdBy' => function($q) use ($department){
      //   $q->where('project',$department);
      //
      //   }])
      // ->whereHas('project')
      whereHas('createdBy' , function ($createdBy) use($department){
        $createdBy->where('project',$department);
      })
      // ->whereIn('created_by', $ids)
      ->orderBy('created_at','DESC')
      ->limit('3000')
      ->get();

      // dd($history[2], $history);
      if($department == '1und1 DSL Retention')
      {
        return view('trackingDSLAdmin', compact('history', 'users'));
      }
      else {
        // dd($users);
      return view('trackingMobileAdmin', compact('history', 'users'));
      }
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
        }}])

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

      // categories
      // 1 = SSC Calls
      // 2 = BSC Calls
      // 3 = Portal Calls
      // 4 = Sonstige Calls
      // 5 = Rentention Calls
      // 6 = Prevention Calls

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
