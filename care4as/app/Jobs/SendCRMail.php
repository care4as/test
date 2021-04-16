<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

use App\Mail\CRMail;
use Mail;
use Carbon\Carbon;

class SendCRMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;

    public function __construct()
    {

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

    if($mobileSalesSata->sum('calls_ssc') == 0)
    {
      $ssccr = 'Daten noch nicht auswertbar';
    }
    else {
      $ssccr = round($mobileSalesSata->sum('ret_ssc_contract_save')*100/$mobileSalesSata->sum('calls_ssc'),2).'%';
    }
    if($dslSalesData->sum('calls') == 0)
    {
      $dslcr = 'Daten noch nicht auswertbar';
    }
    else {
      $dslcr = round($dslSalesData->sum('ret_de_1u1_rt_save')*100/$dslSalesData->sum('calls'),2).'%';
    }

    // dd($dslSalesData);
    $data = array('DSLCR' => $dslcr , 'SSC-CR' => $ssccr);

    $email = new CRMail($data);

    $mailinglist = 'andreas.robrahn@care4as.de';

    Mail::to($mailinglist)->send($email);

    $this::dispatch()->delay(now()->addMinutes(120))->onConnection('database');
  }
}
