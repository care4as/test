<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PauseController extends Controller
{
    public function show()
    {
      return view('telefonica.pause');
    }
    public function getIntoPause()
    {
      $users = $this->getUsers();


      if ($users->count() < 3) {

      $username = Auth()->user()->surname.' '.Auth()->user()->lastname;

      if(DB::table('pause')->where('name', $username)->exists())
        {

          return response()->json('du bist schon in Pause');
        }
        else {
          DB::table('pause')->insert(['name' => $username]);
          return response()->json('angenehme Pause '.$username);
        }
      }
      else {
        return response()->json('zuviele Leute in der Pause');
      }

    }
    public function getOutOfPause($value='')
    {
      $username = Auth()->user()->surname.' '.Auth()->user()->lastname;
      if(DB::table('pause')->where('name', $username)->delete())
      {
        return response()->json('Pause beendet');
      }
      else {
        return response()->json('Fehler');
      }
    }
    public function getUsers()
    {
      return DB::table('pause')->get();
    }
}
