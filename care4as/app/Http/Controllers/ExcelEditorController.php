<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Jobs\ImportDailyAgentChunks;

use App\DailyAgent;
use App\CapacitySuitReport;
use App\RetentionDetail;
use App\Hoursreport;

class ExcelEditorController extends Controller
{
    public function dailyAgentView($value='')
    {
      return view('reports/dailyAgent');
    }

    public function nettozeitenImport(Request $request)
    {

      $fromRow = 1;
      $insertData = array();

      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);

      $file = request()->file('file');

      $data = Excel::ToArray(new DataImport, $file)[0];

      // dd($data);
      for ($i=$fromRow-1; $i <= count($data)-1; $i++) {
      // for ($i=$fromRow-1; $i <= 10; $i++) {

        $cell = $data[$i];

        if(is_numeric($cell[0]))
        {
          $UNIX_DATE = ($cell[0] - 25569) * 86400;

          $date = gmdate("Y-m-d",$UNIX_DATE);

          // dd($data[5],$date);
          $insertData[$i] = array(

            "Case Reference Date" => $date,
            "AH3: Department (Agent Hierarchy 3) (Hist)" => $cell[1],
            "AH4: Team (Agent Hierarchy 4) (Hist)" => $cell[2],
            "Source Forecast Issue" => $cell[3],
            "Workpool" => $cell[4],
            "Agent" => $cell[5],
            "Case Medium" => $cell[6],
            "Case ID" => $cell[7],
            "Next Case Status" => $cell[8],
            "Has Call" => $cell[9],
            "CosmoCom Call Dnis Prefix" => $cell[10],
            "Is Billing Relevant" => $cell[11],
            "Is Case created by same Agent" => $cell[12],
            "Is Nightshift" => $cell[13],
            "Avg Case Editing Time sec (Limit 1h)" => $cell[14],
            "Avg SAS Editing Time sec (Limit 1h)" => $cell[15],
            "Sum Case Editing Time sec (Limit 1h)" => $cell[16],
            "Sum SAS Editing Time sec (Limit 1h)" => $cell[17],
            "Sum Case and SAS Editing Time (Limit 1h)" => $cell[18],
            "Count SSE Case Measurements" => $cell[19],
            "Count SAS Measurements" => $cell[20],
            "Count Case and SAS Measurements" => $cell[21],
          );
        }
        else {
          // dd($cell);
        }
      }
      $insertData = array_chunk($insertData, 3500);

      // dd($insertData);
      for($i=0; $i <= count($insertData)-1; $i++)
      {
        DB::table('nettozeitenimport')->insertOrIgnore($insertData[$i]);
      }
      // return redirect()->back();

