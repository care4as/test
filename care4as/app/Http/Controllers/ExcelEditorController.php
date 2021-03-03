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

class ExcelEditorController extends Controller
{
    public function dailyAgentView($value='')
    {
      return view('reports/dailyAgent');
    }
    public function dailyAgentUploadQueue(Request $request)
    {
      //determines which sheet should be used
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
      // $path1 = request()->file('file')->store('temp');
      // $path= storage_path('app').'/'.$path1;
      // $path = $file->getRealPath();
      // $path= storage_path('app').'/'.$path1;

      ini_set('memory_limit', '-1');
      DB::disableQueryLog();
      ini_set('max_execution_time', '0'); // for infinite time of execution

      $data = Excel::ToArray(new DataImport, $file );
      // $data = Excel::ToArray(new DataImport, $file );
      $counter=0;
      $insertData=array();

      // dd($data[$sheet-1]);

      for($i=$fromRow-1; $i <= count($data[$sheet-1])-1; $i++ )
      {
        $cell = $data[$sheet-1][$i];
        // return $cell;
        $UNIX_DATE = ($cell[1] - 25569) * 86400;
        $date = date("Y-m-d H:i:s", $UNIX_DATE);

        if(is_numeric($cell[18]))
        {
          $UNIX_DATE2 = ($cell[24] - 25569) * 86400;
          $start_time = date("Y-m-d H:i:s",$UNIX_DATE2);
        }

        $UNIX_DATE3 = ($cell[25] - 25569) * 86400;
        $end_time = date("Y-m-d H:i:s", $UNIX_DATE3);

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
        if($date &&  $cell[7])
        {

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
        else
        {
          // return $cell;
        }
      }
        // dd($insertData);
        $insertData = array_chunk($insertData, 3500);
        // DB::table('dailyagent')->insert($insertData[0]);

        for($i=0; $i <= count($insertData)-1; $i++)
        {
          ImportDailyAgentChunks::dispatch($insertData[$i])
          ->delay(now()->addMinutes($i*0.2));
        }
        return redirect()->back();
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
      $file = request()->file('file');
      $path = $file->getRealPath();
      $data = Excel::ToArray(new DataImport, request()->file('file'));
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
          $dailyAgent->date = date("Y-m-d H:i:s", $UNIX_DATE);

          if(is_numeric($cell[24]))
          {
            $UNIX_DATE2 = ($cell[24] - 25569) * 86400;
            $dailyAgent->start_time = date("Y-m-d H:i:s",$UNIX_DATE2);
          }
          else {
            return 'Datenfehler in Zeile '.$counter.':'.json_encode($cell[23]);
          }

          $UNIX_DATE3 = ($cell[25] - 25569) * 86400;
          $dailyAgent->end_time = date("Y-m-d H:i:s", $UNIX_DATE3);
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
      $data = Excel::ToArray(new DataImport, request()->file('file'))[0];
      unset($data[0]);
      // dd($data);
      foreach($data as $row)
      {
        $UNIX_DATE = ($row[1] - 25569) * 86400;
        $date = date("Y-m-d", $UNIX_DATE);

        if($row[0] && !RetentionDetail::where('person_id',$row[0])->where('call_date',$date)->exists())
        {
          $report = new RetentionDetail;
          $report->person_id = $row[0];
          $report->call_date = $date;
          $report->department_desc = $row[9];
          $report->calls = $row[11];

          if($row[9] !='Care4as Retention DSL Eggebek')
          {
            $report->calls_smallscreen = $row[14];
            $report->calls_bigscreen = $row[15];
            $report->calls_portale = $row[16];
            $report->orders_smallscreen = $row[18] + $row[23];
            $report->orders_bigscreen = $row[19] + $row[24];
            $report->orders_portale = $row[21] + $row[26];
            $report->mvlzNeu = $row[33];
            $report->rlzPlus = $row[35];
          }
          else
          {
            $report->mvlzNeu = $row[32];
            $report->rlzPlus = $row[34];
          }
          $report->orders = $row[17] + $row[22];
          $report->Rabatt_Guthaben_Brutto_Mobile = $row[28];

          $report->save();
        }
      }
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
          $date = date("Y-m-d H:i:s", $UNIX_DATE);
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

}
