<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\sendIntermediateMail;
use App\Jobs\Intermediate;

class Configcontroller extends Controller
{
  public function index()
  {
       $adresses = DB::table('email_providers')->where('name','test')->first('adresses');

       if ($adresses) {
         $array = json_decode($adresses->adresses);
       }

       $processes = DB::table('jobs')->get();
       // dd($array);
       foreach($processes as $process)
       {
         $datetime = \Carbon\Carbon::parse($process->available_at);
         $datetime->setTimezone('Europe/Berlin');
         //
         $process->duedate = $datetime->format('Y-m-d H:i:s');
       }

       return view('general_config', compact('adresses','processes'));
  }
    public function sendIntermediateMail()
    {
      // $email = Auth()->user()->email;

      if(request('isMobile'))
      {
        $email = DB::table('email_providers')
        ->where('name','intermediateMailMobile')
        ->first('adresses');
      }
      else {
        $email = DB::table('email_providers')
        ->where('name','intermediateMailDSL')
        ->first('adresses');
      }

      $antijson = json_decode($email->adresses);

      $trimmed_array = array_map('trim', $antijson);
      // dd($antijson);
      $filter = array_filter($trimmed_array);

      if(request('isMobile'))
      {
        // return 1;
        sendIntermediateMail::dispatch($filter,1,true)->onConnection('sync');
      }
      else {
        // dd(request());
        // return 2;
        sendIntermediateMail::dispatch($filter,1,false)->onConnection('sync');
      }
      return redirect()->back();
    }

    public function activateIntermediateMailMobile()
    {

      $time =  time();
      $inTowHours = ceil(time() / (120 * 60)) * (120 * 60);
      $timediff = intval($inTowHours)-$time;

      $asString = ($timediff/60) + 1 .' Minutes';
      // $asString = 0.2.' Minutes';

      // $email = array('andreas.robrahn@care4as.de','maximilian.steinberg@care4as.de','andreas.nissen@care4as.de','aysun.yildiz@care4as.de');

      $emails = DB::table('email_providers')
      ->where('name','intermediateMailMobile')
      ->first('adresses');
      // $email = array('andreas.robrahn@care4as.de');

      $antijson = json_decode($emails->adresses);

      $trimmed_array = array_map('trim', $antijson);
      // dd($antijson);
      $emails = array_filter($trimmed_array);

      // return $email;
      sendIntermediateMail::dispatch($emails,2,true)->delay(now()->add($asString))->onConnection('database')->onQueue('MailMobile');

      // sendIntermediateMail::dispatch($email,2)->delay(now()->add('5 Seconds'))->onConnection('database');

      // return 'tolle';
    }
    public function activateIntermediateMailDSL()
    {

      $time =  time();
      $inTowHours = ceil(time() / (120 * 60)) * (120 * 60);
      $timediff = intval($inTowHours)-$time;

      $asString = ($timediff/60) + 1 .' Minutes';
      // $asString = 0.2.' Minutes';

      $emails = DB::table('email_providers')
      ->where('name','intermediateMailDSL')
      ->first('adresses');
      // $email = array('andreas.robrahn@care4as.de');

      $antijson = json_decode($emails->adresses);

      $trimmed_array = array_map('trim', $antijson);
      // dd($antijson);
      $emails = array_filter($trimmed_array);

      // $email = array('andreas.robrahn@care4as.de','maximilian.steinberg@care4as.de','andreas.nissen@care4as.de','aysun.yildiz@care4as.de');
      // $email = array('andreas.robrahn@care4as.de');
      // return $email;
      sendIntermediateMail::dispatch($emails,2,false)->delay(now()->add($asString))->onConnection('database')->onQueue('MailDSL');

      // sendIntermediateMail::dispatch($email,2)->delay(now()->add('5 Seconds'))->onConnection('database');

      // return 'tolle';
    }
    public function deactivateIntermediateMailMobile()
    {

      DB::table('jobs')->where('queue','MailMobile')->delete();

      return response()->json('success');
    }
    public function deactivateIntermediateMailDSL()
    {

      DB::table('jobs')->where('queue','MailDSL')->delete();

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
      $providername = 'intermediateMailMobile';
      $adresses = array('andreas.robrahn@care4as.de');

      if($request->emails)
      {
        $adresses = explode(';',$request->emails);
      }

      if ($request->providername) {
        $providername = $request->providername;
      }

      $adresses = array_map('trim', $adresses);

      $adresses = array_filter($adresses);

      $json = json_encode($adresses);

      DB::table('email_providers')
      ->updateOrInsert(
          ['name' => $providername],
          ['adresses' => $json]
      );

      return redirect()->back();
    }
    public function deleteProcess($id)
    {
      DB::table('jobs')->where('id',$id)->delete();
      return redirect()->back();
    }
}
