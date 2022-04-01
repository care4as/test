@extends('general_layout')
@section('pagetitle')
    Controlling: Umsatzmeldung
@endsection

@section('additional_css')
<style>
    .umsatz{
        display: none;
    }

    .availbench{
        display: none;
    }

    .cpo{
        display: none;
    }

    .optin{
        display: none;
    }

    .heads{
        display: none;
    }

    .fte{
        display: none;
    }

    .sick{
        display: none;
    }

    .worktime{
        display: none;
    }

    tr:hover td{
        background-color: #ddd;
    }
</style>
@endsection

@section('content')
<div>
    <form action="{{route('revenuereport.master')}}" method="get">
    @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Projekt</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <label for="project" style="margin: auto 0 auto auto;">Projekt:</label>
                                        <select id="project" class="form-control" style="color:black;" name="project">
                                                <option value="10" @if($param['project'] == 10) selected @endif>1u1 DSL Retention</option>
                                                <option value="7" @if($param['project'] == 7) selected @endif>1u1 Mobile Retention</option>
                                        </select>
                                        <label for="format" style="margin: auto 0 auto auto;">Formatierung:</label>
                                        <select id="format" class="form-control" style="color:black;" name="format">
                                                <option value="yes" @if($param['format'] == 'yes') selected @endif>Ja</option>
                                                <option value="no" @if($param['format'] == 'no') selected @endif>Nein</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Zeitraum</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <label for="month" style="margin: auto 0 auto auto;">Monat:</label>
                                        <select id="month" class="form-control" style="color:black;" name="month">
                                            @foreach($dateSelection['month'] as $key => $entry)
                                                <option value="{{$key}}" @if($key == $param['month']) selected @endif>{{$entry}}</option>
                                            @endforeach
                                        </select>
                                        <label for="year" style="margin: auto 0 auto auto;">Jahr:</label>
                                        <select id="year" class="form-control" style="color:black;" name="year">
                                            @foreach($dateSelection['year'] as $key => $entry)
                                                <option value="{{$key}}" @if($key == $param['year']) selected @endif>{{$entry}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Funktionen</div>
                                <div class="max-panel-content" style="display: flex; justify-content: space-around; flex-direction: column; gap: 5px">
                                    <button type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Liste anzeigen</button>
                                    <button class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Sonderposten hinzufügen</button>
                                    <button class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Werte anpassen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>    
        </div>
    </form>

    @if($param['comp'] == true)
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="max-panel">
                                <div class="max-panel-title">Auswertung</div>
                                <div class="max-panel-content" style="overflow-x: scroll;">
                                    <table class="max-table" id="datatable" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Datum</th>
                                                <th><abbr title="Nur bezahlte Kundenberater und Backoffice ohne:&#010;- Krank o. Lfz.&#010;- Unbezahlt krank&#010;- Mutterschutz&#010;- Erziehungsurlaub&#010;- Fehlt unentschuldigt&#010;- Beschäftigungsverbot&#010;- Krank bei Eintritt&#010;- Kindkrank o. Lfz.&#010;- Krank Quarantäne&#010;- Kind Corona&#010;Der zugrundeliegende Status lässt sich an den jeweiligen Tagen nachvollziehen">FTE Bestand <button onclick="changeDisplay('fte', 'fte_button')"><i id="fte_button" class="fas fa-caret-right"></i></button></abbr></th>
                                                    <th class="fte"><abbr title="Alle eingestellten Kundenberater unabhängig von nicht bezahlten Status">KB</abbr></th>
                                                    <th class="fte"><abbr title="Alle eingestellten Overheads unabhängig von nicht bezahlten Status">OVH</abbr></th>
                                                <th><abbr title="Nur bezahlte Kundenberater und Backoffice ohne:&#010;- Krank o. Lfz.&#010;- Unbezahlt krank&#010;- Mutterschutz&#010;- Erziehungsurlaub&#010;- Fehlt unentschuldigt&#010;- Beschäftigungsverbot&#010;- Krank bei Eintritt&#010;- Kindkrank o. Lfz.&#010;- Krank Quarantäne&#010;- Kind Corona&#010;Der zugrundeliegende Status lässt sich an den jeweiligen Tagen nachvollziehen">Köpfe Bestand <button onclick="changeDisplay('heads', 'heads_button')"><i id="heads_button" class="fas fa-caret-right"></i></button></abbr></th>
                                                    <th class="heads"><abbr title="Alle eingestellten Kundenberater unabhängig von nicht bezahlten Status">KB</abbr></th>
                                                    <th class="heads"><abbr title="Alle eingestellten Overheads unabhängig von nicht bezahlten Status">OVH</abbr></th>
                                                <th><abbr title="Berücksichtigt werden bezahlte Kundenberater und Backoffice.&#010;Die Kriterien sind identisch zum FTE Bestand.&#010;Wichtig: Die Summe weicht vom KDW-Tool ab! Dies liegt daran, dass KB in nicht bezahlten Status dort in den bezahlten Std. berücksichtigt werden.">Std. bezahlt <button onclick="changeDisplay('worktime', 'worktime_button')"><i id="worktime_button" class="fas fa-caret-right"></i></button></abbr></th>
                                                    <th class="worktime">Alle Std.</th>
                                                    <th class="worktime">← davon in unbezahlten Status</th>
                                                <th><abbr title="Netto Krankenquote:&#010;Std. krank (N) / Std. bezahlt&#010;&#010;Zielwert: ≤ {{number_format($param['constants'][$param['project']]['target_sick_percentage'], 2, ',', '.')}} %">Krankenquote (N) <button onclick="changeDisplay('sick', 'sick_button')"><i id="sick_button" class="fas fa-caret-right"></i></button></abbr></th>
                                                    <th class="sick"><abbr title="Berücksichtigt werden:&#010;- Krank&#010;- Kindkrank">Std. krank (N)</abbr></th>
                                                    <th class="sick"><abbr title="Brutto Krankenquote:&#010;Std. krank (B) / Alle std.">Krankenquote (B)</abbr></th>
                                                    <th class="sick"><abbr title="Berücksichtigt werden:&#010;- Krank&#010;- Kindkrank&#010;- Krank???&#010;- Krank o. Lfz.&#010;- Unbezahlt krank&#010;- Krank bei Eintritt&#010;- Krank Quarantäne&#010;- Kind Corona">Std. krank (B)</abbr></th>
                                                <th>Umsatz IST <button onclick="changeDisplay('umsatz', 'umsatz_ist_button')"><i id="umsatz_ist_button" class="fas fa-caret-right"></i></button></th>
                                                    <th class="umsatz">CPO <button onclick="changeDisplay('cpo', 'cpo_button')"><i id="cpo_button" class="fas fa-caret-right"></i></button></th>
                                                        @if($param['project'] == 10)
                                                            <th class="cpo">DSL</hd>
                                                        @endif
                                                        @if($param['project'] == 7)
                                                            <th class="cpo">SSC</th>
                                                            <th class="cpo">BSC</th>
                                                            <th class="cpo">Portale</th>
                                                        @endif
                                                        <th class="cpo">KüRü</th>
                                                    <th class="umsatz">Availbench <button onclick="changeDisplay('availbench', 'availbench_button')"><i id="availbench_button" class="fas fa-caret-right"></i></button></th>
                                                        <th class="availbench">Total Cost Per Interval</th>
                                                        <th class="availbench">← inkl. Malus</th>
                                                        <th class="availbench">Malus Incentive</th>
                                                        <th class="availbench">AHT Zielmangement</th>
                                                    <th class="umsatz">Optin  <button onclick="changeDisplay('optin', 'optin_button')"><i id="optin_button" class="fas fa-caret-right"></i></button></th>
                                                        <th class="optin">Call</th>
                                                        <th class="optin">E-Mail</th>
                                                        <th class="optin">Print</th>
                                                        <th class="optin">SMS</th>
                                                        <th class="optin">Verkehrsdaten</th>
                                                        <th class="optin">Nutzungsdaten</th>
                                                    <th class="umsatz">SaS</th>
                                                    <th class="umsatz">Speedretention</th>
                                                <th><abbr title="Zielwert: {{number_format($param['constants'][$param['project']]['target_revenue_paid_hour'], 2, ',', '.')}} €">Umsatz / bez. Std.</abbr></th>
                                                <th>Umsatz SOLL</th>
                                                <th>Deckung</th>
                                                <th>Zielerreichung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['daily'] as $key => $entry)
                                            <tr>
                                                <td>{{date('d.m.Y', strtotime($key))}} - 
                                                    @if(date('D', strtotime($key)) == 'Mon')
                                                        Mo
                                                    @elseif(date('D', strtotime($key)) == 'Tue')
                                                        Di
                                                    @elseif(date('D', strtotime($key)) == 'Wed')
                                                        Mi
                                                    @elseif(date('D', strtotime($key)) == 'Thu')
                                                        Do
                                                    @elseif(date('D', strtotime($key)) == 'Fri')
                                                        Fr
                                                    @elseif(date('D', strtotime($key)) == 'Sat')
                                                        Sa
                                                    @elseif(date('D', strtotime($key)) == 'Sun')
                                                        So
                                                    @endif</td>
                                                @if(isset($entry['fte']['information'][0]))
                                                    <td style="text-align: center;"><abbr title="@foreach($entry['fte']['information'] as $status => $description){{$description}}&#010;@endforeach">{{number_format($entry['fte']['payed_kb_fte'], 3, ',', '.')}}</abbr></td>
                                                @else
                                                    <td style="text-align: center;">{{number_format($entry['fte']['payed_kb_fte'], 3, ',', '.')}}</td>
                                                @endif
                                                    <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="fte">{{number_format($entry['fte']['all_kb_fte'], 3, ',', '.')}}</td>
                                                    <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="fte">{{number_format($entry['fte']['all_ovh_fte'], 3, ',', '.')}}</td>
                                                <td style="text-align: center;">{{$entry['fte']['payed_kb_heads']}}</td>
                                                    <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="heads">{{$entry['fte']['all_kb_heads']}}</td>
                                                    <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="heads">{{$entry['fte']['all_ovh_heads']}}</td>
                                                <td style="text-align: center;">{{number_format($entry['worktime']['payed_hours'], 2, ',', '.')}}</td>
                                                    <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="worktime">{{number_format($entry['worktime']['all_hours'], 2, ',', '.')}}</td>
                                                    <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="worktime">{{number_format($entry['worktime']['unpayed_hours'], 2, ',', '.')}}</td>
                                                @if($param['format'] == 'yes')
                                                    @if($entry['worktime']['sick_percentage_netto'] <= $param['constants'][$param['project']]['target_sick_percentage'])
                                                        <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: center;">{{number_format($entry['worktime']['sick_percentage_netto'], 2, ',', '.')}} %</td>
                                                        @else
                                                        <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: center;">{{number_format($entry['worktime']['sick_percentage_netto'], 2, ',', '.')}} %</td>
                                                        @endif
                                                    @else
                                                    <td style="text-align: center;">{{number_format($entry['worktime']['sick_percentage_netto'], 2, ',', '.')}} %</td>
                                                @endif
                                                    @if($entry['worktime']['information']['netto']['count_employees'] > 0)
                                                        <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="sick"><abbr title="Köpfe Krank: {{$entry['worktime']['information']['netto']['count_employees']}}&#010;@foreach($entry['worktime']['information']['netto']['entries'] as $sickKey => $sickEntry){{$sickEntry}}&#010;@endforeach">{{number_format($entry['worktime']['sick_hours_netto'], 2, ',', '.')}}</abbr></td>
                                                    @else
                                                        <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="sick">{{number_format($entry['worktime']['sick_hours_netto'], 2, ',', '.')}}</td>
                                                    @endif                                                    
                                                    <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="sick">{{number_format($entry['worktime']['sick_percentage_brutto'], 2, ',', '.')}} %</td>
                                                    @if($entry['worktime']['information']['brutto']['count_employees'] > 0)
                                                        <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="sick"><abbr title="Köpfe Krank: {{$entry['worktime']['information']['brutto']['count_employees']}}&#010;@foreach($entry['worktime']['information']['brutto']['entries'] as $sickKey => $sickEntry){{$sickEntry}}&#010;@endforeach">{{number_format($entry['worktime']['sick_hours_brutto'], 2, ',', '.')}}</abbr></td>
                                                    @else
                                                        <td style="text-align: center; background-color: rgb(123, 176, 212,0.3)" class="sick">{{number_format($entry['worktime']['sick_hours_brutto'], 2, ',', '.')}}</td>
                                                    @endif  
                                                <td style="text-align: right;">{{number_format($entry['revenue']['revenue'], 2, ',', '.')}} €</td>
                                                    <td class="umsatz" style="text-align: right; background-color: rgb(123, 176, 212,0.3)">{{number_format($entry['details']['revenue'],2, ',', '.')}} €</td>
                                                        @if($param['project'] == 10)    
                                                            <td class="cpo" style="background-color: rgb(194, 230, 255,0.3)">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['dsl_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['dsl_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($param['project'] == 7)
                                                            <td class="cpo" style="background-color: rgb(194, 230, 255,0.3)">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['ssc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['ssc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo" style="background-color: rgb(194, 230, 255,0.3)">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['bsc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['bsc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo" style="background-color: rgb(194, 230, 255,0.3)">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['portale_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['portale_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        <td class="cpo" style="background-color: rgb(194, 230, 255,0.3)">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['details']['kuerue_orders']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['details']['kuerue_revenue'], 2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                    <td class="umsatz" style="text-align: right; background-color: rgb(123, 176, 212,0.3)">{{number_format($entry['availbench']['revenue'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: rgb(194, 230, 255,0.3)">{{number_format($entry['availbench']['total_costs_per_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: rgb(194, 230, 255,0.3)">-{{number_format($entry['availbench']['malus_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: rgb(194, 230, 255,0.3)">{{number_format($entry['availbench']['malus_incentive'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: rgb(194, 230, 255,0.3)">{{number_format($entry['availbench']['aht_zielmanagement'],2, ',', '.')}} €</td>
                                                    <td class="umsatz" style="text-align: right; background-color: rgb(123, 176, 212,0.3)">{{number_format($entry['optin']['revenue'],2, ',', '.')}} €</td>
                                                        <td class="optin" style="background-color: rgb(194, 230, 255,0.3)">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['optin']['optin_call_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['optin']['optin_call_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="background-color: rgb(194, 230, 255,0.3)">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['optin']['optin_mail_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['optin']['optin_mail_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="background-color: rgb(194, 230, 255,0.3)">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['optin']['optin_print_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['optin']['optin_print_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="background-color: rgb(194, 230, 255,0.3)">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['optin']['optin_sms_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['optin']['optin_sms_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="background-color: rgb(194, 230, 255,0.3)">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['optin']['optin_trafic_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['optin']['optin_trafic_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="background-color: rgb(194, 230, 255,0.3)">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['optin']['optin_usage_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['optin']['optin_usage_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="umsatz" style="background-color: rgb(123, 176, 212,0.3)">
                                                        <div style="display:flex">
                                                            <div style="margin-right: 15px;">[{{$entry['sas']['sas_count']}}]</div>
                                                            <div style="margin-left:auto">{{number_format($entry['sas']['revenue'], 2, ',', '.')}} €</div>
                                                        </div>
                                                    </td>
                                                    <td class="umsatz" style="background-color: rgb(123, 176, 212,0.3)">
                                                        <div style="display:flex">
                                                            <div style="margin-right: 15px;">[{{number_format($entry['speedretention']['duration'],2, ',', '.')}}]</div>
                                                            <div style="margin-left:auto">{{number_format($entry['speedretention']['revenue'], 2, ',', '.')}} €</div>
                                                        </div>
                                                    </td>                                                
                                                @if($param['format'] == 'yes')
                                                    @if($entry['revenue']['revenue_paid_hour'] >= $param['constants'][$param['project']]['target_revenue_paid_hour'])
                                                        <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{number_format($entry['revenue']['revenue_paid_hour'], 2, ',', '.')}} €</td>
                                                        @else
                                                        <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{number_format($entry['revenue']['revenue_paid_hour'], 2, ',', '.')}} €</td>
                                                    @endif
                                                @else
                                                    <td style="text-align: right;">{{number_format($entry['revenue']['revenue_paid_hour'], 2, ',', '.')}} €</td>
                                                @endif
                                                <td style="text-align: right;">{{number_format($entry['revenue']['revenue_target'], 2, ',', '.')}} €</td>
                                                @if($param['format'] == 'yes')
                                                    @if($entry['revenue']['revenue_attainment'] >= 0)
                                                        <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{number_format($entry['revenue']['revenue_attainment'], 2, ',', '.')}} €</td>
                                                        @else
                                                        <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{number_format($entry['revenue']['revenue_attainment'], 2, ',', '.')}} €</td>
                                                    @endif
                                                @else
                                                    <td style="text-align: right;">{{number_format($entry['revenue']['revenue_attainment'], 2, ',', '.')}} €</td>
                                                @endif
                                                @if($param['format'] == 'yes')
                                                    <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) <?php echo $entry['revenue']['revenue_attainment_percent']?>%, rgba(247, 247, 247,0.5) <?php echo $entry['revenue']['revenue_attainment_percent']?>%);">{{number_format($entry['revenue']['revenue_attainment_percent'], 2, ',', '.')}}%</td>
                                                @else
                                                    <td style="text-align: center;">{{number_format($entry['revenue']['revenue_attainment_percent'], 2, ',', '.')}}%</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            <!-- <tr>
                                                <td>Sonderposten</td>
                                                <td colspan="2">Praxischeck</td>
                                                <td>4.000 €</td>
                                                <td colspan="100%"></td>
                                            </tr>
                                            <tr>
                                                <td>Sonderposten</td>
                                                <td colspan="2">E-Mail Verifikation</td>
                                                <td>6.500 €</td>
                                                <td colspan="100%"></td>
                                            </tr> -->
                                        </tbody>
                                        <tfoot>
                                            <tr style="font-weight: bold; background-color: #ddd;">
                                                <td>Summe</td>
                                                <td style="text-align: center;"><abbr title="Zeitgewichteter Mittelwert">{{number_format($data['sum']['fte']['payed_kb_fte'],3, ',', '.')}}</abbr></td>
                                                    <td style="text-align: center;background-color: #ddd;" class="fte">{{number_format($data['sum']['fte']['all_kb_fte'],3, ',', '.')}}</td>
                                                    <td style="text-align: center;background-color: #ddd;" class="fte">{{number_format($data['sum']['fte']['all_ovh_fte'],3, ',', '.')}}</td>
                                                <td style="text-align: center;"><abbr title="Zeitgewichteter Mittelwert">{{number_format($data['sum']['fte']['payed_kb_heads'],3, ',', '.')}}</abbr></td>
                                                    <td style="text-align: center;background-color: #ddd;" class="heads">{{$data['sum']['fte']['all_kb_heads']}}</td>
                                                    <td style="text-align: center;background-color: #ddd;" class="heads">{{$data['sum']['fte']['all_ovh_heads']}}</td>
                                                <td style="text-align: center; background-color: #ddd;">{{number_format($data['sum']['worktime']['payed_hours'],2, ',', '.')}}</td>
                                                    <td style="text-align: center; background-color: #ddd;" class="worktime">{{number_format($data['sum']['worktime']['all_hours'],2, ',', '.')}}</td>
                                                    <td style="text-align: center; background-color: #ddd;" class="worktime">{{number_format($data['sum']['worktime']['unpayed_hours'],2, ',', '.')}}</td>
                                                <td style="text-align:center;">{{number_format($data['sum']['worktime']['sick_percentage_netto'],2, ',', '.')}} % </td>
                                                    <td style="text-align: center; background-color: #ddd;" class="sick">{{number_format($data['sum']['worktime']['sick_hours_netto'],2, ',', '.')}}</td>
                                                    <td style="text-align: center; background-color: #ddd;" class="sick">{{number_format($data['sum']['worktime']['sick_percentage_brutto'],2, ',', '.')}} % </td>
                                                    <td style="text-align: center; background-color: #ddd;" class="sick">{{number_format($data['sum']['worktime']['sick_hours_brutto'],2, ',', '.')}}</td>
                                                <td style="text-align:right;">{{number_format($data['sum']['revenue']['revenue'],2, ',', '.')}} €</td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['details']['revenue'],2, ',', '.')}} €</td>
                                                        @if($param['project'] == 10)    
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['dsl_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['dsl_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($param['project'] == 7)
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['ssc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['ssc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['bsc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['bsc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['portale_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['portale_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['details']['kuerue_orders']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['details']['kuerue_revenue'], 2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['revenue'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['total_costs_per_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">-{{number_format($data['sum']['availbench']['malus_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['malus_incentive'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['aht_zielmanagement'],2, ',', '.')}} €</td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['optin']['revenue'],2, ',', '.')}} €</td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['optin']['optin_call_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['optin']['optin_call_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['optin']['optin_mail_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['optin']['optin_mail_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['optin']['optin_print_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['optin']['optin_print_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['optin']['optin_sms_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['optin']['optin_sms_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['optin']['optin_trafic_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['optin']['optin_trafic_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['optin']['optin_usage_count']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['optin']['optin_usage_revenue'],2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">
                                                        <div style="display:flex">
                                                            <div style="margin-right: 15px;">[{{$data['sum']['sas']['sas_count']}}]</div>
                                                            <div style="margin-left:auto">{{number_format($data['sum']['sas']['revenue'], 2, ',', '.')}} €</div>
                                                        </div>
                                                    </td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">
                                                        <div style="display:flex">
                                                            <div style="margin-right: 15px;">[{{number_format($data['sum']['speedretention']['duration'],2, ',', '.')}}]</div>
                                                            <div style="margin-left:auto">{{number_format($data['sum']['speedretention']['revenue'], 2, ',', '.')}} €</div>
                                                        </div>
                                                    </td>
                                                <td style="text-align:right;">{{number_format($data['sum']['revenue']['revenue_paid_hour'],2, ',', '.')}} €</td>
                                                <td style="text-align:right;">{{number_format($data['sum']['revenue']['revenue_target'],2, ',', '.')}} €</td>
                                                <td style="text-align:right;">{{number_format($data['sum']['revenue']['revenue_attainment'],2, ',', '.')}} €</td>
                                                <td style="text-align:center;">{{number_format($data['sum']['revenue']['revenue_attainment_percent'],2, ',', '.')}}%</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @if(count($data['sum']['fte']['information']) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="max-main-container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="max-panel">
                                    <div class="max-panel-title">Besonderheiten im Berichtszeitraum</div>
                                    <div class="max-panel-content">
                                        <div class="row">
                                            @foreach($data['sum']['fte']['information'] as $key => $entry)
                                                
                                                <div class="col-lg-4 col-md-6">
                                                    <p style="margin-bottom:0; font-weight:bold">{{$key}}</p>
                                                    <ul>
                                                        @foreach($entry as $statusKey => $statusEntry)
                                                        <li>{{$statusEntry}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            
                                            @endforeach
                                            @if(count($data['sum']['fte']['sick_entries']) > 0)
                                                <div class="col-lg-4 col-md-6">
                                                    <p style="margin-bottom:0; font-weight:bold">Tage Krank</p>
                                                    <ul>
                                                        @foreach($data['sum']['fte']['sick_entries'] as $key => $entry)
                                                        <li>{{$entry}} @if($entry == 1)Tag: @else Tage: @endif {{$key}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>    
            </div>
        @endif
    
    @endif










</div>
@endsection

@section('additional_js')
<script>
    function changeDisplay(classname, buttonId){
        var collection = document.getElementsByClassName(classname);
        status = window.getComputedStyle(collection[0]).display;

        if (status == 'table-cell'){
            for(i = 0; i<collection.length; i++){
                collection[i].style.display = 'none';
            }
        } else {
            for(i = 0; i<collection.length; i++){
                collection[i].style.display = 'table-cell';
            }
        }

        button = document.getElementById(buttonId);
        
        if (button.className == 'fas fa-caret-right'){
            button.className = 'fas fa-caret-left'
        } else {
            button.className = 'fas fa-caret-right';
        }
    }
</script>
@endsection