      dd(count($data)-1);
    }

    public function GeVoUpload(Request $request)
    {

      $fromRow = 1;
      $insertData = array();

      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);

      $file = request()->file('file');

      $data = Excel::ToArray(new DataImport, $file);

      for ($i=$fromRow-1; $i <= count($data[0])-1; $i++) {

      // dd($data[0][0],$data[0][1]);
      $cell = $data[0][$i];

      if ($cell[12] && is_numeric($cell[1])) {

      $UNIX_DATE2 = ($cell[1] - 25569) * 86400;
      $date = gmdate("Y-m-d",$UNIX_DATE2);

        $insertData[$i] = array(

          "order_id" => $cell[0],
          "date" => $date,
          "department_desc" => $cell[6],
          "change_cluster" => $cell[8],
          "contract_id" => $cell[9],
          "business_transaction_desc" => $cell[11],
          "person_id" => $cell[12],
          "Ziel_LZV" => $cell[14],
          "Ziel_LZV" => $cell[17],
          "has_cancellation_index" => $cell[18],
          "contract_period_impact" => $cell[19],
          "Order_Retention" => $cell[20],
          "Order_Prevention" => $cell[21],
          "Ziel_Welt_Bezeichnung" => $cell[22],
        );
      }}

      $insertData = array_chunk($insertData, 3500);

      // dd($insertData);
      for($i=0; $i <= count($insertData)-1; $i++)
      {
        DB::table('gevotracking')->insertOrIgnore($insertData[$i]);
      }
      return redirect()->back();
    }

    public function Optinupload(Request $request)
    {
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      if($request->sheet)
      {
        $sheet = $request->sheet;
      }
      else {
        $sheet = 1;
      }

      if($request->fromRow)
      {
        $fromRow = $request->fromRow;
      }
      else
      {
        $fromRow = 2;
      }

      //determines from which row the the app starts editing the data
      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);
      $file = request()->file('file');

      $data = Excel::ToArray(new DataImport, $file);
      // $data = Excel::ToArray(new DataImport, $file );

      // dd($data);
      $insertData=array();

      $data2 = $data[$sheet-1];

      $insertData=array();
      // dd($data2);

      for ($i=$fromRow-1; $i <= count($data2)-1; $i++) {
        $cell = $data2[$i];

        $UNIX_DATE2 = ($cell[3] - 25569) * 86400;
        $date = gmdate("Y-m-d",$UNIX_DATE2);

        $insertData[$i] = [
          'date' => gmdate($date),
          'department' => $cell[5],
          'person_id' => $cell[7],
          'Anzahl_Handled_Calls' => $cell[8],
          'Anzahl_Handled_Calls_ohne_Call-OptIn' => $cell[9],
          'Anzahl_Handled_Calls_ohne_Daten-OptIn' => $cell[10],
          'Anzahl_OptIn-Abfragen' =>$cell[11] ,
          'Anzahl_OptIn-Erfolg' => $cell[12],
          'Anzahl_Call_OptIn' => $cell[13],
          'Anzahl_Email_OptIn' => $cell[14],
          'Anzahl_Print_OptIn' => $cell[15],
          'Anzahl_SMS_OptIn' => $cell[16],
          'Anzahl_Nutzungsdaten_OptIn' => $cell[17],
          'Anzahl_Verkehrsdaten_OptIn' => $cell[18],
          // 'Quote Opt-In Abfragen auf Handled Calls' =>  number_format(floatval(), 2, '.', ''),
          'Quote Opt-In Abfragen auf Handled Calls' =>  $cell[19],
          'Quote Opt-In Erfolg' => $cell[20],
        ];
      }

      $insertData = array_chunk($insertData, 3500);

      // dd($insertData);
      for($i=0; $i <= count($insertData)-1; $i++)
      {
        DB::table('optin')->insertOrIgnore($insertData[$i]);
      }
      return redirect()->back();
    }

    public function SASupload(Request $request)
    {
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      if($request->sheet)
      {
        $sheet = $request->sheet;
      }
      else {
        $sheet = 1;
      }

      if($request->fromRow)
      {
        $fromRow = $request->fromRow;
      }
      else
      {
        $fromRow = 2;
      }

      //determines from which row the the app starts editing the data
      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);
      $file = request()->file('file');

      $data = Excel::ToArray(new DataImport, $file);
      // $data = Excel::ToArray(new DataImport, $file );

      $insertData=array();

      $data2 = $data[$sheet-1];

      $insertData=array();

      // dd($data2);

        for ($i=$fromRow-1; $i <= count($data2)-1; $i++) {

          $cell = $data2[$i];
          // dd($cell);
          $date = \Carbon\Carbon::parse(strval($cell[1]));

          // return $date;
          if(!$cell[35])
          {
            $cell[35] = 0;
          }
          $insertData[$i] = [
            'order_id' => $cell[0],
            'date' => $date->format('Y-m-d'),
            'topic' => $cell[6],
            'serviceprovider_place' => $cell[7],
            'person_id' => $cell[11],
            'contract_id' => $cell[12],
            'case' => $cell[13],
            'productgroup' => $cell[17],
            'productcluster' =>$cell[15] ,
            'GO_Prov' => $cell[35],
          ];
      }
      $insertData = array_chunk($insertData, 3500);

      // dd($insertData);
      for($i=0; $i <= count($insertData)-1; $i++)
      {
        DB::table('sas')->insertOrIgnore($insertData[$i]);
      }
      return redirect()->back();
    }

    public function sseTrackingUpload(Request $request)
    {
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      if($request->sheet)
      {
        $sheet = $request->sheet;
      }
      else {
        $sheet = 1;
      }

      if($request->fromRow)
      {
        $fromRow = $request->fromRow;
      }
      else
      {
        $fromRow = 2;
      }

      //determines from which row the the app starts editing the data
      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);
      $file = request()->file('file');

      $data = Excel::ToArray(new DataImport, $file);
      // $data = Excel::ToArray(new DataImport, $file );

      $insertData=array();

      $data2 = $data[$sheet-1];

      $insertData=array();

      // dd($data2);

      for ($i=$fromRow-1; $i <= count($data2)-1; $i++) {

        $cell = $data2[$i];

        // dd($cell);
        if(!DB::table('sse_tracking')->where('sse_case_id',$cell[7])->where('person_id',$cell[10])->exists())
        {
          $UNIX_DATE1 = ($cell[0] - 25569) * 86400;
          $date = gmdate("Y-m-d", $UNIX_DATE1);

          $UNIX_DATE2 = ($cell[17] - 25569) * 86400;
          $duedate = gmdate("Y-m-d", $UNIX_DATE2);

          $insertData[$i] = [
            'trackingdate' => $date,
            'department' => $cell[5],
            'sse_case_id' => $cell[7],
            'sseType' => $cell[8],
            'contract_id' => $cell[9],
            'person_id' => $cell[10],
            'Tracking_Item1' => $cell[15],
            'Tracking_Item2' => $cell[16],
            'created_at' => now(),
          ];
        }}
      $insertData = array_chunk($insertData, 3500);

      for($i=0; $i <= count($insertData)-1; $i++)
      {
        DB::table('sse_tracking')->insert($insertData[$i]);
      }
      return redirect()->back();
    }

    public function debug(Request $request)
    {
      // for infinite time of execution
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0');

      if($request->sheet)
      {
        $sheet = $request->sheet;
      }
      else {
        $sheet = 1;
      }

      if($request->fromRow)
      {
        $fromRow = $request->fromRow;
      }
      else
      {
        $fromRow = 2;
      }

      //determines from which row the the app starts editing the data
      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);
      $file = request()->file('file');

      $data = Excel::ToArray(new DataImport, $file);

      if(1)
      {

      $counter = 0;
      foreach($data[0] as $cell)
        {
          $date = 0;

          if($cell[4] == '')
          {
            $cell[4] = 0;
          }
          if($cell[13] == '')
          {
            $cell[13] = 0;
          }
          if($cell[15] == '')
          {
            $cell[15] = 0;
          }

          //convert all the excel dates to unix date
          if(is_numeric($cell[0]))
          {
            $UNIX_DATE = ($cell[0] - 25569) * 86400;
            if(!$date = gmdate("Y-m-d H:i:s", $UNIX_DATE))
            {
              return redirect()->back()->withErrors(['name' => 'Das Datumsfeld ist nicht vorhanden']);
            };

            // return $date;
          }

          if($date != 0 && $cell[6])
          {
            // if(is_numeric($cell[24]))
            // {
            //   $UNIX_DATE2 = ($cell[24] - 25569) * 86400;
            //   $dailyAgent->start_time = gmdate("Y-m-d H:i:s",$UNIX_DATE2);
            // }
            // else {
            //   return 'Datenfehler start_time in Zeile '.$counter.':'.json_encode($cell[23]);
            // }

            $UNIX_DATE3 = ($cell[24] - 25569) * 86400;

            $insertarray[$counter]['date'] = $date;
            $insertarray[$counter]['agent_id'] = $cell[6];

            $UNIX_DATE2 = ($cell[23] - 25569) * 86400;
            $insertarray[$counter]['start_time'] = gmdate("Y-m-d H:i:s",$UNIX_DATE2);
            $insertarray[$counter]['end_time'] = gmdate("Y-m-d H:i:s", $UNIX_DATE3);
            $insertarray[$counter]['kw'] = $cell[2];
            $insertarray[$counter]['dialog_call_id']  = $cell[4];

            $insertarray[$counter]['agent_login_name'] = $cell[7];
            $insertarray[$counter]['agent_name'] = $cell[8];
            $insertarray[$counter]['agent_group_id'] = $cell[9];
            $insertarray[$counter]['agent_group_name'] = $cell[10];

            if($cell[12])
            {
              $insertarray[$counter]['agent_team_id'] = $cell[12];
            }
            else {
                $insertarray[$counter]['agent_team_id'] = 0;
            }

            $insertarray[$counter]['queue_id'] = $cell[17];
            $insertarray[$counter]['queue_name'] = $cell[19];
            $insertarray[$counter]['skill_id'] = $cell[20];
            $insertarray[$counter]['skill_name'] = $cell[21];
            $insertarray[$counter]['status'] = $cell[22];

            if($cell[25] && is_numeric($cell[25]))
            {
              $insertarray[$counter]['time_in_state'] = $cell[25];
            }
            else {
              $insertarray[$counter]['time_in_state'] = 0;
            }

          }
          $counter = $counter +1;
        }
        // dd($insertarray);
        $insertarray = array_chunk($insertarray, 3500);
      }
      dd($insertarray);
    }

    public function queueOrNot(Request $request)
    {
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution
      DB::statement('SET SESSION interactive_timeout = 28800');

      //determines which sheet should be used
      if($request->sheet && $request->sheet > 1)
      {
        $sheet = $request->sheet;
      }
      else {
        $sheet = 1;
      }

      //determines from which row the the app starts editing the data
      if($request->fromRow)
      {
        $fromRow = $request->fromRow;
      }
      else
      {
        $fromRow = 2;
      }

      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);

      $file = request()->file('file');
      $filename2Check = request()->file('file')->getClientOriginalName();
      $data = Excel::ToArray(new DataImport, request()->file('file'));
      // dd($data);
      // $possibleFilenames = array(
      //   'dailyagent.xlsx',
      //   'Daily_Agent.xlsx',
      // );

      $input['row'] = $fromRow;
      $input['sheet'] = $sheet;

      $nameconvention = 'DAI';

      if(str_contains($filename2Check, $nameconvention))
      {
        // dd($data);
        $this->dailyAgentUpload($data);
      }
      else {
        // return $filename2Check;
        $this->dailyAgentUploadQueue($data,$input);
      }

        return response()->json('success');
    }

    public function dailyAgentUploadQueue($data,$input)
    {

      $sheet = $input['sheet'];
      $fromRow = $input['row'];

      if(!isset($data[$sheet-1]) && empty($data[$sheet-1]))
      {
        return abort(403, 'das Sheet '.$sheet.' wurde nicht gefunden');
      }
      else {
        $data2 = $data[$sheet-1];
      }
      // dd($data2);
      if($countsheet = count($data2) < 2000)
      {
        for ($i=0; $i <= count($data)-1; $i++) {

          if(count($data[$i]) > 2000)
          {
            $data2 = $data[$i];
            $check = true;
          }
          if ($i == count($data)-1 && !$check) {
            abort(403, 'kein Sheet mit mehr als 2000 Datensätzen gefunden');
          }

        }
      }
      // dd($data);
      // $data = Excel::ToArray(new DataImport, $file );
      $counter=0;
      $insertData=array();
      // dd($data2);
      for($i=$fromRow-1; $i <= count($data2)-1; $i++ )
      {
        $cell = $data2[$i];

        if(is_numeric($cell[1]))
        {
          $UNIX_DATE = ($cell[1] - 25569) * 86400;
          $date = gmdate("Y-m-d H:i:s", $UNIX_DATE);
          // date_timezone_set ( $date, 'Europe/Berlin' );
        }

        else {
          $date = $cell[1];
        }

        if($date &&  is_numeric($cell[7]))
        {
          // return $cell;
          if(is_numeric($cell[18]))
          {
            $UNIX_DATE2 = ($cell[24] - 25569) * 86400;
            $start_time = gmdate("Y-m-d H:i:s",$UNIX_DATE2);
          }

          $UNIX_DATE3 = ($cell[25] - 25569) * 86400;
          $end_time = gmdate("Y-m-d H:i:s", $UNIX_DATE3);

          if($cell[5] == '')
          {
            $cell[5] = 0;
          }
          if($cell[12] == '')
          {
            $cell[12] = 0;
          }
          if($cell[15] == '')
          {
            $cell[15] = 0;
          }
          //check if the row hast data
            $insertData[$i] = [
              'date' => $date,
              'start_time' => $start_time,
              'end_time' => $end_time,
              'kw' => $cell[3],
              'dialog_call_id' => $cell[5],
              'agent_id' => $cell[7],
              'agent_login_name' => $cell[8],
              'agent_name' => $cell[9],
              'agent_group_id' => $cell[10],
              'agent_group_name' => $cell[11],
              'agent_team_id' => $cell[12],
              'queue_id' => $cell[18],
              'queue_name' => $cell[20],
              'skill_id' => $cell[21],
              'skill_name' => $cell[22],
              'status' => $cell[23],
              'time_in_state' => $cell[26],
              ];
        }}

        $insertData = array_chunk($insertData, 3500);

        // DB::table('dailyagent')->insert($insertData[0]);
        for($i=0; $i <= count($insertData)-1; $i++)
        {
          ImportDailyAgentChunks::dispatch($insertData[$i])
          ->delay(now()->addMinutes($i*0.2));
        }

        // return redirect()->back();
    }

    public function dailyAgentUpload($data)
    {
        $counter = 0;

        // dd($data[0]);

        foreach($data[0] as $cell)
        {
          $date = 0;

          if($cell[4] == '')
          {
            $cell[4] = 0;
          }
          if($cell[13] == '')
          {
            $cell[13] = 0;
          }
          if($cell[15] == '')
          {
            $cell[15] = 0;
          }

          //convert all the excel dates to unix date
          if(is_numeric($cell[0]))
          {
            $UNIX_DATE = ($cell[0] - 25569) * 86400;
            if(!$date = gmdate("Y-m-d H:i:s", $UNIX_DATE))
            {
              return redirect()->back()->withErrors(['name' => 'Das Datumsfeld ist nicht vorhanden']);
            };

            // return $date;
          }

          if($date != 0 && $cell[6])
          {
            // if(is_numeric($cell[24]))
            // {
            //   $UNIX_DATE2 = ($cell[24] - 25569) * 86400;
            //   $dailyAgent->start_time = gmdate("Y-m-d H:i:s",$UNIX_DATE2);
            // }
            // else {
            //   return 'Datenfehler start_time in Zeile '.$counter.':'.json_encode($cell[23]);
            // }

            $UNIX_DATE3 = ($cell[24] - 25569) * 86400;

            $insertarray[$counter]['date'] = $date;
            $insertarray[$counter]['agent_id'] = $cell[6];

            $UNIX_DATE2 = ($cell[23] - 25569) * 86400;
            $insertarray[$counter]['start_time'] = gmdate("Y-m-d H:i:s",$UNIX_DATE2);
            $insertarray[$counter]['end_time'] = gmdate("Y-m-d H:i:s", $UNIX_DATE3);
            $insertarray[$counter]['kw'] = $cell[2];
            $insertarray[$counter]['dialog_call_id']  = $cell[4];

            $insertarray[$counter]['agent_login_name'] = $cell[7];
            $insertarray[$counter]['agent_name'] = $cell[8];
            $insertarray[$counter]['agent_group_id'] = $cell[9];
            $insertarray[$counter]['agent_group_name'] = $cell[10];

            if($cell[12])
            {
              $insertarray[$counter]['agent_team_id'] = $cell[12];
            }
            else {
                $insertarray[$counter]['agent_team_id'] = 0;
            }

            $insertarray[$counter]['queue_id'] = $cell[17];
            $insertarray[$counter]['queue_name'] = $cell[19];
            $insertarray[$counter]['skill_id'] = $cell[20];
            $insertarray[$counter]['skill_name'] = $cell[21];
            $insertarray[$counter]['status'] = $cell[22];

            if($cell[25] && is_numeric($cell[25]))
            {
              $insertarray[$counter]['time_in_state'] = $cell[25];
            }
            else {
              $insertarray[$counter]['time_in_state'] = 0;
            }

          }
          $counter = $counter +1;
        }

        // dd($insertarray);
        $insertarray = array_chunk($insertarray, 3500);

        // DB::table('dailyagent')->insert($insertData[0]);
        for($i=0; $i <= count($insertarray)-1; $i++)
        {
          ImportDailyAgentChunks::dispatch($insertarray[$i])
          ->onConnection('sync');
        }
    }

    public function capacitysuitReport ()
    {
      return view('reports.capacityReport');
    }

    public function capacitysuitReportUpload(Request $request)
    {
      // the capacitysuitReport variable stores one entry for the capacityReport table
      $capaySuitInput = null;

      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);

      $file = request()->file('file');
      $path = $file->getRealPath();
      $data = Excel::ToArray(new DataImport, request()->file('file'));

      // for($i=0;$i <= 10; $i++ )
      // {
      //   unset($data[0][$i]);
      // }
      $transData = $data[0];
      // dd($transData = $data[0]);
      // foreach($transData as $array)
      // {
      //     $capaySuitInput->$transData[0] = $array[0];
      //     $capaySuitInput->$transData[1] = $array[1];
      //     $capaySuitInput->$transData[2] = $array[2];
      // }

      // return  count($transData[0]);
      for($i = 0; $i< (count($transData))-1; $i++)
      {
        $capacySuitInput = new CapacitySuitReport;
        for($j=0; $j < (count($transData[0])-1); $j++)
        {
          $property = $transData[0][$j];
          if(!$property == '')
          $capacySuitInput->$property = $transData[$i+1][$j];
          $property= null;
        }

        if(!CapacitySuitReport::where('target_date',$capacySuitInput->target_date)->where('agent_id',$capacySuitInput->agent_id)->exists())
        {
          $capacySuitInput->save();
        }

      }
      return redirect()->back();
    }

    public function RetentionDetailsReport(Request $request)
    {
      if($request->sheet)
      {
        $sheet = $request->sheet;
      }
      else {
        $sheet = 3;
      }

      if($request->fromRow)
      {
        $fromRow = $request->fromRow;
      }
      else
      {
        $fromRow = 2;
      }

      $data = Excel::ToArray(new DataImport, request()->file('file'))[0];

      // dd($data);

      $insertarray = array();

      for($i = $fromRow-1; $i <= count($data)-1; $i++)
      {
        $UNIX_DATE = ($data[$i][1] - 25569) * 86400;
        $date = gmdate("Y-m-d", $UNIX_DATE);
        // $report = new RetentionDetail;
        // $report->person_id = $row[0];
        $insertarray[$i]['person_id'] = $data[$i][0];
        // $report->call_date = $date;
        $insertarray[$i]['call_date'] = $date;
        // $report->department_desc = $row[9];
        $insertarray[$i]['department_desc']  = $data[$i][9];

        // $report->calls = $row[11];
        $insertarray[$i]['calls']  = $data[$i][11];



        if($data[$i][9] !='Care4as Retention DSL Eggebek')
        {
          // $report->calls_smallscreen = $row[14];
          $insertarray[$i]['calls_smallscreen'] = $data[$i][14];

          // $report->calls_bigscreen = $row[15];
          $insertarray[$i]['calls_bigscreen'] = $data[$i][15];

          // $report->calls_portale = $row[16];
          $insertarray[$i]['calls_portale'] = $data[$i][16];

          // $report->orders_smallscreen = $row[18] + $row[23];
          $insertarray[$i]['orders_smallscreen'] = $data[$i][18] + $data[$i][23];

          // $report->orders_bigscreen = $row[19] + $row[24];
          $insertarray[$i]['orders_bigscreen'] = $data[$i][19] + $data[$i][24];

          // $report->orders_portale = $row[21] + $row[26];
          $insertarray[$i]['orders_portale'] = $data[$i][21] + $data[$i][26];

          // $report->mvlzNeu = $row[33];
          $insertarray[$i]['mvlzNeu'] = $data[$i][33];

          // $report->rlzPlus = $row[35];
          $insertarray[$i]['rlzPlus'] = $data[$i][35];
        }
        else
        {
          // $report->mvlzNeu = $row[32];
          $insertarray[$i]['mvlzNeu'] = $data[$i][32];

          // $report->rlzPlus = $row[34];
          $insertarray[$i]['rlzPlus'] = $data[$i][34];
        }
        // $report->orders = $row[17] + $row[22];
        $insertarray[$i]['orders'] = $data[$i][17] + $data[$i][22];

        // $report->Rabatt_Guthaben_Brutto_Mobile = $row[28];
        $insertarray[$i]['Rabatt_Guthaben_Brutto_Mobile'] = $data[$i][28];
        $insertarray[$i]['orders_kuerue']  = $data[$i][50] + $data[$i][54];
        // $insertarray2[] = $insertarray;
      }

      for($i=$fromRow-1; $i <= count($insertarray); $i++)
      {
        DB::table('retention_details')->insertOrIgnore($insertarray[$i]);
      }
      // return response()->json($insertarray);
      // return redirect()->back();
      // dd($insertarray);

    }

    public function provisionView()
    {
      return view('reports/provisionInput');
    }

    public function provisionUpload(Request $request)
    {
      $name ='Dirki';
      $path1 = request()->file('file')->store('temp');
      $path= storage_path('app').'/'.$path1;

      // $data = Excel::ToArray(new DataImport, request()->file('file'))[0];
      $data = Excel::ToArray(new DataImport, $path)[0];
      unset($data[0]);
      // dd($data);
      foreach ($data as $row) {
        if($row[0] && $row[1] && is_numeric($row[1]) && $row[2])
        {
          $UNIX_DATE = ($row[0] - 25569) * 86400;
          $date = gmdate("Y-m-d H:i:s", $UNIX_DATE);
          if(!DB::table('buchungsliste')->where('date',$date)->where('contractnumber',$row[1])->exists())
          {
            if($row[1] != null)
            {
              if(is_int($row[1]))
              {
                $contract = $row[1];
              }
              else {
                $contract = 0;
              }
              if($date == '08.12.2020')
              {
                echo $date;
              }
              DB::table('buchungsliste')
              ->updateOrInsert([
                'date' => $date,
                'contractnumber' => $contract,
                'SaveAgent' => $row[2],
                'edited_by' => $name,
              ]);
            }
          }
        }
      }

      // return redirect()->back();
    }

    public function reportHours(Request $request)
    {
      if($request->sheet)
      {
        $sheet = $request->sheet;
      }
      else {
        $sheet = 3;
      }

      if($request->fromRow)
      {
        $fromRow = $request->fromRow;
      }
      else
      {
        $fromRow = 2;
      }
      //determines from which row the the app starts editing the data
      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);
      $file = request()->file('file');

      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0');
      $data = Excel::ToArray(new DataImport, $file)[0];
      // dd($data);
      for ($i=$fromRow; $i < count($data)-1; $i++) {

        $row = $data[$i];
        $UNIX_DATE = ($row[0] - 25569) * 86400;
        $date = gmdate("Y-m-d", $UNIX_DATE);

        if(!HoursReport::where('name',$row[1])->where('date',$date)->exists() && $row[1])
        {
          $hoursReport = new Hoursreport;
          $hoursReport->date = $date;
          $hoursReport->name = $row[1];
          $hoursReport->IST = $row[2];
          $hoursReport->vacation = $row[3];
          $hoursReport->SA = $row[4];
          $hoursReport->sick = $row[5];
          $hoursReport->IST_Angepasst = $row[6];
          $hoursReport->vacation_Angepasst = $row[7];
          $hoursReport->SA_Angepasst = $row[8];
          $hoursReport->sick_Angepasst = $row[9];

          $hoursReport->save();
        }
      }

      return redirect()->route('hoursreport.sync');
    }

    public function availbenchReport(Request $request){
      //configure DB import settings
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      //validate $request
      $request->validate([
        'file' => 'required',
      ]);

      $file = request()->file('file');  //save $request in variable

      //convert .txt file to array
      $file = file_get_contents($file);                         // Get the whole file as string
      $file = mb_convert_encoding($file, 'UTF8', 'UTF-16LE');   // Convert the file to UTF8
      $file = preg_split("/\R/", $file);                        // Split it by line breaks

      $fileArray = array(); //initialize array

      foreach ($file as $key => $line) {
        $fileArray[$key] = str_getcsv($line, ";");
      };

      $header = array_shift($fileArray);

      $availbenchArray = array();
      $i = 0;

      //get datatables timespan
      $dataTables = DB::table('datatables_timespan')
      ->get()
      ->toArray();

      $minDate = null;
      $maxDate = null;

      foreach($dataTables as $key => $entry){
        $entry = (array) $entry;
        if ($entry['data_table'] == 'availbench_report'){
          $minDate = date_create_from_format('Y-m-d', $entry['min_date']);
          $maxDate = date_create_from_format('Y-m-d',$entry['max_date']);
        }
      }

      //dd($fileArray);

      foreach($fileArray as $row) {
        if(count($header) == count($row)) {
          $availbenchArray[$i]['date_key'] = intval($row[0]);
          $availbenchArray[$i]['date_date'] = date_create_from_format('d.m.Y', $row[1]); //Date
          $availbenchArray[$i]['call_date_interval_start_time'] = date_create_from_format('d.m.Y G:i:s', $row[2]); //timestamp
          $availbenchArray[$i]['call_forecast_issue_key'] = intval($row[3]);
          $availbenchArray[$i]['call_forecast_issue'] = $row[4];
          $availbenchArray[$i]['call_forecast_owner_key'] = intval($row[5]);
          $availbenchArray[$i]['call_forecast_owner'] = $row[6];
          $availbenchArray[$i]['forecast'] = intval($row[7]);
          $availbenchArray[$i]['handled'] = intval($row[8]);
          $availbenchArray[$i]['availtime_summary'] = intval($row[9]);
          $availbenchArray[$i]['availtime_sec'] = intval($row[10]);
          $availbenchArray[$i]['handling_time_sec'] = intval($row[11]);
          $availbenchArray[$i]['availtime_percent'] = floatval(str_replace(',', '.', str_replace('.', '', $row[12])));
          $availbenchArray[$i]['forecast_rate'] = floatval(str_replace(',', '.', str_replace('.', '', $row[13])));
          $availbenchArray[$i]['avail_bench'] = floatval(str_replace(',', '.', str_replace('.', '', $row[14])));
          $availbenchArray[$i]['idp_done'] = intval($row[15]);
          $availbenchArray[$i]['number_payed_calls'] = floatval(str_replace(',', '.', str_replace('.', '', $row[16])));
          $availbenchArray[$i]['price'] = floatval(str_replace(',', '.', str_replace('.', '', $row[17])));
          $availbenchArray[$i]['aht'] = floatval(str_replace(',', '.', str_replace('.', '', $row[18])));
          $availbenchArray[$i]['productive_minutes'] = floatval(str_replace(',', '.', str_replace('.', '', $row[19])));
          $availbenchArray[$i]['malus_interval'] = floatval(str_replace(',', '.', str_replace('.', '', $row[20])));
          $availbenchArray[$i]['malus_percent'] = floatval(str_replace(',', '.', str_replace('.', '', $row[21])));
          $availbenchArray[$i]['acceptance_rate'] = floatval(str_replace(',', '.', str_replace('.', '', $row[22])));
          $availbenchArray[$i]['total_costs_per_interval'] = floatval(str_replace(',', '.', str_replace('.', '', $row[23])));
          $availbenchArray[$i]['malus_approval_done'] = intval($row[24]);

          if ($minDate == null) {
            $minDate = $availbenchArray[$i]['date_date'];
          } else if ($availbenchArray[$i]['date_date'] < $minDate){
            $minDate = $availbenchArray[$i]['date_date'];
          }

          if ($maxDate == null) {
            $maxDate = $availbenchArray[$i]['date_date'];
          } else if ($availbenchArray[$i]['date_date'] > $maxDate){
            $maxDate = $availbenchArray[$i]['date_date'];
          }

          $i++;
        }
      }

      for ($i = 0; $i < count($availbenchArray); $i++){
        //echo $availbenchArray[$i]['call_forecast_owner_key'].' - '.$availbenchArray[$i]['call_date_interval_start_time'].' - '.$i;
        DB::table('availbench_report')->updateOrInsert(
          [
            'call_forecast_issue_key' => $availbenchArray[$i]['call_forecast_issue_key'],
            'call_date_interval_start_time' => $availbenchArray[$i]['call_date_interval_start_time']
          ],
          [
          'date_key' => $availbenchArray[$i]['date_key'],
          'date_date' => $availbenchArray[$i]['date_date'],
          'call_forecast_owner_key' => $availbenchArray[$i]['call_forecast_owner_key'],
          'call_forecast_issue' => $availbenchArray[$i]['call_forecast_issue'],
          'call_forecast_owner' => $availbenchArray[$i]['call_forecast_owner'],
          'forecast' => $availbenchArray[$i]['forecast'],
          'handled' => $availbenchArray[$i]['handled'],
          'availtime_summary' => $availbenchArray[$i]['availtime_summary'],
          'availtime_sec' => $availbenchArray[$i]['availtime_sec'],
          'handling_time_sec' => $availbenchArray[$i]['handling_time_sec'],
          'availtime_percent' => $availbenchArray[$i]['availtime_percent'],
          'forecast_rate' => $availbenchArray[$i]['forecast_rate'],
          'avail_bench' => $availbenchArray[$i]['avail_bench'],
          'idp_done' => $availbenchArray[$i]['idp_done'],
          'number_payed_calls' => $availbenchArray[$i]['number_payed_calls'],
          'price' => $availbenchArray[$i]['price'],
          'aht' => $availbenchArray[$i]['aht'],
          'productive_minutes' => $availbenchArray[$i]['productive_minutes'],
          'malus_interval' => $availbenchArray[$i]['malus_interval'],
          'malus_percent' => $availbenchArray[$i]['malus_percent'],
          'acceptance_rate' => $availbenchArray[$i]['acceptance_rate'],
          'total_costs_per_interval' => $availbenchArray[$i]['total_costs_per_interval'],
          'malus_approval_done' => $availbenchArray[$i]['malus_approval_done']
          ]
        );

        DB::table('datatables_timespan')->updateOrInsert(
          [
            'data_table' => 'availbench_report',
          ],
          [
            'min_date' => $minDate,
            'max_date' => $maxDate,
          ]
        );
      }
      return redirect()->back();
    }

    public function availbenchReportKDW(Request $request){
      //configure DB import settings
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      //validate $request
      $request->validate([
        'file' => 'required',
      ]);

      $file = request()->file('file');  //save $request in variable

      //convert .txt file to array
      $file = file_get_contents($file);                         // Get the whole file as string
      $file = mb_convert_encoding($file, 'UTF8', 'UTF-16LE');   // Convert the file to UTF8
      $file = preg_split("/\R/", $file);                        // Split it by line breaks

      $fileArray = array(); //initialize array

      foreach ($file as $key => $line) {
        $fileArray[$key] = str_getcsv($line, "\t");
      };

      $header = array_shift($fileArray);

      $availbenchArray = array();
      $i = 0;

      //get datatables timespan
      $dataTables = DB::table('datatables_timespan')
      ->get()
      ->toArray();

      $minDate = null;
      $maxDate = null;

      foreach($dataTables as $key => $entry){
        $entry = (array) $entry;
        if ($entry['data_table'] == 'availbench_report'){
          $minDate = date_create_from_format('Y-m-d', $entry['min_date']);
          $maxDate = date_create_from_format('Y-m-d',$entry['max_date']);
        }
      }

      //dd($fileArray);

      foreach($fileArray as $row) {
        if(count($header) == count($row)) {
          if(intval($row[3]) == 54){
            $availbenchArray[$i]['date_key'] = intval($row[0]);
            $availbenchArray[$i]['date_date'] = date_create_from_format('d.m.Y', $row[1]); //Date
            $availbenchArray[$i]['call_date_interval_start_time'] = date_create_from_format('d.m.Y G:i', $row[2]); //timestamp
            $availbenchArray[$i]['call_forecast_issue_key'] = intval($row[3]);
            $availbenchArray[$i]['call_forecast_issue'] = $row[4];
            $availbenchArray[$i]['call_forecast_owner_key'] = intval($row[5]);
            $availbenchArray[$i]['call_forecast_owner'] = $row[6];
            $availbenchArray[$i]['forecast'] = intval($row[7]);
            $availbenchArray[$i]['handled'] = intval($row[8]);
            $availbenchArray[$i]['availtime_summary'] = intval($row[9]);
            $availbenchArray[$i]['availtime_sec'] = intval($row[10]);
            $availbenchArray[$i]['handling_time_sec'] = intval($row[11]);
            $availbenchArray[$i]['availtime_percent'] = floatval(str_replace(',', '.', str_replace('.', '', $row[12])));
            $availbenchArray[$i]['forecast_rate'] = floatval(str_replace(',', '.', str_replace('.', '', $row[13])));
            $availbenchArray[$i]['avail_bench'] = floatval(str_replace(',', '.', str_replace('.', '', $row[14])));
            $availbenchArray[$i]['idp_done'] = intval($row[15]);
            $availbenchArray[$i]['number_payed_calls'] = floatval(str_replace(',', '.', str_replace('.', '', $row[16])));
            $availbenchArray[$i]['price'] = floatval(str_replace(',', '.', str_replace('.', '', $row[17])));
            $availbenchArray[$i]['aht'] = floatval(str_replace(',', '.', str_replace('.', '', $row[18])));
            $availbenchArray[$i]['productive_minutes'] = floatval(str_replace(',', '.', str_replace('.', '', $row[19])));
            $availbenchArray[$i]['malus_interval'] = floatval(str_replace(',', '.', str_replace('.', '', $row[20])));
            $availbenchArray[$i]['malus_percent'] = floatval(str_replace(',', '.', str_replace('.', '', $row[21])));
            $availbenchArray[$i]['acceptance_rate'] = floatval(str_replace(',', '.', str_replace('.', '', $row[22])));
            $availbenchArray[$i]['total_costs_per_interval'] = floatval(str_replace(',', '.', str_replace('.', '', $row[23])));
            $availbenchArray[$i]['malus_approval_done'] = intval($row[24]);

            if ($minDate == null) {
              $minDate = $availbenchArray[$i]['date_date'];
            } else if ($availbenchArray[$i]['date_date'] < $minDate){
              $minDate = $availbenchArray[$i]['date_date'];
            }

            if ($maxDate == null) {
              $maxDate = $availbenchArray[$i]['date_date'];
            } else if ($availbenchArray[$i]['date_date'] > $maxDate){
              $maxDate = $availbenchArray[$i]['date_date'];
            }
            $i++;
          }
        }
      }

      for ($i = 0; $i < count($availbenchArray); $i++){
        //echo $availbenchArray[$i]['call_forecast_owner_key'].' - '.$availbenchArray[$i]['call_date_interval_start_time'].' - '.$i;
        DB::table('availbench_report')->updateOrInsert(
          [
            'call_forecast_issue_key' => $availbenchArray[$i]['call_forecast_issue_key'],
            'call_date_interval_start_time' => $availbenchArray[$i]['call_date_interval_start_time']
          ],
          [
          'date_key' => $availbenchArray[$i]['date_key'],
          'date_date' => $availbenchArray[$i]['date_date'],
          'call_forecast_owner_key' => $availbenchArray[$i]['call_forecast_owner_key'],
          'call_forecast_issue' => $availbenchArray[$i]['call_forecast_issue'],
          'call_forecast_owner' => $availbenchArray[$i]['call_forecast_owner'],
          'forecast' => $availbenchArray[$i]['forecast'],
          'handled' => $availbenchArray[$i]['handled'],
          'availtime_summary' => $availbenchArray[$i]['availtime_summary'],
          'availtime_sec' => $availbenchArray[$i]['availtime_sec'],
          'handling_time_sec' => $availbenchArray[$i]['handling_time_sec'],
          'availtime_percent' => $availbenchArray[$i]['availtime_percent'],
          'forecast_rate' => $availbenchArray[$i]['forecast_rate'],
          'avail_bench' => $availbenchArray[$i]['avail_bench'],
          'idp_done' => $availbenchArray[$i]['idp_done'],
          'number_payed_calls' => $availbenchArray[$i]['number_payed_calls'],
          'price' => $availbenchArray[$i]['price'],
          'aht' => $availbenchArray[$i]['aht'],
          'productive_minutes' => $availbenchArray[$i]['productive_minutes'],
          'malus_interval' => $availbenchArray[$i]['malus_interval'],
          'malus_percent' => $availbenchArray[$i]['malus_percent'],
          'acceptance_rate' => $availbenchArray[$i]['acceptance_rate'],
          'total_costs_per_interval' => $availbenchArray[$i]['total_costs_per_interval'],
          'malus_approval_done' => $availbenchArray[$i]['malus_approval_done']
          ]
        );

        DB::table('datatables_timespan')->updateOrInsert(
          [
            'data_table' => 'availbench_report',
          ],
          [
            'min_date' => $minDate,
            'max_date' => $maxDate,
          ]
        );
      }
      return redirect()->back();
    }

    public function dailyAgentCsvUpload(Request $request){
      //configure DB import settings
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '0'); // for infinite time of execution

      //validate $request
      $request->validate([
        'file' => 'required',
      ]);

      $file = request()->file('file');  //save $request in variable

      $csv = array_map('str_getcsv', file($file));
      $csv[0][0] = 'mydate';

      // dd($csv[0]);
      array_pop($csv);
      array_walk($csv, function(&$a) use ($csv) {
        $a = array_combine($csv[0], $a);
      });
      array_shift($csv);

      //get datatables timespan
      $dataTables = DB::table('datatables_timespan')
      ->get()
      ->toArray();

      $minDate = null;
      $maxDate = null;

      foreach($dataTables as $key => $entry){
        $entry = (array) $entry;
        if ($entry['data_table'] == 'dailyAgent_report'){
          $minDate = date_create_from_format('Y-m-d', $entry['min_date']);
          $maxDate = date_create_from_format('Y-m-d',$entry['max_date']);
        }
      }

      foreach($csv as $entry){
        if($entry['agent_group_id'] == 772 || $entry['agent_group_id'] == 1253) {
          // find date for datatables timespan min- and max- values
          $date = date_create_from_format('Y-m-d', $entry['mydate']);

          if ($minDate == null) {
            $minDate = $date;
          } else if ($date < $minDate){
            $minDate = $date;
          }

          if ($maxDate == null) {
            $maxDate = $date;
          } else if ($date > $maxDate){
            $maxDate = $date;
          }

          DB::table('datatables_timespan')->updateOrInsert(
            [
              'data_table' => 'dailyAgent_report',
            ],
            [
              'min_date' => $minDate,
              'max_date' => $maxDate,
            ]
          );

          DB::table('dailyagent')->insertOrIgnore(
            [
              'start_time' => $entry['start_time'],
              'agent_id' => $entry['agent_id'],
              'status' => $entry['status'],
              'date' => $date,
              'kw' => $entry['kw'],
              'dialog_call_id' => $entry['dialog_call_id'],
              'agent_login_name' => $entry['agent_login_name'],
              'agent_name' => $entry['agent_name'],
              'agent_group_name' => $entry['agent_group_name'],
              'agent_group_id' => $entry['agent_group_id'],
              'agent_team_id' => $entry['agent_team_id'],
              'agent_team_name' => $entry['agent_team_name'],
              'queue_id' => $entry['queue_id'],
              'queue_name' => $entry['queue_name'],
              'skill_id' => $entry['skill_id'],
              'skill_name' => $entry['skill_name'],
              'start_time' => $entry['start_time'],
              'end_time' => $entry['end_time'],
              'time_in_state' => $entry['time_in_state'],
              'timezone' => $entry['timezone']
            ]
          );
        }

      }
      return redirect()->back();
    }

}
