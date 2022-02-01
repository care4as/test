<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectReportController extends Controller
{
    public function load(){
        $project = request('project');              // Projektauswahl aus Webpage
        $startDateString = request('startDate');    // Startdatumsauswahl aus Webpage
        $endDateString = request('endDate');        // Enddatumsauswahl aus Webpage
        $team = request('team');
        $report = request('report');

        // Namen des Teams speichern
        if ($team == 'all'){
            $teamName = 'Alle Teams';
        } else if ($team != null) {
            $teamName = DB::connection('mysqlkdw')->table('teams')->where('ds_id', $team)->value('bezeichnung');
        } else {
            $teamName = null;
        }

        // Namen des Projekt nach eigener Konvention speichern

        if ($project == '1u1_dsl_ret'){
            $projectName = '1u1 DSL Retention';
        } else if ($project == '1u1_mobile_ret') {
            $projectName = '1u1 Mobile Retention';
        } else {
            $projectName = $project;
        }

        if ($startDateString == null){  // Prüfen ob Startdatum eingegeben wurde
            $startDate = null;          // Wenn nichts eingegeben wurde, Wert auf 'null' setzen
        } else {
            $startDate = Carbon::createFromFormat("Y-m-d", $startDateString);   // Aus Datumsstring Objekt erzeugen
        }
        if ($endDateString == null){    // Prüfen ob Enddatum eingegeben wurde
            $endDate = null;            // Wenn nichts eingegeben wurde, Wert auf 'null' setzen
        } else {
            $endDate = Carbon::createFromFormat("Y-m-d", $endDateString);       // Aus Datumsstring Objekt erzeugen
        }

        $differenceDate = Carbon::parse($startDate)->diffInDays($endDate);      // Differenz zwischen Start- und Enddatum berechnen
 
        $defaultVariablesArray = array(         // Speichert globale Variablen in Array
            'project' => $project,              // Projektauswahl aus Webpage
            'projectName' => $projectName,
            'projectData' => $this->getProjects(),
            'team' => $team,
            'teamName' => $teamName,
            'report' => $report,
            'startDate' => $startDateString,    // Startdatum aus Webpage
            'endDate' => $endDateString,        // Enddatum aus Webpage
            'differenceDate' =>$differenceDate, // Differenz zwischen Start- und Enddatum
            'startDatePHP' => $startDate,       // Startdatum in Objekt konvertiert
            'endDatePHP' => $endDate,           // Enddatum in Objekt konvertiert
            'revenue_sale_dsl' => 16,           // Umsatz für DSL GeVo Save
            'revenue_kuerue_dsl' => 5,          // Umsatz für Kündigungsrücknahme
            'revenue_sale_mobile_ssc' => 16,    // Umsatz für SSC und Portale GeVo Save
            'revenue_sale_mobile_bsc' => 11,    // Umsatz für BSC GeVo Save
            'revenue_kuerue_mobile' => 5,       // Umsatz für Kündigungsrücknahme
            'revenue_hour_speedretention' => 38,// Umsatz pro Stunde auf Speedretention
            'optin_call' => 1.20,               // Umsatz für OptIn Call
            'optin_mail' => 0.3,                // Umsatz für OptIn Mail
            'optin_print' => 0.1,               // Umsatz für OptIn Print
            'optin_sms' => 0.1,                 // Umsatz für OptIn SMS
            'optin_usage' => 0.4,               // Umsatz für OptIn Nutzungsdaten
            'optin_traffic' => 0.4,             // Umsatz für OptIn Verkehrsdaten
            'cost_per_hour_dsl' => 36.41,          // Stündliche Kosten eines DSL MA
            'cost_per_hour_mobile' => 36.99,       // Stündliche Kosten eines DSL MA
        );
 
        $dataArray = array();   // Array für alle Daten anlegen, welche übermittelt werden sollen

        // Daten je nach Projekt und Report bereitstellen
        if($defaultVariablesArray['project'] == '1u1_dsl_ret'){             // Auswahl wenn Projekt == DSL
            if ($report == 'projektmeldung'){
                $dataArray = $this->get1u1DslRet($defaultVariablesArray);       // Datenarray mit DSL Daten füllen
            } else if ($report == 'teamscan'){
                $dataArray['team'] = $this->get1u1DslRet($defaultVariablesArray);
                $defaultVariablesArray['team'] = 'all';
                $dataArray['project'] = $this->get1u1DslRet($defaultVariablesArray);
                $defaultVariablesArray['team'] = $team;
            }
        }
        if($defaultVariablesArray['project'] == '1u1_mobile_ret'){             // Ablauf wenn Projekt == Mobile
            if ($report == 'projektmeldung'){
                $dataArray = $this->get1u1MobileRet($defaultVariablesArray);    // Datenarray mit Mobile Daten füllen
            } else if ($report == 'teamscan'){
                $dataArray['team'] = $this->get1u1MobileRet($defaultVariablesArray);
                $defaultVariablesArray['team'] = 'all';
                $dataArray['project'] = $this->get1u1MobileRet($defaultVariablesArray);
                $defaultVariablesArray['team'] = $team;
            }
        }

        //dd($dataArray);
        //dd($defaultVariablesArray);
        return view('projectReport', compact('defaultVariablesArray', 'dataArray'));
    }

    public function getProjects(){
        $projects = array(
            '1u1_dsl_ret' => [
              'id' => 10,
              'name' => '1und1 DSL Retention',
              'teams' => $this->getTeams(10)
            ],
            '1u1_mobile_ret' => [
              'id' => 7,
              'name' => '1und1 Mobile Retention',
              'teams' => $this->getTeams(7)
            ],
          );
        return $projects;
      }

    
      public function getTeams($projectId){
        $teamsData = DB::connection('mysqlkdw')
        ->table('teams')
        ->where('projekt_id', $projectId)
        ->get();

        $teams = array();
        foreach($teamsData as $key => $entry){
            $entry = (array) $entry;
            $teams[$key]['ds_id'] = $entry['ds_id'];
            $teams[$key]['bezeichnung'] = $entry['bezeichnung'];
        }
        return $teams;
    }

    public function get1u1MobileRet($defaultVariablesArray){
        /** Die Funktion 'get1u1MobileRet()' übernimmt Fuktionsaufrufe, um ein Array zu erstellen, welches, 
         * gegliedert nach MA-ID, alle MA des Projekts, sowie eine Summe über die gesamten Projektkennzahlen, auflistet. */

        $finalArray = array(); // Array für die Daten erstellen

        $finalArray['employees'] = 
            $this->get1u1MobileRetEmployees($defaultVariablesArray);    // Array mit den Daten der 1u1 Mobile MA füllen

        $finalArray = $this->get1u1MobileRetSum($defaultVariablesArray, $finalArray); // Die MA Daten summieren

        //dd($finalArray);
        return $finalArray;

    }

    public function get1u1DslRet($defaultVariablesArray){
        /** Die Funktion 'get1u1DslRet()' übernimmt Fuktionsaufrufe, um ein Array zu erstellen, welches, 
         * gegliedert nach MA-ID, alle MA des Projekts, sowie eine Summe über die gesamten Projektkennzahlen, auflistet. */

        $finalArray = array(); // Array für Daten erstellen

        $finalArray['employees'] = 
            $this->get1u1DslRetEmployees($defaultVariablesArray); // Array mit Daten von 1u1 DSL MA füllen

        $finalArray = 
            $this->get1u1DslRetSum($defaultVariablesArray, $finalArray); // Die MA Daten summieren

        //dd($finalArray);
        return $finalArray; // Das befüllte Array wird zurückgegeben
    }

    public function get1u1DslRetSum($defaultVariablesArray, $finalArray){
        /** Hier wird der Projektumsatz durch den Availbench berechnet */
        $availbenchData = $this->getAvailbench($defaultVariablesArray, 'DE_1u1_RT_Access_1st');     // Datenbankabfrage um alle relevanten Availbenchdaten zu ziehen
        $finalArray['sum']['revenue_availbench'] = 0;                                               // Umsatz Availbench mit 0 initialisieren
        foreach($availbenchData as $key => $entry){                                                 // Das Availbencharray durchlaufen
            $finalArray['sum']['revenue_availbench'] += $entry['total_costs_per_interval'];         // Für jeden Eintrag den Umsatz auf die Summe addieren
        }

        /** Hier werden die globalen Variablen jeweils mit 0 initialisiert */
        $finalArray['sum']['fte'] = 0;
        $finalArray['sum']['work_hours'] = 0;                   // Bezahlte Stunden initialisieren
        $finalArray['sum']['productive_hours'] = 0;             // Produktivstunden initialisieren
        $finalArray['sum']['ccu_hours'] = 0;             
        $finalArray['sum']['sick_hours'] = 0;                   // Krankstunden initialisieren
        $finalArray['sum']['break_hours'] = 0;                  // Pausenstunden initialisieren
        $finalArray['sum']['dsl_calls'] = 0;                    // DSL Calls initialisieren
        $finalArray['sum']['time_in_call_seconds'] = 0;         // Zeit in Calls initialisieren
        $finalArray['sum']['dsl_saves'] = 0;                    // DSL Saves initialisieren
        $finalArray['sum']['dsl_kuerue'] = 0;                   // DSL KüRüs initialisieren
        $finalArray['sum']['optin_new_email'] = 0;              // OptIn Mail initialisieren
        $finalArray['sum']['optin_new_print'] = 0;              // OptIn Print initialisieren
        $finalArray['sum']['optin_new_sms'] = 0;                // OptIn SMS initialisieren
        $finalArray['sum']['optin_new_call'] = 0;               // OptIn Call initialisieren
        $finalArray['sum']['optin_new_usage'] = 0;              // OptIn Nutzungsdaten initialisieren
        $finalArray['sum']['optin_new_traffic'] = 0;            // OptIn Verkehrsdaten initialisieren
        $finalArray['sum']['optin_sum_payed'] = 0;              // Summe bezahlter OptIn initialisieren
        $finalArray['sum']['optin_calls_new'] = 0;              // Summe quotenrelevanter OptIn initialisieren
        $finalArray['sum']['optin_calls_possible'] = 0;         // Summe möglicher quotenrelevanter OptIn initialisieren
        $finalArray['sum']['sas_orders'] = 0;                   // SAS Saves initialisieren
        $finalArray['sum']['pay_cost'] = 0;                     // Mitarbeiterkosten initialisieren
        $finalArray['sum']['rlz_minus'] = 0;                    // Summe RLZ-24 initialisieren
        $finalArray['sum']['rlz_plus'] = 0;                     // Summe RLZ+24 initialisieren
        $finalArray['sum']['hours_speedretention'] = 0;         // Summe Std. Speedretention initialisieren
        $finalArray['sum']['revenue_speedretention'] = 0;       // Umsatz Speedretention initialisieren

        /** In dieser Schleife wird jeder Mitarbeiter betrachtet und seine Werte auf die Summe addiert */
        foreach($finalArray['employees'] as $key => $entry) {
            $finalArray['sum']['fte'] += $entry['fte'];
            $finalArray['sum']['work_hours'] += $entry['work_hours'];
            $finalArray['sum']['productive_hours'] += $entry['productive_hours'];
            $finalArray['sum']['ccu_hours'] += $entry['ccu_hours'];
            $finalArray['sum']['sick_hours'] += $entry['sick_hours'];
            $finalArray['sum']['break_hours'] += $entry['break_hours'];
            $finalArray['sum']['dsl_calls'] += $entry['dsl_calls'];
            $finalArray['sum']['time_in_call_seconds'] += $entry['time_in_call_seconds'];
            $finalArray['sum']['dsl_saves'] += $entry['dsl_saves'];
            $finalArray['sum']['dsl_kuerue'] += $entry['dsl_kuerue'];
            $finalArray['sum']['optin_new_email'] += $entry['optin_new_email'];
            $finalArray['sum']['optin_new_print'] += $entry['optin_new_print'];
            $finalArray['sum']['optin_new_sms'] += $entry['optin_new_sms'];
            $finalArray['sum']['optin_new_call'] += $entry['optin_new_call'];
            $finalArray['sum']['optin_new_usage'] += $entry['optin_new_usage'];
            $finalArray['sum']['optin_new_traffic'] += $entry['optin_new_traffic'];
            $finalArray['sum']['optin_sum_payed'] += $entry['optin_sum_payed'];
            $finalArray['sum']['optin_calls_new'] += $entry['optin_calls_new'];
            $finalArray['sum']['optin_calls_possible'] += $entry['optin_calls_possible'];
            $finalArray['sum']['sas_orders'] += $entry['sas_orders'];
            $finalArray['sum']['pay_cost'] += $entry['pay_cost'];
            $finalArray['sum']['rlz_minus'] += $entry['rlz_minus'];
            $finalArray['sum']['rlz_plus'] += $entry['rlz_plus'];
            $finalArray['sum']['hours_speedretention'] += $entry['hours_speedretention'];
        }

        /** Hier wird der Umsatz durch Speedretention berechnet */
        $finalArray['sum']['revenue_speedretention'] = 
            $finalArray['sum']['hours_speedretention'] 
            * $defaultVariablesArray['revenue_hour_speedretention'];

        /** Hier wird der Umsatz durch OptIn berechnet */
        $finalArray['sum']['revenue_optin'] =                                                       // Umsatz OptIn = Stückzahl * Preis pro Item (Festgelegt im DefaultVariablesArray)
            $finalArray['sum']['optin_new_call'] * $defaultVariablesArray['optin_call']             // OptIn Call * 1,20€
            + $finalArray['sum']['optin_new_email'] * $defaultVariablesArray['optin_mail']          // OptIn Mail * 0,30€
            + $finalArray['sum']['optin_new_print'] * $defaultVariablesArray['optin_print']         // OptIn Print * 0,10€
            + $finalArray['sum']['optin_new_sms'] * $defaultVariablesArray['optin_sms']             // OptIn Sms * 0,10€
            + $finalArray['sum']['optin_new_usage'] * $defaultVariablesArray['optin_usage']         // OptIn Verkehrsdaten * 0,40€
            + $finalArray['sum']['optin_new_traffic'] * $defaultVariablesArray['optin_traffic'];    // OptIn Nutzungsdaten * 0,40€

        /** Hier wird die Produktivquote berechnet */
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['productive_percentage_brutto'] = 
                ($finalArray['sum']['productive_hours'] 
                / $finalArray['sum']['work_hours']) 
                * 100;
        } else {
            $finalArray['sum']['productive_percentage_brutto'] = 0;
        }

        if($finalArray['sum']['ccu_hours'] > 0){
            $finalArray['sum']['productive_percentage_netto'] = 
                ($finalArray['sum']['productive_hours'] 
                / $finalArray['sum']['ccu_hours']) 
                * 100;
        } else {
            $finalArray['sum']['productive_percentage_netto'] = 0;
        }

        /** Hier wird die Pausenquote berechnet */
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['break_percentage'] = ($finalArray['sum']['break_hours'] / $finalArray['sum']['work_hours'] * 100);
        } else {
            $finalArray['sum']['break_percentage'] = 0;
        }

        /** Hier wird die Krankenquote berechnet */
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['sick_percentage'] = ($finalArray['sum']['sick_hours'] / $finalArray['sum']['work_hours']) * 100;
        } else {
            $finalArray['sum']['sick_percentage'] = 0;
        }

        /** Hier werden die Calls / Stunde berechnet */
        if($finalArray['sum']['productive_hours'] > 0){
            $finalArray['sum']['calls_per_hour'] = $finalArray['sum']['dsl_calls'] / $finalArray['sum']['productive_hours'];
        } else {
            $finalArray['sum']['calls_per_hour'] = 0;
        }

        /** Hier wird die AHT berechnet */
        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['aht'] = $finalArray['sum']['time_in_call_seconds'] / $finalArray['sum']['dsl_calls'];
        } else {
            $finalArray['sum']['aht'] = 0;
        }

        /** Hier wird die DSL CR berechnet */
        if($finalArray['sum']['dsl_saves'] > 0){
            $finalArray['sum']['dsl_cr'] = ($finalArray['sum']['dsl_saves'] / $finalArray['sum']['dsl_calls']) * 100;
        } else {
            $finalArray['sum']['dsl_cr'] = 0;
        }

        /** Hier wird die OptInqoute berechnet */
        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['optin_percentage'] = ($finalArray['sum']['optin_calls_new'] / $finalArray['sum']['dsl_calls']) * 100;
        } else {
            $finalArray['sum']['optin_percentage'] = 0;
        }

        /** Hier wird die mögliche OptInquote berechnet */
        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['optin_possible_percentage'] = ($finalArray['sum']['optin_calls_possible'] / $finalArray['sum']['dsl_calls']) * 100;
        } else {
            $finalArray['sum']['optin_possible_percentage'] = 0;
        }

        /** Hier wird die SAS-Quote berechnet */
        if($finalArray['sum']['dsl_calls'] > 0){
            $finalArray['sum']['sas_promille'] = ($finalArray['sum']['sas_orders'] / $finalArray['sum']['dsl_calls']) * 1000;
        } else {
            $finalArray['sum']['sas_promille'] = 0;
        }

        /** Hier wird die RLZ+24-Quote berechnet */
        if(($finalArray['sum']['rlz_minus'] + $finalArray['sum']['rlz_plus']) > 0){
            $finalArray['sum']['rlz_plus_percentage'] = ($finalArray['sum']['rlz_plus'] / ($finalArray['sum']['rlz_minus'] + $finalArray['sum']['rlz_plus'])) * 100;
        } else {
            $finalArray['sum']['rlz_plus_percentage'] = 0;
        }

        /** Berechnung des Umsatz durch Sales */
        $finalArray['sum']['revenue_sales'] = 
            $finalArray['sum']['dsl_saves'] 
            * $defaultVariablesArray['revenue_sale_dsl']
            + $finalArray['sum']['dsl_kuerue']
            * $defaultVariablesArray['revenue_kuerue_mobile'];

        /** Berechnung des gesamten Umsatz */
        $finalArray['sum']['revenue_sum'] = 
            $finalArray['sum']['revenue_sales'] 
            + $finalArray['sum']['revenue_availbench'] 
            + $finalArray['sum']['revenue_optin']
            + $finalArray['sum']['revenue_speedretention'];

        /** Berechnung des Umsatzdeltas */
        $finalArray['sum']['revenue_delta'] = // Delta = Umsaz - Kosten
            $finalArray['sum']['revenue_sum'] 
            - $finalArray['sum']['pay_cost'];

        /** Berechnung des Umsatz pro bezahlter Stunde */
        if($finalArray['sum']['work_hours'] > 0){ // Wenn bezahlte Stunden vorhanden
            $finalArray['sum']['revenue_per_hour_paid'] = // Umsatz pro bezahlte Stunde = Umsatz / bezahlte Stunden
                $finalArray['sum']['revenue_sum'] // Summe Umsatz
                / $finalArray['sum']['work_hours']; // Summe bezahlte Stunden
        } else { // Wenn keine bezahlten Stunden vorhanden
            $finalArray['sum']['revenue_per_hour_paid'] = 0; // Kein Umsatz pro bezahlte Stunden
        }

        /** Berechnung des Umsatz pro Produktivstunde */
        if($finalArray['sum']['productive_hours'] > 0){
            $finalArray['sum']['revenue_per_hour_productive'] = $finalArray['sum']['revenue_sum'] / $finalArray['sum']['productive_hours'];
        } else {
            $finalArray['sum']['revenue_per_hour_productive'] = 0;
        }

        /** Berechnung der finalen MA-Werte, welche die Projektsummen erfordern */
        foreach($finalArray['employees'] as $key => $entry) {

            /** Berechnung des Umsatz durch Availbench */
            if($finalArray['sum']['dsl_calls'] > 0){
                if($entry['dsl_calls'] > 0){
                    $finalArray['employees'][$key]['revenue_availbench'] = ($entry['dsl_calls'] / $finalArray['sum']['dsl_calls']) * $finalArray['sum']['revenue_availbench'];
                } else {
                    $finalArray['employees'][$key]['revenue_availbench'] = 0;
                }
            } else {
              $finalArray['employees'][$key]['revenue_availbench'] = 0;
            }
            
            /** Berechnung des Umsatz durch OptIn */
            $finalArray['employees'][$key]['revenue_optin'] =                                                       // Umsatz OptIn = Stückzahl * Preis pro Item 
                $finalArray['employees'][$key]['optin_new_call'] * $defaultVariablesArray['optin_call']             // OptIn Call * 1,20€
                + $finalArray['employees'][$key]['optin_new_email'] * $defaultVariablesArray['optin_mail']          // OptIn Mail * 0,30€
                + $finalArray['employees'][$key]['optin_new_print'] * $defaultVariablesArray['optin_print']         // OptIn Print * 0,10€
                + $finalArray['employees'][$key]['optin_new_sms'] * $defaultVariablesArray['optin_sms']             // OptIn Sms * 0,10€
                + $finalArray['employees'][$key]['optin_new_usage'] * $defaultVariablesArray['optin_usage']         // OptIn Verkehrsdaten * 0,40€
                + $finalArray['employees'][$key]['optin_new_traffic'] * $defaultVariablesArray['optin_traffic'];    // OptIn Nutzungsdaten * 0,40€

            /** Berechnung des Umsatz durch Speedretention */
            $finalArray['employees'][$key]['revenue_speedretention'] =      // Umsatz Speedretention berechnen
                $finalArray['employees'][$key]['hours_speedretention']      // Stunden auf Status
                * $defaultVariablesArray['revenue_hour_speedretention'];    // Multipliziert mit €-Wert je Stunde

            /** Berechnung des gesamten Umsatz */
            $finalArray['employees'][$key]['revenue_sum'] =                 // Summe Umsazu = Summe aller anderen Umsätze
                $finalArray['employees'][$key]['revenue_availbench']        // Umsatz Availbench
                + $finalArray['employees'][$key]['revenue_sales']           // + Umsatz Sales (RET GeVo + KüRü)
                + $finalArray['employees'][$key]['revenue_optin']           // + Umsatz OptIn
                + $finalArray['employees'][$key]['revenue_speedretention']; // + Umsatz Speedretention
            
            /** Berechnung des Umsatzdeltas */
            $finalArray['employees'][$key]['revenue_delta'] =   // Delta = Umsatz - Kosten
                $finalArray['employees'][$key]['revenue_sum']   // Summe aller Umsätze eines MA
                - $finalArray['employees'][$key]['pay_cost'];   // Kosten der Arbeitszeit (Stunden * 35,00€)
            
            /** Berechnung des Umsatz pro bezahlter Stunde */
            if($entry['work_hours'] > 0){                                               // Prüfen ob Produktivstunden vorhanden sind
                $finalArray['employees'][$key]['revenue_per_hour_paid'] =                   // Falls ja: Umsatz pro bezahlter Stunde berechne
                    $finalArray['employees'][$key]['revenue_sum']                                // Gesamten Umsatz eines MA nehmen
                    / $entry['work_hours'];                                                      // Diesen durch die bezahlten Stunden teilen
            } else {
                $finalArray['employees'][$key]['revenue_per_hour_paid'] = 0;                // Falls nein: Umsatz pro bezahlter Stunde auf 0 setzen
            }
            
            /** Berechnung des Umsatz pro Produktivstunde */
            if($entry['productive_hours'] > 0){                                         // Prüfen ob Produktivstunden vorhanden sind
                $finalArray['employees'][$key]['revenue_per_hour_productive'] =             // Falls ja: Umsatz pro Produktivstunde berechnen
                    $finalArray['employees'][$key]['revenue_sum']                               // Gesamten Umsatz eines MA nehmen
                    / $entry['productive_hours'];                                               // Diesen durch die Produktivstunden teilen
            } else {
                $finalArray['employees'][$key]['revenue_per_hour_productive'] = 0;          // Falls nein: Umsatz pro Produktivstunde auf 0 setzen
            }
        }

        //dd($finalArray);
        return $finalArray;
    }

    public function get1u1MobileRetSum($defaultVariablesArray, $finalArray){
        /** Hier wird der Projektumsatz durch den Availbench berechnet */

        /** WICHTIG: Hier Anpassen sobald Availbench zur Verfügung steht */
        $availbenchData = $this->getAvailbench($defaultVariablesArray, 'DE_1u1_RT_Mobile_1st');     // Datenbankabfrage um alle relevanten Availbenchdaten zu ziehen
        $finalArray['sum']['revenue_availbench'] = 0;                                               // Umsatz Availbench mit 0 initialisieren
        $finalArray['sum']['availbench_calls'] = 0;                                                 // Calls des Availbench mit 0 initialisieren
        foreach($availbenchData as $key => $entry){                                                 // Das Availbencharray durchlaufen
            $finalArray['sum']['revenue_availbench'] += $entry['total_costs_per_interval'];         // Für jeden Eintrag den Umsatz auf die Summe addieren
            $finalArray['sum']['availbench_calls'] += $entry['handled'];                            // Für jeden Eintrag die handled Calls auf die Summe addieren
        }
        
        /** Hier werden die globalen Variablen jeweils mit 0 initialisiert */
        $finalArray['sum']['fte'] = 0; 
        $finalArray['sum']['work_hours'] = 0;                   // Bezahlte Stunden initialisieren
        $finalArray['sum']['productive_hours'] = 0;             // Produktivstunden initialisieren
        $finalArray['sum']['ccu_hours'] = 0;
        $finalArray['sum']['sick_hours'] = 0;                   // Krankstunden initialisieren
        $finalArray['sum']['break_hours'] = 0;                  // Pausenstunden initialisieren
        $finalArray['sum']['mobile_calls_sum'] = 0;             // Mobile Calls initialisieren
        $finalArray['sum']['mobile_calls_ssc'] = 0;             // Mobile Calls initialisieren
        $finalArray['sum']['mobile_calls_bsc'] = 0;             // Mobile Calls initialisieren
        $finalArray['sum']['mobile_calls_portale'] = 0;         // Mobile Calls initialisieren
        $finalArray['sum']['time_in_call_seconds'] = 0;         // Zeit in Calls initialisieren
        $finalArray['sum']['mobile_saves_sum'] = 0;             // Mobile Saves initialisieren
        $finalArray['sum']['mobile_saves_ssc'] = 0;             // Mobile Saves initialisieren
        $finalArray['sum']['mobile_saves_bsc'] = 0;             // Mobile Saves initialisieren
        $finalArray['sum']['mobile_saves_portale'] = 0;         // Mobile Saves initialisieren
        $finalArray['sum']['mobile_kuerue'] = 0;                // Mobile KüRüs initialisieren
        $finalArray['sum']['optin_new_email'] = 0;              // OptIn Mail initialisieren
        $finalArray['sum']['optin_new_print'] = 0;              // OptIn Print initialisieren
        $finalArray['sum']['optin_new_sms'] = 0;                // OptIn SMS initialisieren
        $finalArray['sum']['optin_new_call'] = 0;               // OptIn Call initialisieren
        $finalArray['sum']['optin_new_usage'] = 0;              // OptIn Nutzungsdaten initialisieren
        $finalArray['sum']['optin_new_traffic'] = 0;            // OptIn Verkehrsdaten initialisieren
        $finalArray['sum']['optin_sum_payed'] = 0;              // Summe bezahlter OptIn initialisieren
        $finalArray['sum']['optin_calls_new'] = 0;              // Summe quotenrelevanter OptIn initialisieren
        $finalArray['sum']['optin_calls_possible'] = 0;         // Summe möglicher quotenrelevanter OptIn initialisieren
        $finalArray['sum']['sas_orders'] = 0;                   // SAS Saves initialisieren
        $finalArray['sum']['pay_cost'] = 0;                     // Mitarbeiterkosten initialisieren
        $finalArray['sum']['rlz_minus'] = 0;                    // Summe RLZ-24 initialisieren
        $finalArray['sum']['rlz_plus'] = 0;                     // Summe RLZ+24 initialisieren
        $finalArray['sum']['hours_speedretention'] = 0;         // Summe Std. Speedretention initialisieren
        $finalArray['sum']['revenue_speedretention'] = 0;       // Umsatz Speedretention initialisieren

        /** In dieser Schleife wird jeder Mitarbeiter betrachtet und seine Werte auf die Summe addiert */
        foreach($finalArray['employees'] as $key => $entry) {
            $finalArray['sum']['fte'] += $entry['fte'];
            $finalArray['sum']['work_hours'] += $entry['work_hours'];
            $finalArray['sum']['productive_hours'] += $entry['productive_hours'];
            $finalArray['sum']['ccu_hours'] += $entry['ccu_hours'];
            $finalArray['sum']['sick_hours'] += $entry['sick_hours'];
            $finalArray['sum']['break_hours'] += $entry['break_hours'];
            $finalArray['sum']['mobile_calls_sum'] += $entry['mobile_calls_sum'];
            $finalArray['sum']['mobile_calls_ssc'] += $entry['mobile_calls_ssc'];
            $finalArray['sum']['mobile_calls_bsc'] += $entry['mobile_calls_bsc'];
            $finalArray['sum']['mobile_calls_portale'] += $entry['mobile_calls_portale'];
            $finalArray['sum']['time_in_call_seconds'] += $entry['time_in_call_seconds'];
            $finalArray['sum']['mobile_saves_sum'] += $entry['mobile_saves_sum'];
            $finalArray['sum']['mobile_saves_ssc'] += $entry['mobile_saves_ssc'];
            $finalArray['sum']['mobile_saves_bsc'] += $entry['mobile_saves_bsc'];
            $finalArray['sum']['mobile_saves_portale'] += $entry['mobile_saves_portale'];
            $finalArray['sum']['mobile_kuerue'] += $entry['mobile_kuerue'];
            $finalArray['sum']['optin_new_email'] += $entry['optin_new_email'];
            $finalArray['sum']['optin_new_print'] += $entry['optin_new_print'];
            $finalArray['sum']['optin_new_sms'] += $entry['optin_new_sms'];
            $finalArray['sum']['optin_new_call'] += $entry['optin_new_call'];
            $finalArray['sum']['optin_new_usage'] += $entry['optin_new_usage'];
            $finalArray['sum']['optin_new_traffic'] += $entry['optin_new_traffic'];
            $finalArray['sum']['optin_sum_payed'] += $entry['optin_sum_payed'];
            $finalArray['sum']['optin_calls_new'] += $entry['optin_calls_new'];
            $finalArray['sum']['optin_calls_possible'] += $entry['optin_calls_possible'];
            $finalArray['sum']['sas_orders'] += $entry['sas_orders'];
            $finalArray['sum']['pay_cost'] += $entry['pay_cost'];
            $finalArray['sum']['rlz_minus'] += $entry['rlz_minus'];
            $finalArray['sum']['rlz_plus'] += $entry['rlz_plus'];
            $finalArray['sum']['hours_speedretention'] += $entry['hours_speedretention'];
        }

        if ($finalArray['sum']['availbench_calls'] > 0){
            $finalArray['sum']['revenue_availbench'] = ($finalArray['sum']['revenue_availbench'] * ($finalArray['sum']['mobile_calls_sum'] / $finalArray['sum']['availbench_calls']));
        } else {
            $finalArray['sum']['revenue_availbench'] = 0;
        }

        /** Hier wird der Umsatz durch Speedretention berechnet */
        $finalArray['sum']['revenue_speedretention'] = 
            $finalArray['sum']['hours_speedretention'] 
            * $defaultVariablesArray['revenue_hour_speedretention'];

        /** Hier wird der Umsatz durch OptIn berechnet */
        $finalArray['sum']['revenue_optin'] =                                                       // Umsatz OptIn = Stückzahl * Preis pro Item (Festgelegt im DefaultVariablesArray)
            $finalArray['sum']['optin_new_call'] * $defaultVariablesArray['optin_call']             // OptIn Call * 1,20€
            + $finalArray['sum']['optin_new_email'] * $defaultVariablesArray['optin_mail']          // OptIn Mail * 0,30€
            + $finalArray['sum']['optin_new_print'] * $defaultVariablesArray['optin_print']         // OptIn Print * 0,10€
            + $finalArray['sum']['optin_new_sms'] * $defaultVariablesArray['optin_sms']             // OptIn Sms * 0,10€
            + $finalArray['sum']['optin_new_usage'] * $defaultVariablesArray['optin_usage']         // OptIn Verkehrsdaten * 0,40€
            + $finalArray['sum']['optin_new_traffic'] * $defaultVariablesArray['optin_traffic'];    // OptIn Nutzungsdaten * 0,40€

        /** Hier wird die Produktivquote berechnet */
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['productive_percentage_brutto'] = 
                ($finalArray['sum']['productive_hours'] 
                / $finalArray['sum']['work_hours']) 
                * 100;
        } else {
            $finalArray['sum']['productive_percentage_brutto'] = 0;
        }

        if($finalArray['sum']['ccu_hours'] > 0){
            $finalArray['sum']['productive_percentage_netto'] = 
                ($finalArray['sum']['productive_hours'] 
                / $finalArray['sum']['ccu_hours']) 
                * 100;
        } else {
            $finalArray['sum']['productive_percentage_netto'] = 0;
        }

        /** Hier wird die Pausenquote berechnet */
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['break_percentage'] = ($finalArray['sum']['break_hours'] / $finalArray['sum']['work_hours'] * 100);
        } else {
            $finalArray['sum']['break_percentage'] = 0;
        }

        /** Hier wird die Krankenquote berechnet */
        if($finalArray['sum']['work_hours'] > 0){
            $finalArray['sum']['sick_percentage'] = ($finalArray['sum']['sick_hours'] / $finalArray['sum']['work_hours']) * 100;
        } else {
            $finalArray['sum']['sick_percentage'] = 0;
        }

        /** Hier werden die Calls / Stunde berechnet */
        if($finalArray['sum']['productive_hours'] > 0){
            $finalArray['sum']['calls_per_hour'] = $finalArray['sum']['mobile_calls_sum'] / $finalArray['sum']['productive_hours'];
        } else {
            $finalArray['sum']['calls_per_hour'] = 0;
        }

        /** Hier wird die AHT berechnet */
        if($finalArray['sum']['mobile_calls_sum'] > 0){
            $finalArray['sum']['aht'] = $finalArray['sum']['time_in_call_seconds'] / $finalArray['sum']['mobile_calls_sum'];
        } else {
            $finalArray['sum']['aht'] = 0;
        }

        /** Hier wird die SSC CR berechnet */
        if($finalArray['sum']['mobile_calls_ssc'] > 0){
            $finalArray['sum']['mobile_cr_ssc'] = ($finalArray['sum']['mobile_saves_ssc'] / $finalArray['sum']['mobile_calls_ssc']) * 100;
        } else {
            $finalArray['sum']['mobile_cr_ssc'] = 0;
        }

        /** Hier wird die BSC CR berechnet */
        if($finalArray['sum']['mobile_calls_bsc'] > 0){
            $finalArray['sum']['mobile_cr_bsc'] = ($finalArray['sum']['mobile_saves_bsc'] / $finalArray['sum']['mobile_calls_bsc']) * 100;
        } else {
            $finalArray['sum']['mobile_cr_bsc'] = 0;
        }

        /** Hier wird die Portale CR berechnet */
        if($finalArray['sum']['mobile_calls_portale'] > 0){
            $finalArray['sum']['mobile_cr_portale'] = ($finalArray['sum']['mobile_saves_portale'] / $finalArray['sum']['mobile_calls_portale']) * 100;
        } else {
            $finalArray['sum']['mobile_cr_portale'] = 0;
        }

        /** Hier wird die OptInqoute berechnet */
        if($finalArray['sum']['mobile_calls_sum'] > 0){
            $finalArray['sum']['optin_percentage'] = ($finalArray['sum']['optin_calls_new'] / $finalArray['sum']['mobile_calls_sum']) * 100;
        } else {
            $finalArray['sum']['optin_percentage'] = 0;
        }

        /** Hier wird die mögliche OptInquote berechnet */
        if($finalArray['sum']['mobile_calls_sum'] > 0){
            $finalArray['sum']['optin_possible_percentage'] = ($finalArray['sum']['optin_calls_possible'] / $finalArray['sum']['mobile_calls_sum']) * 100;
        } else {
            $finalArray['sum']['optin_possible_percentage'] = 0;
        }

        /** Hier wird die SAS-Quote berechnet */
        if($finalArray['sum']['mobile_calls_sum'] > 0){
            $finalArray['sum']['sas_promille'] = ($finalArray['sum']['sas_orders'] / $finalArray['sum']['mobile_calls_sum']) * 1000;
        } else {
            $finalArray['sum']['sas_promille'] = 0;
        }

        /** Hier wird die RLZ+24-Quote berechnet */
        if(($finalArray['sum']['rlz_minus'] + $finalArray['sum']['rlz_plus']) > 0){
            $finalArray['sum']['rlz_plus_percentage'] = ($finalArray['sum']['rlz_plus'] / ($finalArray['sum']['rlz_minus'] + $finalArray['sum']['rlz_plus'])) * 100;
        } else {
            $finalArray['sum']['rlz_plus_percentage'] = 0;
        }

        /** Berechnung des Umsatz durch Sales */
        $finalArray['sum']['revenue_sales'] = 
            $finalArray['sum']['mobile_saves_ssc'] 
            * $defaultVariablesArray['revenue_sale_mobile_ssc']
            + $finalArray['sum']['mobile_saves_portale'] 
            * $defaultVariablesArray['revenue_sale_mobile_ssc']
            + $finalArray['sum']['mobile_saves_bsc'] 
            * $defaultVariablesArray['revenue_sale_mobile_bsc']
            + $finalArray['sum']['mobile_kuerue']
            * $defaultVariablesArray['revenue_kuerue_mobile'];

        /** Berechnung des gesamten Umsatz */
        $finalArray['sum']['revenue_sum'] = 
            $finalArray['sum']['revenue_sales'] 
            + $finalArray['sum']['revenue_availbench'] 
            + $finalArray['sum']['revenue_optin']
            + $finalArray['sum']['revenue_speedretention'];

        /** Berechnung des Umsatzdeltas */
        $finalArray['sum']['revenue_delta'] = // Delta = Umsaz - Kosten
            $finalArray['sum']['revenue_sum'] 
            - $finalArray['sum']['pay_cost'];

        /** Berechnung des Umsatz pro bezahlter Stunde */
        if($finalArray['sum']['work_hours'] > 0){ // Wenn bezahlte Stunden vorhanden
            $finalArray['sum']['revenue_per_hour_paid'] = // Umsatz pro bezahlte Stunde = Umsatz / bezahlte Stunden
                $finalArray['sum']['revenue_sum'] // Summe Umsatz
                / $finalArray['sum']['work_hours']; // Summe bezahlte Stunden
        } else { // Wenn keine bezahlten Stunden vorhanden
            $finalArray['sum']['revenue_per_hour_paid'] = 0; // Kein Umsatz pro bezahlte Stunden
        }

        /** Berechnung des Umsatz pro Produktivstunde */
        if($finalArray['sum']['productive_hours'] > 0){
            $finalArray['sum']['revenue_per_hour_productive'] = $finalArray['sum']['revenue_sum'] / $finalArray['sum']['productive_hours'];
        } else {
            $finalArray['sum']['revenue_per_hour_productive'] = 0;
        }

        /** Berechnung der finalen MA-Werte, welche die Projektsummen erfordern */
        foreach($finalArray['employees'] as $key => $entry) {

            /** Berechnung des Umsatz durch Availbench */
            if($finalArray['sum']['mobile_calls_sum'] > 0){
                if($entry['mobile_calls_sum'] > 0){
                    $finalArray['employees'][$key]['revenue_availbench'] = ($entry['mobile_calls_sum'] / $finalArray['sum']['mobile_calls_sum']) * $finalArray['sum']['revenue_availbench'];
                } else {
                    $finalArray['employees'][$key]['revenue_availbench'] = 0;
                }
            } else {
              $finalArray['employees'][$key]['revenue_availbench'] = 0;
            }
            
            /** Berechnung des Umsatz durch OptIn */
            $finalArray['employees'][$key]['revenue_optin'] =                                                       // Umsatz OptIn = Stückzahl * Preis pro Item 
                $finalArray['employees'][$key]['optin_new_call'] * $defaultVariablesArray['optin_call']             // OptIn Call * 1,20€
                + $finalArray['employees'][$key]['optin_new_email'] * $defaultVariablesArray['optin_mail']          // OptIn Mail * 0,30€
                + $finalArray['employees'][$key]['optin_new_print'] * $defaultVariablesArray['optin_print']         // OptIn Print * 0,10€
                + $finalArray['employees'][$key]['optin_new_sms'] * $defaultVariablesArray['optin_sms']             // OptIn Sms * 0,10€
                + $finalArray['employees'][$key]['optin_new_usage'] * $defaultVariablesArray['optin_usage']         // OptIn Verkehrsdaten * 0,40€
                + $finalArray['employees'][$key]['optin_new_traffic'] * $defaultVariablesArray['optin_traffic'];    // OptIn Nutzungsdaten * 0,40€

            /** Berechnung des Umsatz durch Speedretention */
            $finalArray['employees'][$key]['revenue_speedretention'] =      // Umsatz Speedretention berechnen
                $finalArray['employees'][$key]['hours_speedretention']      // Stunden auf Status
                * $defaultVariablesArray['revenue_hour_speedretention'];    // Multipliziert mit €-Wert je Stunde

            /** Berechnung des gesamten Umsatz */
            $finalArray['employees'][$key]['revenue_sum'] =                 // Summe Umsazu = Summe aller anderen Umsätze
                $finalArray['employees'][$key]['revenue_availbench']        // Umsatz Availbench
                + $finalArray['employees'][$key]['revenue_sales']           // + Umsatz Sales (RET GeVo + KüRü)
                + $finalArray['employees'][$key]['revenue_optin']           // + Umsatz OptIn
                + $finalArray['employees'][$key]['revenue_speedretention']; // + Umsatz Speedretention
            
            /** Berechnung des Umsatzdeltas */
            $finalArray['employees'][$key]['revenue_delta'] =   // Delta = Umsatz - Kosten
                $finalArray['employees'][$key]['revenue_sum']   // Summe aller Umsätze eines MA
                - $finalArray['employees'][$key]['pay_cost'];   // Kosten der Arbeitszeit (Stunden * 35,00€)
            
            /** Berechnung des Umsatz pro bezahlter Stunde */
            if($entry['work_hours'] > 0){                                               // Prüfen ob Produktivstunden vorhanden sind
                $finalArray['employees'][$key]['revenue_per_hour_paid'] =                   // Falls ja: Umsatz pro bezahlter Stunde berechne
                    $finalArray['employees'][$key]['revenue_sum']                                // Gesamten Umsatz eines MA nehmen
                    / $entry['work_hours'];                                                      // Diesen durch die bezahlten Stunden teilen
            } else {
                $finalArray['employees'][$key]['revenue_per_hour_paid'] = 0;                // Falls nein: Umsatz pro bezahlter Stunde auf 0 setzen
            }
            
            /** Berechnung des Umsatz pro Produktivstunde */
            if($entry['productive_hours'] > 0){                                         // Prüfen ob Produktivstunden vorhanden sind
                $finalArray['employees'][$key]['revenue_per_hour_productive'] =             // Falls ja: Umsatz pro Produktivstunde berechnen
                    $finalArray['employees'][$key]['revenue_sum']                               // Gesamten Umsatz eines MA nehmen
                    / $entry['productive_hours'];                                               // Diesen durch die Produktivstunden teilen
            } else {
                $finalArray['employees'][$key]['revenue_per_hour_productive'] = 0;          // Falls nein: Umsatz pro Produktivstunde auf 0 setzen
            }
        }

        //dd($finalArray);
        return $finalArray;
    }

    public function get1u1DslRetEmployees($defaultVariablesArray){
        /** Die Funktion 'get1u1DslRetEmployees()' erstellt zunächst ein Array aller relevanten Mitarbeiter anhand des KDW-Tools. 
         * Anschließend werden die Einträge um der Personen ID aus der lokalen Datenbank ergänzt.
         * Danach werden alle Relevanten Daten über Funktionsaufrufe in Variablen gespeichert.
         * Zuletzt wird jeder MA über eine Schleife mit allen Variablen abgegelichen und die passenden Einträge diesem zugeordnet.*/

        $employees = DB::connection('mysqlkdw')                                 // Verbindung zur externen Datenbank 'mysqlkdw' wird hergestellt
        ->table('MA')                                                           // Berücksichtigt werden soll die Tabelle 'MA'
        ->where(function($query) {                                              // Filter der zu berücksitgenden Funktionen    
            $query
            ->where('abteilung_id', '=', 10)                                    // Funktion: Agenten
            ->orWhere('abteilung_id', '=', 19);                                 // Funktion: Backoffice
        })
        ->where('projekt_id', '=', 10)                                          // Filter auf die Projekt ID. Hier ist DSL: 10
        ->where(function($query) use($defaultVariablesArray){                   // Prüfen, dass MA zum Zeitpunkt im Unternehmen beschäftigt war
            $query
            ->where('austritt', '=', null)                                      // Austritt soll entweder 'null' sein (also noch kein Austritt)
            ->orWhere('austritt', '>', $defaultVariablesArray['startDate']);})  // Oder Austritt soll nach dem Startdatum erfolgt sein
        ->where('eintritt', '<=', $defaultVariablesArray['endDate'])            // Eintritt soll vor dem Enddatum erfolgt sein
        ->get()                                                                 // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                            // Objekt wird in Array gewandelt

        $personList = DB::table('users')    // Eine weitere Userliste aus der internen Tabelle wird erstellt, um $employees mit 1u1 ID's zu ergänzen
        ->get()                             // Gesamte Tabelle wird geholt
        ->toArray();                        // Objekt wird in Array gewandelt

        $refinedPersonList = array();       // Leeres Array für die zusammengesetzte MA-Liste wird erzeugt

        $teamEmployees = $this->getTeamEmployees();

        /* In dieser Schleife wird das User-Array um die Personen IDs ergänzt */
        foreach($personList as $key => $person){                                                            // Schleife durchläuft die Personenlist
            $personArray = (array) $person;                                                                 // Der aktuelle Eintrag wird von Objekt zu Array konvertiert
            if($personArray['name'] != 'superuser'){                                                        // Superuser soll nicht berücksichtigt werden
              $refinedPersonList[$personArray['ds_id']]['ds_id'] = $personArray['ds_id'];                   // DS-ID wird dem User-Array hinzugefügt
              $refinedPersonList[$personArray['ds_id']]['person_id'] = $personArray['1u1_person_id'];       // Personen-ID wird dem User-Array hinzugefügt
              $refinedPersonList[$personArray['ds_id']]['cosmocom_id'] = $personArray['1u1_agent_id'];      // Cosmocom-ID wird dem User-Array hinzugefügt
            }
        }

        $kdwHours = $this->getKdwHours($defaultVariablesArray);                                             // KDW Stundenreport speichern
        $retDetailsData = $this->getRetDetails($defaultVariablesArray, 'Care4as Retention DSL Eggebek');    // Retention Details speichern
        $optinData = $this->getOptin($defaultVariablesArray, 'Care4as Retention DSL Eggebek');              // OptIn Report speichern
        $sasData = $this->getSas($defaultVariablesArray, 'RT_DSL');                                         // SAS Report speichern
        $dailyagentData = $this->getDailyAgent($defaultVariablesArray, 'DE_care4as_RT_DSL_Eggebek');        // Daily Agent speichern
        $speedRetentionData = $this->getSpeedRetention($defaultVariablesArray);                             // Speed Retention speichern

        $refinedEmployees = array();    // Ein neues Array wird angelegt, welches die finale MA-Liste beinhalten soll

        /* Dies ist die Hauptschleife. Hier wird für jeden MA eine Abfrage über alle Variablen erstell und die Daten zugeordnet*/
        foreach($employees as $key => $employee) {                                                      // Das MA-Array aus dem KDW Tool wird durchlaufen
            $employeeArray = (array) $employee;                                                         // Der aktuelle Eintrag wird von Objekt zu Array konvertiert
            $teamId = $teamEmployees->where('MA_id', $employeeArray['ds_id'])->sum('team_id');

            if($defaultVariablesArray['team'] == 'all' || $teamId == $defaultVariablesArray['team']){
            
                $refinedEmployees[$employeeArray['ds_id']]['lastname'] = $employeeArray['familienname'];    // User-Array wird um Nachname ergänzt
                $refinedEmployees[$employeeArray['ds_id']]['firstname'] = $employeeArray['vorname'];        // User-Array wird um Vorname ergänzt
                $refinedEmployees[$employeeArray['ds_id']]['full_name'] =                                   // User-Array wird um zusammengesetzten Namen ergänzt
                    $employeeArray['familienname'] . ', ' . $employeeArray['vorname'];                      // Zusammengesetzter Name ist 'Nachname, Vorname'
                $refinedEmployees[$employeeArray['ds_id']]['ds_id'] = $employeeArray['ds_id'];              // User-Array wird um ds-id ergänzt
                $refinedEmployees[$employeeArray['ds_id']]['fte'] = $employeeArray['soll_h_day'] / 8;
                $refinedEmployees[$employeeArray['ds_id']]['team_id'] = $teamEmployees->where('MA_id', $employeeArray['ds_id'])->sum('team_id');

                $refinedEmployees[$employeeArray['ds_id']]['work_hours'] = 0;                               // MA bez. Stunden werden initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['sick_hours'] = 0;                               // MA krank Stunden werden initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['break_hours'] = 0;                              // MA pausen Stunden werden initialisiert

                if(isset($refinedPersonList[$employeeArray['ds_id']]['person_id']) == true) {               // Prüfen ob Personen-ID gesetzt ist
                    $refinedEmployees[$employeeArray['ds_id']]['person_id'] =                               // Personen-ID in das finale User-Array übertragen
                        $refinedPersonList[$employeeArray['ds_id']]['person_id'];
                }

                if(isset($refinedPersonList[$employeeArray['ds_id']]['cosmocom_id']) == true) {             // Prüfen ob Personen-ID gesetzt ist
                    $refinedEmployees[$employeeArray['ds_id']]['cosmocom_id'] =                             // Cosmocom-ID in das finale User-Array übertragen
                        $refinedPersonList[$employeeArray['ds_id']]['cosmocom_id'];
                }

                /* Hier wird das User-array um die Stunden aus dem KDW Tool ergänzt */
                foreach($kdwHours as $key => $entry) {                                  // Das KDW-Array wird durchlaufen
                    if ($entry['MA_id'] == $employeeArray['ds_id']){                    // Wenn die 'MA_id' mit der ds_id matched wird fortgefahren
                        $refinedEmployees[$employeeArray['ds_id']]['work_hours']        // Die bez. Stunden werden um die Stunden des Eintrags erweitert
                            += $entry['work_hours'];
                        if($entry['state_id'] == 1){                                    // Wenn Status == 1 ist ein MA an diesem Tag krank
                            $refinedEmployees[$employeeArray['ds_id']]['sick_hours']    // In diesem Fall werden die Krank-Stunden erweitert
                                += $entry['work_hours'];
                        } else {
                            $refinedEmployees[$employeeArray['ds_id']]['break_hours']   // Wenn ein MA nicht krank ist, werden auch die Pausenstunden des Eintrags genommen
                                += $entry['pay_break_hours'];
                        }
                    }
                }

                $refinedEmployees[$employeeArray['ds_id']]['pay_cost'] =        // Hier werden die Kosten eines MA bestimmt (bez. Stunden * Kosten pro Stunde)
                    $refinedEmployees[$employeeArray['ds_id']]['work_hours']    // Hier die bezahlten Stunden
                    * $defaultVariablesArray['cost_per_hour_dsl'];              // * Kosten pro Stunde

                /* Hier werden die Kranken- und Pausenquote berechnet */
                if($refinedEmployees[$employeeArray['ds_id']]['work_hours'] > 0){       // Quoten sollen nur berechnet werden, wenn bez. Stunden vorhanden sind
                    $refinedEmployees[$employeeArray['ds_id']]['sick_percentage'] =     // Krankenquote berechnen (Krankstunden / bez. Stunden * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['sick_hours']       // Hier die Krankstunden
                        / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])     // / bez. Stunden
                        * 100;                                                          // * 100 um in Prozent auszugeben
                    $refinedEmployees[$employeeArray['ds_id']]['break_percentage'] =    // Pausenquote berechnen (Pausenstunden / bez. Stunden * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['break_hours']      // Hier die Pausenstunden
                        / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])     // / bez. Stunden
                        * 100;                                                          // * 100 um in Prozent auszugeben
                } else {                                                                // Falls keine Stunden vorhanden sind:
                    $refinedEmployees[$employeeArray['ds_id']]['sick_percentage'] = 0;  // Krankenquote auf 0 setzen
                    $refinedEmployees[$employeeArray['ds_id']]['break_percentage'] = 0; // Pausenquote auf 0 setzen
                }

                /** Hier werden die Produktivstunden aus dem Daily Agent genommen und die Produktivquote berechnet */
                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] = 0;         // Produktivstunden werden initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] = 0;
                $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_netto'] = 0;    // Produktvquote wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_brutto'] = 0;    // Produktvquote wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] = 0;     // Summe Zeit in Call (in Sek.) wird initialisiert

                if(isset($refinedEmployees[$employeeArray['ds_id']]['cosmocom_id']) == true){                                   // Es wird geprüft ob für den MA die Cosmocom-ID gesetzt ist
                    foreach($dailyagentData as $key => $entry){                                                                 // Dailyagent-Array wird durchlaufen
                        if($entry['agent_id'] == $refinedEmployees[$employeeArray['ds_id']]['cosmocom_id']){                    // Prüfen Cosmocom-ID vom Eintrag mit der des Users übereinstimmt
                            if($entry['status'] == 'Available') {                                                               // Prüfen ob Status von Eintrag == Available
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Ringing') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'In Call') {                                                                 // Prüfen ob Status von Eintrag == In Call
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden den Produktivstunden hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];  // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'On Hold') {                                                                 // Prüfen ob Status von Eintrag == On Hold
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden den Produktivstunden hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];  // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Wrap Up') {                                                                 // Prüfen ob Status von Eintrag == Wrap Up
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden den Produktivstunden hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];  // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Released (01_screen break)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (03_away)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (04_offline work)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (05_occupied)') {                                                             // Prüfen ob Status von Eintrag == 05_Occupied
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Released (06_practice)') {                                                             // Prüfen ob Status von Eintrag == 06_Practice
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Released (07_meeting)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (08_organization)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (09_outbound)') {                                                             // Prüfen ob Status von Eintrag == 09_Outbound
                                if($refinedEmployees[$employeeArray['ds_id']]['team_id'] == 90){
                                    $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                                }
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                        }
                    }
                    $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] =        // Hier werden die summierten Sekunden in Stunden umgeandelt
                        $refinedEmployees[$employeeArray['ds_id']]['productive_hours']      // Genommen werden die Produktivstunden (aktuell noch sekunden)
                            / 60                                                            // / 60 um in Minuten zu konvertieren
                            / 60;                                                           // / 60 um in Stunden zu konvertieren

                    $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] =        // Hier werden die summierten Sekunden in Stunden umgeandelt
                    $refinedEmployees[$employeeArray['ds_id']]['ccu_hours']      // Genommen werden die Produktivstunden (aktuell noch sekunden)
                        / 60                                                            // / 60 um in Minuten zu konvertieren
                        / 60;                                                           // / 60 um in Stunden zu konvertieren

                    /* Hier wird die Produktivquote berechnet */
                    if ($refinedEmployees[$employeeArray['ds_id']]['work_hours'] == 0){             // Prüfen ob bez. Stunden vorhanden sind
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_brutto'] = 0;    // Fall nein, wird die Produktivquote auf 0 gesetzt
                    } else {
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_brutto'] =       // Falls ja, wird die Produktivquote berechnet
                            ($refinedEmployees[$employeeArray['ds_id']]['productive_hours']         // Genommen werden die Produktivstunden
                            / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])             // und durch die bez. Stunden geteilt
                            * 100;                                                                  // mit 100 multipliert um Prozenz auszugeben
                    }

                    if ($refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] == 0){             
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_netto'] = 0;    
                    } else {
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_netto'] =      
                            ($refinedEmployees[$employeeArray['ds_id']]['productive_hours']       
                            / $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'])
                            * 100;                                                               
                    }
                    
                }

                /* Hier werden die Retention Details Daten verarbeitet, summiert und Quoten berechnet */
                $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] = 0;    // Summe DSL Calls wird initialisiert 
                $refinedEmployees[$employeeArray['ds_id']]['dsl_saves'] = 0;    // Summe DSL Saves wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['dsl_kuerue'] = 0;   // Summe DSL KüRüs wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['rlz_minus'] = 0;    // Summe Saves ohne RLZ+24 wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] = 0;     // Summe Sabes mit RLZ+24 wird initialisiert

                if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){                         // Prüfen ob Personen-ID gesetzt ist
                    foreach($retDetailsData as $key => $entry){                                                     // Retention Details Array wird durchlaufen
                        if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){         // Prüfen ob Personen-ID des Eintrags mit der des Users übereinstimmt
                            $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] += $entry['calls'];             // Summe DSL Calls wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['dsl_saves'] += $entry['orders'];            // Summe DSL Saves wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['dsl_kuerue'] += $entry['orders_kuerue'];    // Summe DSL KüRüs wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['rlz_minus'] += $entry['mvlzNeu'];           // Summe DSL Saves ohne RLZ+24 wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] += $entry['rlzPlus'];            // Summe DSL Saves mit RLZ+24 wird um die Anzahl aus Eintrag erweitert
                        }
                    }
                }

                /** Produktivstunden berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['productive_hours'] > 0){     // Prüfen ob MA Produktivstunden hat
                    $refinedEmployees[$employeeArray['ds_id']]['calls_per_hour'] =          // Calls pro Stunde berechnen
                        $refinedEmployees[$employeeArray['ds_id']]['dsl_calls']             // Calls nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['productive_hours'];   // Durch Produktivstunden teilen
                } else{
                    $refinedEmployees[$employeeArray['ds_id']]['calls_per_hour'] = 0;       // Wenn MA keine Produktivstunden hat werden Calls pro Stunde auf 0 gesetzt
                }

                /** AHT berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){            // Prüfen ob der MA Calls gemacht hat
                    $refinedEmployees[$employeeArray['ds_id']]['aht'] =                     // AHT berechnen (Zeit im Call / Anzahl Calls)
                        $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds']  // hier wird die Zeit im Call genommen
                        / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'];          // Durch die Anzahl der Calls geteilt
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['aht'] = 0;                  // Wenn keine Calls vorhanden sind wird die AHT auf 0 gesetzt
                }

                /** CR berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){            // Prüfen ob der MA Calls gemacht hat 
                    $refinedEmployees[$employeeArray['ds_id']]['dsl_cr'] =                  // DSL CR berechnen (Saves / Calls * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['dsl_saves']            // DSL Saves nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'])          // Diese durch die DSL Calls teilen
                        * 100;                                                              // Mit 100 multiplizeren um in Prozent zu wandeln
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['dsl_cr'] = 0;               // Wenn keine Calls vorhanden sind wird die CR auf 0 gesetzt
                }

                /** RLZ+24 Quote berechnen */
                if(($refinedEmployees[$employeeArray['ds_id']]['rlz_minus']                 // Prüfen ob die Summe von RLZ+24 mit und ohne > 0 ist 
                    + $refinedEmployees[$employeeArray['ds_id']]['rlz_plus']) > 0) {        
                        $refinedEmployees[$employeeArray['ds_id']]['rlz_plus_percentage'] = // RLZ+24 Quote berechnen ( RLZ+24 / (Rlz+24 mit und ohne) * 100)
                            ($refinedEmployees[$employeeArray['ds_id']]['rlz_plus']         // Summe RLZ+24 Saves nehmen
                            / ($refinedEmployees[$employeeArray['ds_id']]['rlz_plus']       // Teilen durch die Summe von RLZ+24 mit
                            + $refinedEmployees[$employeeArray['ds_id']]['rlz_minus']))     // und RLZ+24 ohne
                            * 100;                                                          // Mit 100 multiplizieren um in Prozent zu wandeln
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['rlz_plus_percentage'] = 0;  // Wenn keine Fälle mit RLZ bearbeitet wurden Quote auf 0 setzen
                }

                /** Umsatz durch Sales berechnen */
                $refinedEmployees[$employeeArray['ds_id']]['revenue_sales'] =               // Hier werden alle Umsätze zusammengezählt
                    $refinedEmployees[$employeeArray['ds_id']]['dsl_saves']                 // Summe der GeVo Saves
                    * $defaultVariablesArray['revenue_sale_dsl']                            // Multipliziert mit dem €-Wert für einen Save
                    + $refinedEmployees[$employeeArray['ds_id']]['dsl_kuerue']              // Summe der KüRüs
                    * $defaultVariablesArray['revenue_kuerue_dsl'];                             // Multipliziert mit dem €-Wert für eine KüRü

                /* Hier wird die Stückzahl an OptIn ermittelt und die Quoten berechnet */
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_email'] = 0;          // Anzahl OptIn Mail initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_print'] = 0;          // Anzahl OptIn Print initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_sms'] = 0;            // Anzahl OptIn SMS initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_call'] = 0;           // Anzahl OptIn Call initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_usage'] = 0;          // Anzahl OptIn Nutzungsdaten initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_traffic'] = 0;        // Anzahl OptIn Verkehrsdaten initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_sum_payed'] = 0;          // Summe bezahlte OptIn initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_calls_new'] = 0;          // Anzahl OptIn für Quote initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible'] = 0;     // Anzahl mögliche OptIn für Quote initialisieren

                /** Hier wird die Anzahl gemachter OptIn summiert */
                if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){
                    foreach($optinData as $key => $entry){
                        if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){
                            $refinedEmployees[$employeeArray['ds_id']]['optin_calls_new'] += $entry['Anzahl_OptIn-Erfolg'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible'] += max($entry['Anzahl_Handled_Calls_ohne_Call-OptIn'], $entry['Anzahl_Handled_Calls_ohne_Daten-OptIn']);
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_email'] += $entry['Anzahl_Email_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_print'] += $entry['Anzahl_Print_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_sms'] += $entry['Anzahl_SMS_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_call'] += $entry['Anzahl_Call_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_usage'] += $entry['Anzahl_Nutzungsdaten_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_traffic'] += $entry['Anzahl_Verkehrsdaten_OptIn'];
                        }
                    }
                    $refinedEmployees[$employeeArray['ds_id']]['optin_sum_payed'] =                 // Hier wird die Summe aller OptIn zusammengezählt
                        $refinedEmployees[$employeeArray['ds_id']]['optin_new_email']               // + OptIn Mail
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_print']             // + OptIn Print
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_sms']               // + OptIn SMS
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_call']              // + OptIn Call
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_usage']             // + OptIn Nutzungsdaten
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_traffic'];          // + OptIn Verkehrsdaten
                }

                /** OptIn Quote und mögliche OptIn Quote berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){                    // Prüfen ob DSL Calls gemacht wurden
                    $refinedEmployees[$employeeArray['ds_id']]['optin_percentage'] =                // OptIn Quote berechnen
                        ($refinedEmployees[$employeeArray['ds_id']]['optin_calls_new']              // Quotenrelevante OptIn nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'])                  // Durch die Calls teilen
                        * 100;                                                                      // Mit 100 multiplizieren um Prozent auszugeben
                    $refinedEmployees[$employeeArray['ds_id']]['optin_possible_percentage'] =       // Mögliche OptIn Qupte berechnen
                        ($refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible']         // Mögliche OptIn nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'])                  // Durch die Calls teilen
                        * 100;                                                                      // Mit 100 multiplizieren um Prozent auszugeben
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['optin_percentage'] = 0;             // Wenn keine Calls gemacht wurden OptIn Quote auf 0 setzen
                    $refinedEmployees[$employeeArray['ds_id']]['optin_possible_percentage'] = 0;    // Wenn keine Calls gemacht wurden mögliche OptIn Quote auf 0 setzen
                }

                /* Berechnung der SAS Anzahl und Quote */
                $refinedEmployees[$employeeArray['ds_id']]['sas_orders'] = 0;   // SAS Orders werden initzialisiert und auf 0 gesetzt

                if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){                 // Prüfen ob Personen ID gesetzt ist
                    foreach($sasData as $key => $entry){                                                    // Wenn Personen ID gesetzt ist, die SAS Daten durchlaufen
                        if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){ // Prüfen ob Personen ID des Eintrags mit aktuellem MA übereinstimmt
                            $refinedEmployees[$employeeArray['ds_id']]['sas_orders'] += 1;                  // Anzahl SAS Orders um 1 erhöhen
                        }
                    }
                }

                if($refinedEmployees[$employeeArray['ds_id']]['dsl_calls'] > 0){        // Prüfen ob Calls vorhanden sind
                    $refinedEmployees[$employeeArray['ds_id']]['sas_promille'] =        // SAS = SAS Orders / DSL Calls
                        ($refinedEmployees[$employeeArray['ds_id']]['sas_orders']       // Zugriff auf SAS Orders des ausgewählten MA
                        / $refinedEmployees[$employeeArray['ds_id']]['dsl_calls'])      // Zugriff auf DSL Calls des ausgewählten MA
                        * 1000;                                                         // Ergebnis wird mit 1000 multipliziert, um Promille auszugeben
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['sas_promille'] = 0;     // Wenn keine Calls vorhanden sind Wert auf 0 setzen
                }

                /** Speedretention berechnen */
                $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention'] = 0;         // Stunden Speedretention initialisieren
                $employeeSpeedRetentionArray = $speedRetentionData;                             // Hier wird ein Array erstellt, in das die für den MA relevanten Daten aus dem speedRetentionArray gespeichert werden.
                foreach($employeeSpeedRetentionArray as $key => $entry) {                       // Gesamtes speedRetentionArray durchlaufen
                    if($entry['MA_id'] != $refinedEmployees[$employeeArray['ds_id']]['ds_id']){ // Prüfen ob ds_id des Eintrags mit der des MA übereinstimmt
                        unset($employeeSpeedRetentionArray[$key]);                              // Wenn dies nicht der Fall ist Eintrag entfernen
                    }
                }

                $speedretentionStartTime = 0;   // Variable Startzeit initialisieren
                $speedretentionEndTime = 0;     // Variable Endzeit initialisieren
                $isOnSpeedretention = false;    // Boolean ist in Status initialisieren

                foreach($employeeSpeedRetentionArray as $key => $entry){                        // Schleife über alle Einträge MA Speedretention Arrays
                    if($isOnSpeedretention == false){                                           // Prüfen ob aktuell nicht im Status Speedretention
                        if($entry['acd_state_id'] == 41){                                       // Prüfen ob Status die ID 41 hat (Speedretention)
                            $speedretentionStartTime =                                          // Wenn dies der Fall ist Startzeit seiten
                            date_create_from_format('Y-m-d H:i:s', $entry['book_date']          // Dazu ein Datum aus book_date und book_time erstellen
                            . ' ' . 
                            $entry['book_time'])
                            ->format('U');                                                      // Dieses in UNIX formatieren
                            $isOnSpeedretention = true;                                         // In Status auf true setzen
                        }
                    }
                    else if($isOnSpeedretention == true){                                       // Prüfen ob aktuell im Status Speedretention ist, um Endwert zu finden
                        if($entry['acd_state_id'] != 41){                                       // Prüfen ob Status ungleich 41 ist
                            $speedretentionEndTime = 
                            date_create_from_format('Y-m-d H:i:s', $entry['book_date']          // Dazu ein Datum aus book_date und book_time erstellen
                            . ' ' . 
                            $entry['book_time'])
                            ->format('U');                                                      // Dieses in UNIX formatieren
                            $isOnSpeedretention = false;                                        // In Status auf false setzen
                            $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention']  // Zeit in Status um Differenz zwischen Start- und Endwert ergänzen
                                += ($speedretentionEndTime - $speedretentionStartTime);         // Endzeit - Startzeit = Differenz
                        }
                    }
                }

                if($refinedEmployees[$employeeArray['ds_id']]['hours_speedretention'] > 0){     // Wenn Zeit auf Speedretention > 0 ist, Zeit von Sekunden in Stunden ändern
                    $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention'] = 
                        $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention']      // Sekunden in Status nehmen
                        / 60                                                                    // In Minuten wandeln
                        / 60;                                                                   // In Stunden wandeln
                }
            }

        }
        asort($refinedEmployees);   // Das gesamte Personenarray wird alphabetisch sortiert. Ausgangspunkt ist der erste Eintrag (Nachname)

        return $refinedEmployees;   // Rückgabe des befüllten Personenarrays
    }

    public function get1u1MobileRetEmployees($defaultVariablesArray){
        /** Die Funktion 'get1u1DslRetEmployees()' erstellt zunächst ein Array aller relevanten Mitarbeiter anhand des KDW-Tools. 
         * Anschließend werden die Einträge um der Personen ID aus der lokalen Datenbank ergänzt.
         * Danach werden alle Relevanten Daten über Funktionsaufrufe in Variablen gespeichert.
         * Zuletzt wird jeder MA über eine Schleife mit allen Variablen abgegelichen und die passenden Einträge diesem zugeordnet.*/

        $employees = DB::connection('mysqlkdw')                                 // Verbindung zur externen Datenbank 'mysqlkdw' wird hergestellt
        ->table('MA')                                                           // Berücksichtigt werden soll die Tabelle 'MA'
        ->where(function($query) {                                              // Filter der zu berücksitgenden Funktionen    
            $query
            ->where('abteilung_id', '=', 10)                                    // Funktion: Agenten
            ->orWhere('abteilung_id', '=', 19);                                 // Funktion: Backoffice
        })
        ->where('projekt_id', '=', 7)                                          // Filter auf die Projekt ID. Hier ist Mobile: 7
        ->where(function($query) use($defaultVariablesArray){                   // Prüfen, dass MA zum Zeitpunkt im Unternehmen beschäftigt war
            $query
            ->where('austritt', '=', null)                                      // Austritt soll entweder 'null' sein (also noch kein Austritt)
            ->orWhere('austritt', '>', $defaultVariablesArray['startDate']);})  // Oder Austritt soll nach dem Startdatum erfolgt sein
        ->where('eintritt', '<=', $defaultVariablesArray['endDate'])            // Eintritt soll vor dem Enddatum erfolgt sein
        ->get()                                                                 // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                            // Objekt wird in Array gewandelt

        $personList = DB::table('users')    // Eine weitere Userliste aus der internen Tabelle wird erstellt, um $employees mit 1u1 ID's zu ergänzen
        ->get()                             // Gesamte Tabelle wird geholt
        ->toArray();                        // Objekt wird in Array gewandelt

        $refinedPersonList = array();       // Leeres Array für die zusammengesetzte MA-Liste wird erzeugt

        /* In dieser Schleife wird das User-Array um die Personen IDs ergänzt */
        foreach($personList as $key => $person){                                                            // Schleife durchläuft die Personenlist
            $personArray = (array) $person;                                                                 // Der aktuelle Eintrag wird von Objekt zu Array konvertiert
            if($personArray['name'] != 'superuser'){                                                        // Superuser soll nicht berücksichtigt werden
              $refinedPersonList[$personArray['ds_id']]['ds_id'] = $personArray['ds_id'];                   // DS-ID wird dem User-Array hinzugefügt
              $refinedPersonList[$personArray['ds_id']]['person_id'] = $personArray['1u1_person_id'];       // Personen-ID wird dem User-Array hinzugefügt
              $refinedPersonList[$personArray['ds_id']]['cosmocom_id'] = $personArray['1u1_agent_id'];      // Cosmocom-ID wird dem User-Array hinzugefügt
            }
        }


        /** ACHTUNG: Beim Wechsel von Mobile komplett zur Care4as müssen hier ggf. Änderungen vorgenommen werden! */
        $kdwHours = $this->getKdwHours($defaultVariablesArray);                                                         // KDW Stundenreport speichern
        $retDetailsData = $this->getRetDetails($defaultVariablesArray, 'KDW Retention Mobile Flensburg');               // Retention Details speichern
        $optinData = $this->getOptin($defaultVariablesArray, 'KDW Retention Mobile Flensburg');                         // OptIn Report speichern
        $sasData = $this->getSas($defaultVariablesArray, 'RT_Mobile');                                                  // SAS Report speichern
        $dailyagentData = $this->getDailyAgent($defaultVariablesArray, 'DE_KDW_Retention_Mobile_Flensburg');            // Daily Agent speichern
        $speedRetentionData = $this->getSpeedRetention($defaultVariablesArray);                                         // Speed Retention speichern
        $teamEmployees = $this->getTeamEmployees();

        $refinedEmployees = array();    // Ein neues Array wird angelegt, welches die finale MA-Liste beinhalten soll

        /* Dies ist die Hauptschleife. Hier wird für jeden MA eine Abfrage über alle Variablen erstell und die Daten zugeordnet*/
        foreach($employees as $key => $employee) {                                                      // Das MA-Array aus dem KDW Tool wird durchlaufen
            $employeeArray = (array) $employee;                                                         // Der aktuelle Eintrag wird von Objekt zu Array konvertiert
            $teamId = $teamEmployees->where('MA_id', $employeeArray['ds_id'])->sum('team_id');

            if($defaultVariablesArray['team'] == 'all' || $teamId == $defaultVariablesArray['team']){

                $refinedEmployees[$employeeArray['ds_id']]['lastname'] = $employeeArray['familienname'];    // User-Array wird um Nachname ergänzt
                $refinedEmployees[$employeeArray['ds_id']]['firstname'] = $employeeArray['vorname'];        // User-Array wird um Vorname ergänzt
                $refinedEmployees[$employeeArray['ds_id']]['full_name'] =                                   // User-Array wird um zusammengesetzten Namen ergänzt
                    $employeeArray['familienname'] . ', ' . $employeeArray['vorname'];                      // Zusammengesetzter Name ist 'Nachname, Vorname'
                $refinedEmployees[$employeeArray['ds_id']]['fte'] = $employeeArray['soll_h_day'] / 8;
                $refinedEmployees[$employeeArray['ds_id']]['ds_id'] = $employeeArray['ds_id'];              // User-Array wird um ds-id ergänzt
                $refinedEmployees[$employeeArray['ds_id']]['team_id'] = $teamEmployees->where('MA_id', $employeeArray['ds_id'])->sum('team_id');
                $refinedEmployees[$employeeArray['ds_id']]['work_hours'] = 0;                               // MA bez. Stunden werden initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['sick_hours'] = 0;                               // MA krank Stunden werden initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['break_hours'] = 0;                              // MA pausen Stunden werden initialisiert

                if(isset($refinedPersonList[$employeeArray['ds_id']]['person_id']) == true) {               // Prüfen ob Personen-ID gesetzt ist
                    $refinedEmployees[$employeeArray['ds_id']]['person_id'] =                               // Personen-ID in das finale User-Array übertragen
                        $refinedPersonList[$employeeArray['ds_id']]['person_id'];
                }

                if(isset($refinedPersonList[$employeeArray['ds_id']]['cosmocom_id']) == true) {             // Prüfen ob Personen-ID gesetzt ist
                    $refinedEmployees[$employeeArray['ds_id']]['cosmocom_id'] =                             // Cosmocom-ID in das finale User-Array übertragen
                        $refinedPersonList[$employeeArray['ds_id']]['cosmocom_id'];
                }

                /* Hier wird das User-array um die Stunden aus dem KDW Tool ergänzt */
                foreach($kdwHours as $key => $entry) {                                  // Das KDW-Array wird durchlaufen
                    if ($entry['MA_id'] == $employeeArray['ds_id']){                    // Wenn die 'MA_id' mit der ds_id matched wird fortgefahren
                        $refinedEmployees[$employeeArray['ds_id']]['work_hours']        // Die bez. Stunden werden um die Stunden des Eintrags erweitert
                            += $entry['work_hours'];
                        if($entry['state_id'] == 1){                                    // Wenn Status == 1 ist ein MA an diesem Tag krank
                            $refinedEmployees[$employeeArray['ds_id']]['sick_hours']    // In diesem Fall werden die Krank-Stunden erweitert
                                += $entry['work_hours'];
                        } else {
                            $refinedEmployees[$employeeArray['ds_id']]['break_hours']   // Wenn ein MA nicht krank ist, werden auch die Pausenstunden des Eintrags genommen
                                += $entry['pay_break_hours'];
                        }
                    }
                }

                $refinedEmployees[$employeeArray['ds_id']]['pay_cost'] =        // Hier werden die Kosten eines MA bestimmt (bez. Stunden * Kosten pro Stunde)
                    $refinedEmployees[$employeeArray['ds_id']]['work_hours']    // Hier die bezahlten Stunden
                    * $defaultVariablesArray['cost_per_hour_mobile'];           // * Kosten pro Stunde

                /* Hier werden die Kranken- und Pausenquote berechnet */
                if($refinedEmployees[$employeeArray['ds_id']]['work_hours'] > 0){       // Quoten sollen nur berechnet werden, wenn bez. Stunden vorhanden sind
                    $refinedEmployees[$employeeArray['ds_id']]['sick_percentage'] =     // Krankenquote berechnen (Krankstunden / bez. Stunden * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['sick_hours']       // Hier die Krankstunden
                        / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])     // / bez. Stunden
                        * 100;                                                          // * 100 um in Prozent auszugeben
                    $refinedEmployees[$employeeArray['ds_id']]['break_percentage'] =    // Pausenquote berechnen (Pausenstunden / bez. Stunden * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['break_hours']      // Hier die Pausenstunden
                        / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])     // / bez. Stunden
                        * 100;                                                          // * 100 um in Prozent auszugeben
                } else {                                                                // Falls keine Stunden vorhanden sind:
                    $refinedEmployees[$employeeArray['ds_id']]['sick_percentage'] = 0;  // Krankenquote auf 0 setzen
                    $refinedEmployees[$employeeArray['ds_id']]['break_percentage'] = 0; // Pausenquote auf 0 setzen
                }

                /** Hier werden die Produktivstunden aus dem Daily Agent genommen und die Produktivquote berechnet */
                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] = 0;         // Produktivstunden werden initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] = 0;
                $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_netto'] = 0;    // Produktvquote wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_brutto'] = 0;    // Produktvquote wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] = 0;     // Summe Zeit in Call (in Sek.) wird initialisiert

                if(isset($refinedEmployees[$employeeArray['ds_id']]['cosmocom_id']) == true){                                   // Es wird geprüft ob für den MA die Cosmocom-ID gesetzt ist
                    foreach($dailyagentData as $key => $entry){                                                                 // Dailyagent-Array wird durchlaufen
                        if($entry['agent_id'] == $refinedEmployees[$employeeArray['ds_id']]['cosmocom_id']){                    // Prüfen Cosmocom-ID vom Eintrag mit der des Users übereinstimmt
                            if($entry['status'] == 'Available') {                                                               // Prüfen ob Status von Eintrag == Available
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Ringing') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'In Call') {                                                                 // Prüfen ob Status von Eintrag == In Call
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden den Produktivstunden hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];  // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'On Hold') {                                                                 // Prüfen ob Status von Eintrag == On Hold
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden den Produktivstunden hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];  // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Wrap Up') {                                                                 // Prüfen ob Status von Eintrag == Wrap Up
                                $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];      // Sekunden werden den Produktivstunden hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds'] += $entry['time_in_state'];  // Sekunden werden der Zeit im Call hinzugefügt
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Released (01_screen break)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (03_away)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (04_offline work)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (05_occupied)') {                                                             // Prüfen ob Status von Eintrag == 05_Occupied
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Released (06_practice)') {                                                             // Prüfen ob Status von Eintrag == 06_Practice
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                            if($entry['status'] == 'Released (07_meeting)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (08_organization)') {                                                               
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];     
                            }
                            if($entry['status'] == 'Released (09_outbound)') {                                                             // Prüfen ob Status von Eintrag == 09_Outbound
                                if($refinedEmployees[$employeeArray['ds_id']]['team_id'] == 89){
                                    $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] += $entry['time_in_state'];
                                }
                                $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] += $entry['time_in_state'];   
                            }
                        }
                    }
                    $refinedEmployees[$employeeArray['ds_id']]['productive_hours'] =        // Hier werden die summierten Sekunden in Stunden umgeandelt
                        $refinedEmployees[$employeeArray['ds_id']]['productive_hours']      // Genommen werden die Produktivstunden (aktuell noch sekunden)
                            / 60                                                            // / 60 um in Minuten zu konvertieren
                            / 60;                                                           // / 60 um in Stunden zu konvertieren

                    $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] =        // Hier werden die summierten Sekunden in Stunden umgeandelt
                    $refinedEmployees[$employeeArray['ds_id']]['ccu_hours']      // Genommen werden die Produktivstunden (aktuell noch sekunden)
                        / 60                                                            // / 60 um in Minuten zu konvertieren
                        / 60;                                                           // / 60 um in Stunden zu konvertieren

                    /* Hier wird die Produktivquote berechnet */
                    if ($refinedEmployees[$employeeArray['ds_id']]['work_hours'] == 0){             // Prüfen ob bez. Stunden vorhanden sind
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_brutto'] = 0;    // Fall nein, wird die Produktivquote auf 0 gesetzt
                    } else {
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_brutto'] =       // Falls ja, wird die Produktivquote berechnet
                            ($refinedEmployees[$employeeArray['ds_id']]['productive_hours']         // Genommen werden die Produktivstunden
                            / $refinedEmployees[$employeeArray['ds_id']]['work_hours'])             // und durch die bez. Stunden geteilt
                            * 100;                                                                  // mit 100 multipliert um Prozenz auszugeben
                    }

                    if ($refinedEmployees[$employeeArray['ds_id']]['ccu_hours'] == 0){             
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_netto'] = 0;    
                    } else {
                        $refinedEmployees[$employeeArray['ds_id']]['productive_percentage_netto'] =      
                            ($refinedEmployees[$employeeArray['ds_id']]['productive_hours']       
                            / $refinedEmployees[$employeeArray['ds_id']]['ccu_hours'])
                            * 100;                                                               
                    }
                    
                }

                $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'] = 0;     // Summe Mobile Calls wird initialisiert 
                $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_ssc'] = 0;     // Summe Mobile Calls SSC wird initialisiert 
                $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_bsc'] = 0;     // Summe Mobile Calls BSC wird initialisiert 
                $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_portale'] = 0; // Summe Mobile Calls Portal wird initialisiert 
                $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_sum'] = 0;     // Summe Mobile Saves wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_ssc'] = 0;     // Summe Mobile Saves SSC wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_bsc'] = 0;     // Summe Mobile Saves BSC wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_portale'] = 0; // Summe Mobile Saves Portal wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['mobile_kuerue'] = 0;        // Summe Mobile KüRüs wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['rlz_minus'] = 0;            // Summe Saves ohne RLZ+24 wird initialisiert
                $refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] = 0;             // Summe Sabes mit RLZ+24 wird initialisiert

                if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){                                     // Prüfen ob Personen-ID gesetzt ist
                    foreach($retDetailsData as $key => $entry){                                                                 // Retention Details Array wird durchlaufen
                        if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){                     // Prüfen ob Personen-ID des Eintrags mit der des Users übereinstimmt
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'] += $entry['calls'];                  // Summe Mobile Calls wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_ssc'] += $entry['calls_smallscreen'];      // Summe Mobile Calls SSC wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_bsc'] += $entry['calls_bigscreen'];        // Summe Mobile Calls BSC wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_portale'] += $entry['calls_portale'];      // Summe Mobile Calls Portal wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_sum'] += $entry['orders'];                 // Summe Mobile Saves wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_ssc'] += $entry['orders_smallscreen'];     // Summe Mobile Saves SSC wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_bsc'] += $entry['orders_bigscreen'];       // Summe Mobile Saves BSC wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_portale'] += $entry['orders_portale'];     // Summe Mobile Saves Portal wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['mobile_kuerue'] += $entry['orders_kuerue'];             // Summe Mobile KüRüs wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['rlz_minus'] += $entry['mvlzNeu'];                       // Summe Mobile Saves ohne RLZ+24 wird um die Anzahl aus Eintrag erweitert
                            $refinedEmployees[$employeeArray['ds_id']]['rlz_plus'] += $entry['rlzPlus'];                        // Summe Mobile Saves mit RLZ+24 wird um die Anzahl aus Eintrag erweitert
                        }
                    }
                }

                /** Produktivstunden berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['productive_hours'] > 0){         // Prüfen ob MA Produktivstunden hat
                    $refinedEmployees[$employeeArray['ds_id']]['calls_per_hour'] =              // Calls pro Stunde berechnen
                        $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum']          // Calls nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['productive_hours'];       // Durch Produktivstunden teilen
                } else{
                    $refinedEmployees[$employeeArray['ds_id']]['calls_per_hour'] = 0;           // Wenn MA keine Produktivstunden hat werden Calls pro Stunde auf 0 gesetzt
                }

                /** AHT berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'] > 0){         // Prüfen ob der MA Calls gemacht hat
                    $refinedEmployees[$employeeArray['ds_id']]['aht'] =                         // AHT berechnen (Zeit im Call / Anzahl Calls)
                        $refinedEmployees[$employeeArray['ds_id']]['time_in_call_seconds']      // hier wird die Zeit im Call genommen
                        / $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'];       // Durch die Anzahl der Calls geteilt
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['aht'] = 0;                      // Wenn keine Calls vorhanden sind wird die AHT auf 0 gesetzt
                }

                /** SSC CR berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['mobile_calls_ssc'] > 0){         // Prüfen ob der MA Calls gemacht hat 
                    $refinedEmployees[$employeeArray['ds_id']]['mobile_cr_ssc'] =               // CR berechnen (Saves / Calls * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['mobile_saves_ssc']         // Saves nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_ssc'])       // Diese durch die Calls teilen
                        * 100;                                                                  // Mit 100 multiplizeren um in Prozent zu wandeln
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['mobile_cr_ssc'] = 0;            // Wenn keine Calls vorhanden sind wird die CR auf 0 gesetzt
                }

                /** BSC CR berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['mobile_calls_bsc'] > 0){         // Prüfen ob der MA Calls gemacht hat 
                    $refinedEmployees[$employeeArray['ds_id']]['mobile_cr_bsc'] =               // CR berechnen (Saves / Calls * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['mobile_saves_bsc']         // Saves nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_bsc'])       // Diese durch die Calls teilen
                        * 100;                                                                  // Mit 100 multiplizeren um in Prozent zu wandeln
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['mobile_cr_bsc'] = 0;            // Wenn keine Calls vorhanden sind wird die CR auf 0 gesetzt
                }

                /** Portal CR berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['mobile_calls_portale'] > 0){     // Prüfen ob der MA Calls gemacht hat 
                    $refinedEmployees[$employeeArray['ds_id']]['mobile_cr_portale'] =           // CR berechnen (Saves / Calls * 100)
                        ($refinedEmployees[$employeeArray['ds_id']]['mobile_saves_portale']     // Saves nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_portale'])   // Diese durch die Calls teilen
                        * 100;                                                                  // Mit 100 multiplizeren um in Prozent zu wandeln
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['mobile_cr_portale'] = 0;        // Wenn keine Calls vorhanden sind wird die CR auf 0 gesetzt
                }

                /** RLZ+24 Quote berechnen */
                if(($refinedEmployees[$employeeArray['ds_id']]['rlz_minus']                 // Prüfen ob die Summe von RLZ+24 mit und ohne > 0 ist 
                    + $refinedEmployees[$employeeArray['ds_id']]['rlz_plus']) > 0) {        
                        $refinedEmployees[$employeeArray['ds_id']]['rlz_plus_percentage'] = // RLZ+24 Quote berechnen ( RLZ+24 / (Rlz+24 mit und ohne) * 100)
                            ($refinedEmployees[$employeeArray['ds_id']]['rlz_plus']         // Summe RLZ+24 Saves nehmen
                            / ($refinedEmployees[$employeeArray['ds_id']]['rlz_plus']       // Teilen durch die Summe von RLZ+24 mit
                            + $refinedEmployees[$employeeArray['ds_id']]['rlz_minus']))     // und RLZ+24 ohne
                            * 100;                                                          // Mit 100 multiplizieren um in Prozent zu wandeln
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['rlz_plus_percentage'] = 0;  // Wenn keine Fälle mit RLZ bearbeitet wurden Quote auf 0 setzen
                }

                /** Umsatz durch Sales berechnen */
                $refinedEmployees[$employeeArray['ds_id']]['revenue_sales'] =               // Hier werden alle Umsätze zusammengezählt
                    $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_ssc']          // Summe der SSC GeVo Saves
                    * $defaultVariablesArray['revenue_sale_mobile_ssc']                     // Multipliziert mit dem €-Wert für einen SSC Save
                    + $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_portale']    // Summe der Portale GeVo Saves
                    * $defaultVariablesArray['revenue_sale_mobile_ssc']                     // Multipliziert mit dem €-Wert für einen SSC Save
                    + $refinedEmployees[$employeeArray['ds_id']]['mobile_saves_bsc']        // Summe der BSC GeVo Saves
                    * $defaultVariablesArray['revenue_sale_mobile_bsc']                     // Multipliziert mit dem €-Wert für einen SSC Save
                    + $refinedEmployees[$employeeArray['ds_id']]['mobile_kuerue']           // Summe der KüRüs
                    * $defaultVariablesArray['revenue_kuerue_mobile'];                      // Multipliziert mit dem €-Wert für eine KüRü

                /* Hier wird die Stückzahl an OptIn ermittelt und die Quoten berechnet */
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_email'] = 0;          // Anzahl OptIn Mail initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_print'] = 0;          // Anzahl OptIn Print initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_sms'] = 0;            // Anzahl OptIn SMS initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_call'] = 0;           // Anzahl OptIn Call initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_usage'] = 0;          // Anzahl OptIn Nutzungsdaten initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_new_traffic'] = 0;        // Anzahl OptIn Verkehrsdaten initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_sum_payed'] = 0;          // Summe bezahlte OptIn initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_calls_new'] = 0;          // Anzahl OptIn für Quote initialisieren
                $refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible'] = 0;     // Anzahl mögliche OptIn für Quote initialisieren

                /** Hier wird die Anzahl gemachter OptIn summiert */
                if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){
                    foreach($optinData as $key => $entry){
                        if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){
                            $refinedEmployees[$employeeArray['ds_id']]['optin_calls_new'] += $entry['Anzahl_OptIn-Erfolg'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible'] += max($entry['Anzahl_Handled_Calls_ohne_Call-OptIn'], $entry['Anzahl_Handled_Calls_ohne_Daten-OptIn']);
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_email'] += $entry['Anzahl_Email_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_print'] += $entry['Anzahl_Print_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_sms'] += $entry['Anzahl_SMS_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_call'] += $entry['Anzahl_Call_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_usage'] += $entry['Anzahl_Nutzungsdaten_OptIn'];
                            $refinedEmployees[$employeeArray['ds_id']]['optin_new_traffic'] += $entry['Anzahl_Verkehrsdaten_OptIn'];
                        }
                    }
                    $refinedEmployees[$employeeArray['ds_id']]['optin_sum_payed'] =                 // Hier wird die Summe aller OptIn zusammengezählt
                        $refinedEmployees[$employeeArray['ds_id']]['optin_new_email']               // + OptIn Mail
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_print']             // + OptIn Print
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_sms']               // + OptIn SMS
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_call']              // + OptIn Call
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_usage']             // + OptIn Nutzungsdaten
                        + $refinedEmployees[$employeeArray['ds_id']]['optin_new_traffic'];          // + OptIn Verkehrsdaten
                }

                /** OptIn Quote und mögliche OptIn Quote berechnen */
                if($refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'] > 0){             // Prüfen ob Mobile Calls gemacht wurden
                    $refinedEmployees[$employeeArray['ds_id']]['optin_percentage'] =                // OptIn Quote berechnen
                        ($refinedEmployees[$employeeArray['ds_id']]['optin_calls_new']              // Quotenrelevante OptIn nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'])           // Durch die Calls teilen
                        * 100;                                                                      // Mit 100 multiplizieren um Prozent auszugeben
                    $refinedEmployees[$employeeArray['ds_id']]['optin_possible_percentage'] =       // Mögliche OptIn Qupte berechnen
                        ($refinedEmployees[$employeeArray['ds_id']]['optin_calls_possible']         // Mögliche OptIn nehmen
                        / $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'])           // Durch die Calls teilen
                        * 100;                                                                      // Mit 100 multiplizieren um Prozent auszugeben
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['optin_percentage'] = 0;             // Wenn keine Calls gemacht wurden OptIn Quote auf 0 setzen
                    $refinedEmployees[$employeeArray['ds_id']]['optin_possible_percentage'] = 0;    // Wenn keine Calls gemacht wurden mögliche OptIn Quote auf 0 setzen
                }

                /* Berechnung der SAS Anzahl und Quote */
                $refinedEmployees[$employeeArray['ds_id']]['sas_orders'] = 0;   // SAS Orders werden initzialisiert und auf 0 gesetzt

                if(isset($refinedEmployees[$employeeArray['ds_id']]['person_id']) == true){                 // Prüfen ob Personen ID gesetzt ist
                    foreach($sasData as $key => $entry){                                                    // Wenn Personen ID gesetzt ist, die SAS Daten durchlaufen
                        if($entry['person_id'] == $refinedEmployees[$employeeArray['ds_id']]['person_id']){ // Prüfen ob Personen ID des Eintrags mit aktuellem MA übereinstimmt
                            $refinedEmployees[$employeeArray['ds_id']]['sas_orders'] += 1;                  // Anzahl SAS Orders um 1 erhöhen
                        }
                    }
                }

                if($refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'] > 0){     // Prüfen ob Calls vorhanden sind
                    $refinedEmployees[$employeeArray['ds_id']]['sas_promille'] =            // SAS = SAS Orders / DSL Calls
                        ($refinedEmployees[$employeeArray['ds_id']]['sas_orders']           // Zugriff auf SAS Orders des ausgewählten MA
                        / $refinedEmployees[$employeeArray['ds_id']]['mobile_calls_sum'])   // Zugriff auf DSL Calls des ausgewählten MA
                        * 1000;                                                             // Ergebnis wird mit 1000 multipliziert, um Promille auszugeben
                } else {
                    $refinedEmployees[$employeeArray['ds_id']]['sas_promille'] = 0;         // Wenn keine Calls vorhanden sind Wert auf 0 setzen
                }

                /** Speedretention berechnen */
                $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention'] = 0;         // Stunden Speedretention initialisieren
                $employeeSpeedRetentionArray = $speedRetentionData;                             // Hier wird ein Array erstellt, in das die für den MA relevanten Daten aus dem speedRetentionArray gespeichert werden.
                foreach($employeeSpeedRetentionArray as $key => $entry) {                       // Gesamtes speedRetentionArray durchlaufen
                    if($entry['MA_id'] != $refinedEmployees[$employeeArray['ds_id']]['ds_id']){ // Prüfen ob ds_id des Eintrags mit der des MA übereinstimmt
                        unset($employeeSpeedRetentionArray[$key]);                              // Wenn dies nicht der Fall ist Eintrag entfernen
                    }
                }

                $speedretentionStartTime = 0;   // Variable Startzeit initialisieren
                $speedretentionEndTime = 0;     // Variable Endzeit initialisieren
                $isOnSpeedretention = false;    // Boolean ist in Status initialisieren

                foreach($employeeSpeedRetentionArray as $key => $entry){                        // Schleife über alle Einträge MA Speedretention Arrays
                    if($isOnSpeedretention == false){                                           // Prüfen ob aktuell nicht im Status Speedretention
                        if($entry['acd_state_id'] == 41){                                       // Prüfen ob Status die ID 41 hat (Speedretention)
                            $speedretentionStartTime =                                          // Wenn dies der Fall ist Startzeit seiten
                            date_create_from_format('Y-m-d H:i:s', $entry['book_date']          // Dazu ein Datum aus book_date und book_time erstellen
                            . ' ' . 
                            $entry['book_time'])
                            ->format('U');                                                      // Dieses in UNIX formatieren
                            $isOnSpeedretention = true;                                         // In Status auf true setzen
                        }
                    }
                    else if($isOnSpeedretention == true){                                       // Prüfen ob aktuell im Status Speedretention ist, um Endwert zu finden
                        if($entry['acd_state_id'] != 41){                                       // Prüfen ob Status ungleich 41 ist
                            $speedretentionEndTime = 
                            date_create_from_format('Y-m-d H:i:s', $entry['book_date']          // Dazu ein Datum aus book_date und book_time erstellen
                            . ' ' . 
                            $entry['book_time'])
                            ->format('U');                                                      // Dieses in UNIX formatieren
                            $isOnSpeedretention = false;                                        // In Status auf false setzen
                            $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention']  // Zeit in Status um Differenz zwischen Start- und Endwert ergänzen
                                += ($speedretentionEndTime - $speedretentionStartTime);         // Endzeit - Startzeit = Differenz
                        }
                    }
                }

                if($refinedEmployees[$employeeArray['ds_id']]['hours_speedretention'] > 0){     // Wenn Zeit auf Speedretention > 0 ist, Zeit von Sekunden in Stunden ändern
                    $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention'] = 
                        $refinedEmployees[$employeeArray['ds_id']]['hours_speedretention']      // Sekunden in Status nehmen
                        / 60                                                                    // In Minuten wandeln
                        / 60;                                                                   // In Stunden wandeln
                }
            }
        }

        asort($refinedEmployees);   // Das gesamte Personenarray wird alphabetisch sortiert. Ausgangspunkt ist der erste Eintrag (Nachname)

        return $refinedEmployees;   // Rückgabe des befüllten Personenarrays
    }

    public function getKdwHours($defaultVariablesArray){
        /** Diese Funktion greift auf die KDW-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen. 
         * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */

        $hours =  DB::connection('mysqlkdw')                            // Verbindung zur externen Datenbanl 'mysqlkdw' wird hergestellt
        ->table("chronology_work")                                      // Aus der Datenbank soll auf die Tabelle 'chronology_work' zugegriffen werden
        ->where('work_date', '>=', $defaultVariablesArray['startDate']) // Datum muss größergleich dem Startdatum sein
        ->where('work_date', '<=', $defaultVariablesArray['endDate'])   // Datum muss kleinergleich dem Enddatum sein
        ->where(function($query){                                       // Unbezahlte Status sollen nicht berücksichtigt werden
            $query
            ->where('state_id', null)                                   // Status 'null' soll berücksichtigt werden (häufigster Eintrag)
            ->orWhereNotIn('state_id', array(13, 15, 16, 24));          // Status 13, 15, 16 und 24 sind unbezahlt und sollen nicht berücksichtigt werden
        })
        ->get()                                                         // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                    // Objekt wird in Array gewandelt

        foreach($hours as $key => $entry){  // Gesamtes Array wird durchlaufen
            $entryArray = (array) $entry;   // Der aktuelle Eintrag von von Objekt in Array konvertiert
            $hours[$key] = $entryArray;     // Der aktuelle Eintrag wird mit dem erzeugten Array überschrieben
        }

        return $hours; // Das Datenarray wird zurückgegeben
    }

    public function getRetDetails($defaultVariablesArray, $department){
        /** Diese Funktion greift auf die RetentionDetails-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen. 
         * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */
        
        $data = DB::table('retention_details')                              // Verbindung zur Tabelle 'retention_details' wird hergestellt
        ->where('call_date', '>=', $defaultVariablesArray['startDate'])     // Datum muss größergleich dem Startdatum sein
        ->where('call_date', '<=', $defaultVariablesArray['endDate'])       // Datum muss kleinergleich dem Enddatum sein
        ->where('department_desc', '=', $department)                        // Die Department Bezeichnung muss gleich dem übergebenen Wert sein
        ->get()                                                             // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                        // Objekt wird in Array gewandelt

        foreach($data as $key => $entry){   // Gesamtes Array wird durchlaufen
            $entryArray = (array) $entry;   // Der aktuelle Eintrag von von Objekt in Array konvertiert
            $data[$key] = $entryArray;      // Der aktuelle Eintrag wird mit dem erzeugten Array überschrieben
        }
        
        //dd($data);
        return $data; // Das Datenarray wird zurückgegeben
    }

    public function getOptin($defaultVariablesArray, $department){
        /** Diese Funktion greift auf die OptIn-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen. 
         * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */

        $data = DB::table('optin')                                  // Verbindung zur Tabelle 'optin' wird hergestellt
        ->where('date', '>=', $defaultVariablesArray['startDate'])  // Datum muss größergleich dem Startdatum sein
        ->where('date', '<=', $defaultVariablesArray['endDate'])    // Datum muss kleinergleich dem Enddatum sein
        ->where('department', '=', $department)                     // Das Department muss gleich dem übergebenen Wert sein
        ->get()                                                     // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                // Objekt wird in Array gewandelt

        foreach($data as $key => $entry){   // Gesamtes Array wird durchlaufen
            $entryArray = (array) $entry;   // Der aktuelle Eintrag von von Objekt in Array konvertiert
            $data[$key] = $entryArray;      // Der aktuelle Eintrag wird mit dem erzeugten Array überschrieben
        }

        //dd($data);
        return $data; // Das Datenarray wird zurückgegeben
    }

    public function getSpeedRetention($defaultVariablesArray){
        /** Diese Funktion greift auf das KDW Tool zu und zieht für einen festgelegten Zeitraum alle Stunden die auf dem Projekt Speedretention gemacht wurden. */
        
        $hours =  DB::connection('mysqlkdw')                            // Verbindung zur externen Datenbanl 'mysqlkdw' wird hergestellt
        ->table("chronology_book")                                      // Aus der Datenbank soll auf die Tabelle 'chronology_book' zugegriffen werden
        ->where('book_date', '>=', $defaultVariablesArray['startDate']) // Datum muss größergleich dem Startdatum sein
        ->where('book_date', '<=', $defaultVariablesArray['endDate'])   // Datum muss kleinergleich dem Enddatum sein
        ->get()                                                         // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                    // Objekt wird in Array gewandelt

        foreach($hours as $key => $entry){  // Gesamtes Array wird durchlaufen
            $entryArray = (array) $entry;   // Der aktuelle Eintrag von von Objekt in Array konvertiert
            $hours[$key] = $entryArray;     // Der aktuelle Eintrag wird mit dem erzeugten Array überschrieben
        }

        return $hours; // Array zurückgeben
    }

    public function getDailyAgent($defaultVariablesArray, $department){
        /** Diese Funktion greift auf die DailyAgent-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen. 
         * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */

        $startDate = $defaultVariablesArray['startDatePHP']->setTime(0,0);
        $endDate = $defaultVariablesArray['endDatePHP']->setTime(23,59);

        $data = DB::table('dailyagent')                 // Verbindung zur Tabelle 'dailyagent' wird hergestellt
        ->where('start_time', '>=', $startDate)         // Datum muss größergleich dem Startdatum sein
        ->where('start_time', '<=', $endDate)           // Datum muss kleinergleich dem Enddatum sein
        ->where('agent_group_name', '=', $department)   // Die Agenten Gruppe muss gleich dem übergebenen Wert sein
        ->get()                                         // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                    // Objekt wird in Array gewandelt

        foreach($data as $key => $entry){   // Gesamtes Array wird durchlaufen
            $entryArray = (array) $entry;   // Der aktuelle Eintrag von von Objekt in Array konvertiert
            $data[$key] = $entryArray;      // Der aktuelle Eintrag wird mit dem erzeugten Array überschrieben
        }
        
        //dd($data);
        return $data; // Das Datenarray wird zurückgegeben
    }

    public function getAvailbench($defaultVariablesArray, $department){
        /** Diese Funktion greift auf die Availbench-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen. 
         * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */

        $data = DB::table('availbench_report')                          // Verbindung zur Tabelle 'availbench_report' wird hergestellt
        ->where('date_date', '>=', $defaultVariablesArray['startDate']) // Datum muss größergleich dem Startdatum sein
        ->where('date_date', '<=', $defaultVariablesArray['endDate'])   // Datum muss kleinergleich dem Enddatum sein
        ->where('call_forecast_issue', '=', $department)                // Der Forecast wird auf das übergebene Department gefiltert
        ->where('forecast', '>', 0)                                     // Nur Forecast mit einem Wert >0 werden berücksichtigt
        ->get()                                                         // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                    // Objekt wird in Array gewandelt

        foreach($data as $key => $entry){   // Gesamtes Array wird durchlaufen
            $entryArray = (array) $entry;   // Der aktuelle Eintrag von von Objekt in Array konvertiert
            $data[$key] = $entryArray;      // Der aktuelle Eintrag wird mit dem erzeugten Array überschrieben
        }

        return $data; // Das Datenarray wird zurückgegeben
    }

    public function getSas($defaultVariablesArray, $department){
        /** Diese Funktion greift auf die SAS-Datenbank zurück und zieht sich alle Daten, welche die erstellten Kriterien erfüllen. 
         * Schlussendlich werden die Daten vor der Rückgabe in ein Array gewandelt. */
        
        $data = DB::table('sas')                                    // Verbindung zur Tabelle 'sas' wird hergestellt
        ->where('date', '>=', $defaultVariablesArray['startDate'])  // Datum muss größergleich dem Startdatum sein
        ->where('date', '<=', $defaultVariablesArray['endDate'])    // Datum muss kleinergleich dem Enddatum sein
        ->where('topic', '=', $department)                          // Das Topic wird auf die übergebene Department-ID gefiltert
        ->get()                                                     // Tabelle wird unter berücksichtigung der Filter geholt
        ->toArray();                                                // Objekt wird in Array gewandelt

        foreach($data as $key => $entry){   // Gesamtes Array wird durchlaufen
            $entryArray = (array) $entry;   // Der aktuelle Eintrag von von Objekt in Array konvertiert
            $data[$key] = $entryArray;      // Der aktuelle Eintrag wird mit dem erzeugten Array überschrieben
        }

        //dd($data);
        return $data; // Das Datenarray wird zurückgegeben
    }

    public function getTeamEmployees(){
        $teamEmployees =  DB::connection('mysqlkdw')
        ->table("teams_MA")
        ->get();

        return $teamEmployees;
    }
}
