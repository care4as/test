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

        $intervall->date = \Carbon\Carbon::parse($intervall->date)->format('H:i');

        if($user->department == '1&1 Mobile Retention')
        {
          if($intervall->SSC_Calls != 0)
          {
            $intervallquota =  round($intervall->SSC_Orders*100/$intervall->SSC_Calls,2);
            $quotaarray[] = $intervallquota;
          }
          else {
            $quotaarray[] = 0;
          }

        }
        else {
          if ($intervall->Calls != 0) {

            $intervallquota =  round($intervall->Orders*100/$intervall->Calls,2);
            $quotaarray[] = $intervallquota;
          }
          else {
            $quotaarray[] = 0;
          }

          }
      }

      $timestamparray = $intermediates->pluck('date')->toArray();

      $dataarray = array($timestamparray, $quotaarray);
      return response()->json($dataarray);
      // return response()->json(1);
      // dd($timestamparray);
    }
}
