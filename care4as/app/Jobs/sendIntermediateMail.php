<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Mail\IntermediateMail;
use Mail;

class sendIntermediateMail implements ShouldQueue
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
      $currentSSCCR = 0;
      $dslcr = 0;

      $allSscCalls = 0;
      $allSscOrders = 0;

      $allDSLCalls = 0;
      $allDLSOrders = 0;

      $userids = DB::table('intermediate_status')->whereDate('date', Carbon::today())->pluck('person_id');

      $users = User::whereIn('person_id',$userids)
      ->with('intermediatesLatest')
      ->get();

      // if($mobileSalesSata->sum('calls_ssc') == 0)
      // {
      //   $ssccr = 'Daten noch nicht auswertbar';
      // }
      // else {
      //   $ssccr = round($mobileSalesSata->sum('ret_ssc_contract_save')*100/$mobileSalesSata->sum('calls_ssc'),2).'%';
      // }
      // if($dslSalesData->sum('calls') == 0)
      // {
      //   $dslcr = 'Daten noch nicht auswertbar';
      // }
      // else {
      //   $dslcr = round($dslSalesData->sum('ret_de_1u1_rt_save')*100/$dslSalesData->sum('calls'),2).'%';
      // }

      foreach($users as $user)
      {
        $formerValues = DB::table('intermediate_status')
        ->whereDate('date', Carbon::today())
        ->where('person_id', $user->person_id)
        ->where('id','<', $user->intermediatesLatest->id)
        ->orderBY('id','DESC')
        ->first();

        if( $user->department == "1&1 Mobile Retention")
        {
          // dd($user, $formerValues);
          if ($user->intermediatesLatest->SSC_Calls == 0) {
            $ssccr = 0;
          }
          else {
            $ssccr = round(($user->intermediatesLatest->SSC_Orders* 100 / $user->intermediatesLatest->SSC_Calls),2).'%';

          }

          if($formerValues)
          {
            if($formerValues->SSC_Calls == 0)
            {
                $sscr_diff = '0%';
            }
            else {
              $sscr_diff = round(($user->intermediatesLatest->SSC_Orders* 100 / $user->intermediatesLatest->SSC_Calls) - ($formerValues->SSC_Orders* 100 / $formerValues->SSC_Calls),0).'%';
            }

            $sscDiff =  $user->intermediatesLatest->SSC_Calls - $formerValues->SSC_Calls;
            $bscDiff =  $user->intermediatesLatest->BSC_Calls - $formerValues->BSC_Calls;
            $portalCallsDiffer =  $user->intermediatesLatest->Portal_Calls - $formerValues->Portal_Calls;

            $sscSaveDiff = $user->intermediatesLatest->SSC_Orders - $formerValues->SSC_Orders;
            $bscSaveDiff = $user->intermediatesLatest->BSC_Orders- $formerValues->BSC_Orders;
            $portalSaveDiff = $user->intermediatesLatest->Portal_Orders - $formerValues->Portal_Orders;
            $CallsDiff = $user->intermediatesLatest->Calls - $formerValues->Calls;
            $ordersDiff = $user->intermediatesLatest->Orders - $formerValues->Orders;

            if(!$ssccr)
            {
              // dd($user->intermediatesLatest, $formerValues);
            }


            $emailarray[] = array(
              'name' => $user->surname.' '.$user->lastname,
              'SSC-CR' => $ssccr,
              'SSC-CR_diff' => $sscr_diff,
              'Calls' => $user->intermediatesLatest->Calls,
              'Calls_differ' => $CallsDiff,
              'SSC_Calls' => $user->intermediatesLatest->SSC_Calls,
              'SSC_Calls_differ' => $sscDiff,
              'BSC_Calls' => $user->intermediatesLatest->BSC_Calls,
              'BSC_Calls_differ' => $bscDiff,
              'Portal_Calls' => $user->intermediatesLatest->Portal_Calls,
              'Portal_Calls_differ' => $portalCallsDiffer,
              'PTB_Calls' => $user->intermediatesLatest->BSC_Calls,
              'KüRü' => $user->intermediatesLatest->KüRü,
              'Orders' => $user->intermediatesLatest->Orders,
              'Orders_diff' => $ordersDiff,
              'SSC-Orders' => $user->intermediatesLatest->SSC_Orders,
              'SSC-Orders_differ' => $sscSaveDiff,
              'BSC-Orders' => $user->intermediatesLatest->BSC_Orders,
              'BSC-Orders_differ' => $bscSaveDiff,
              'Portal-Orders' => $user->intermediatesLatest->Portal_Orders,
              'Portal-Orders_differ' => $portalSaveDiff,
            );
          }
          else {

            $emailarray[] = array(

              'SSC-CR' => $ssccr,
              'SSC-CR_diff' => $sscr_diff,
              'name' => $user->surname.' '.$user->lastname,
              'Calls' => $user->intermediatesLatest->Calls,
              'Calls_differ' => 0,
              'SSC_Calls' => $user->intermediatesLatest->SSC_Calls,
              'SSC_Calls_differ' => 0,
              'BSC_Calls' => $user->intermediatesLatest->BSC_Calls,
              'BSC_Calls_differ' => 0,
              'Portal_Calls' => $user->intermediatesLatest->Portal_Calls,
              'Portal_Calls_differ' => 0,
              'PTB_Calls' => $user->intermediatesLatest->PTB_Calls,
              'KüRü' => $user->intermediatesLatest->KüRü,
              'Orders' => $user->intermediatesLatest->Orders,
              'Orders_diff' => 0,
              'SSC-Orders' => $user->intermediatesLatest->SSC_Orders,
              'SSC-Orders_differ' => 0,
              'BSC-Orders' => $user->intermediatesLatest->BSC_Orders,
              'BSC-Orders_differ' => 0,
              'Portal-Orders' => $user->intermediatesLatest->Portal_Orders,
              'Portal-Orders_differ' => 0,
          );
        }

        $allSscCalls += $user->intermediatesLatest->SSC_Calls;
        $allSscOrders += $user->intermediatesLatest->SSC_Orders;

      }
      //if the agent is in the dsl department
      else {

        if ( $user->intermediatesLatest->Calls == 0) {

            $dslcrcurrent = 0;
        }

        else {
          $dslcrcurrent = $user->intermediatesLatest->Orders*100 / $user->intermediatesLatest->Calls;
        }

        if($formerValues)
        {

            $callsDiff = $user->intermediatesLatest->Calls - $formerValues->Calls;
            $ordersDiff = $user->intermediatesLatest->Orders - $formerValues->Orders;

            if ($formerValues->Calls == 0) {

              $dslcr_differ = 0;

            }
            else {
              $formerdslcr = $formerValues->Orders*100/$formerValues->Calls;
            }

            $dslcr_differ = round($dslcrcurrent - $formerdslcr,2).'%';
            $dslcrcurrent = round($dslcrcurrent,2).'%';

            $emailarrayDSL[] = array(
              'dslcr' => $dslcrcurrent,
              'dslcr_differ' => $dslcr_differ,
              'name' => $user->surname.' '.$user->lastname,
              'Calls' => $user->intermediatesLatest->Calls,
              'Calls_differ' => $callsDiff,
              'Orders' => $user->intermediatesLatest->Orders,
              'Orders_differ' => $ordersDiff,
              'KüRü' => $user->intermediatesLatest->KüRü,
            );
        }
        else {
            $emailarrayDSL[] = array(
              'dslcr' => $dslcrcurrent,
              'dslcr_differ' => 0,
              'name' => $user->surname.' '.$user->lastname,
              'Calls' =>$user->intermediatesLatest->Calls,
              'Calls_differ' => 0,
              'Orders' => $user->intermediatesLatest->Orders,
              'Orders_differ' => 0,
              'KüRü' => $user->intermediatesLatest->KüRü
            );
        }

        $allDSLCalls += $user->intermediatesLatest->Calls;
        $allDLSOrders += $user->intermediatesLatest->Orders;

        }
      }

      // dd($emailarray);
      $currentSSCCR =  round($allSscOrders * 100 / $allSscCalls,2).'%';
      $currentDSLCR =  round($allDLSOrders * 100 / $allDSLCalls,2).'%';

      $data = array('date'=> Carbon::now()->format('Y-m-d H:i:s'),'ssccr' => $currentSSCCR,'dslcr' => $currentDSLCR, 'mobile' => $emailarray, 'dsl' => $emailarrayDSL);

      // dd($data);
      $email = new IntermediateMail($data);

      // $mailinglist = ['andreas.robrahn@care4as.de','maximilian.steinberg@care4as.de'];

      $mailinglist = ['andreas.robrahn@care4as.de'];

      Mail::to($mailinglist)->send($email);

      if (Mail::failures()) {
        foreach(Mail::failures() as $email_address) {
              $logentry = new App\Log;
              $logentry->logEntry("Fehler Email - $email_address <br />");
           }
         }
      }
}
