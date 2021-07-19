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

        if(DB::table('pause')->where('name', Auth()->user()->name)->exists())
        {
          return response()->json('du bist schon in Pause');
        }
        else {
          DB::table('pause')->insert(['name' => Auth()->user()->name]);
          return response()->json('angenehme Pause'.Auth()->user()->surname.' '.Auth()->user()->lastname);
        }
      }
      else {
        return response()->json('zuviele Leute in der Pause');
      }

    }
    public function getOutOfPause($value='')
    {
      if(DB::table('pause')->where('name', Auth()->user()->name)->delete())
      {
        return response()->json(1);
      }
      else {
        return response()->json(2);
      }
    }
    public function getUsers()
    {
      return DB::table('pause')->get();
    }
}
