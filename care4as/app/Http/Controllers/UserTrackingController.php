<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserTracking;

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
      $trackings = UserTRacking::where('user_id',$id)->whereDate('created_at', \Carbon\Carbon::today())->get();
      $saves = $trackings->where('save',1);

      foreach ($saves as $key => $save) {

        $countcalls = $trackings->where('division','call')->where('created_at','<=',$save->created_at)->count();
        $countsaves= $saves->where('save','1')->where('created_at','<=',$save->created_at)->count();
        $countsavecorrections= $saves->where('save','-1')->where('created_at','<=',$save->created_at)->count();

        if($countcalls == 0)
        {
          $countcalls = 1;
        }
        $quota = round((($countsaves-$countsavecorrections) / $countcalls)*100, 0);

        $timestamparray[] = 'Save/'.$save->created_at->format('h:i:s');
        $quotaarray[] = $quota;
        // $dataarray[] = array($save->created_at->format('h:m:s'), $quota);
      }
      $dataarray = array($timestamparray, $quotaarray);
      return response()->json($dataarray);
      // return response()->json(1);
      // dd($timestamparray);
    }
}
