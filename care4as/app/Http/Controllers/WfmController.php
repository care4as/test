<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WfmController extends Controller
{

    /** ÜBERLEGUNG: Wie kann der Controller für mehrere Views verwendet werden? 
     *  Kann Paramerer als Switch übergeben werden?
     *  Verschiedene Funktionsaufrufe, die seperart einen Aufruf an master machen? 
     * 
     * Ziel: Tracking Differenz sollte sich auch schnell mit einbinden lassen.*/
    
    public function master(){

        $param = $this->getParam();

        if($param['comp'] == true){
            $data = $this->getData($param);
        } else {
            $data = null;
        }

        return view('wfm.employeeTimes', compact('param', 'data'));

    }

    public function getParam(){

        /** Get all Parameters from View-Form */
        $param = array(
            'project' => request('project'),
            'date' => request('date'),
            'comp' => true,
        );
        
        /** Check if all Parameters are filled */
        foreach($param as $key => $entry){
            if($entry == null){
                $param['comp'] = false;
            }
        };
        
        return $param;

    }

    public function getData($param){

        $personIds = $this->getPersonId($param);
        $chronWork = $this->getChronologyWork($param['date'], $personIds);
        $chronBook = $this->getChronologyBook($param['date'], $personIds);
        $empData = $this->getEmpData($param['date'], $personIds);

        $data = $this->combineData($chronWork, $chronBook, $empData);

        return $data;
    }

    public function combineData($chronWork, $chronBook, $empData){
        $data = array();
        $i = 0;

        foreach ($chronWork as $key => $entry){
            $status = $chronBook->where('MA_id', $entry->MA_id);
            $employee = $empData->where('ds_id', $entry->MA_id)->first();

            $data[$i]['name'] = $employee->lastname . ', '. $employee->surname;
            $data[$i]['ma_id'] = $entry->MA_id;
            $data[$i]['agent_id'] = $employee->{'1u1_agent_id'} ;
            $data[$i]['date'] = $entry->work_date;
            $data[$i]['work_beginn_kdw'] = $entry->work_time_begin;
            $data[$i]['work_end_kdw'] = $entry->work_time_end;
            $data[$i]['work_duration'] = $entry->work_hours;
            $data[$i]['lunch_break_beginn'] = $status->whereIn('acd_state_id', [5, 29])->first()->book_time ?? null;

            if($data[$i]['lunch_break_beginn'] == null) {
                $data[$i]['lunch_break_end'] = null;
                $data[$i]['lunch_break_duration'] = null;
            } else {
                $data[$i]['lunch_break_duration'] = $entry->pause_hours;
                $data[$i]['pause_sekunden'] = intval($data[$i]['lunch_break_duration'] * 3600);
                $data[$i]['lunch_break_end'] = date('H:i:s', strtotime($data[$i]['lunch_break_beginn']. ' +'. intval($data[$i]['lunch_break_duration'] * 3600) .' seconds'));
            }

            $data[$i]['short_break_count'] = $chronBook->where('MA_id', $entry->MA_id)->whereIn('acd_state_id', [6, 34])->count();
            $data[$i]['short_break_duration'] = $entry->pay_break_hours;

            $i++;

        }

        asort($data);

        return $data;

    }

    public function getPersonId($param){
        /** Gibt ein Array zurück in dem alle IDs der MA eines Projekts sind */

        $personIds = DB::connection('mysqlkdw')
        ->table('MA')
        ->where(function($query) {
            $query
            ->where('abteilung_id', '=', 10)
            ->orWhere('abteilung_id', '=', 19);
        })
        ->where('projekt_id', '=', $param['project'])
        ->where(function($query) use($param){
            $query
            ->where('austritt', '=', null)
            ->orWhere('austritt', '>', $param['date']);})
        ->where('eintritt', '<=', $param['date'])
        ->pluck('ds_id');

        return $personIds;
    }

    public function getChronologyWork($date, $personIds){
        /** Gibt ein Objekt zurück, welches die Arbeitszeiten von Mitarbeitern beinhaltet.
         * Folgende Filter werden berücksichtigt:
         * - Datum
         * - Projekt
         * - Anwesenheit
         */
        
        $chronWork =  DB::connection('mysqlkdw')                            
        ->table('chronology_work')                                      
        ->where('work_date', '>=', $date) 
        ->where('work_date', '<=', $date)
        ->where(function($query){
            $query
            ->where('state_id', null)
            ->orWhereNotIn('state_id', array(1, 2, 8, 13, 15, 16, 24, 34)); // Hier können Filter auf die ID gesetzt werden (Urlaub, Krank usw.)
        })
        ->where(function ($query) use ($personIds){
            $query
            ->whereIn('MA_id', $personIds);
        })
        ->where('work_hours', '>', 0)
        ->get();

        return $chronWork;
    }

    public function getChronologyBook($date, $personIds){
        $chronBook =  DB::connection('mysqlkdw')                            
        ->table('chronology_book')                                      
        ->where('book_date', '>=', $date) 
        ->where('book_date', '<=', $date)
        ->where(function ($query) use ($personIds){
            $query
            ->whereIn('MA_id', $personIds);
        })
        ->get();

        return $chronBook;
    }

    public function getEmpData($date, $personIds){
        $emp = DB::table('users')
        ->where(function ($query) use ($personIds){
            $query
            ->whereIn('ds_id', $personIds);
        })
        ->get();

        return $emp;
    }
        
}
