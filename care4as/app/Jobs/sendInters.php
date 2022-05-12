<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\User;
use App\Log;
use App\Mail\IntersMail;
use Mail;

class sendInters implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      /*

      this job is supposed to collect the dsl sales information from the kdw tool and send it to the scriptmaster pc controlled
      by Rene Schmidt.

      1. Collect the data
      2.
      */

      // the salesinfo of today
      $dslSalesData = DB::connection('mysqlkdwtracking')
      ->table('1und1_dslr_tracking_inb_new_ebk')
      // ->whereIn('MA_id', $userids)
      ->whereDate('date', '=', Carbon::today())
      ->get();

      // dd($dslSalesData);
      $retsaves = $dslSalesData->sum('ret_de_1u1_rt_save');
      $calls = $dslSalesData->sum('calls');

      $data = array('retsaves' =>$retsaves,
      'calls' => $calls);

      $mailinglist = array('scriptmaster@care4as.de','andreas.robrahn@care4as.de');
      // $mailinglist = array('andreas.robrahn@care4as.de');
      $mail = new Intersmail($data);
      // return (new Intersmail($data))->render();
      Mail::to($mailinglist)->send($mail);
      $time =  time();
        // $fromEightThirty = Carbon::createFromTimeString('8:30');

      if (Carbon::parse($time) < Carbon::createFromTimeString('22:00'))
      {
        $fifteenMinutes = ceil(time() / (15 * 60)) * (15 * 60);
        $timediff = intval($fifteenMinutes)-$time;
        // $asString = 0.2 .' Minutes';
        $asString = ($timediff/60) + 1 .' Minutes';
      }
      else {
        $tommorrowMorning = Carbon::createFromTimeString('8:30')->addDay();

        $timediff = intval($tommorrowMorning->timestamp) - $time;

        $asString = ($timediff/60) + 1 .' Minutes';
        // $asString = 0.2 .' Minutes';
        }

      //repeats the process
      $this::dispatch()->delay(now()->add($asString))->onConnection('database')->onQueue('sendInters');
    }
}
