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
use App\Mail\SicknessMail;
use Mail;

class sendSichknessMail implements ShouldQueue
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
      $projektid= 10;
      $sickstates = array(1,8,13,14);

      $data = DB::connection('mysqlkdw')
      ->table('history_state')
      ->where('project_id', '=', $projektid)
      ->whereIn('state_id',$sickstates)
      ->where('date_end','>=', Carbon::today())
      ->get();

      // dd($data);
      $mailinglist = array('andreas.robrahn@care4as.de');
      $mail = new SicknessMail($data);
      Mail::to($mailinglist)->send($mail);

        $time =  time();
        $tommorrowMorning = Carbon::createFromTimeString('7:30')->addDay();

        $timediff = intval($tommorrowMorning->timestamp) - $time;

        $asString = ($timediff/60).' Minutes';
        // $asString = (0.5/60) + 1 .' Minutes';

      $this::dispatch()->delay(now()->add($asString))->onConnection('database')->onQueue('SickMa');
    }
}
