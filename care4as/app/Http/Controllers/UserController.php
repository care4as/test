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
      $sumSSCCalls = 0;
      $sumBSCCalls = 0;
      $sumPortalCalls = 0;
      $sumSSCOrders = 0;
      $sumBSCOrders = 0;
      $sumPortalOrders = 0;

      $monthlyReports = null;
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

      $salesdata = array(
        'sscCalls' => $sumSSCCalls,
        'sscOrders' => $sumSSCOrders,
        'bscCalls' =>  $sumBSCCalls,
        'bscOrders' => $sumBSCOrders,
        'portalCalls' => $sumPortalCalls,
        'portalOrders' => $sumPortalOrders );

      $reports = (new Collection($reports))->paginate(31);

      // $monthlyReports = \App\RetentionDetail::where('person_id',$user->person_id);

      $year = 2020;

      for($i=1; $i <= 12; $i++)
      {
        $startOfMonth= \Carbon\Carbon::createFromDate($year,$i,1);
        $Date2ToTransform= \Carbon\Carbon::createFromDate($year,$i,1);
        // $endOfMonth= \Carbon\Carbon::createFromDate($year,$i,31);
        $endOfMonth= $Date2ToTransform->modify('last day of this month');
        // echo $endOfMonth.'</br>';

        $monthlyReports[] = \App\RetentionDetail::where('person_id',$user->person_id)->whereDate('call_date','>',$startOfMonth)->whereDate('call_date','<',$endOfMonth)->select('calls_smallscreen','calls_bigscreen','calls_portale','orders_smallscreen','orders_bigscreen','orders_portale','mvlzNeu','rlzPlus')->get();
      }
      // dd($monthlyReports);
      // return 'break';

      return view('AgentAnalytics', compact('user','reports','sumorders','sumcalls','sumrlz24','sumNMlz','salesdata','monthlyReports'));
    }

    public function saveCancel(Request $request)
    {

    }
}
