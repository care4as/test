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
      // if (Support\Carbon::now()->isToday())
      // {
      //   switch ($action) {
      //     case 'save':
      //         echo "i ist gleich 0";
      //         break;
      //     case 'service':
      //         echo "i ist gleich 1";
      //         break;
      //     case 'cancel':
      //         echo "i ist gleich 2";
      //         break;
      // }
      //   return 1;
      // }
      // else
      // {
      //   return 2;
      // }
      return redirect()->route('dashboard');
    }
}
