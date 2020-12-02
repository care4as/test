<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cancel;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Support\Collection;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('TrackingToday')->get();

        return view('usersIndex', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createUser');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => 'required',
          'password' => 'required',
          // 'name' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = 'testmail'.rand(1,2500).'@mail.de';
        $user->role = $request->role;

        $user->save();

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
      $request->validate([
        // 'person_id' => 'required|integer'
        ]);
        $user = User::find($id);
        $user->person_id = $request->person_id;
        $user->dailyhours = $request->dailyhours;


        $user->save();
        return redirect()->back();
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

    public function dashboard()
    {
      $user = Auth()->user();
      $user->load('TrackingToday');
      // dd();
      // if($tracking = Tracking::where('user_id', $user->id)->whereDate('updated_at', '=', Support\Carbon::today())->first())
      // {
      //
      // }
      // else
      // {
      //   $tracking = new Tracking;
      // }
      return view('dashboard',compact('user'));
    }
    public function AgentAnalytica($id='', Request $request=null)
    {

      // sum of all orders during the timespan
      $sumorders = 0;
      // sum of all calls during the timespan

      $sumcalls = 0;

      $sumNMlz = 0;
      $sumrlz24 = 0;

      // dd($request);
      $user = User::find($id);
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

      $reports = $query->get();

      for($i = 0; $i <= count($reports)-1; $i++)
      {
        if($reports[$i])
        {
          $sumorders += ($reports[$i]->orders);
          $sumcalls += ($reports[$i]->calls);
          $sumrlz24 += ($reports[$i]->rlzPlus);
          $sumNMlz += ($reports[$i]->mvlzNeu);
        }
      }
      $reports = (new Collection($reports))->paginate(20);
      return view('AgentAnalytics', compact('user','reports','sumorders','sumcalls','sumrlz24','sumNMlz'));
    }

    public function saveCancel(Request $request)
    {

    }
}
