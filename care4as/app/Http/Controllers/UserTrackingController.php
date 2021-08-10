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
    public function getCurrentTracking($dep= 'Mobile')
    {
      // return $dep;
      $dslSalesSata = '';
      $mobileSalesSata = '';

      if($dep == 'Mobile')
      {
        $department = '1&1 Mobile Retention';

        $mobileSalesSata = DB::connection('mysqlkdwtracking')
        ->table('1und1_mr_tracking_inb_new_ebk')
        // ->whereIn('MA_id', $userids)
        ->whereDate('date', '=', Carbon::today())
        ->get();

        $SalesSata = $mobileSalesSata;
      }

      else {
        $department = '1&1 DSL Retention';

        $dslSalesSata = DB::connection('mysqlkdwtracking')
        ->table('1und1_dslr_tracking_inb_new_ebk')
        // ->whereIn('MA_id', $userids)
        ->whereDate('date', '=', Carbon::today())
        ->get();

        $SalesSata = $dslSalesSata;
      }

      $trackingidsMobile = $SalesSata->pluck('agent_ds_id')->toArray();

      $users = User::whereIn('tracking_id',$trackingidsMobile)
      ->where('role','Agent')
      ->where('department',$department)
      ->get();

      foreach($users as $key => $user)
      {
        if ($user->department == '1&1 Mobile Retention') {

          $user->salesdata = $mobileSalesSata->where('agent_ds_id', $user->tracking_id)->first();
          $user->ssc_calls = $user->salesdata->calls_ssc;
          $user->ssc_orders = $user->salesdata->ret_ssc_contract_save;
          $user->calls = $user->salesdata->calls;

          $user->bsc_calls = $user->salesdata->calls_bsc;
          $user->bsc_orders = $user->salesdata->ret_bsc_contract_save;
          $user->portal_calls = $user->salesdata->calls_portal;
          $user->portal_orders = $user->salesdata->ret_portal_save;
          $user->orders = $user->ssc_orders + $user->bsc_orders + $user->portal_orders;

          if($user->ssc_calls != 0)
          {
            $user->ssc_quota = round(($user->ssc_orders*100/$user->ssc_calls),2);
          }
          else {
            $user->ssc_quota = 0;
          }

          $user->cr = $this->getQuota($user->calls, $user->orders);
        }
        //the users in the dsl department
        else {
            if ($user->salesdata = $dslSalesSata->where('agent_ds_id', $user->tracking_id)->first()) {
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

        $data[] = array(
          'ssc_calls'=>$allSSCCalls,
          'ssc_saves'=>$allSSCOrders,
          'bsc_calls'=>$allBSCCalls,
          'bsc_saves'=>$allBSCOrders,
          'portal_calls'=>$allPortalCalls,
          'portal_saves'=>$allPortalOrders,
          'calls'=>$allCalls,
          'orders'=>$allOrders,
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
    public function getTracking($id='')
    {
      $timestamparray = array();
      $quotaarray = array();

      $user = User::find($id);

      $intermediates = DB::Table('intermediate_status')
      ->where('person_id',$user->person_id)
      ->whereDate('date',Carbon::today())
      ->get();

      // dd($intermediates);

      foreach ($intermediates as $key => $intervall) {

        $intervall->date2 = \Carbon\Carbon::parse($intervall->date)->format('H:i');

        $formerValues = DB::table('intermediate_status')
        ->where('date','<', $intervall->date)
        ->where('person_id', $user->person_id)
        // ->where('id','!=', $intervall->id)
        ->orderBY('id','DESC')
        ->select('Calls','Orders','date','id')
        ->first();

        // dd($formerValues);

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
            $callarray[] = $intervall->Calls - $formerValues->Calls;
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
      // dd($request);
      $users = User::where('role','agent')
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
      // return 1;
      $intermediates = Intermediate::whereDate('date', Carbon::today())
      ->get();
      $times = $intermediates->unique('date')->pluck('date');
      // dd($times);
      foreach ($times as $key => $timestamp) {

        $intervall = $intermediates->where('date',$timestamp);

        $sscCalls = $intervall->sum('SSC_Calls');
        $sscOrders = $intervall->sum('SSC_Orders');
        $orders = $intervall->sum('Orders');
        $calls = $intervall->sum('Calls');

        $cr = $this->getQuota($calls, $orders);
        $sscCR = $this->getQuota($sscCalls, $sscOrders);

        $timestamp = Carbon::parse($timestamp)->format('H:i');

        // dd($timestamp);
        $ssccrarray[] = $sscCR;
        $crarray[] = $cr;
        $timesarray[] = $timestamp;

        }

      // $timesarray = $intermediates->pluck('date2')->toArray();
      $dataarray = array($crarray,$ssccrarray, $timesarray);

      return response()->json($dataarray);
    }

}
