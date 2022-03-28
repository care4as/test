<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Diff;

class RevenueReportController extends Controller
{

    /** ÜBERLEGUNG: Wie kann der Controller für mehrere Views verwendet werden? 
     *  Kann Paramerer als Switch übergeben werden?
     *  Verschiedene Funktionsaufrufe, die seperart einen Aufruf an master machen? 
     * 
     * Ziel: Tracking Differenz sollte sich auch schnell mit einbinden lassen.*/
    
    public function master(){

        $param = $this->getParam();
        $dateSelection = $this->calcDateSelection();

        if($param['comp'] == true){
            $data = $this->getData($param);
        } else {
            $data = null;
        }

        return view('controlling.revenueReport', compact('param', 'data', 'dateSelection'));

    }

    public function getParam(){

        /** Get all Parameters from View-Form */
        $param = array(
            'project' => request('project'),
            'month' => request('month'),
            'year' => request('year'),
            'comp' => true,
        );

        if ($param['month'] != null){
            $date = date_parse($param['month']);
            $param['month_num'] = $date['month'];
        }

        /** Zusätzliche Parameter festlegen */
        if($param['project'] == 10){ //DSL
            $param['department_desc'] = 'Care4as Retention DSL Eggebek';

        } else if ($param['project'] == 7){ // Mobile
            $param['department_desc'] = 'KDW Retention Mobile Flensburg';
        }

                
        /** Check if all Parameters are filled */
        foreach($param as $key => $entry){
            if($entry == null){
                $param['comp'] = false;
            }
        };
        
        if($param['comp'] == true){
            $param['constants'] = $this->getConstants();


            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $param['month_num'], $param['year']);
            //strtotime date
            $param['start_date'] = date('Y-m-d', strtotime($param['year'] . '-' . $param['month_num'] . '-01'));
            $param['end_date'] = date('Y-m-d', strtotime($param['year'] . '-' . $param['month_num'] . '-' . $daysInMonth));;
        }

        // dd($param);
        
