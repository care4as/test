<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\sendIntermediateMail;
use App\Jobs\Intermediate;

class Configcontroller extends Controller
{
    public function sendIntermediateMail()
    {
      sendIntermediateMail::dispatch()->onConnection('sync');
      return redirect()->back();
    }

    public function activateIntermediateMail()
    {
      $time =  time();
      $nextHalfHour = ceil(time() / (30 * 60)) * (30 * 60);
      $timediff = intval($nextHalfHour)-$time;

      $asString = ($timediff/60) + 1 .' Minutes';

      sendIntermediateMail::dispatch()->delay(now()->add($asString))->onConnection('database');

      // return 'tolle';
    }
    public function deactivateIntermediateMail()
    {

    }

    public function activateAutomaticeIntermediate()
    {
      $time =  time();
      $nextHalfHour = ceil(time() / (30 * 60)) * (30 * 60);
      $timediff = intval($nextHalfHour)-$time;

      $asString = ($timediff/60) + 0.5 .' Minutes';

      Intermediate::dispatch('repeat')->delay(now()->add($asString))->onQueue('intermediate')->onConnection('database');
    }
    public function deleteAutomaticeIntermediate()
    {
      DB::table('jobs')->where('queue','intermediate')->delete();
    }

    public function updateEmailprovider(Request $request)
    {
      $request->
      $array = array('a@b.de', 'c@de.de');

      $json = json_encode($array);

      DB::table('email_providers')
      ->where('name',$request->providername)
      ->update([
        'adresses' => $json,
      ]);
    }
}
