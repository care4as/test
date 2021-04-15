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

      $insertData=array();

      $data2 = $data[$sheet-1];

      $insertData=array();

      // dd($data2);

      for ($i=$fromRow-1; $i <= count($data2)-1; $i++) {

        $cell = $data2[$i];

        $date = \Carbon\Carbon::parse($cell[3]);

        $insertData[$i] = [
          'date' => $date->format('Y-m-d'),
          'department' => $cell[5],
          'person_id' => $cell[6],
          'Anzahl_Handled_Calls' => $cell[7],
          'Anzahl_Handled_Calls_ohne_Call-OptIn' => $cell[8],
          'Anzahl_Handled_Calls_ohne_Daten-OptIn' => $cell[9],
          'Anzahl_OptIn-Abfragen' =>$cell[10] ,
          'Anzahl_OptIn-Erfolg' => $cell[11],
          'Anzahl_Global_OptIn' => $cell[12],
          'Anzahl_Call_OptIn' => $cell[13],
          'Anzahl_Email_OptIn' => $cell[14],
          'Anzahl_Print_OptIn' => $cell[15],
          'Anzahl_SMS_OptIn' => $cell[16],
          'Anzahl_Nutzungsdaten_OptIn' => $cell[17],
          'Anzahl_Verkehrsdaten_OptIn' => $cell[18],
          'Anzahl_Call_OptOut' => $cell[19],
          'Anzahl_Email_OptOut' => $cell[20],
        ];
      }

    $insertData = array_chunk($insertData, 3500);

    // dd($insertData);
    for($i=0; $i <= count($insertData)-1; $i++)
    {
      DB::table('optin')->insertOrIgnore($insertData[$i]);
    }
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

      // dd($insertData);
      for($i=0; $i <= count($insertData)-1; $i++)
      {
        DB::table('sse_tracking')->insert($insertData[$i]);
      }
      return redirect()->back();
    }
    public function dailyAgentUploadQueue(Request $request)
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


      $data = Excel::ToArray(new DataImport, request()->file('file'));

      // dd($data);
      if(!isset($data[$sheet-1]) && empty($data[$sheet-1]))
      {
        return abort(403, 'das Sheet '.$sheet.' wurde nicht gefunden');
      }
      else {
        $data2 = $data[$sheet-1];
      }
      if($countsheet = count($data2) < 2000)
      {
        for ($i=0; $i <= count($data)-1; $i++) {
          if($data[$i] > 2000)
          {
            $data2 = $data[$i];
            $check = true;
          }
          if ($i == count($data)-1 && !$check) {
            abort(403, 'kein Sheet mit mehr als 2000 Datensätzen gefunden');
          }
        }
      }
      else
      {
        return abort(403, 'weniger als 2000 ('.$countsheet.') Datensätze in dem Sheet');
      }
      // dd($data);
      // $data = Excel::ToArray(new DataImport, $file );
      $counter=0;
      $insertData=array();

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
        }
        }

        $insertData = array_chunk($insertData, 3500);

        // DB::table('dailyagent')->insert($insertData[0]);
        for($i=0; $i <= count($insertData)-1; $i++)
        {
          ImportDailyAgentChunks::dispatch($insertData[$i])
          ->delay(now()->addMinutes($i*0.2));
        }
        return response()->json('success');
        // return redirect()->back();
    }
    public function dailyAgentUpload(Request $request)
    {
      DB::disableQueryLog();
      ini_set('memory_limit', '-1');
      // return 1;
      $request->validate([
        'file' => 'required',
        // 'name' => 'required',
      ]);

      // $file = request()->file('file');
      // $path = $file->getRealPath();
      $data = Excel::ToArray(new DataImport, request()->file('file'))[0];
      $counter=0;

      for($i=0;$i <= 1; $i++ )
      {
        unset($data[0][$i]);
      }
      // $keyarray = array(0 => "xy", 1 => "xy", 2 => "xy", 3 => "xy", 4 => "xy", 5 => "xy", 6 => "xy", 7 => "xy", 8 => "xy", 9 => "xy", 10 => "xy");
      // $convArray = array_diff_key($data[0], $keyarray);

      // array_splice($data[0],-7);
      // dd($data[0]);
        foreach($data[0] as $cell)
        {
          $counter = $counter +1;
          $dailyAgent = new DailyAgent;

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

          $UNIX_DATE = ($cell[0] - 25569) * 86400;
          $dailyAgent->date = gmdate("Y-m-d H:i:s", $UNIX_DATE);

          if(is_numeric($cell[24]))
          {
            $UNIX_DATE2 = ($cell[24] - 25569) * 86400;
            $dailyAgent->start_time = gmdate("Y-m-d H:i:s",$UNIX_DATE2);
          }
          else {
            return 'Datenfehler in Zeile '.$counter.':'.json_encode($cell[23]);
          }

          $UNIX_DATE3 = ($cell[25] - 25569) * 86400;
          $dailyAgent->end_time = gmdate("Y-m-d H:i:s", $UNIX_DATE3);
          $dailyAgent->kw = $cell[3];
          $dailyAgent->dialog_call_id  = $cell[5];
          $dailyAgent->agent_id = $cell[7];
          $dailyAgent->agent_login_name = $cell[8];
          $dailyAgent->agent_name = $cell[9];
          $dailyAgent->agent_group_id = $cell[10];
          $dailyAgent->agent_group_name = $cell[11];
          $dailyAgent->agent_team_id = $cell[12];
          $dailyAgent->queue_id = $cell[18];
          $dailyAgent->queue_name = $cell[20];
          $dailyAgent->skill_id = $cell[21];
          $dailyAgent->skill_name = $cell[22];
          $dailyAgent->status = $cell[23];
          $dailyAgent->time_in_state = $cell[26];

          $dailyAgent->save();
        }

      return redirect()->back();
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

        // $insertarray2[] = $insertarray;
      }

      for($i=$fromRow-1; $i <= count($insertarray); $i++)
      {
        DB::table('retention_details')->insertOrIgnore($insertarray[$i]);
      }
      // return response()->json($insertarray);
      return redirect()->back();
      // dd($data);

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


}
