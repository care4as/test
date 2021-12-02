<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackEvent;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //   'contract_number' => 'required',
        //   'product_category' => 'required',
        //   'event_category' => 'required',
        //   'optin' => 'required',
        //   'runtime' => 'required',
        //   'backoffice' => 'required',
        // ]);

        $request->contract_number= 1312123;
        $request->product_category= 'SSC';
        $request->event_category= 'Cancel';
        $request->optin= 1;
        $request->runtime= 1;
        $request->backoffice= 1;
        $request->target_tarif= 'testtarif';

        $trackevent = new TrackEvent;

        $trackevent->contract_number = $request->contract_number;
        $trackevent->product_category = $request->product_category;
        $trackevent->event_category = $request->event_category;
        $trackevent->optin = $request->optin;
        $trackevent->runtime = $request->runtime;
        $trackevent->backoffice = $request->backoffice;
        $trackevent->target_tarif = $request->target_tarif;
        $trackevent->created_by = Auth()->id();
        $trackevent->save();

        dd($trackevent);
        // return redirect()->back();
    }
    public function AdminIndex()
    {
      $events = TrackEvent::with('createdBy')
      ->get();

      dd($events);
      // return view('adminIndex');
    }
    public function trackCall($upDown)
    {

      if($upDown == 1)
      {
        if(TrackCall::where('user_id', Auth()->id())->whereDate('created_at', Carbon::today())->first())
        {
          TrackCall::where('user_id', Auth()->id())
          ->whereDate('created_at', Carbon::today())
          ->update([
            'calls' => DB::raw('count+1'),
          ]);
        }
      }
      else {
        TrackCall::where('user_id', Auth()->id())
        ->whereDate('created_at', Carbon::today())
        ->update([
          'calls' => DB::raw('count-1'),
        ]);
      }
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
