<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Diff;

class RevenueReportController extends Controller
{
    
    public function master(){

        $param = $this->getParam();
        $dateSelection = $this->calcDateSelection();

        if($param['comp'] == true){
            $data = $this->getData($param);
        } else {
            $data = null;
        }

        $constants = array(
            'all_constants' => $this->getConstantsOverview(),
        );
        // dd($constants['all_constants']);

        return view('controlling.revenueReport', compact('param', 'data', 'dateSelection', 'constants'));

    }

    public function getParam(){

        /** Get all Parameters from View-Form */
        $param = array(
            'project' => request('project'),
            'month' => request('month'),
            'year' => request('year'),
            'format' => request('format'),
            'comp' => true,
        );

        if ($param['month'] != null){
            $date = date_parse($param['month']);
            $param['month_num'] = $date['month'];
        }

        /** Zusätzliche Parameter festlegen */
        if($param['project'] == 10){ //DSL
            $param['department_desc'] = 'Care4as Retention DSL Eggebek';
            $param['forecast_issue'] = 'DE_1u1_RT_Access_1st';
            $param['serviceprovider'] = 'Care4As_Flensburg';

        } else if ($param['project'] == 7){ // Mobile
            $param['department_desc'] = 'KDW Retention Mobile Flensburg';
            $param['forecast_issue'] = 'DE_1u1_RT_Mobile_1st';
            $param['serviceprovider'] = 'KDW_Flensburg';
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
                'availbench_ziel_aht' => 610,
                'cpo_dsl' => 16,
                'cpo_kuerue' => 5,
                'optin_call' => 1.2,
                'optin_mail' => 0.3,
                'optin_print' => 0.1,
                'optin_sms' => 0.1,
                'optin_trafic' => 0.4,
                'optin_usage' => 0.4,
                'speedretention' => 38,
                'target_sick_percentage' => 8,
                'target_revenue_paid_hour' => 36.41,
            ),
            7 => array(// Mobile
                'availbench_ziel_aht' => 700,
                'cpo_ssc' => 16,
                'cpo_bsc' => 12,
                'cpo_portale' => 16,
                'cpo_kuerue' => 5,
                'optin_call' => 1.2,
                'optin_mail' => 0.3,
                'optin_print' => 0.1,
                'optin_sms' => 0.1,
                'optin_trafic' => 0.4,
                'optin_usage' => 0.4,
                'speedretention' => 38,
                'target_sick_percentage' => 8,
                'target_revenue_paid_hour' => 36.99,
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
        $basedataProjctChanges = $this->getBaseDataProjectChanges($param);
        $personIds = $this->getPersonId($param, $basedataProjctChanges);

        $rawdata = array(
            'dates' => $this->getDateList($param),
            'availbench' => $this->getAvailbench($param),
            'details' => $this->getRetentionDetails($param),
            'chronBook' => $this->getChronologyBook($param, $personIds),
            'optin' => $this->getOptin($param),
            'ma' => $this->getKdwMa($param, $basedataProjctChanges),
            'person_ids' => $personIds,
            'history_state' => $this->getHistoryState($param, $basedataProjctChanges),
            'states_description' => $this->getStatesDesc(),
            'project_description' => $this->getProjectDesc(),
            'chronology_work' => $this->getChronologyWork($param, $personIds),
            'sas' => $this->getSas($param),
            'basedata_project_changes' => $basedataProjctChanges,
            'basedata_contract_changes' => $this->getBaseDataContractChanges($param),
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
            //SPEEDRETENTION KOMPLETT RAUS?
            $data['daily'][$entry['date']]['speedretention'] = $this->calcSpeedRetentionDaily($entry['date'], $rawdata['chronBook'], $param);//ANPASSEN AUF STAMMDATEN
            $data['daily'][$entry['date']]['optin'] = $this->calcOptinDaily($entry['date'], $rawdata['optin'], $param['constants'][$param['project']]);
            $data['daily'][$entry['date']]['fte'] = $this->calcFteDaily($entry['date'], $rawdata['ma'], $rawdata['history_state'], $rawdata['states_description'], $rawdata['basedata_project_changes'], $param, $rawdata['project_description'], $rawdata['basedata_contract_changes']);//ANPASSEN AUF STAMMDATEN
            $data['daily'][$entry['date']]['worktime'] = $this->calcWorktimeDaily($rawdata['chronology_work'], $entry['date'], $rawdata['states_description'], $rawdata['ma'], $param, $rawdata['basedata_project_changes']);//ANPASSEN AUF STAMMDATEN
            $data['daily'][$entry['date']]['sas'] = $this->calcSasDaily($entry['date'], $rawdata['sas']);
            
            // Umsatzberechnung als letztes
            $data['daily'][$entry['date']]['revenue'] = $this->calcRevenueDaily($data['daily'][$entry['date']], $param, $entry['date']);//ANPASSEN AUF STAMMDATEN
        }

        /** Summen Berechnung */
        $data['sum']['availbench'] = $this->calcAvailbenchSum($param, $rawdata['availbench']);
        $data['sum']['details'] = $this->calcDetailsSum($param, $rawdata['details']);
        $data['sum']['speedretention'] = $this->calcSpeedRetentionSum($data);//ANPASSEN AUF STAMMDATEN
        $data['sum']['optin'] = $this->calcOptinSum($data, $param['constants'][$param['project']]);
        $data['sum']['fte'] = $this->calcFteSum($data, $rawdata['history_state'], $rawdata['states_description'], $rawdata['ma'], $param, $rawdata['chronology_work'], $rawdata['basedata_project_changes'], $rawdata['project_description'], $rawdata['basedata_contract_changes'], $rawdata['person_ids']);//ANPASSEN AUF STAMMDATEN
        $data['sum']['worktime'] = $this->calcWorktimeSum($data['daily']);//ANPASSEN AUF STAMMDATEN
        $data['sum']['sas'] = $this->calcSasSum($rawdata['sas']);
        $data['sum']['revenue'] = $this->calcRevenueSum($data['sum'], $param, $data['daily']);//ANPASSEN AUF STAMMDATEN

        // dd($rawdata['basedata_contract_changes']);
        // dd($data);
        // dd($param);

        return $data;

    }

    public function calcRevenueDaily($allData, $param, $date){
        $data = array();

        $data['revenue'] = 
              $allData['availbench']['revenue']
            + $allData['details']['revenue']
            + $allData['speedretention']['revenue']
            + $allData['optin']['revenue']
            + $allData['sas']['revenue'];

        if($allData['worktime']['payed_hours'] > 0){
            $data['revenue_paid_hour'] = $data['revenue'] / $allData['worktime']['payed_hours'];
        } else {
            $data['revenue_paid_hour'] = 0;
        }

        $dayNum = date('N', strtotime($date));
        if ($dayNum >= 6){
            $data['revenue_target'] = 0;
            $data['revenue_attainment_percent'] = 0;
        } else {
            $data['revenue_target'] = $allData['worktime']['payed_hours'] * $param['constants'][$param['project']]['target_revenue_paid_hour'];
            
            if($data['revenue_target'] > 0){
                $data['revenue_attainment_percent'] = ($data['revenue'] / $data['revenue_target']) * 100;
            } else {
                $data['revenue_attainment_percent'] = 0;
            }           
        }

        $data['revenue_attainment'] = $data['revenue'] - $data['revenue_target'];

        return $data;
    }

    public function calcRevenueSum($allData, $param, $dailyData){
        $data = array();

        $data['revenue'] = 
              $allData['availbench']['revenue']
            + $allData['details']['revenue']
            + $allData['speedretention']['revenue']
            + $allData['optin']['revenue']
            + $allData['sas']['revenue'];

        if($allData['worktime']['payed_hours'] > 0){
            $data['revenue_paid_hour'] = $data['revenue'] / $allData['worktime']['payed_hours'];
        } else {
            $data['revenue_paid_hour'] = 0;
        }

        $data['revenue_target'] = 0;
        foreach($dailyData as $key => $entry){
            $data['revenue_target'] += $entry['revenue']['revenue_target'];
        }
            
        if($data['revenue_target'] > 0){
            $data['revenue_attainment_percent'] = ($data['revenue'] / $data['revenue_target']) * 100;
        } else {
            $data['revenue_attainment_percent'] = 0;
        }           
        
        $data['revenue_attainment'] = $data['revenue'] - $data['revenue_target'];

        return $data;
    }

    public function calcSasDaily($date, $sas){
        $data = array(
            'sas_count' => $sas->where('date', $date)->count(),
            'revenue' => $sas->where('date', $date)->sum('GO_Prov'),
        );

        return $data;
    }

    public function calcSasSum($sas){
        $data = array(
            'sas_count' => $sas->count(),
            'revenue' => $sas->sum('GO_Prov'),
        );

        return $data;
    }

    public function calcOptinDaily($date, $optin, $constants){
        $data = array();

        // Parameter auf Report zuschneiden
        $date = date('Y-m-d H:i:s', strtotime($date));
        $optin = $optin->where('date', $date);

        $data['optin_call_count'] = $optin->sum('Anzahl_Call_OptIn');
        $data['optin_mail_count'] = $optin->sum('Anzahl_Email_OptIn');
        $data['optin_print_count'] = $optin->sum('Anzahl_Print_OptIn');
        $data['optin_sms_count'] = $optin->sum('Anzahl_SMS_OptIn');
        $data['optin_trafic_count'] = $optin->sum('Anzahl_Nutzungsdaten_OptIn');
        $data['optin_usage_count'] = $optin->sum('Anzahl_Verkehrsdaten_OptIn');

        $data['optin_call_revenue'] = $data['optin_call_count'] * $constants['optin_call'];
        $data['optin_mail_revenue'] = $data['optin_mail_count'] * $constants['optin_mail'];
        $data['optin_print_revenue'] = $data['optin_print_count'] * $constants['optin_print'];
        $data['optin_sms_revenue'] = $data['optin_sms_count'] * $constants['optin_sms'];
        $data['optin_trafic_revenue'] = $data['optin_trafic_count'] * $constants['optin_trafic'];
        $data['optin_usage_revenue'] = $data['optin_usage_count'] * $constants['optin_usage'];

        $data['revenue'] = $data['optin_call_revenue'] + $data['optin_mail_revenue'] + $data['optin_print_revenue'] + $data['optin_sms_revenue'] + $data['optin_trafic_revenue'] + $data['optin_usage_revenue']; 

        return $data;
    }

    public function calcOptinSum($allData, $constants){
        $data = array(
            'optin_call_count' => 0,
            'optin_mail_count' => 0,
            'optin_print_count' => 0,
            'optin_sms_count' => 0,
            'optin_trafic_count' => 0,
            'optin_usage_count' => 0,
        );

        foreach($allData['daily'] as $key => $entry){
            $data['optin_call_count'] += $entry['optin']['optin_call_count'];
            $data['optin_mail_count'] += $entry['optin']['optin_mail_count'];
            $data['optin_print_count'] += $entry['optin']['optin_print_count'];
            $data['optin_sms_count'] += $entry['optin']['optin_sms_count'];
            $data['optin_trafic_count'] += $entry['optin']['optin_trafic_count'];
            $data['optin_usage_count'] += $entry['optin']['optin_usage_count'];
        }

        $data['optin_call_revenue'] = $data['optin_call_count'] * $constants['optin_call'];
        $data['optin_mail_revenue'] = $data['optin_mail_count'] * $constants['optin_mail'];
        $data['optin_print_revenue'] = $data['optin_print_count'] * $constants['optin_print'];
        $data['optin_sms_revenue'] = $data['optin_sms_count'] * $constants['optin_sms'];
        $data['optin_trafic_revenue'] = $data['optin_trafic_count'] * $constants['optin_trafic'];
        $data['optin_usage_revenue'] = $data['optin_usage_count'] * $constants['optin_usage'];

        $data['revenue'] = $data['optin_call_revenue'] + $data['optin_mail_revenue'] + $data['optin_print_revenue'] + $data['optin_sms_revenue'] + $data['optin_trafic_revenue'] + $data['optin_usage_revenue']; 

        return $data;
    }

    public function calcWorktimeDaily($chronWork, $date, $states, $ma, $param, $basedataProjectChanges){
        $data = array();

        $excludedMa = array();

        foreach($basedataProjectChanges as $key => $entry){ 
            if (($entry->value_old == $param['project'] && $entry->date < $date) || ($entry->value_new == $param['project'] && $entry->date > $date)){
                $excludedMa[] = $entry->ds_id;
            }
        }

        $chronWork = $chronWork->where('work_date', $date)->whereNotIn('MA_id', $excludedMa);

        $data['all_hours'] = $chronWork->sum('work_hours');
        $data['unpayed_hours'] = $chronWork->whereIn('state_id', [13, 14, 15, 23, 24, 26, 30, 33, 34, 35])->sum('work_hours');
        $data['payed_hours'] = $data['all_hours'] - $data['unpayed_hours'];
        $data['sick_hours_netto'] = $chronWork->whereIn('state_id', [1, 7])->sum('work_hours');
        if($data['sick_hours_netto'] > 0){
            $data['sick_percentage_netto'] = ($data['sick_hours_netto'] / $data['payed_hours']) * 100;
        } else {
            $data['sick_percentage_netto'] = 0;
        }
        $data['sick_hours_brutto'] = $chronWork->whereIn('state_id', [1, 7, 8, 13, 14, 30, 34, 35])->sum('work_hours');
        if($data['sick_hours_brutto'] > 0){
            $data['sick_percentage_brutto'] = ($data['sick_hours_brutto'] / $data['all_hours']) * 100;
        } else {
            $data['sick_percentage_brutto'] = 0;
        }

        // dd($chronWork->whereIn('state_id', [1, 7])->sortBy('state_id'));

        $data['information']['netto']['count_employees'] = sizeof($chronWork->whereIn('state_id', [1, 7])->where('work_hours', '>', 0));
        if($data['information']['netto']['count_employees'] > 0){
            foreach($chronWork->whereIn('state_id', [1, 7])->sortBy('state_id')->where('work_hours', '>', 0) as $key => $entry){
                $data['information']['netto']['entries'][] = $states->where('ds_id', $entry->state_id)->first()->description . ' ' . $ma->where('ds_id', $entry->MA_id)->first()->soll_h_day . ' Std.: ' . $ma->where('ds_id', $entry->MA_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->MA_id)->first()->familienname;
            }
        }

        $data['information']['brutto']['count_employees'] = sizeof($chronWork->whereIn('state_id', [1, 7, 8, 13, 14, 30, 34, 35])->where('work_hours', '>', 0));
        if($data['information']['brutto']['count_employees'] > 0){
            foreach($chronWork->whereIn('state_id', [1, 7, 8, 13, 14, 30, 34, 35])->sortBy('state_id')->where('work_hours', '>', 0) as $key => $entry){
                $data['information']['brutto']['entries'][] = $states->where('ds_id', $entry->state_id)->first()->description . ' ' . $ma->where('ds_id', $entry->MA_id)->first()->soll_h_day . ' Std.: ' . $ma->where('ds_id', $entry->MA_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->MA_id)->first()->familienname;
            }
        }

        return $data;
    }

    public function calcWorktimeSum($rawdata){
        $data = array();
        $data['all_hours'] = 0;
        $data['unpayed_hours'] = 0;
        $data['sick_hours_netto'] = 0;
        $data['sick_hours_brutto'] = 0;

        foreach($rawdata as $key => $entry){
            $data['all_hours'] += $entry['worktime']['all_hours'];
            $data['unpayed_hours'] += $entry['worktime']['unpayed_hours'];
            $data['sick_hours_netto'] += $entry['worktime']['sick_hours_netto'];
            $data['sick_hours_brutto'] += $entry['worktime']['sick_hours_brutto'];
        }

        $data['payed_hours'] = $data['all_hours'] - $data['unpayed_hours'];
        if($data['sick_hours_netto'] > 0){
            $data['sick_percentage_netto'] = ($data['sick_hours_netto'] / $data['payed_hours']) * 100;
        } else {
            $data['sick_percentage_netto'] = 0;
        }
        if($data['sick_hours_brutto'] > 0){
            $data['sick_percentage_brutto'] = ($data['sick_hours_brutto'] / $data['all_hours']) * 100;
        } else {
            $data['sick_percentage_brutto'] = 0;
        }

        return $data;
    }

    public function calcFteDaily($date, $ma, $history, $states, $basedataProjectChanges, $param, $projectDescription, $basedataContractChanges){
        $data = array();

        /** Stammdatenänderungen Anpassen
         * Rückgabewert: Liste aller MA-ID, die an gegebenen Tag NICHT in Projekt aktiv waren!
         * Diese ID's dann aus den MA-Bestand herausfiltern
         * -> Es bleiben nur aktive MA!
         */
        $excludedMa = array();

        foreach($basedataProjectChanges as $key => $entry){ 
            if (($entry->value_old == $param['project'] && $entry->date < $date) || ($entry->value_new == $param['project'] && $entry->date > $date)){
                $excludedMa[] = $entry->ds_id;
            }
        }

        $history = $history->whereIn('state_id', [13, 14, 15, 16, 23, 24, 30, 33, 34, 35])->whereNotIn('agent_ds_id', $excludedMa);

        $ma = $ma->where('eintritt', '<=', $date)->whereNotIn('ds_id', $excludedMa);
        $maDsIds = $ma->pluck('ds_id');

        // Anpassung der Vertragsstunden für den jeweiligen Tag
        foreach($basedataContractChanges->whereIn('ds_id', $maDsIds) as $key => $entry){
            if ($entry->date <= $date){
                $ma->where('ds_id', $entry->ds_id)->first()->soll_h_day = $basedataContractChanges->whereIn('ds_id', $maDsIds)->where('date', '<=', $date)->last()->value_new / 5;
            } else if($entry->date > $date){
                $ma->where('ds_id', $entry->ds_id)->first()->soll_h_day = $basedataContractChanges->where('ds_id', $entry->ds_id)->where('date', '>', $date)->first()->value_old / 5;
            } else {
                $ma->where('ds_id', $entry->ds_id)->first()->soll_h_day = $basedataContractChanges->where('ds_id', $entry->ds_id)->last()->value_new / 5;
            }
        }
        
        // Alle Mitarbeiter
        $data['all_employee_hours'] = $ma->where('austritt', null)->sum('soll_h_day');
        $data['all_employee_hours'] += $ma->where('austritt', '>=', $date)->sum('soll_h_day');
        $data['all_employee_heads'] = $ma->where('austritt', null)->count();
        $data['all_employee_heads'] += $ma->where('austritt', '>=', $date)->count();

        // Alle Kundenberater
        $data['all_kb_hours'] = $ma->where('abteilung_id', 10)->where('austritt', null)->sum('soll_h_day');
        $data['all_kb_hours'] += $ma->where('abteilung_id', 10)->where('austritt', '>=', $date)->sum('soll_h_day');
        $data['all_kb_heads'] = $ma->where('abteilung_id', 10)->where('austritt', null)->count();
        $data['all_kb_heads'] += $ma->where('abteilung_id', 10)->where('austritt', '>=', $date)->count();


        $data['all_kb_fte'] = $data['all_kb_hours'] / 8;

        // Alle OVH
        $data['all_ovh_hours'] = $data['all_employee_hours'] - $data['all_kb_hours'];
        $data['all_ovh_heads'] = $data['all_employee_heads'] - $data['all_kb_heads'];
        $data['all_ovh_fte'] = $data['all_ovh_hours'] / 8;

        // Alle nicht bezahlten Kundenberater (nur für Berechnung)
        $data['unpayed_kb_hours'] = $ma->where('abteilung_id', 10)->whereIn('ds_id', $history->where('date_begin', '<=', $date)->where('date_end', '>=', $date)->pluck('agent_ds_id'))->sum('soll_h_day');
        $data['unpayed_kb_heads'] = $ma->where('abteilung_id', 10)->whereIn('ds_id', $history->where('date_begin', '<=', $date)->where('date_end', '>=', $date)->pluck('agent_ds_id'))->count();

        // Alle bezahlten Kundenberater
        $data['payed_kb_hours'] = $data['all_kb_hours'] - $data['unpayed_kb_hours'];
        $data['payed_kb_heads'] = $data['all_kb_heads'] - $data['unpayed_kb_heads'];
        $data['payed_kb_fte'] = $data['payed_kb_hours'] / 8;
        
        $data['information'] = array();

        foreach($ma->where('abteilung_id', 10) as $key => $entry){
            if($entry->eintritt == $date){
                $data['information'][] = 'Eintritt ' . number_format($entry->soll_h_day / 8, 3, ',', '.') . ' FTE: ' . $entry->vorname . ' ' . $entry->familienname;
            }
            if($entry->austritt == $date){
                $data['information'][] = 'Austritt ' . number_format($entry->soll_h_day / 8, 3, ',', '.') . ' FTE: ' . $entry->vorname . ' ' . $entry->familienname;
            }
        }

        // Stammdatenänderung
        foreach($basedataProjectChanges as $key => $entry){ 
            if ($entry->value_old == $param['project'] && $entry->date == $date){
                $data['information'][] = 'Projektwechsel ' . number_format($ma->where('ds_id', $entry->ds_id)->first()->soll_h_day / 8, 3, ',', '.') . ' FTE zu ' . $projectDescription->where('ds_id', $entry->value_new)->first()->bezeichnung . ': ' . $ma->where('ds_id', $entry->ds_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->ds_id)->first()->familienname;
            } else if($entry->value_new == $param['project'] && $entry->date == $date){
                $data['information'][] = 'Projektwechsel ' . number_format($ma->where('ds_id', $entry->ds_id)->first()->soll_h_day / 8, 3, ',', '.') . ' FTE von ' . $projectDescription->where('ds_id', $entry->value_old)->first()->bezeichnung . ': ' . $ma->where('ds_id', $entry->ds_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->ds_id)->first()->familienname;
            }
        }

        // Änderung Vertragsstunden
        foreach($basedataContractChanges->where('date', $date)->whereIn('ds_id', $maDsIds) as $key => $entry){
            $data['information'][] = 'Änderung Vertragsstunden ' . number_format($entry->value_old / 40, 3, ',', '.') . ' FTE zu ' . number_format($entry->value_new / 40, 3, ',', '.') . ' FTE: ' . $ma->where('ds_id', $entry->ds_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->ds_id)->first()->familienname;
        }
        
        // Start nicht bezahlter Status
        foreach($ma->where('abteilung_id', 10)->whereIn('ds_id', $history->where('date_begin', $date)->pluck('agent_ds_id')) as $key => $entry){
            $data['information'][] = 'Start ' . $states->where('ds_id', $history->where('date_begin', $date)->where('agent_ds_id', $entry->ds_id)->first()->state_id)->first()->description . ' ' . number_format($entry->soll_h_day / 8, 3, ',', '.') . ' FTE: ' . $entry->vorname . ' ' . $entry->familienname;
        } 

        // Ende nicht bezahlter Status
        foreach($ma->where('abteilung_id', 10)->whereIn('ds_id', $history->where('date_end', $date)->pluck('agent_ds_id')) as $key => $entry){
            $data['information'][] = 'Ende ' . $states->where('ds_id', $history->where('date_end', $date)->where('agent_ds_id', $entry->ds_id)->first()->state_id)->first()->description . ' ' . number_format($entry->soll_h_day / 8, 3, ',', '.') . ' FTE: ' . $entry->vorname . ' ' . $entry->familienname;
        } 
        
        return $data;
    }

    public function calcFteSum($allData, $history, $states, $ma, $param, $chronWork, $basedataProjectChanges, $projectDescription, $basedataContractChanges, $personIds){
        $data = array(
            'payed_kb_hours' => 0,
            'payed_kb_heads' => 0,
        );

        $excludedMa = array();


        foreach($basedataProjectChanges as $key => $entry){ 
            if (($entry->value_old == $param['project'] && $entry->date == $param['start_date'])){
                $excludedMa[] = $entry->ds_id;
            }
        }

        $history = $history->whereIn('state_id', [13, 14, 15, 16, 23, 24, 30, 33, 34, 35])->whereNotIn('agent_ds_id', $excludedMa);

        foreach($allData['daily'] as $key => $entry){
            $data['payed_kb_hours'] += $entry['fte']['payed_kb_hours'];
            $data['payed_kb_heads'] += $entry['fte']['payed_kb_heads'];
        }

        $numDays = sizeof($allData['daily']);

        $data['payed_kb_hours'] = $data['payed_kb_hours'] / $numDays;
        $data['payed_kb_heads'] = $data['payed_kb_heads'] / $numDays;
        $data['payed_kb_fte'] = $data['payed_kb_hours'] / 8;

        $data['all_kb_fte'] = $allData['daily'][array_key_last($allData['daily'])]['fte']['all_kb_fte'];
        $data['all_kb_heads'] = $allData['daily'][array_key_last($allData['daily'])]['fte']['all_kb_heads'];
        $data['all_ovh_fte'] = $allData['daily'][array_key_last($allData['daily'])]['fte']['all_ovh_fte'];
        $data['all_ovh_heads'] = $allData['daily'][array_key_last($allData['daily'])]['fte']['all_ovh_heads'];

        // Start nicht bezahlter Status
        foreach($ma->sortBy('eintritt') as $key => $entry){
            if($entry->eintritt >= $param['start_date']){
                $data['information']['Eintritt'][] = date_format(date_create($entry->eintritt), 'd.m.Y') . ': ' . $entry->vorname . ' ' . $entry->familienname;
            }
        }

        foreach($ma->sortBy('austritt') as $key => $entry){
            if($entry->austritt != null){
                if($entry->austritt <= $param['end_date']){
                    $data['information']['Austritt'][] = date_format(date_create($entry->austritt), 'd.m.Y') . ': ' . $entry->vorname . ' ' . $entry->familienname;
                }
            }
        }

        // Projektwechsel
        foreach($basedataProjectChanges as $key => $entry){
            if($entry->date >= $param['start_date'] && $entry->date <= $param['end_date']){
                if($entry->value_old == $param['project']){
                    $data['information']['Projektabgang'][] = date_format(date_create($entry->date), 'd.m.Y') . ': ' . $ma->where('ds_id', $entry->ds_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->ds_id)->first()->familienname . ' zu ' . $projectDescription->where('ds_id', $entry->value_new)->first()->bezeichnung;
                } else if ($entry->value_new == $param['project']){
                    $data['information']['Projektzugang'][] = date_format(date_create($entry->date), 'd.m.Y') . ': ' . $ma->where('ds_id', $entry->ds_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->ds_id)->first()->familienname . ' von ' . $projectDescription->where('ds_id', $entry->value_old)->first()->bezeichnung;
                }
            }
        }
    
        // Vertragswechsel
        // WICHTIG DSID MUSS IN MA SEIN!
        foreach($basedataContractChanges->whereIn('ds_id', $personIds) as $key => $entry){
            if($entry->date >= $param['start_date'] && $entry->date <= $param['end_date']){
                $data['information']['Vertragswechsel'][] = date_format(date_create($entry->date), 'd.m.Y') . ': ' . $ma->where('ds_id', $entry->ds_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->ds_id)->first()->familienname . ' von ' . number_format($entry->value_old / 40, 3, ',', '.') . ' FTE zu ' . number_format($entry->value_new / 40, 3, ',', '.') . ' FTE';
            }
        }

        foreach($history->sortBy('date_begin')->sortBy('state_id')->whereIn('agent_ds_id', $ma->pluck('ds_id')) as $key => $entry){
            $data['information'][$states->where('ds_id', $entry->state_id)->first()->description][] = date_format(date_create($entry->date_begin), 'd.m.Y') . ' - ' . date_format(date_create($entry->date_end), 'd.m.Y') . ': ' . $ma->where('ds_id', $entry->agent_ds_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->agent_ds_id)->first()->familienname;
        }

        // Berechnen wie viele Tage MA im Berichtszeitraum krank waren
        $sickEntries = $chronWork->whereIn('state_id', [1, 7]);
        foreach($sickEntries as $key => $entry){
            $entryName = $ma->where('ds_id', $entry->MA_id)->first()->vorname . ' ' . $ma->where('ds_id', $entry->MA_id)->first()->familienname;

            if(isset($data['sick_entries'][$entryName])){
                $data['sick_entries'][$entryName] += 1;
            } else {
                $data['sick_entries'][$entryName] = 1;
            }
        }

        arsort($data['sick_entries']);

        return $data;
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
        ->whereMonth('date_date', $param['month_num'])
        ->whereYear('date_date', $param['year'])
        ->where('call_forecast_issue', $param['forecast_issue'])
        ->where('total_costs_per_interval', '>', 0)
        ->get(['date_date', 'call_date_interval_start_time', 'call_forecast_issue', 'total_costs_per_interval', 'malus_interval', 'number_payed_calls', 'price', 'aht']);

        return $availbench;

    }

    public function getPersonId($param, $basedataProjectChanges){
        /** Gibt ein Array zurück in dem alle IDs der MA eines Projekts sind */

        $personIds = DB::connection('mysqlkdw')
        ->table('MA')
        ->where(function($query){
            $query
            ->where('abteilung_id', '=', 10)
            ->orWhere('abteilung_id', '=', 19);
        })
        ->where(function($query) use ($param, $basedataProjectChanges){
            $query
            ->where('projekt_id',  $param['project'])
            ->orWhere(function($query) use ($basedataProjectChanges) {    //STAMMDATENÄNDERUNG
                $query
                ->whereIn('ds_id', $basedataProjectChanges->pluck('ds_id'));
            });
        })
        ->pluck('ds_id');

        return $personIds;
    }

    public function getChronologyWork($param, $personIds){
        $chronWork =  DB::connection('mysqlkdw')                            
        ->table('chronology_work')                                      
        ->where('work_date', '>=', $param['start_date']) 
        ->where('work_date', '<=', $param['end_date'])
        ->where(function ($query) use ($personIds){
            $query
            ->whereIn('MA_id', $personIds);
        })
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

    public function getKdwMa($param, $basedataProjectChanges){
        $data =  DB::connection('mysqlkdw')                            
        ->table('MA')
        ->where(function($query) use ($param, $basedataProjectChanges){
            $query
            ->where('projekt_id',  $param['project'])
            ->orWhere(function($query) use ($basedataProjectChanges) {    //STAMMDATENÄNDERUNG
                $query
                ->whereIn('ds_id', $basedataProjectChanges->pluck('ds_id'));
            });
        })
        ->where('eintritt', '<=', $param['end_date'])
        ->where(function($query) use ($param){
            $query
            ->where('austritt', null)
            ->orWhere('austritt', '>=', $param['start_date']);
        })
        ->get(['ds_id', 'agent_id', 'vorname', 'familienname', 'abteilung_id', 'projekt_id', 'eintritt', 'austritt', 'soll_h_day']);

        return $data;
    }

    public function getAllKdwMa($param){
        $data =  DB::connection('mysqlkdw')                            
        ->table('MA')
        ->where('eintritt', '<=', $param['end_date'])
        ->where(function($query) use ($param){
            $query
            ->where('austritt', null)
            ->orWhere('austritt', '>=', $param['start_date']); // Hier können Filter auf die ID gesetzt werden (Urlaub, Krank usw.)
        })
        ->get(['ds_id', 'agent_id', 'vorname', 'familienname', 'abteilung_id', 'projekt_id', 'eintritt', 'austritt', 'soll_h_day']);

        return $data;
    }

    public function getHistoryState($param, $basedataProjectChanges){
        $data =  DB::connection('mysqlkdw')                            
        ->table('history_state')
        ->where(function($query) use ($param, $basedataProjectChanges){
            $query
            ->where('project_id',  $param['project'])
            ->orWhere(function($query) use ($basedataProjectChanges) {    //STAMMDATENÄNDERUNG
                $query
                ->whereIn('agent_ds_id', $basedataProjectChanges->pluck('ds_id'));
            });
        })
        ->where('date_begin', '<=', $param['end_date'])
        ->where('date_end', '>=', $param['start_date'])
        ->whereIn('state_id', [8, 13, 14, 15, 16, 23, 24, 30, 33, 34, 35])
        ->get(['agent_id', 'agent_ds_id', 'date_begin', 'date_end', 'state_id']);

        /** 
         * Beschreibung 'state_id'
         * 08: Krank???
         * 13: Krank o. Lfz.
         * 14: Unbezahlt Krank
         * 15: Mutterschutz
         * 26: Erziehungsurlaub
         * 23: Fehlt unentschuldig
         * 24: Beschäftigungsverbot
         * 30: Krank bei Eintritt
         * 33: Kindkrank o. Lfz.
         * 34: Krank Quarantäne
         * 35: Kind Corona
         */

        return $data;
    }

    public function getStatesDesc(){
        $data =  DB::connection('mysqlkdw')                            
        ->table('states_MA')
        ->get(['ds_id', 'description']);

        return $data;
    }

    public function getProjectDesc(){
        $data =  DB::connection('mysqlkdw')                            
        ->table('projekte')
        ->get(['ds_id', 'bezeichnung']);

        return $data;
    }

    public function getOptin($param){
        $data = DB::table('optin')
        ->where('department', $param['department_desc'])
        ->where('date', '>=', $param['start_date'])
        ->where('date', '<=', $param['end_date'])
        ->get(['date', 'Anzahl_Call_OptIn', 'Anzahl_Email_OptIn', 'Anzahl_Print_OptIn', 'Anzahl_SMS_OptIn', 'Anzahl_Nutzungsdaten_OptIn', 'Anzahl_Verkehrsdaten_OptIn']);

        return $data;
    }

    public function getSas($param){
        return DB::table('sas')
        ->where('date', '>=', $param['start_date'])
        ->where('date', '<=', $param['end_date'])
        ->where('serviceprovider_place', $param['serviceprovider'])
        ->where('GO_Prov', '>', 0)
        ->get(['date', 'GO_Prov']);
    }

    public function getBaseDataProjectChanges($param){
        $data =  DB::table('basedatachange')
        ->where('date', '>=', $param['start_date'])
        ->where('type', 'project_change')
        ->where(function($query) use ($param){
            $query
            ->where('value_old', $param['project'])
            ->orWhere('value_new', $param['project']); 
        })
        ->get(['date', 'ds_id', 'type', 'value_old', 'value_new'])
        ->sortBy('date');

        return $data;
    }

    public function getBaseDataContractChanges($param){
        $data =  DB::table('basedatachange')
        ->where('date', '>=', $param['start_date'])
        ->where('type', 'contract_hours')
        ->get(['date', 'ds_id', 'type', 'value_old', 'value_new'])
        ->sortBy('date');

        return $data;
    }

    // Zielwerte
    public function getConstantsOverview(){
        $data = DB::table('project_constants_overview')
        ->get();

        return $data;
    }
    
    public function getConstantsEntries(){

    }

    public function newConstant(){

    }

    public function newConstantEntry(){

    }
        
}
