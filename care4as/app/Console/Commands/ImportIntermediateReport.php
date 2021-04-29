<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;

class ImportIntermediateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $name = 'import:Intermediate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function fire()
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

      $users = User::whereIn('tracking_id',$trackingids)->get();

      // dd($users);

      foreach($users as $user)
      {
        if($user->salesdata = $mobileSalesSata->where('agent_ds_id', $user->tracking_id)->first())
        {
          $insertarray[] = array(
            'person_id' => $user->person_id,
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
            $user->salesdata = $dslSalesData->where('agent_ds_id', $user->tracking_id)->first();
            // dd($user);
            $insertarray[] = array(

              'person_id' => $user->person_id,
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
      }

        DB::table('intermediate_status')->insert($insertarray);
    }
}
