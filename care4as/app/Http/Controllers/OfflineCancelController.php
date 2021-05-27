<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfflineTracking;

class OfflineCancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offlinetracks = OfflineTracking::with('user')->get();

        $usersdouble = $offlinetracks->map(function($element, $value){
            return $element->user;

        });

        $users = ($usersdouble->unique());

        // dd($users);
        return view('test', compact('offlinetracks','users'));
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
