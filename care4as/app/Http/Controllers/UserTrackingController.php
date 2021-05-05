<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserTracking;
use App\User;
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
}
