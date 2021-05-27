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
    protected $email;
    protected $sync;
    protected $isMobile;

    public function __construct($email,$sync='',$isMobile = true)
    {
        $this->email = $email;
        $this->sync = $sync;
        $this->isMobile = $isMobile;
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
      $bsccr  = 0;
      $portalcr = 0;
      $gevocrMOB = 0;

      $allSscCalls = 0;
      $allSscOrders = 0;

      $allCallsMOB = 0;
      $allOrdersMOB = 0;
      $allBSCCalls = 0;
      $allBSCOrders = 0;
      $allPortalCalls = 0;
      $allPortalOrders = 0;

      $allDSLCalls = 0;
      $allDLSOrders = 0;
      $currentBSCCCR = 'keine Daten';

      $userids = DB::table('intermediate_status')->whereDate('date', Carbon::today())->pluck('person_id');

      $users = User::whereIn('person_id',$userids)
      ->with('intermediatesLatest')
      ->get();



      if(!$users->first())
      {
          $emailarray[] = array(
          'name' => 0,
          'SSC-CR' => 0,
          'GeVo-CR' => 0,
          'SSC-CR_diff' => 0,
          'Calls' => 0,
          'Calls_differ' =>0,
          'SSC_Calls' => 0,
          'SSC_Calls_differ' => 0,
          'BSC-CR' => 0,
          'BSC_Calls' => 0,
          'BSC_Calls_differ' => 0,
          'Portal-CR' => 0,
          'Portal_Calls' => 0,
          'Portal_Calls_differ' => 0,
          'PTB_Calls' => 0,
          'KüRü' => 0,
          'Orders' => 0,
          'Orders_diff' => 0,
          'SSC-Orders' => 0,
          'SSC-Orders_differ' => 0,
          'BSC-Orders' => 0,
          'BSC-Orders_differ' => 0,
          'Portal-Orders' => 0,
          'Portal-Orders_differ' => 0,
        );

        $emailarrayDSL[] = array(
          'dslcr' => 0,
          'dslcr_differ' => 0,
          'name' => 0,
          'Calls' => 0,
          'Calls_differ' => 0,
          'Orders' => 0,
          'Orders_differ' => 0,
          'KüRü' => 0,
        );
      }

      foreach($users as $user)
      {

        $formerValues = DB::table('intermediate_status')
        ->whereDate('date', Carbon::today())
        ->where('person_id', $user->person_id)
        ->where('id','<', $user->intermediatesLatest->id)
        ->orderBY('id','DESC')
        ->limit(4)
        ->get();

        $formerValues = $formerValues->last();

        if($user->department == "1&1 Mobile Retention" && $this->isMobile == true)
        {

          if ($user->intermediatesLatest->SSC_Calls == 0) {
            $ssccr = 0;
          }
          else {
            $ssccr = round(($user->intermediatesLatest->SSC_Orders* 100 / $user->intermediatesLatest->SSC_Calls),2);
          }
          if ($user->intermediatesLatest->Calls == 0) {
            $ssccr = 0;
          }
          else {
            $gevocr = round(($user->intermediatesLatest->Orders* 100 / $user->intermediatesLatest->Calls),2);
          }

          if ($user->intermediatesLatest->BSC_Calls == 0) {
            $bsccr = 0;
          }
          else {
            $bsccr = round(($user->intermediatesLatest->BSC_Orders* 100 / $user->intermediatesLatest->BSC_Calls),2);
          }
          if ($user->intermediatesLatest->Portal_Calls == 0) {
            $portalcr = 0;
          }
          else {
            $portalcr = round(($user->intermediatesLatest->Portal_Orders* 100 / $user->intermediatesLatest->Portal_Calls),2);
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
              'SSC-Orders' => $user->intermediatesLatest->SSC_Orders,
              'SSC-Orders_differ' => $sscSaveDiff,
              'BSC_CR' => $bsccr,
              'PortalCR' => $portalcr,

            );
            usort($emailarray, function($a, $b) {
                return $b['SSC-CR'] <=> $a['SSC-CR'];
            });
          }
          else {

            $emailarray[] = array(

              'name' => $user->surname.' '.$user->lastname,
              'SSC-CR' => $ssccr,
              'SSC-CR_diff' => 0,

              'Calls' => $user->intermediatesLatest->Calls,
              'Calls_differ' => 0,
              'SSC_Calls' => $user->intermediatesLatest->SSC_Calls,
              'SSC_Calls_differ' => 0,
              'SSC-Orders' => $user->intermediatesLatest->SSC_Orders,
              'SSC-Orders_differ' => 0,
              'BSC_CR' => $bsccr,
              'PortalCR' => $portalcr,
          );
          usort($emailarray, function($a, $b) {
              return $b['SSC-CR'] - $a['SSC-CR'];
          });
        }
        $allSscCalls += $user->intermediatesLatest->SSC_Calls;
        $allSscOrders += $user->intermediatesLatest->SSC_Orders;

        $allCallsMOB += $user->intermediatesLatest->Calls;
        $allOrdersMOB += $user->intermediatesLatest->Orders;

        $allBSCCalls += $user->intermediatesLatest->BSC_Calls;
        $allBSCOrders += $user->intermediatesLatest->BSC_Orders;
        $allPortalCalls += $user->intermediatesLatest->Portal_Calls;
        $allPortalOrders += $user->intermediatesLatest->Portal_Orders;
      }

      //if the agent is in the dsl department
      elseif($user->department == "1&1 DSL Retention") {

        $formerdslcr = 0;

        if ( $user->intermediatesLatest->Calls == 0) {

            $dslcrcurrent = 0;
            $dslcr_differ = 0;
        }

        else {

          $dslcrcurrent = $user->intermediatesLatest->Orders*100 / $user->intermediatesLatest->Calls;
        }
        if($formerValues)
        {
            $callsDiff = $user->intermediatesLatest->Calls - $formerValues->Calls;
            $ordersDiff = $user->intermediatesLatest->Orders - $formerValues->Orders;
            if ($formerValues->Calls == 0) {
              $formerdslcr = 0;
            }
            else {
                $formerdslcr = $formerValues->Orders *100 / $formerValues->Calls;
              }

            if ($formerdslcr) {
              $dslcr_differ = round($dslcrcurrent - $formerdslcr,2).'%';
            }
            else {
              $dslcr_differ = 0;
            }
            $dslcrcurrent = round($dslcrcurrent,2);
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
            $dslcrcurrent = round($dslcrcurrent,2);

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

        usort($emailarrayDSL, function($a, $b) {
            return $b['dslcr'] - $a['dslcr'];
        });
        }
      }

      if ($allSscCalls != 0) {

        $currentSSCCR =  round($allSscOrders * 100 / $allSscCalls,2);
      }

      else {
        $currentSSCCR = 0;
      }
      if ($allCallsMOB != 0) {

        $currentGeVoCCR =  round($allOrdersMOB * 100 / $allCallsMOB,2);
      }

      else {
        $currentGeVoCCR = 0;
      }
      if ($allBSCCalls != 0) {

        $currentBSCCCR =  round($allBSCOrders * 100 / $allBSCCalls,2);
      }

      else {
        $currentBSCCCR = 0;
      }
      if ($allPortalCalls != 0) {

        $currentPortalCCR =  round($allPortalOrders * 100 / $allPortalCalls,2);
        // dd($currentPortalCCR) ;
      }

      else {
        $currentPortalCCR = 0;
      }

      if ($allDSLCalls != 0) {
        $currentDSLCR =  round($allDLSOrders * 100 / $allDSLCalls,2);
      }
      else {
        $currentDSLCR = 0;
      }

      $time =  time();

      if (Carbon::parse($time) < Carbon::createFromTimeString('22:00'))
      {
        $nextTwo = ceil(time() / (120 * 60)) * (120 * 60);
        $timediff = intval($nextTwo)-$time;

        // $asString = 0.2 .' Minutes';
        $asString = ($timediff/60) + 1 .' Minutes';
      }
      else {
        $tommorrowMorning = Carbon::createFromTimeString('10:00')->addDay();

        $timediff = intval($tommorrowMorning->timestamp) - $time;

        $asString = ($timediff/60) + 1 .' Minutes';
        // $asString = 0.2 .' Minutes';
      }

      if($this->isMobile)
      {
        // dd($emailarray);
        $data = array('date'=> Carbon::now()->format('Y-m-d H:i:s'),'ssccr' => $currentSSCCR,'bsccr' => $currentBSCCCR, 'portalcr' => $currentPortalCCR, 'mobile' => $emailarray, 'isMobile' => 1);
        $email = new IntermediateMail($data);

        $mailinglist = $this->email;
        Mail::to($mailinglist)->send($email);
        if (Mail::failures()) {
          foreach(Mail::failures() as $email_address) {
                $logentry = new App\Log;
                $logentry->logEntry("Fehler Email - $email_address <br />");
             }
           }
           if ($this->sync != 1) {
             $this::dispatch($this->email,2,true)->delay(now()->add($asString))->onConnection('database')->onQueue('MailMobile');
             // $this::dispatch($this->email,,false)->delay(now()->add($asString))->onConnection('database')->onQueue('MailDSL');
           }
      }
      else {
        $data = array('date'=> Carbon::now()->format('Y-m-d H:i:s'), 'dslcr' => $currentDSLCR, 'dsl' => $emailarrayDSL,'isMobile' => false);
        $emailDSL = new IntermediateMail($data);
        $mailinglist = $this->email;

        Mail::to($mailinglist)->send($emailDSL);

        if (Mail::failures()) {
          foreach(Mail::failures() as $email_address) {
                $logentry = new App\Log;
                $logentry->logEntry("Fehler Email - $email_address <br />");
             }
           }
           if ($this->sync != 1) {

             // $this::dispatch($this->email,2,true)->delay(now()->add($asString))->onConnection('database')->onQueue('MailMobile');
             $this::dispatch($this->email,2,false)->delay(now()->add($asString))->onConnection('database')->onQueue('MailDSL');
           }
      }




  }

}
