<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfflineTracking;
use App\User;
use Illuminate\Support\Facades\DB;

class OfflineCancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('offlineTracking')->get();

        date_default_timezone_set('Europe/Berlin');

        $date = \Carbon\Carbon::parse(date(now()));
        // $date->diffForHumans($cbv);

        //
        $date->setTime(0,0,0);
        //
        // $date->format('Y-m-d H:i:s');
        $trackings = OfflineTracking::whereDate('created_at',$date->format('Y-m-d'))
        ->get();

        // dd($trackings);
        // dd($trackings->where('timespan','8 - 9')->where('category',''));

        return view('overhead.userOfflineTrackingAnalysis', compact('users','trackings'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trackingUserOffline');
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
          'category' => 'required',
          'timespan' => 'required',
          'contract_number' => 'required',
        ]);

        $offTR = new OfflineTracking;
        $offTR->contract_number = $request->contract_number;
        $offTR->timespan = $request->timespan;
        $offTR->category = $request->category;
        $offTR->created_by = Auth()->user()->id;

        $offTR->save();
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
