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
      $userdata = DB::connection('mysqlkdw')->table('MA')->where('ds_id',Auth()->user()->ds_id)->first();

      $monthSP = Auth()->user()->load('TrackingOverall')->TrackingOverall;
      $trackcalls = Auth()->user()->load('TrackingCallsToday')->TrackingCallsToday;
      $trackcallsM = Auth()->user()->load('TrackingCallsMonth')->TrackingCallsMonth;

      $history = Auth()->user()->load('TrackingToday')->TrackingToday;
      // $history = $monthSP->where('created_at', Carbon::today());
      // dd($userdata);
      return view('trackingMobile', compact('history','trackcalls','monthSP','userdata','trackcallsM'));
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
