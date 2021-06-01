<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cancel;
use App\User;
use App\Role;
use App\Hoursreport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Support\Collection;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('TrackingToday')
        ->orderBy('surname', 'ASC')
        ->get();

        return view('usersIndex', compact('users'));
    }
    public function getUsersIntermediate()
    {
      // return 1;

      if(request('department'))
      {
        $userids = DB::table('intermediate_status')
        ->whereDate('date', Carbon::today())
        ->pluck('person_id')
        ->toArray();

        if(!$userids)
        {
            return abort(403, 'kein Zwischenstand von heute in der Datenbank');
        }
        else {
          $users= User::where('department',request('department'))
          ->where('role','Agent')
          ->whereIn('person_id',$userids)
          ->get();
        }


        return response()->json($users);
      }
      if(request('employees'))
      {
        return response()->json(request('employees'));
      }
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

    public function startEnd($start_date = 0, $end_date= 0)
    {
      if(request('start_date'))
      {
        $start_date = request('start_date');
      }
      if(request('end_date'))
      {
        $end_date = request('end_date');
      }

      // return $start_date;

      $history = DB::connection('mysqlkdw')
      ->table('MA')
      ->whereIn('standort',array('Flensburg','Eggebek'))
      ->whereDate('eintritt','>=',$start_date)

      ->where(function($q) use($start_date, $end_date){
        $q->whereDate('eintritt','>=',$start_date);
        $q->orWhere('austritt', '<=', $end_date);
        })
      ->get();

      // dd($history);

      return view('userStartEnd', compact('history'));
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
          'name' => 'required| unique:users',
          'password' => 'required',
          'role' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->lastname = $request->lastname;
        $user->password = Hash::make($request->password);
        $user->email = 'testmail'.rand(1,2500).'@mail.de';
        $user->role = $request->role;
        $user->team = $request->team;
        $user->department = $request->department;
        $user->person_id = $request->personid;
        $user->agent_id = $request->agentid;

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
      // dd($request);
      $request->validate([
        // 'person_id' => 'required|integer'
        ]);

        $user = User::find($id);


        if ($request->person_id) {
          $user->person_id = $request->person_id;
        }
        if ( $request->email) {

        if (Auth()->user()->id == $user->id) {

            $user->email = $request->email;
          }
          else {
            abort(403,'Du darfst nur deine eigene Email ändern');
          }
        }

        if ($request->dailyhours) {
          $user->dailyhours = $request->dailyhours;
        }

        if ($request->surname) {
          $user->surname = $request->surname;
        }

        if ($request->lastname) {
          $user->lastname = $request->lastname;
        }

        if ($request->team) {
          $user->team = $request->team;
        }

        if ($request->department) {
          $user->department = $request->department;
        }

        if ($request->agent_id) {
          $user->agent_id = $request->agent_id;
        }

        if ($request->kdwid) {
            $user->ds_id = $request->kdwid;
        }
        if ($request->role) {
            $user->role = $request->role;
        }
        if ($request->trackingid) {
            $user->tracking_id = $request->trackingid;
        }

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

    public function Scorecard($id)
    {
      $user = User::find($id);

      $roles = Role::all();
      return view('Scorecard',compact('user','roles'));
    }
    public function getSalesperformanceBetweenDates()
    {
      $avgCRArray = array();
      // return response()->json(request('userid'));
      // return request('start');

      if (request('start')) {
          $start_date = Carbon::createFromFormat('Y-m-d', request('start'))->format('Y-m-d');
      }
      else {
        $start_date = 1;
      }

      if (request('end')) {

        $end_date = Carbon::createFromFormat('Y-m-d', request('end'));
      }
      else {

        $end_date = 1;
      }

      // return response()->json($start_date);

      $user = User::where('id',request('userid'))
      ->where('role','agent')
      // ->select('id','surname','lastname','person_id','agent_id','dailyhours','department','ds_id')
      ->with(['retentionDetails' => function($q) use ($start_date,$end_date){
        // $q->select(['id','person_id','calls','call_date']);
        if($start_date !== 1)
        {
          $q->where('call_date','>=', $start_date);
            // return response()->json($start_date);
        }
        if($end_date !== 1)
        {
          $q->where('call_date','<=',$end_date);
        }
      }])
      // ->with('retentionDetails')
      ->first();
      // ->get();

      if ($user->retentionDetails->sum('calls') != 0) {
        $averageCR = round($user->retentionDetails->sum('orders') *100 / $user->retentionDetails->sum('calls'),2);

      }
      else {
        $averageCR = 0;
      }

      if ($user->retentionDetails->sum('calls_smallscreen') != 0) {

        $averageSSCCR = round($user->retentionDetails->sum('orders_smallscreen') *100 / $user->retentionDetails->sum('calls_smallscreen'),2);

      }
      else {
        $averageSSCCR = 0;
      }
      foreach($user->retentionDetails as $day)
      {
        if ($day->calls == 0) {
          $performanceArray[] = 0;
        }
        else {
          $performanceArray[] = round($day->orders *100 / $day->calls,2);
        }
        if ($day->calls_smallscreen == 0) {
          $sscArray[] = 0;
        }
        else {
          $sscArray[] = round($day->orders_smallscreen *100 / $day->calls_smallscreen,2);
        }

        $timestamparray[] = $day->call_date->format('d.m.');
        $avgCRArray[] = $averageCR;
        $averageSSCCArray[] = $averageSSCCR;
      }

      if(!isset($performanceArray))
      {
        return abort(403,'keine Daten im Zeitraum');
      }
      return response()->json(array($timestamparray,$performanceArray,$avgCRArray,$averageSSCCArray,$sscArray));
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
      $AHT = null;
      $year = Carbon::now()->year;
      $start_date = 1;
      $end_date = 1;

      if(request('start_date'))
      {
        $start_date = request('start_date');
      }
      else {
        $start_date = Carbon::now()->subDays(21)->format('Y-m-d H:i:s');
      }
      if (request('end_date')) {
        $end_date = request('end_date');
      }

      $monthlyAHT = null;
      $monthlyReports = null;

      if($start_date != 1)
      {
        $begin = Carbon::parse($start_date)->setTime(2,0,0);
      }
      else {
        $begin = Carbon::parse(Hoursreport::min('work_date'));
        $begin->setTime(2,0,0);
      }

      if($end_date != 1)
      {
        $end =  Carbon::parse($end_date)->setTime(23,59,59);
      }
      else {

        $end = Carbon::parse(Hoursreport::max('work_date'));
        $end->setTime(23,59,59);
      }

      $holidays = [
          //new years day
          Carbon::createFromDate($year, 1, 1)->toDateString(),

          $eastersunday = Carbon::createFromDate($year,3,21)->addDays(easter_days($year))->toDateString(),
          $easterfriday = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)-2)->toDateString(),
          $ascchrist = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)+39)->toDateString(),
          $pentecost = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)+49)->toDateString(),
          $pentecostmonday = Carbon::createFromDate($year,3,21)->addDays(easter_days($year)+50)->toDateString(),
          // 1. Mai
          Carbon::create($year, 5, 1)->toDateString(),
          //erster Weihnachstag
          Carbon::create($year, 12, 25)->toDateString(),
          //zweiter Weihnachstag
          Carbon::create($year, 12, 26)->toDateString(),

          //Tag der deutschen Einheit
          Carbon::create($year, 10, 3)->toDateString(),
      ];

      // dd($begin);

      $days = $begin->diffInDaysFiltered(function (Carbon $date) use($holidays){

        return $date->isWeekday() && !in_array($date->toDateString(),$holidays);

      }, $end);

      $dayscount = $begin->diffInDays($end);

      $weekenddays = array();

      for ($i=1; $i <= $dayscount; $i++) {

        $day = $begin->copy()->addDays($i);

        if($day->isWeekend())
        {
          $weekenddays[] = $day->format('Y-m-d');
        }
      }

      $user = User::where('id',$id)
      ->with(['dailyagent' => function($q) use ($start_date,$end_date){
        $q->select(['id','agent_id','status','time_in_state','date']);
        if($start_date !== 1)
        {

          $datemod = Carbon::parse($start_date)->setTime(2,0,0);
          $q->where('date','>=',$datemod);
        }
        if($end_date !== 1)
        {
          $datemod2 = Carbon::parse($end_date)->setTime(23,59,59);
          $q->where('date','<=',$datemod2);
        }
        }])
      ->with(['retentionDetails' => function($q) use ($start_date,$end_date){
        // $q->select(['id','person_id','calls','time_in_state','call_date']);
        if($start_date !== 1)
        {
          $q->where('call_date','>=',$start_date);
        }
        if($end_date !== 1)
        {
          $q->where('call_date','<=',$end_date);
        }
        }])
        ->with(['hoursReport' => function($q) use ($start_date,$end_date){

          if($start_date !== 1)
          {
            $q->where('work_date','>=',$start_date);
          }
          if($end_date !== 1)
          {
            $q->where('work_date','<=',$end_date);
          }
          }])

        ->first();

      if(!$user)
      {
        // get previous user id
       return redirect()->back()->withErrors('User nicht vorhanden');
      }
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

      $ahtStates = array('On Hold','Wrap Up','In Call');

      for($i=1; $i <= 12; $i++)
      {
        $startOfMonth= Carbon::createFromDate($year,$i,1);
        $Date2ToTransform= Carbon::createFromDate($year,$i,1);
        // $endOfMonth= \Carbon\Carbon::createFromDate($year,$i,31);
        $endOfMonth= $Date2ToTransform->modify('last day of this month');
        // echo $endOfMonth.'</br>';

        $retentiondetailreport = \App\RetentionDetail::where('person_id',$user->person_id)->whereDate('call_date','>=',$startOfMonth)->whereDate('call_date','<=',$endOfMonth)->select('call_date','calls_smallscreen','calls_bigscreen','calls_portale','orders_smallscreen','orders_bigscreen','orders_portale','mvlzNeu','rlzPlus')->get();
        $workreport = \App\Hoursreport::where('MA_id',$user->ds_id)->whereDate('work_date','>=',$startOfMonth)->whereDate('work_date','<=',$endOfMonth)->get();


        $workedHours = $workreport->sum('work_hours');

        $contracthours = $days * $user->dailyhours;
        $sickHours = $workreport->whereIn('state_id',array(1,7))->whereNotIn('work_date',$weekenddays)->sum('work_hours');

        if($workedHours !=0)
        {
          $sicknessquota = round($sickHours*100/$workedHours,2);
        }
        else {
          $sicknessquota = 0;
        }

        $monthlyReports[$i]['sicknessquota'] = $sicknessquota;
        $monthlyReports[$i]['retentiondata'][] = $retentiondetailreport;
        // $monthlyReports[$i]['aht'] = 700;

        $ahtmo = 0;
      }
      // dd($monthlyReports);


      $casetime = $user->dailyagent->whereIn('status', $ahtStates)->sum('time_in_state');

      $calls = $user->dailyagent->where('status', 'Ringing')
      ->count();

      if($calls == 0)
      {
        $AHT = 0;
      }
      else {
        $AHT =  round(($casetime/ $calls),0);
      }


      $workedHours = $user->hoursReport->sum('work_hours');
      $contracthours = $days * $user->dailyhours;
      $sickHours = $user->hoursReport->whereIn('state_id',array(1,7))->whereNotIn('work_date',$weekenddays)->sum('work_hours');

      if($workedHours != 0)
      {
        $sicknessquota = round($sickHours*100/$workedHours,2);
        $sicknessquotastring = $sicknessquota.'%';
      }
      else {
        $sicknessquotastring = 0;
      }

      $roles = \App\Role::where('name','!=','superadmin')->get();
      return view('AgentAnalytics', compact('user','reports','sumorders','sumcalls','sumrlz24','sumNMlz','salesdata','monthlyReports','AHT','sicknessquotastring', 'year','roles'));
    }

    public function changePassword(Request $request)
    {
      $request->validate([
        'newpassword' => 'required',
        'confirm_newpassword' => 'required|same:newpassword',
      ]);

      if($request->newpassword == $request->confirm_newpassword)
      {
          Auth()->user()->password = Hash::make($request->newpassword);
          Auth()->user()->save();
      }

      return redirect()->back();
    }
    public function changePasswordView()
    {
      return view('changePassword');
    }
    public function getAHTbetweenDates(Request $request)
    {
      // $endOfMonth= \Carbon\Carbon::createFromDate($year,$i,31);

      $user = User::find($request->userid);

      $productivereport = \App\DailyAgent::where('agent_id',$user->agent_id)->whereDate('date','>=',$request->firstDay)->whereDate('date','<=',$request->lastDay)->get();

      $ahtStates = array('On Hold','Wrap Up','In Call');

      $casetime = $productivereport->whereIn('status', $ahtStates)->sum('time_in_state');#
      $calls = $productivereport->where('status', 'Ringing')
      ->count();

      if($calls != 0)
      {
        $aht = round($casetime/$calls);
      }
      else {
        $aht = 'keine validen Daten';
      }

      return response()->json($aht);
  }
    public function delete($id)
    {
      User::where('id',$id)->delete();
      return redirect()->back();
    }

    public function connectUsersToKDW($value='')
    {
      $workers = DB::connection('mysqlkdw')
      ->table('MA')
      ->join('projekte', 'MA.projekt_id', '=', 'projekte.ds_id')
      ->select('MA.ds_id','MA.vorname','MA.familienname', 'MA.standort','projekte.bezeichnung')
      ->whereIN('projekte.bezeichnung', array('1und1 Retention','1und1 DSL Retention'))
      ->where('MA.austritt',null)
      ->get();


      foreach($workers as $worker)
      {
        DB::table('users')->where('surname',$worker->vorname)->where('lastname',$worker->familienname)
        ->update([
          'ds_id' => $worker->ds_id
        ]);
      }

      return redirect()->back();
    }
    public function deactivate($id)
    {
      User::where('id',$id)
      ->update([
        'status' => 0,
      ]);

      return redirect()->back();
    }
    public function activate($id)
    {
      User::where('id',$id)
      ->update([
        'status' => 1,
      ]);

      return redirect()->back();
    }
}
