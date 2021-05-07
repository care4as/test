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
      // $email = Auth()->user()->email;
      $email = array('andreas.robrahn@care4as.de');

      sendIntermediateMail::dispatch($email,1)->onConnection('sync');
      return redirect()->back();
    }

    public function activateIntermediateMail()
    {

      $time =  time();
      $inTowHours = ceil(time() / (120 * 60)) * (120 * 60);
      $timediff = intval($inTowHours)-$time;

      $asString = ($timediff/60) + 1 .' Minutes';

      $email = array('andreas.robrahn@care4as.de','maximilian.steinberg@care4as.de','andreas.nissen@care4as.de','aysun.yildiz@care4as.de');
      // $email = array('andreas.robrahn@care4as.de');
      // return $email;

      sendIntermediateMail::dispatch($email,2)->delay(now()->add($asString))->onConnection('database');
      // sendIntermediateMail::dispatch($email,2)->delay(now()->add('5 Seconds'))->onConnection('database');

      // return 'tolle';
    }
    public function deactivateIntermediateMail()
    {

      DB::table('jobs')->where('queue','default')->delete();

      return response()->json('success');
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
      $providername = 'test';
      $adresses = array('a@b.de', 'c@de.de');

      if($request->emails)
      {
        $adresses = $request->emails;
      }
      if ($request->providername) {
        $providername = $request->providername;
      }

      $json = json_encode($adresses);

      DB::table('email_providers')
      ->where('name',$providername)
      ->update([
        'adresses' => $json,
      ]);

      return redirect()->back();
    }
}
