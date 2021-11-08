<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Mail\IntermediateMail;
use Mail;

class Intermediate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $repeat;

    public $tries = 1;

    public function __construct($repeat)
    {
        $this->repeat = $repeat;

        // if($this->repeat == 'nonrepeat')
        // {
        //   $this->onConnection('sync');
        // }
        // else {
        //   $this->onConnection('database');
        //   $this->onQueue('intermediate');
        // }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $mobileSalesSata = DB::connection('mysqlkdwtracking')
      ->table('1und1_mr_tracking_inb_new_ebk')
      // ->whereIn('MA_id', $userids)
      ->whereDate('date', '=', Carbon::today())
      ->get();

      $dslSalesData = DB::connection('mysqlkdwtracking')
      ->table('1und1_dslr_tracking_inb_new_ebk')
      // ->whereIn('MA_id', $userids)
      ->whereDate('date', '=', Carbon::today())
      ->get();

      $trackingidsMobile = $mobileSalesSata->pluck('agent_ds_id')->toArray();
      $trackingidsDSL = $dslSalesData->pluck('agent_ds_id')->toArray();

      $trackingids = array_merge($trackingidsMobile, $trackingidsDSL);

      $users = User::whereIn('kdw_tracking_id',$trackingids)
      ->where('role','Agent')
      ->get();

      // dd($users);

      if(!$users->first())
      {
        $insertarray[] = array(
          'person_id' => 0,
          'date' => 0,
          'Calls' =>0,
          'SSC_Calls' => 0,
          'BSC_Calls' => 0,
          'Portal_Calls' => 0,
          'PTB_Calls' => 0,
          'KüRü' => 0,
          'Orders' => 0,
          'SSC_Orders' => 0,
          'BSC_Orders' => 0,
          'Portal_Orders' => 0,
        );
      }

      foreach($users as $user)
      {

        if($user->salesdata = $mobileSalesSata->where('agent_ds_id', $user->kdw_tracking_id)->first())
        {
          if($user->{'1u1_person_id'})
          {
              $insertarray[] = array(
              'person_id' => $user->{'1u1_person_id'},
              'date' => Carbon::now()->format('Y-m-d H:i:s'),
              'Calls' => $user->salesdata->calls,
              'SSC_Calls' => $user->salesdata->calls_ssc,
              'BSC_Calls' => $user->salesdata->calls_bsc,
              'Portal_Calls' => $user->salesdata->calls_portal,
              'PTB_Calls' => $user->salesdata->calls_ptb,
              'KüRü' => $user->salesdata->kuerue_ssc_contract_save + $user->salesdata->kuerue_bsc_contract_save + $user->salesdata->kuerue_portal_save,
              'Orders' => $user->salesdata->ret_ssc_contract_save + $user->salesdata->ret_bsc_contract_save + $user->salesdata->ret_portal_save,
              'SSC_Orders' => $user->salesdata->ret_ssc_contract_save,
              'BSC_Orders' => $user->salesdata->ret_bsc_contract_save,
              'Portal_Orders' => $user->salesdata->ret_portal_save,
            );
          }
          else {
            return 'test';
          }

        }
        else {

            $user->salesdata = $dslSalesData->where('agent_ds_id', $user->kdw_tracking_id)->first();
            // dd($user);
            if($user->{'1u1_person_id'})
            {
              $insertarray[] = array(
                'person_id' => $user->{'1u1_person_id'},
                'date' => Carbon::now()->format('Y-m-d H:i:s'),
                'Calls' => $user->salesdata->calls,
                'KüRü' => $user->salesdata->kuerue,
                'Orders' => $user->salesdata->ret_de_1u1_rt_save,
                'SSC_Calls' => 0,
                'BSC_Calls' => 0,
                'Portal_Calls' => 0,
                'PTB_Calls' => 0,
                'SSC_Orders' => 0,
                'BSC_Orders' => 0,
                'Portal_Orders' => 0,
              );
            }
            else {
              return 'test';
            }
          }
      }


      if($users->first())
      {
        DB::table('intermediate_status')->insert($insertarray);
      }

    $time =  time();

    if (Carbon::parse($time) < Carbon::createFromTimeString('22:00'))
    {
      $time =  time();
      $nextHalfHour = ceil(time() / (30 * 60)) * (30 * 60);
      $timediff = intval($nextHalfHour)-$time;

      // $asString = ($timediff/60) .' Minutes';
      $asString = ($timediff/60)+ 0.5 .' Minutes';
    }
    else {

      $tommorrowMorning = Carbon::createFromTimeString('08:00')->addDay();

      $timediff = intval($tommorrowMorning->timestamp) - $time;

      $asString = ($timediff/60) + 1 .' Minutes';
    }

   if ($this->repeat != 'nonsync') {

    $this::dispatch('repeat')->delay(now()->add($asString))->onQueue('intermediate')->onConnection('database');
   }
  }
}