        return $param;

    }

    /** Hier Konstanten bearbeiten! */
    public function getConstants(){
        /** Diese Funktion gibt Konstanten zurück. Später sollen diese aus der Datenbank genommen und dynamisch werden */
        
        $constants = array(
            10 => array(    // DSL
                'availbench_ziel_aht' => 580,
                'cpo_dsl' => 16,
                'cpo_kuerue' => 5,
                'speedretention' => 38,
            ),
            7 => array(// Mobile
                'availbench_ziel_aht' => 700,
                'cpo_ssc' => 16,
                'cpo_bsc' => 12,
                'cpo_portale' => 16,
                'cpo_kuerue' => 5,
                'speedretention' => 38,
            ) 
        );

        return $constants;

    }

    public function calcDateSelection(){
        $data = array();

        $difYear = date('Y') - 2022;
        
        for ($i = 0; $i <= $difYear; $i++){
            $data['year'][2022 + $i] = 2022 + $i;
        }

        $data['month'] = array(
            'january' => 'Januar',
            'february' => 'Februar',
            'march' => 'März',
            'april' => 'April',
            'may' => 'Mai',
            'june' => 'Juni',
            'july' => 'Juli',
            'august' => 'August',
            'september' => 'September',
            'october' => 'Oktober',
            'november' => 'November',
            'december' => 'Dezember',
        );
        return $data;
    }

    public function getData($param){
        $personIds = $this->getPersonId($param);

        $rawdata = array(
            'dates' => $this->getDateList($param),
            'availbench' => $this->getAvailbench($param),
            'details' => $this->getRetentionDetails($param),
            'chronBook' => $this->getChronologyBook($param, $personIds),
            'optin' => null,
            'ma' => $this->getKdwMa($param),
            'history_state' => $this->getHistoryState($param),
        );

        $data = $this->combineData($param, $rawdata);

        // dd($data);

        return $data;
    }

    

    public function combineData($param, $rawdata){
        /** Wie Funktion aufbauen, damit diese auch von anderen Projekten verwendet werden kann?
         * Filter Array übergeben und entsprechend füllen?
         * If Anweisungen oder Switch Case
        */
        
        $data = array();

        /** Tageweise Berechnung */
        foreach($rawdata['dates'] as $key => $entry){      
            $data['daily'][$entry['date']]['availbench'] = $this->calcAvailbenchDaily($param, $rawdata['availbench'], $entry['date']);
            $data['daily'][$entry['date']]['details'] = $this->calcDetailsDaily($param, $entry['date'], $rawdata['details']);
            $data['daily'][$entry['date']]['speedretention'] = $this->calcSpeedRetentionDaily($entry['date'], $rawdata['chronBook'], $param);
            $data['daily'][$entry['date']]['optin'] = $this->calcOptinDaily();
            $data['daily'][$entry['date']]['fte'] = $this->calcFteDaily($entry['date'], $rawdata['ma'], $rawdata['history_state']);
            
        }

        /** Summen Berechnung */
        $data['sum']['availbench'] = $this->calcAvailbenchSum($param, $rawdata['availbench']);
        $data['sum']['details'] = $this->calcDetailsSum($param, $rawdata['details']);
        $data['sum']['speedretention'] = $this->calcSpeedRetentionSum($data);

        // dd($data);
        // dd($param);

        return $data;

    }

    public function calcFteDaily($date, $ma, $history){
        $data = array();

        // Alle Mitarbeiter
        $data['all_employee_hours'] = $ma->sum('soll_h_day');
        $data['all_employee_heads'] = $ma->count();

        // Alle Kundenberater
        $data['all_kb_hours'] = $ma->where('abteilung_id', 10)->sum('soll_h_day');
        $data['all_kb_heads'] = $ma->where('abteilung_id', 10)->count();
        $data['all_kb_fte'] = $data['all_kb_hours'] / 8;

        // Alle OVH
        $data['all_ovh_hours'] = $data['all_employee_hours'] - $data['all_kb_hours'];
        $data['all_ovh_heads'] = $data['all_employee_heads'] - $data['all_kb_heads'];
        $data['all_ovh_fte'] = $data['all_ovh_hours'] / 8;

        // Alle nicht bezahlten Kundenberater (nur für Berechnung)
        $data['unpayed_kb_hours'] = null;
        $data['unpayed_kb_heads'] = null;

        // Alle bezahlten Kundenberater
        $data['payed_kb_hours'] = null;
        $data['payed_kb_heads'] = null;
        $data['payed_kb_fte'] = null;

        dd($history);
        dd($data);
        dd($ma);
        /** 
         * 1. ChronologyWork -> Liste der eingestellten MA im Zeitraum
         */

        
        
        // Kundenberater bezahlt
        // Kundenberater gesamt
        // Overhead

        // Köpfe und FTE Berechnen

        // Auffälligkeiten
            // Statusänderungen, Eintritte und Austritte
        return $data;
    }

    public function calcFteSum(){
        $data = array();

        // Alle Mitarbeiter
        $data['all_employee_hours'] = null;
        $data['all_employee_heads'] = null;

        // Alle Kundenberater
        $data['all_kb_hours'] = null;
        $data['all_kb_heads'] = null;
        $data['all_kb_fte'] = null;

        // Alle OVH
        $data['all_ovh_hours'] = null;
        $data['all_ovh_heads'] = null;
        $data['all_ovh_fte'] = null;

        // Alle nicht bezahlten Kundenberater
        $data['unpayed_kb_hours'] = null;
        $data['unpayed_kb_heads'] = null;
        $data['unpayed_kb_fte'] = null;

        // Alle bezahlten Kundenberater
        $data['payed_kb_hours'] = null;
        $data['payed_kb_heads'] = null;
        $data['payed_kb_fte'] = null;

        return $data;
    }

    public function calcOptinDaily(){

    }

    public function calcOptinSum(){

    }

    public function calcSpeedRetentionDaily($date, $chronBook, $param){
        $data = array(
            'duration' => 0,
            'revenue' => 0,
        );

        $filtered = $chronBook->where('book_date', $date);

        foreach($filtered as $key => $entry){
            if($entry->acd_state_id == 41){

                /** Prüfen ob es ein Doppeltracking gibt. z.B. durch Autokorrektur 2x gleicher Status und gleiche Uhrzeit. Einen der beiden Einträge löschen. */
                if($filtered->where('MA_id', $entry->MA_id)->where('book_time', $entry->book_time)->where('ds_id', '!=', $entry->ds_id)->where('acd_state_id', 41)->count() > 0){
                    $filtered->forget($key);
                } else {
                    if($filtered->where('MA_id', $entry->MA_id)->where('book_time', '>', $entry->book_time)->first() != null){
                        $data['duration'] += (strtotime($filtered->where('MA_id', $entry->MA_id)->where('book_time', '>', $entry->book_time)->first()->book_time) - strtotime($entry->book_time)) / 3600;
                    }
                }                
            }
        }

        $data['revenue'] = $data['duration'] * $param['constants'][$param['project']]['speedretention'];

        return $data;       
    }

    public function calcSpeedRetentionSum($data){
        $srData = array(
            'duration' => 0,
            'revenue' => 0,
        );

        foreach($data['daily'] as $key => $entry){
            $srData['duration'] += $entry['speedretention']['duration'];
            $srData['revenue'] += $entry['speedretention']['revenue'];
        }

        return $srData;
    }

    public function calcDetailsDaily($param, $date, $details){
        $data = array();

        if($param['project'] == 10){
            $data['dsl_orders'] = $details->where('call_date', $date)->sum('orders');
            $data['dsl_revenue'] = $data['dsl_orders'] * $param['constants'][$param['project']]['cpo_dsl'];
            $data['kuerue_orders'] = $details->where('call_date', $date)->sum('orders_kuerue');
            $data['kuerue_revenue'] = $data['kuerue_orders'] * $param['constants'][$param['project']]['cpo_kuerue'];
            $data['revenue'] = $data['dsl_revenue'] + $data['kuerue_revenue'];
        } else if ($param['project'] == 7){
            $data['ssc_orders'] = $details->where('call_date', $date)->sum('orders_smallscreen');
            $data['ssc_revenue'] = $data['ssc_orders'] * $param['constants'][$param['project']]['cpo_ssc'];
            $data['bsc_orders'] = $details->where('call_date', $date)->sum('orders_bigscreen');
            $data['bsc_revenue'] = $data['bsc_orders'] * $param['constants'][$param['project']]['cpo_bsc'];
            $data['portale_orders'] = $details->where('call_date', $date)->sum('orders_portale');
            $data['portale_revenue'] = $data['portale_orders'] * $param['constants'][$param['project']]['cpo_portale'];
            $data['kuerue_orders'] = $details->where('call_date', $date)->sum('orders_kuerue');
            $data['kuerue_revenue'] = $data['kuerue_orders'] * $param['constants'][$param['project']]['cpo_kuerue'];
            $data['revenue'] = $data['ssc_revenue'] + $data['bsc_revenue'] + $data['portale_revenue'] + $data['kuerue_revenue'];
        }

        return $data;
    }

    public function calcDetailsSum($param, $details){
        $data = array();

        if($param['project'] == 10){
            $data['dsl_orders'] = $details->sum('orders');
            $data['dsl_revenue'] = $data['dsl_orders'] * $param['constants'][$param['project']]['cpo_dsl'];
            $data['kuerue_orders'] = $details->sum('orders_kuerue');
            $data['kuerue_revenue'] = $data['kuerue_orders'] * $param['constants'][$param['project']]['cpo_kuerue'];
            $data['revenue'] = $data['dsl_revenue'] + $data['kuerue_revenue'];
        } else if ($param['project'] == 7){
            $data['ssc_orders'] = $details->sum('orders_smallscreen');
            $data['ssc_revenue'] = $data['ssc_orders'] * $param['constants'][$param['project']]['cpo_ssc'];
            $data['bsc_orders'] = $details->sum('orders_bigscreen');
            $data['bsc_revenue'] = $data['bsc_orders'] * $param['constants'][$param['project']]['cpo_bsc'];
            $data['portale_orders'] = $details->sum('orders_portale');
            $data['portale_revenue'] = $data['portale_orders'] * $param['constants'][$param['project']]['cpo_portale'];
            $data['kuerue_orders'] = $details->sum('orders_kuerue');
            $data['kuerue_revenue'] = $data['kuerue_orders'] * $param['constants'][$param['project']]['cpo_kuerue'];
            $data['revenue'] = $data['ssc_revenue'] + $data['bsc_revenue'] + $data['portale_revenue'] + $data['kuerue_revenue'];
        }

        return $data;
    }

    public function calcAvailbenchDaily($param, $availbench, $date){
        /** Availbench 
         * Gesamter Umsatz = total_cost_per_interval + aht_zielmangement + malus_incentive
         *   - Malus ist in total_cost_per_interval vorhanden
         *   - malus_incentive muss seperat für Tag und Monat berechnet werden
         * Berechnung aht_ziel_management: (Ziel AHT - IST AHT) / (60 * number_payed_calls * price)
        */

        $data = array();

        $data['total_costs_per_interval'] = $availbench->where('date_date', $date)->sum('total_costs_per_interval');
            $data['malus_interval'] = $availbench->where('date_date', $date)->sum('malus_interval');
            $data['malus_incentive'] = 0;
                // Berechnung malus_incentive
            if($data['total_costs_per_interval'] != 0){
                $malusPercentage = $data['malus_interval'] / $data['total_costs_per_interval'];
                if($malusPercentage <= 0.005){
                    $data['malus_incentive'] = $data['malus_interval'];
                } else if ($malusPercentage <= 0.0075){
                    $data['malus_incentive'] = 0.5 * $data['malus_interval'];
                } else if ($malusPercentage <= 0.01){
                    $data['malus_incentive'] = 0.25 * $data['malus_interval'];
                } else if ($malusPercentage <= 0.0125){
                    $data['malus_incentive'] = 0.10 * $data['malus_interval'];
                } else if ($malusPercentage <= 0.015){
                    $data['malus_incentive'] = 0.05 * $data['malus_interval'];
                }
            } else {
                $malusPercentage = 0;
            }
            $data['aht_zielmanagement'] = 0;
                // Berechnung aht_zielmanagement
                foreach($availbench->where('date_date', $date) as $key2 => $entry2){
                    $data['aht_zielmanagement'] += ($param['constants'][$param['project']]['availbench_ziel_aht'] - $entry2->aht) / 60 * $entry2->number_payed_calls * $entry2->price;
                }
            $data['revenue'] = $data['total_costs_per_interval'] + $data['malus_incentive'] + $data['aht_zielmanagement'];

        return $data;
    }

    public function calcAvailbenchSum($param, $availbench){
        $data = array();

        $data['total_costs_per_interval'] = $availbench->sum('total_costs_per_interval');
        $data['malus_interval'] = $availbench->sum('malus_interval');
        $data['malus_incentive'] = 0;
            // Berechnung malus_incentive
            if($data['total_costs_per_interval'] != 0){
                $malusPercentage = $data['malus_interval'] / $data['total_costs_per_interval'];
                if($malusPercentage <= 0.005){
                    $data['malus_incentive'] = $data['malus_interval'];
                } else if ($malusPercentage <= 0.0075){
                    $data['malus_incentive'] = 0.5 * $data['malus_interval'];
                } else if ($malusPercentage <= 0.01){
                    $data['malus_incentive'] = 0.25 * $data['malus_interval'];
                } else if ($malusPercentage <= 0.0125){
                    $data['malus_incentive'] = 0.10 * $data['malus_interval'];
                } else if ($malusPercentage <= 0.015){
                    $data['malus_incentive'] = 0.05 * $data['malus_interval'];
                }
            } else {
                $malusPercentage = 0;
            }
        $data['aht_zielmanagement'] = 0;
            // Berechnung aht_zielmanagement
            foreach($availbench as $key2 => $entry2){
                $data['aht_zielmanagement'] += ($param['constants'][$param['project']]['availbench_ziel_aht'] - $entry2->aht) / 60 * $entry2->number_payed_calls * $entry2->price;
            }
        $data['revenue'] = $data['total_costs_per_interval'] + $data['malus_incentive'] + $data['aht_zielmanagement'];

        return $data;
    }

    public function getDateList($param){
        
        $dates = array();
        $startDate = date('Y-m-d', strtotime('first day of ' . $param['month'] . ' ' . $param['year']));
        $endDate = date('Y-m-d', strtotime('last day of ' . $param['month'] . ' ' . $param['year']));
        $dateDiff = date_diff(date_create_from_format('Y-m-d', $startDate), date_create_from_format('Y-m-d', $endDate))->days;

        for($i = 0; $i<=$dateDiff; $i++){
            $date = date('Y-m-d', strtotime( $startDate . ' +' . $i . ' days'));
            
            $dates[$i]['date'] = $date;
        }

        return $dates;

    }

    public function getAvailbench($param){
        
        /** ANPASSEN DYNAMSICHE PARAMETER whereMonth, whereYear, call_forecast_issue */

        $availbench = DB::table('availbench_report')
        ->whereMonth('date_date', '02')
        ->whereYear('date_date', '2022')
        ->where('call_forecast_issue', 'DE_1u1_RT_Access_1st')
        ->where('total_costs_per_interval', '>', 0)
        ->get(['date_date', 'call_date_interval_start_time', 'call_forecast_issue', 'total_costs_per_interval', 'malus_interval', 'number_payed_calls', 'price', 'aht']);

        return $availbench;

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
        ->where('projekt_id',  $param['project'])
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

    public function getChronologyBook($param, $personIds){
        $chronBook =  DB::connection('mysqlkdw')                            
        ->table('chronology_book')
        ->whereYear('book_date', $param['year'])        
        ->whereMonth('book_date', $param['month_num'])                
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

    public function getRetentionDetails($param){
      
        $data = DB::table('retention_details')
        ->whereYear('call_date', $param['year'])
        ->whereMonth('call_date', $param['month_num'])
        ->where('department_desc', $param['department_desc'])
        ->get();

        // dd($data);

        return $data;
    }

    public function getKdwMa($param){
        $data =  DB::connection('mysqlkdw')                            
        ->table('MA')
        ->where('projekt_id', $param['project'])
        ->where('eintritt', '<=', $param['end_date'])
        ->where(function($query) use ($param){
            $query
            ->where('austritt', null)
            ->orWhere('austritt', '>=', $param['start_date']); // Hier können Filter auf die ID gesetzt werden (Urlaub, Krank usw.)
        })
        ->get(['ds_id', 'agent_id', 'vorname', 'familienname', 'abteilung_id', 'projekt_id', 'eintritt', 'austritt', 'soll_h_day']);

        return $data;
    }

    public function getHistoryState($param){
        $data =  DB::connection('mysqlkdw')                            
        ->table('history_state')
        ->where('project_id', $param['project'])
        ->where('date_begin', '<=', $param['end_date'])
        ->where('date_end', '>=', $param['start_date'])
        ->whereIn('state_id', [13, 15, 23, 24, 33, 34])
        ->get(['agent_id', 'agent_ds_id', 'date_begin', 'date_end', 'state_id']);

        /** 
         * Beschreibung 'state_id'
         * 13: Krank o. Lfz.
         * 15: Mutterschutz
         * 23: Fehlt unentschuldig
         * 24: Beschäftigungsverbot
         * 33: Kindkrank o. Lfz.
         * 34: Krank Quarantäne
         */
        
        return $data;
    }
        
}
