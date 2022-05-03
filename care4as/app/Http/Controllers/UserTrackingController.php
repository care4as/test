<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserTracking;
use App\User;
use App\Intermediate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserTrackingController extends Controller
{
    public function trackEvent($action, $division, $type, $operator)
    {
      $tracking = new UserTracking;
      $tracking->user_id = Auth()->user()->id;

      // return $division;
      switch ($division) {
          case 'call':
            if($action == 'add')
            {
              $tracking->calls = 1;
              $tracking->type = 'add';
            }
            else
            {
              $tracking->calls = -1;
              $tracking->type = 'sub';
            }
            $tracking->division = 'call';
            $tracking->save();
              break;

            case 'Retention' or 'Prevention':

            if($action == 'save' or $action =='cancel' or $action =='service')
            {
              // return $operator;
              if($operator == 1)
              {
                $tracking->$action = 1;
              }
              else
              {
                // return $operator;
                $tracking->$action = -1;
              }
            }
            $tracking->type = $type;
            $tracking->division = $division;
            // dd($action);
            $tracking->save();
            break;
      }

      return redirect()->route('dashboard');
    }
    public function getCurrentTrackingAlt($dep= 'Mobile')
    {
      // return $dep;
      $dslSalesSata = '';
      $mobileSalesSata = '';

      if($dep == 'Mobile')
      {
        $department = '1und1 Retention';
        $agentRole ='Agent_Mobile';
        $mobileSalesSata = DB::connection('mysqlkdwtracking')
        ->table('1und1_mr_tracking_inb_new_ebk')
        // ->whereIn('MA_id', $userids)
        ->whereDate('date', '=', Carbon::today())
        ->get();

        $SalesSata = $mobileSalesSata;
      }

      else {
        $department = '1und1 DSL Retention';
        $agentRole ='Agent_DSL';
        $dslSalesSata = DB::connection('mysqlkdwtracking')
        ->table('1und1_dslr_tracking_inb_new_ebk')
        // ->whereIn('MA_id', $userids)
        ->whereDate('date', '=', Carbon::today())
        ->get();

        $SalesSata = $dslSalesSata;
      }

      // dd($SalesSata);
      $trackingidsMobile = $SalesSata->pluck('agent_ds_id')->toArray();

      $users = User::whereIn('kdw_tracking_id',$trackingidsMobile)
      ->where('role',$agentRole)
      ->where('project',$department)
      ->get();

      // dd($users);
      foreach($users as $key => $user)
      {
        if ($user->project == '1und1 Retention') {

          $user->salesdata = $mobileSalesSata->where('agent_ds_id', $user->kdw_tracking_id)->first();
          $user->ssc_calls = $user->salesdata->calls_ssc;
          $user->ssc_orders = $user->salesdata->ret_ssc_contract_save;
          $user->calls = $user->salesdata->calls;
          $user->bsc_calls = $user->salesdata->calls_bsc;
          $user->bsc_orders = $user->salesdata->ret_bsc_contract_save;
          $user->portal_calls = $user->salesdata->calls_portal;
          $user->portal_orders = $user->salesdata->ret_portal_save;
          $user->orders = $user->ssc_orders + $user->bsc_orders + $user->portal_orders;
          $user->optins = $user->salesdata->optin;

          if($user->ssc_calls != 0)
          {
            $user->ssc_quota = round(($user->ssc_orders*100/$user->ssc_calls),2);
          }
          else {
            $user->ssc_quota = 0;
          }

          $user->cr = $this->getQuota($user->calls, $user->orders);
          $user->bsccr = $this->getQuota($user->bsc_calls, $user->bsc_orders);
        }
        //the users in the dsl department
        else {

            if ($user->salesdata = $dslSalesSata->where('agent_ds_id', $user->kdw_tracking_id)->first()) {
              $user->calls = $user->salesdata->calls;
              // dd($user);
              $user->orders = $user->salesdata->ret_de_1u1_rt_save;

              if ($user->calls !=0 ) {

                  $user->dslqouta = round(($user->orders*100/$user->calls),2);
              }
              else {
                $user->dslqouta = 0;
              }

            }
            else {
              abort(403,'test Fehlercode noch nicht eindeutig');
            }
        }
      }

      $data[] = $users;

      // dd($users);
      if($dep == 'Mobile')
      {
        $allSSCCalls = $users->sum('ssc_calls');
        $allSSCOrders = $users->sum('ssc_orders');
        $allBSCCalls = $users->sum('bsc_calls');
        $allBSCOrders = $users->sum('bsc_orders');
        $allPortalCalls = $users->sum('portal_calls');
        $allPortalOrders = $users->sum('portal_orders');
        $allOrders = $allSSCOrders + $allBSCOrders + $allPortalOrders ;
        $allCalls = $users->sum('calls');
        $allOptins = $users->sum('optins');

        $data[] = array(
          'ssc_calls'=>$allSSCCalls,
          'ssc_saves'=>$allSSCOrders,
          'bsc_calls'=>$allBSCCalls,
          'bsc_saves'=>$allBSCOrders,
          'portal_calls'=>$allPortalCalls,
          'portal_saves'=>$allPortalOrders,
          'calls'=>$allCalls,
          'orders'=>$allOrders,
          'optins'=>$allOptins,
        );
      }
      else {
        $allCalls = $users->sum('calls');
        $allOrders = $users->sum('orders');
        $data[] = array(
          'calls'=>$allCalls,
          'orders'=>$allOrders,
        );
      }
      // $sorted = $users->sortByDesc('ssc_quota');
      // $sorted->values()->all();

      // dd($sorted);
      return response()->json($data);

    }

    public function getCurrentTracking($data){
      $data = json_decode($data);

      $dep = $data[0]->project;
      $team = $data[0]->team;

      $dslSalesSata = '';
      $mobileSalesSata = '';
      $users = '';
      $project = '';

      if($dep == 'Mobile'){
        $project = '1und1 Retention';
      } else {
        $project = '1und1 DSL Retention';
      }
      
      $trackCalls = DB::table('track_calls')
        ->whereDate('created_at', '=', Carbon::today())
        ->get();

      $trackEvents = DB::table('track_events')
        ->whereDate('created_at', '=', Carbon::today())
        ->get();

      if($team == 'all') {
        $users = User::whereIn('id', $trackCalls->pluck('user_id')->unique()->toArray())
        ->where('project', $project)
        ->whereIn('department', ['Agenten', 'Backoffice', 'Qualitätsmanagement'])
        ->get();
      } else {
        $users = User::whereIn('id', $trackCalls->pluck('user_id')->unique()->toArray())
        ->where('project', $project)
        ->where('team', $team)
        ->whereIn('department', ['Agenten', 'Backoffice', 'Qualitätsmanagement'])
        ->get();
      }
      

      foreach($users as $key => $user){
        $user->calls = $trackCalls->where('user_id', $user->id)->sum('calls');
        $user->ssc_calls = $trackCalls->where('user_id', $user->id)->where('category', 1)->sum('calls');
        $user->bsc_calls = $trackCalls->where('user_id', $user->id)->where('category', 2)->sum('calls');
        $user->portal_calls = $trackCalls->where('user_id', $user->id)->where('category', 3)->sum('calls');
        $user->orders = $trackEvents->where('created_by', $user->id)->where('event_category', 'Save')->count();
        $user->ssc_orders = $trackEvents->where('created_by', $user->id)->where('event_category', 'Save')->where('product_category', 'SSC')->count();
        $user->bsc_orders = $trackEvents->where('created_by', $user->id)->where('event_category', 'Save')->where('product_category', 'BSC')->count();
        $user->portal_orders = $trackEvents->where('created_by', $user->id)->where('event_category', 'Save')->where('product_category', 'Portale')->count();
        $user->optin = $trackEvents->where('created_by', $user->id)->where('optin', 1)->count();
        $user->optin_cr = $this->getQuota($user->calls, $user->optin);
        $user->cr = $this->getQuota($user->calls, $user->orders);
        $user->ssc_cr = $this->getQuota($user->ssc_calls, $user->ssc_orders);
        $user->bsc_cr = $this->getQuota($user->bsc_calls, $user->bsc_orders);
        $user->portal_cr = $this->getQuota($user->portal_calls, $user->portal_orders);
        $user->al_0 = $trackEvents->where('created_by', $user->id)->where('al_group', 0)->where('product_category', 'SSC')->where('event_category', 'Save')->count();
        $user->al_1 = $trackEvents->where('created_by', $user->id)->where('al_group', 1)->where('product_category', 'SSC')->where('event_category', 'Save')->count();
        $user->al_2 = $trackEvents->where('created_by', $user->id)->where('al_group', 2)->where('product_category', 'SSC')->where('event_category', 'Save')->count();
        $user->al_3 = $trackEvents->where('created_by', $user->id)->where('al_group', 3)->where('product_category', 'SSC')->where('event_category', 'Save')->count();
        $user->al_4 = $trackEvents->where('created_by', $user->id)->where('al_group', 4)->where('product_category', 'SSC')->where('event_category', 'Save')->count();
        $user->al_5 = $trackEvents->where('created_by', $user->id)->where('al_group', 5)->where('product_category', 'SSC')->where('event_category', 'Save')->count();
      }

      //Sum SSC Calls and Saves 
      $sumSscCalls = $users->sum('ssc_calls');
      $sumSscOrders = $users->sum('ssc_orders');

      foreach($users as $key => $user){
        if($sumSscCalls > 0){
          $teamSscCr = ($sumSscOrders / $sumSscCalls) * 100;
          if($sumSscCalls - $user->ssc_calls != 0){
            $teamSscCrWithoutUser = (($sumSscOrders - $user->ssc_orders) / ($sumSscCalls - $user->ssc_calls)) * 100;
          } else {
            $teamSscCrWithoutUser = 0;
          }
          $user->ssc_impact = $teamSscCr - $teamSscCrWithoutUser;
        } else {
          $user->ssc_impact = 0;
        }

      }

      $data[] = $users;

      // Projectdata
      $data[] = array(
        'calls' => $users->sum('calls'),
        'ssc_calls' => $sumSscCalls,
        'bsc_calls' => $users->sum('bsc_calls'),
        'portal_calls' => $users->sum('portal_calls'),
        'orders' => $users->sum('orders'),
        'ssc_orders' => $sumSscOrders,
        'bsc_orders' => $users->sum('bsc_orders'),
        'portal_orders' => $users->sum('portal_orders'),
        'optin' => $users->sum('optin'),
        'al_0' => $users->sum('al_0'),
        'al_1' => $users->sum('al_1'),
        'al_2' => $users->sum('al_2'),
        'al_3' => $users->sum('al_3'),
        'al_4' => $users->sum('al_4'),
        'al_5' => $users->sum('al_5'),
      );

      $data[] = $users->sortByDesc('ssc_impact')->slice(0, 5)->values()->toArray();

      return response()->json($data);
    }

    public function getTracking($id='')
    {
      $timestamparray = array();
      $quotaarray = array();

      $user = User::find($id);

      $intermediates = DB::Table('intermediate_status')
      ->where('person_id',$user->{'1u1_person_id'})
      ->whereDate('date',Carbon::today())
      ->get();

      // dd($intermediates);

      foreach ($intermediates as $key => $intervall) {

        $intervall->date2 = \Carbon\Carbon::parse($intervall->date)->format('H:i');

        $formerValues = DB::table('intermediate_status')
        ->where('date','<', $intervall->date)
        ->where('person_id', $user->{'1u1_person_id'})
        // ->where('id','!=', $intervall->id)
        ->orderBY('id','DESC')
        ->select('Calls','Orders','date','id')
        ->first();

        // dd($intervall);

        if($user->department == '1&1 Mobile Retention')
        {
          if($intervall->SSC_Calls != 0)
          {
            $intervallquota =  round($intervall->SSC_Orders*100/$intervall->SSC_Calls,2);
            $quotaarray[] = $intervallquota;

            if(!$formerValues)
            {
              $callarray[] = 0;
            }
            else {
              // dd($formerValues,$intervall);
              $callarray[] = $intervall->Calls - $formerValues->Calls;
            }
          }
          else {
            $quotaarray[] = 0;
            $callarray[] = 0;
          }
        }
        else {
          if ($intervall->Calls != 0) {

            $intervallquota =  round($intervall->Orders*100/$intervall->Calls,2);
            $quotaarray[] = $intervallquota;

            if (!$formerValues) {
              $callarray[] = 0;
            }
            else {
              $callarray[] = $intervall->Calls - $formerValues->Calls;
            }

          }
          else {
            $quotaarray[] = 0;
            $callarray[] = 0;
          }
        }
      }
      $timestamparray = $intermediates->pluck('date2')->toArray();

      $dataarray = array($timestamparray, $quotaarray, $callarray);

      return response()->json($dataarray);
      // return response()->json(1);
      // dd($timestamparray);
    }
    public function intermediateImport()
    {
      $mobileSalesSata = DB::connection('mysqlkdwtracking')
      ->table('1und1_mr_tracking_inb_new_ebk')
      // ->whereIn('MA_id', $userids)
      ->whereDate('date', '=', Carbon::today())
      ->get();

      $dslSalesData = DB::connection('mysqlkdwtracking')
      ->table('1und1_dslr_tracking_inb_new_ebk')
      // ->whereIn('MA_id', $userids)
      ->whereDate('date', '=', Carbon::today())
      ->get();

      $trackingidsMobile = $mobileSalesSata->pluck('agent_ds_id')->toArray();
      $trackingidsDSL = $dslSalesData->pluck('agent_ds_id')->toArray();

      $trackingids = array_merge($trackingidsMobile, $trackingidsDSL);

      $users = User::whereIn('tracking_id',$trackingids)->get();

      // dd($users);

      foreach($users as $user)
      {
        if($user->salesdata = $mobileSalesSata->where('agent_ds_id', $user->tracking_id)->first())
        {
          $insertarray[] = array(
            'person_id' => $user->person_id,
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'Calls' => $user->salesdata->calls,
            'SSC_Calls' => $user->salesdata->calls_ssc,
            'BSC_Calls' => $user->salesdata->calls_bsc,
            'Portal_Calls' => $user->salesdata->calls_portal,
            'PTB_Calls' => $user->salesdata->calls_ptb,
            'KüRü' => $user->salesdata->kuerue_ssc_contract_save + $user->salesdata->kuerue_bsc_contract_save + $user->salesdata->kuerue_portal_save,
            'Orders' => $user->salesdata->ret_ssc_contract_save + $user->salesdata->ret_bsc_contract_save + $user->salesdata->ret_portal_save,
            'SSC_Orders' => $user->salesdata->ret_ssc_contract_save,
            'BSC_Orders' => $user->salesdata->ret_bsc_contract_save,
            'Portal_Orders' => $user->salesdata->ret_portal_save,
          );
        }
        else {
            $user->salesdata = $dslSalesData->where('agent_ds_id', $user->tracking_id)->first();
            // dd($user);
            $insertarray[] = array(

              'person_id' => $user->person_id,
              'date' => Carbon::now()->format('Y-m-d H:i:s'),
              'Calls' => $user->salesdata->calls,
              'KüRü' => $user->salesdata->kuerue,
              'Orders' => $user->salesdata->ret_de_1u1_rt_save,
              'SSC_Calls' => 0,
              'BSC_Calls' => 0,
              'Portal_Calls' => 0,
              'PTB_Calls' => 0,
              'SSC_Orders' => 0,
              'BSC_Orders' => 0,
              'Portal_Orders' => 0,
            );
          }
      }

      DB::table('intermediate_status')->insert($insertarray);
    }
    public function getQuota($calls, $orders)
    {
      if($calls == 0)
      {
        $quota = 0;
      }
      else {
        $quota = round(($orders/$calls)*100,2);
      }
      return $quota;
    }
    public function dailyAgentDetectiveIndex(Request $request)
    {

      // $request->validate([
      //   'start_date' => 'required',
      //   'end_date' => 'required',
      //
      // ]);

      $users = User::where('department','Agenten')
      ->with(['dailyAgent' => function($q) {
        // $q->select(['id','person_id','calls','call_date']);

          if(request('start_date') == request('end_date'))
          {
            $q->whereDate('date', request('start_date'));
          }
          else {
            $q->where('date','>=', request('start_date'));
            $q->where('date','<=', request('end_date'));
          }

      }])
      ->get();
      // dd( $users[0]->dailyAgent->first());
      $productivestates = array('Available','In Call','On Hold','Wrap Up');
      $lazystates = array('Released (03_away)','Released (05_occupied)');
      foreach ($users as $key => $user) {

        if($user->dailyAgent->first())
        {
          // dd($user->dailyAgent,$user->dailyAgent->sum('time_in_state'));
          $user->start = $user->dailyAgent->first()->date->format('Y-m-d H:i:s');
          $user->last = $user->dailyAgent->last()->date->format('Y-m-d H:i:s');

          $user->whole = round(($user->dailyAgent->sum('time_in_state')/3600),2);

          $user->away = round($user->dailyAgent->where('status','Released (03_away)')->sum('time_in_state')/60,0);
          $user->occu = round($user->dailyAgent->where('status','Released (05_occupied)')->sum('time_in_state')/60,0);
          $user->screenbreak = round($user->dailyAgent->where('status','Released (01_screen break)')->sum('time_in_state')/60,0);
          $user->onhold = round($user->dailyAgent->where('status','On Hold')->sum('time_in_state')/60,0);
          // $user->productive = $user->dailyAgent->whereIn('status','In Call')->sum('time_in_state');
          $user->productive = round($user->dailyAgent->whereIn('status',$productivestates)->sum('time_in_state')/3600,2);

          if($user->whole != 0)
          {
            $user->prquota = round(($user->productive*100/$user->whole),2);
          }
          else {
            $user->prquota = 0;
          }

          // dd($user->productive);
        }
        else {
          $users->forget($key);
        }

      }
      // dd($users);
      if ($users) {
        return view('userDailyAgentDetective', compact('users'));
      }
      else {
        abort(403, 'keine Daten in diesem Zeitraum im DA');
      }
    }
    public function dailyAgentDetectiveSingle($id)
    {
      if (request('start_date')) {

        $start_date = Carbon::parse(request('start_date'));
      }
      else {
        $start_date = Carbon::today();
      }
      if (request('end_date')) {
            $end_date = Carbon::parse(request('end_date'));
      }
      else {
        $end_date = Carbon::today();
      }

      // return $start_date;
      $user = User::where('id',$id)
      ->with(['dailyAgent' => function($q) use($start_date, $end_date) {
        // $q->select(['id','person_id','calls','call_date']);
        if($start_date == $end_date)
        {
          $q->whereDate('date', $start_date);
        }
        else {
          $q->where('date','>=', $start_date);
          $q->where('date','<=',$end_date);
        }
      }])
      ->first();

      // dd(  $user->dailyAgent);
      return view('userDailyAgentSingle', compact('user'));
    }
    public function getDailyQuotas($dep)
    {
      $ssccrarray = array();
      $crarray = array();
      $timesarray = array();
      // return 1;
      if ($dep == 'Mobile') {
        $department = '1und1 Retention';
      }
      elseif($dep == 'DSL') {
        $department = '1und1 DSL Retention';

      }

      $IDs = User::where('project',$department)
      ->where('status',1)
      ->pluck('1u1_person_id');

      $intermediates = Intermediate::whereDate('date', Carbon::today())
      ->whereIn('person_id',$IDs)
      ->get();

      $times = $intermediates->unique('date')->pluck('date');
      // dd($times);
      if($times)
      {
        foreach ($times as $key => $timestamp) {

          $intervall = $intermediates->where('date',$timestamp);

          if($dep =='Mobile')
          {
            $sscCalls = $intervall->sum('SSC_Calls');
            $sscOrders = $intervall->sum('SSC_Orders');

            $sscCR = $this->getQuota($sscCalls, $sscOrders);
            $ssccrarray[] = $sscCR;
          }

          $orders = $intervall->sum('Orders');
          $calls = $intervall->sum('Calls');

          $cr = $this->getQuota($calls, $orders);
          $timestamp = Carbon::parse($timestamp)->format('H:i');
          // dd($timestamp);
          $crarray[] = $cr;
          $timesarray[] = $timestamp;

          }
        }
        else {
          abort(403,'keine Werte');
        }
      // $timesarray = $intermediates->pluck('date2')->toArray();
      $dataarray = array($crarray,$ssccrarray, $timesarray);

      return response()->json($dataarray);
    }
    public function SaveEvent()
    {

    }
}
