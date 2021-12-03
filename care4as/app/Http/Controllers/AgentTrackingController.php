<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackEvent;
use App\TrackCalls;
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
      $history = TrackEvent::where('created_by', Auth()->id())
      ->get();
      $trackcalls = TrackCalls::where('user_id', Auth()->id())
      ->whereDate('created_at', Carbon::today())
      ->get();


      // dd();
      return view('trackingMobile', compact('history','trackcalls'));
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
          'contract_number' => 'required|unique:track_events',
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

        $trackevent->contract_number = $request->contract_number;
        $trackevent->product_category = $request->product_category;
        $trackevent->event_category = $request->event_category;
        $trackevent->optin = $request->optin;
        $trackevent->runtime = $request->runtime;
        $trackevent->backoffice = $request->backoffice;
        $trackevent->target_tariff = $request->target_tariff;
        $trackevent->created_by = Auth()->id();
        $trackevent->save();

        // dd($trackevent);
        return redirect()->back();
    }
    public function AdminIndex()
    {
      $events = TrackEvent::with('createdBy')
      ->get();

      dd($events);
      // return view('adminIndex');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
