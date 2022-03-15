<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueReportController extends Controller
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

        return view('controlling.revenueReport', compact('param'));

    }

    public function getParam(){

        /** Get all Parameters from View-Form */
        $param = array(
            'project' => request('project'),
            'month' => request('month'),
            'year' => request('year'),
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

        $data = null;

        return $data;
    }

    public function combineData(){
        
        $data = array();

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
