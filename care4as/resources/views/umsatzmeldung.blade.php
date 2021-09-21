@extends('general_layout')
@section('pagetitle')
    Controlling: Umsatzmeldung
@endsection
@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('umsatzmeldung')}}" method="get()"> 
                    @csrf
                    <div class="max-main-container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="max-panel">
                                    <div class="max-panel-title">Projekt</div>
                                    <div class="max-panel-content">
                                        <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                            <label for="inputState" style="margin: auto;">Auswahl:</label>
                                            <select id="inputState" class="form-control" name="project" style="color:black;">
                                                @if($defaultVariablesArray['project'] == 'all')
                                                    <option selected value="all">Projektübergreifend</option>
                                                    @else
                                                    <option value="all">Projektübergreifend</option>
                                                @endif
                                                @if($defaultVariablesArray['project'] == '1u1_dsl_retention')
                                                    <option selected value="1u1_dsl_retention">1u1 DSL Retention</option>
                                                    @else
                                                    <option value="1u1_dsl_retention">1u1 DSL Retention</option>
                                                @endif
                                                @if($defaultVariablesArray['project'] == '1u1_mobile_retention')
                                                    <option selected value="1u1_mobile_retention">1u1 Mobile Retention</option>
                                                    @else
                                                    <option value="1u1_mobile_retention">1u1 Mobile Retention</option>
                                                @endif
                                                @if($defaultVariablesArray['project'] == '1u1_terminationadministration')
                                                    <option selected value="1u1_terminationadministration">1u1 Kündigungsadministration</option>
                                                    @else
                                                    <option value="1u1_terminationadministration">1u1 Kündigungsadministration</option>
                                                @endif
                                                @if($defaultVariablesArray['project'] == 'telefonica_outbound')
                                                    <option selected value="telefonica_outbound">Telefonica Outbound</option>
                                                    @else
                                                    <option value="telefonica_outbound">Telefonica Outbound</option>
                                                @endif
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
                                            <p style="margin: auto;">Von:</p>
                                            <input type="date" id="dateFrom" name="startDate" class="form-control" placeholder="" value="{{$defaultVariablesArray['startdate']}}" style="color: black;">
                                            <p style="margin: auto;">Bis:</p>
                                            <input type="date" id="dateTo" name="endDate" class="form-control" placeholder="" value="{{$defaultVariablesArray['enddate']}}" style="color: black;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:flex; margin-top: 20px; margin-bottom: 20px;">
                                <button class="btn btn-primary" style="margin: auto;" type="submit">Bericht erzeugen</button>
                            </div>
                        </div>
                    </div>  
                </form>
            </div>    
        </div>
        
        @if($defaultVariablesArray['project'] == 'all')
            <div class="row">  
                <div class="col-md-12">
                    <div class="max-main-container">
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 15px; white-space: nowrap; overflow-x: auto;">
                                <p style="margin: 0; margin-right: auto">Umsatzmeldung</p>
                                <p style="margin: 0; text-align: center">Projektübergreifend</p>
                                <p style="margin: 0; margin-left: auto;">{{$defaultVariablesArray['startdate']}} - {{$defaultVariablesArray['enddate']}}</p>
                            </div>
                            <div class="max-panel-content">
                                <div style="min-width: 100%; display: flex; border: 1px solid grey; margin-bottom: 10px; overflow-x: auto; white-space: nowrap; background-color: rgb(247, 247, 247);">
                                    <div style="padding: 5px; margin-top: auto; margin-bottom: auto; flex-grow: 1; font-weight: bold; text-align: center;">Planumsatz gesamter Zeitraum</div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Umsatzsoll:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">DB2 Aktuell:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey;">>>></div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey;">>>></div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; font-weight: bold;"> €</div>
                                        @if(0 >= 0)
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(0,97,0); background-color: rgb(198,239,206);"> %</div>
                                        @else
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(156,0,6); background-color: rgb(255,199,206);"> %</div>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Zielerreichung:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">Umsatzdelta:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center;"> %</div>
                                        @if(0 >= 0)
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(0,97,0); background-color: rgb(198,239,206);"> €</div>
                                        @else
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(156,0,6); background-color: rgb(255,199,206);">€</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div style="width: 100%; overflow-x: auto;">
                                <table class="max-table">
                                    <thead>
                                        <tr style="width: 100%">
                                            <th>Datum</th>
                                            <th>Umsatz IST</th>
                                            <th>Umsatz SOLL</th>
                                            <th>Deckung</th>
                                            <th>Zielerreichung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($defaultVariablesArray['days'] as $key => $day)
                                        <tr>
                                            <td>{{$defaultVariablesArray['app_data'][$day]['date_european']}} - {{$defaultVariablesArray['app_data'][$day]['weekday']}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                        <tr style="font-weight: bold; background-color: #ddd;">
                                            <td>Summe</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="max-main-container">  
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: flex;">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" style="vertical-align: text-top;">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </div>
                                <div style="margin-left: 5px;">
                                    Information
                                </div>
                            </div>
                            <div class="max-panel-content">
                                <ul class="mb-0">
                                    <li style="font-style: italic;">Vorläufige Werte aus dem KDW-Tracking die teilweise approximiert sind.</li>
                                    <li>Feste Werte.</li>
                                    <li>"FTE-Bestand" und "Std. bezahlt" berücksichtigen die Projektzuordnung der Mitarbeiter zum heutigen Datum. Vergangene Projektzuordnungen können durch den Aufbau der KDW-Datenbank nicht abgebildet werden. Zurückliegende Reporte können deshalb Mitarbeiter berücksichtigen, die zu diesem Zeitpunkt nicht in Projekt aktiv waren.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($defaultVariablesArray['project'] == '1u1_dsl_retention')
            <div class="row">  
                <div class="col-md-12">
                    <div class="max-main-container">
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 15px; white-space: nowrap; overflow-x: auto;">
                                <p style="margin: 0; margin-right: auto">Umsatzmeldung</p>
                                <p style="margin: 0; text-align: center">1u1 DSL Retention</p>
                                <p style="margin: 0; margin-left: auto;">{{$defaultVariablesArray['startdate']}} - {{$defaultVariablesArray['enddate']}}</p>
                            </div>
                            <div class="max-panel-content">
                                <div style="min-width: 100%; display: flex; border: 1px solid grey; margin-bottom: 10px; overflow-x: auto; white-space: nowrap; background-color: rgb(247, 247, 247);">
                                    <div style="padding: 5px; margin-top: auto; margin-bottom: auto; flex-grow: 1; font-weight: bold; text-align: center;">Planumsatz gesamter Zeitraum</div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Umsatzsoll:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">DB2 Aktuell:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey;">>>></div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey;">>>></div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; font-weight: bold;">{{$dslCoreDataArray['overview']['revenueShouldString']}} €</div>
                                        @if($dslCoreDataArray['overview']['db2'] >= 0)
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$dslCoreDataArray['overview']['db2String']}} %</div>
                                        @else
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$dslCoreDataArray['overview']['db2String']}} %</div>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Zielerreichung:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">Umsatzdelta:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                    <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$dslCoreDataArray['overview']['attainment']}}%, rgba(247, 247, 247,1) {{$dslCoreDataArray['overview']['attainment']}}%);">{{$dslCoreDataArray['overview']['attainmentString']}} %</div>
                                        @if($dslCoreDataArray['overview']['revenueDelta'] >= 0)
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$dslCoreDataArray['overview']['revenueDeltaString']}} €</div>
                                        @else
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$dslCoreDataArray['overview']['revenueDeltaString']}} €</div>
                                        @endif
                                    </div>
                                </div>
                                <div style="font-style: italic">Development Information: Umsatz um OptIn, SAS und Speedretention erweitern. Sales aus CPO und Availbench hinzufügen.</div>
                                <div style="width: 100%; overflow-x: auto;">
                                <table class="max-table">
                                    <thead>
                                        <tr style="width: 100%">
                                            <th>Datum</th>
                                            <th>FTE Bestand</th>
                                            <th>Std. bezahlt</th>
                                            <th>Sales</th>
                                            <th>Ø€ / Sale</th>
                                            <th>Umsatz Sales</th>
                                            <th>Umsatz Availbench</th>
                                            <th>Umsatz IST</th>
                                            <th>Umsatz / bez. Std.</th>
                                            <th>Umsatz SOLL</th>
                                            <th>Deckung</th>
                                            <th>Zielerreichung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($defaultVariablesArray['days'] as $key => $day)
                                        <tr>
                                            <td>{{$defaultVariablesArray['app_data'][$day]['date_european']}} - {{$defaultVariablesArray['app_data'][$day]['weekday']}}</td>
                                            @if(isset($dslWorktimeArray[$day]['unemployment']) or isset($dslWorktimeArray[$day]['employment']) or isset($dslWorktimeArray[$day]['unproductive']))
                                                <td style="text-align: center;"><abbr title="@if(isset($dslWorktimeArray[$day]['unemployment'])){{''}}@foreach($dslWorktimeArray[$day]['unemployment'] as $user )Austritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($dslWorktimeArray[$day]['employment']))@foreach($dslWorktimeArray[$day]['employment'] as $user )Einritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($dslWorktimeArray[$day]['unproductive']))@foreach($dslWorktimeArray[$day]['unproductive'] as $user){{$user}}&#010;@endforeach{{''}}@endif">{{$dslWorktimeArray[$day]['FTE_string']}}</abbr></td>
                                                @else
                                                <td style="text-align: center;">{{$dslWorktimeArray[$day]['FTE_string']}}</td>
                                            @endif
                                            <td style="text-align: center;">{{$dslWorktimeArray[$day]['work_hours_string']}}</td>
                                            <td style="text-align: center; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['daily'][$day]['sumSaves']}}</td>
                                            <td style="text-align: right; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveString']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSaveSumString']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueAvailbenchSumString']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['daily'][$day]['revenueSumString']}} €</td>
                                            @if($dslCoreDataArray['daily'][$day]['revenuePaidHour'] >= $defaultVariablesArray['revenue_hour_should']['1u1_dsl_retention'])
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$dslCoreDataArray['daily'][$day]['revenuePaidHourString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$dslCoreDataArray['daily'][$day]['revenuePaidHourString']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$dslWorktimeArray[$day]['revenue_should_string']}} €</td>
                                            @if($dslCoreDataArray['daily'][$day]['revenueDelta'] >= 0)
                                                <td style="text-align: right; color: rgb(0,97,0); background-color: rgb(132,220,149,0.5);">{{$dslCoreDataArray['daily'][$day]['revenueDeltaString']}} €</td>
                                                @else
                                                <td style="text-align: right; color: rgb(156,0,6); background-color: rgb(255,91,111,0.35);">{{$dslCoreDataArray['daily'][$day]['revenueDeltaString']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$dslCoreDataArray['daily'][$day]['attainmeint']}}%, rgba(247, 247, 247,0.5) {{$dslCoreDataArray['daily'][$day]['attainmeint']}}%);">{{$dslCoreDataArray['daily'][$day]['attainmeintString']}} %</td>
                                        </tr>
                                        @endforeach
                                        <tr style="font-weight: bold; background-color: #ddd;">
                                            <td>Summe</td>
                                            <td style="text-align: center;">{{$dslWorktimeArray['cumulative']['fte_medium_string']}}</td>
                                            <td style="text-align: center;">{{$dslWorktimeArray['cumulative']['paid_hours_string']}}</td>
                                            <td style="text-align: center; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['cumulative']['sumSaves']}}</td>
                                            <td style="text-align: right; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveString']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['cumulative']['revenueSaveSumString']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$dslSalesDataArray['kdwSalesData']['cumulative']['revenueAvailbenchSumString']}} €</td>
                                            <td style="text-align: right;font-style: italic;;">{{$dslSalesDataArray['kdwSalesData']['cumulative']['revenueSumString']}} €</td>
                                            @if($dslCoreDataArray['cumulative']['revenuePaidHour'] >= $defaultVariablesArray['revenue_hour_should']['1u1_dsl_retention'])
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$dslCoreDataArray['cumulative']['revenuePaidHourString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$dslCoreDataArray['cumulative']['revenuePaidHourString']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$dslWorktimeArray['cumulative']['revenue_should_string']}} €</td>
                                            @if($dslCoreDataArray['cumulative']['revenueDelta'] >= 0)
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$dslCoreDataArray['cumulative']['revenueDeltaString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$dslCoreDataArray['cumulative']['revenueDeltaString']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$dslCoreDataArray['cumulative']['attainmeint']}}%, rgba(221, 221, 221,1) {{$dslCoreDataArray['cumulative']['attainmeint']}}%);">{{$dslCoreDataArray['cumulative']['attainmeintString']}} %</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="max-main-container">  
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: flex;">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" style="vertical-align: text-top;">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </div>
                                <div style="margin-left: 5px;">
                                    Information
                                </div>
                            </div>
                            <div class="max-panel-content">
                                <ul class="mb-0">
                                    <li style="font-style: italic;">Vorläufige Werte aus dem KDW-Tracking die teilweise approximiert sind.</li>
                                    <li>Feste Werte.</li>
                                    <li>"FTE-Bestand" und "Std. bezahlt" berücksichtigen die Projektzuordnung der Mitarbeiter zum heutigen Datum. Vergangene Projektzuordnungen können durch den Aufbau der KDW-Datenbank nicht abgebildet werden. Zurückliegende Reporte können deshalb Mitarbeiter berücksichtigen, die zu diesem Zeitpunkt nicht in Projekt aktiv waren.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        @if($defaultVariablesArray['project'] == '1u1_mobile_retention')
            <div class="row">  
                <div class="col-md-12">
                    <div class="max-main-container">
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 15px; white-space: nowrap; overflow-x: auto;">
                                <p style="margin: 0; margin-right: auto">Umsatzmeldung</p>
                                <p style="margin: 0; text-align: center">1u1 Mobile Retention</p>
                                <p style="margin: 0; margin-left: auto;">{{$defaultVariablesArray['startdate']}} - {{$defaultVariablesArray['enddate']}}</p>
                            </div>
                            <div class="max-panel-content">
                                <div style="min-width: 100%; display: flex; border: 1px solid grey; margin-bottom: 10px; overflow-x: auto; white-space: nowrap; background-color: rgb(247, 247, 247);">
                                    <div style="padding: 5px; margin-top: auto; margin-bottom: auto; flex-grow: 1; font-weight: bold; text-align: center;">Planumsatz gesamter Zeitraum</div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Umsatzsoll:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">DB2 Aktuell:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey;">>>></div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey;">>>></div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; font-weight: bold;">{{$mobileCoreDataArray['revenue_should_string']}} €</div>
                                        @if($mobileCoreDataArray['db2_int'] >= 0)
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$mobileCoreDataArray['db2_string']}} %</div>
                                        @else
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$mobileCoreDataArray['db2_string']}} %</div>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Zielerreichung:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">Umsatzdelta:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$mobileCoreDataArray['attainment_int']}}%, rgba(247, 247, 247,1) {{$mobileCoreDataArray['attainment_int']}}%);">{{$mobileCoreDataArray['attainment_string']}} %</div>
                                        @if($mobileCoreDataArray['revenue_delta_int'] >= 0)
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$mobileCoreDataArray['revenue_delta_string']}} €</div>
                                        @else
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$mobileCoreDataArray['revenue_delta_string']}} €</div>
                                        @endif
                                    </div>
                                </div>
                                <div style="font-style: italic">Development Information: Umsatz um OptIn, SAS und Speedretention erweitern. Sales aus CPO und Availbench hinzufügen.</div>
                                <div style="width: 100%; overflow-x: auto;">
                                <table class="max-table">
                                    <thead>
                                        <tr style="width: 100%">
                                            <th>Datum</th>
                                            <th>FTE Bestand</th>
                                            <th>Std. bezahlt</th>
                                            <th>Sales</th>
                                            <th>Ø€ / Sale</th>
                                            <th><abbr title="Sales * €/Sale&#010;SSC RET: 16,00€&#010;SSC PRE: 12,50€&#010;BSC RET: 11,00€&#010;BSC PRE: 8,50€&#010;Portal RET: 16,00€&#010;Portal PRE: 12,50€&#010;KüRü: 5,00€">Umsatz Sales</abbr></th>
                                            <th><abbr title="KDW: Calls*500/60*0,42">Umsatz Availbench</abbr></th>
                                            <th>Umsatz IST</th>
                                            <th><abbr title="Zielwert: 35,00€">Umsatz / bez. Std.</abbr></th>
                                            <th><abbr title="Std. bezahlt * 35,00€">Umsatz SOLL</abbr></th>
                                            <th>Deckung</th>
                                            <th>Zielerreichung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($defaultVariablesArray['days'] as $key => $day)
                                        <tr>
                                            <td>{{$defaultVariablesArray['app_data'][$day]['date_european']}} - {{$defaultVariablesArray['app_data'][$day]['weekday']}}</td>
                                            @if(isset($mobileWorktimeArray[$day]['unemployment']) or isset($mobileWorktimeArray[$day]['employment']) or isset($mobileWorktimeArray[$day]['unproductive']))
                                                <td style="text-align: center;"><abbr title="@if(isset($mobileWorktimeArray[$day]['unemployment'])){{''}}@foreach($mobileWorktimeArray[$day]['unemployment'] as $user )Austritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($mobileWorktimeArray[$day]['employment']))@foreach($mobileWorktimeArray[$day]['employment'] as $user )Einritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($mobileWorktimeArray[$day]['unproductive']))@foreach($mobileWorktimeArray[$day]['unproductive'] as $user){{$user}}&#010;@endforeach{{''}}@endif">{{$mobileWorktimeArray[$day]['FTE_string']}}</abbr></td>
                                                @else
                                                <td style="text-align: center;">{{$mobileWorktimeArray[$day]['FTE_string']}}</td>
                                            @endif
                                            <td style="text-align: center;">{{$mobileWorktimeArray[$day]['work_hours_string']}}</td>
                                            <td style="text-align: center; font-style: italic;"><abbr title="SSC RET: {{$mobileSalesDataArray['daily_performance'][$day]['SSC_RET_Saves']}}&#010;SSC PRE: {{$mobileSalesDataArray['daily_performance'][$day]['SSC_PRE_Saves']}}&#010;BSC RET: {{$mobileSalesDataArray['daily_performance'][$day]['BSC_RET_Saves']}}&#010;BSC PRE: {{$mobileSalesDataArray['daily_performance'][$day]['BSC_PRE_Saves']}}&#010;Portal RET: {{$mobileSalesDataArray['daily_performance'][$day]['Portal_RET_Saves']}}&#010;Portal PRE: {{$mobileSalesDataArray['daily_performance'][$day]['Portal_PRE_Saves']}}&#010;KüRü: {{$mobileSalesDataArray['daily_performance'][$day]['Kuerue_Saves']}}">{{$mobileSalesDataArray['daily_performance'][$day]['Sum_Sales']}}</abbr></td>
                                            <td style="text-align: right; font-style: italic;">{{$mobileSalesDataArray['daily_performance'][$day]['Median_Revenue_Sum']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$mobileSalesDataArray['daily_performance'][$day]['Revenue_Sales_Sum_string']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$mobileSalesDataArray['daily_performance'][$day]['Availbench_KDW_string']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$mobileSalesDataArray['daily_performance'][$day]['total_revenue_string']}} €</td>
                                            @if($mobileCoreDataArray['daily_performance'][$day]['revenue_payed_hour_int'] >= 35)
                                                <td style="text-align: right; color: rgb(0,97,0); background-color: rgb(132,220,149,0.5);">{{$mobileCoreDataArray['daily_performance'][$day]['revenue_payed_hour_string']}} €</td>
                                                @else
                                                <td style="text-align: right; color: rgb(156,0,6); background-color: rgb(255,91,111,0.35);">{{$mobileCoreDataArray['daily_performance'][$day]['revenue_payed_hour_string']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$mobileWorktimeArray[$day]['revenue_should_string']}} €</td>
                                            @if($mobileCoreDataArray['daily_performance'][$day]['revenue_delta_string'] >= 0)
                                                <td style="text-align: right; color: rgb(0,97,0); background-color: rgb(132,220,149,0.5);">{{$mobileCoreDataArray['daily_performance'][$day]['revenue_delta_string']}} €</td>
                                                @else
                                                <td style="text-align: right; color: rgb(156,0,6); background-color: rgb(255,91,111,0.35);">{{$mobileCoreDataArray['daily_performance'][$day]['revenue_delta_string']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$mobileCoreDataArray['daily_performance'][$day]['attainment_int']}}%, rgba(247, 247, 247,0.5) {{$mobileCoreDataArray['daily_performance'][$day]['attainment_int']}}%);">{{$mobileCoreDataArray['daily_performance'][$day]['attainment_string']}} %</td>
                                        </tr>
                                        @endforeach
                                        <tr style="font-weight: bold; background-color: #ddd;">
                                            <td style="text-align: center;">Summe</td>
                                            <td style="text-align: center;">{{$mobileWorktimeArray['cumulative']['fte_medium_string']}}</td>
                                            <td style="text-align: center;">{{$mobileCoreDataArray['sum_work_hours_string']}}</td>
                                            <td style="text-align: center;">{{$mobileSalesDataArray['total_performance']['total_mobile_sum_sales']}}</td>
                                            <td style="text-align: right;">{{$mobileSalesDataArray['total_performance']['median_revenue_string']}} €</td>
                                            <td style="text-align: right;">{{$mobileSalesDataArray['total_performance']['sum_sales_revenue_string']}} €</td>
                                            <td style="text-align: right;">{{$mobileSalesDataArray['total_performance']['sum_availbench_kdw_string']}} €</td>
                                            <td style="text-align: right;">{{$mobileSalesDataArray['total_performance']['sum_revenue_string']}} €</td>
                                            @if($mobileCoreDataArray['duration_revenue_payed_hour_int'] >= 35)
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$mobileCoreDataArray['duration_revenue_payed_hour_string']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$mobileCoreDataArray['duration_revenue_payed_hour_string']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$mobileCoreDataArray['sum_revenue_should_string']}} €</td>
                                            @if($mobileCoreDataArray['duration_revenue_delta_int'] >= 0)
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$mobileCoreDataArray['duration_revenue_delta_string']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$mobileCoreDataArray['duration_revenue_delta_string']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$mobileCoreDataArray['duration_attainment_int']}}%, rgba(221, 221, 221,1) {{$mobileCoreDataArray['duration_attainment_int']}}%);">{{$mobileCoreDataArray['duration_attainment_string']}} %</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="max-main-container">  
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: flex;">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" style="vertical-align: text-top;">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </div>
                                <div style="margin-left: 5px;">
                                    Information
                                </div>
                            </div>
                            <div class="max-panel-content">
                                <ul class="mb-0">
                                    <li style="font-style: italic;">Vorläufige Werte aus dem KDW-Tracking die teilweise approximiert sind.</li>
                                    <li>Feste Werte.</li>
                                    <li>"FTE-Bestand" und "Std. bezahlt" berücksichtigen die Projektzuordnung der Mitarbeiter zum heutigen Datum. Vergangene Projektzuordnungen können durch den Aufbau der KDW-Datenbank nicht abgebildet werden. Zurückliegende Reporte können deshalb Mitarbeiter berücksichtigen, die zu diesem Zeitpunkt nicht in Projekt aktiv waren.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($defaultVariablesArray['project'] == '1u1_terminationadministration')
            <div class="row">  
                <div class="col-md-12">
                    <div class="max-main-container">
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 15px; white-space: nowrap; overflow-x: auto;">
                                <p style="margin: 0; margin-right: auto">Umsatzmeldung</p>
                                <p style="margin: 0; text-align: center">Kündigungsadministration</p>
                                <p style="margin: 0; margin-left: auto;">{{$defaultVariablesArray['startdate']}} - {{$defaultVariablesArray['enddate']}}</p>
                            </div>
                            <div class="max-panel-content">
                                <div style="min-width: 100%; display: flex; border: 1px solid grey; margin-bottom: 10px; overflow-x: auto; white-space: nowrap; background-color: rgb(247, 247, 247);">
                                    <div style="padding: 5px; margin-top: auto; margin-bottom: auto; flex-grow: 1; font-weight: bold; text-align: center;">Planumsatz gesamter Zeitraum</div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Umsatzsoll:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">DB2 Aktuell:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey;">>>></div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey;">>>></div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; font-weight: bold;">{{$terminationCoreDataArray['overview']['revenueShouldString']}} €</div>
                                        @if($terminationCoreDataArray['overview']['db2'] >= 0)
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$terminationCoreDataArray['overview']['db2String']}} %</div>
                                        @else
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$terminationCoreDataArray['overview']['db2String']}} %</div>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Zielerreichung:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">Umsatzdelta:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                    <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$terminationCoreDataArray['overview']['attainment']}}%, rgba(247, 247, 247,1) {{$terminationCoreDataArray['overview']['attainment']}}%);">{{$terminationCoreDataArray['overview']['attainmentString']}} %</div>
                                        @if($terminationCoreDataArray['overview']['revenueDelta'] >= 0)
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$terminationCoreDataArray['overview']['revenueDeltaString']}} €</div>
                                        @else
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$terminationCoreDataArray['overview']['revenueDeltaString']}} €</div>
                                        @endif
                                    </div>
                                </div>
                                <div style="width: 100%; overflow-x: auto;">
                                <table class="max-table">
                                    <thead>
                                        <tr style="width: 100%">
                                            <th>Datum</th>
                                            <th>FTE Bestand</th>
                                            <th>Std. bezahlt</th>
                                            <th>Distinct Cases</th>
                                            <th>Ø€ / Case</th>
                                            <th>Umsatz IST</th>
                                            <th>Umsatz / bez. Std.</th>
                                            <th>Umsatz SOLL</th>
                                            <th>Deckung</th>
                                            <th>Zielerreichung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($defaultVariablesArray['days'] as $key => $day)
                                        <tr>
                                            <td>{{$defaultVariablesArray['app_data'][$day]['date_european']}} - {{$defaultVariablesArray['app_data'][$day]['weekday']}}</td>
                                            @if(isset($terminationWorktimeArray[$day]['unemployment']) or isset($terminationWorktimeArray[$day]['employment']) or isset($terminationWorktimeArray[$day]['unproductive']))
                                                <td style="text-align: center;"><abbr title="@if(isset($terminationWorktimeArray[$day]['unemployment'])){{''}}@foreach($terminationWorktimeArray[$day]['unemployment'] as $user )Austritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($terminationWorktimeArray[$day]['employment']))@foreach($terminationWorktimeArray[$day]['employment'] as $user )Einritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($terminationWorktimeArray[$day]['unproductive']))@foreach($terminationWorktimeArray[$day]['unproductive'] as $user){{$user}}&#010;@endforeach{{''}}@endif">{{$terminationWorktimeArray[$day]['FTE_string']}}</abbr></td>
                                                @else
                                                <td style="text-align: center;">{{$terminationWorktimeArray[$day]['FTE_string']}}</td>
                                            @endif
                                            <td style="text-align: center;">{{$terminationWorktimeArray[$day]['work_hours_string']}}</td>
                                            <td style="text-align: center; font-style: italic;">{{$terminationSalesDataArray['kdwSalesData']['daily'][$day]['sumDistinctCasesString']}}</td>
                                            <td style="text-align: right; font-style: italic;">{{$terminationSalesDataArray['kdwSalesData']['daily'][$day]['revenueCaseString']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$terminationSalesDataArray['kdwSalesData']['daily'][$day]['revenueSumString']}} €</td>
                                            @if($terminationCoreDataArray['daily'][$day]['revenuePaidHour'] >= $defaultVariablesArray['revenue_hour_should']['1u1_terminationadministration'])
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$terminationCoreDataArray['daily'][$day]['revenuePaidHourString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$terminationCoreDataArray['daily'][$day]['revenuePaidHourString']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$terminationWorktimeArray[$day]['revenue_should_string']}} €</td>
                                            @if($terminationCoreDataArray['daily'][$day]['revenueDelta'] >= 0)
                                                <td style="text-align: right; color: rgb(0,97,0); background-color: rgb(132,220,149,0.5);">{{$terminationCoreDataArray['daily'][$day]['revenueDeltaString']}} €</td>
                                                @else
                                                <td style="text-align: right; color: rgb(156,0,6); background-color: rgb(255,91,111,0.35);">{{$terminationCoreDataArray['daily'][$day]['revenueDeltaString']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$terminationCoreDataArray['daily'][$day]['attainmeint']}}%, rgba(247, 247, 247,0.5) {{$terminationCoreDataArray['daily'][$day]['attainmeint']}}%);">{{$terminationCoreDataArray['daily'][$day]['attainmeintString']}} %</td>
                                        </tr>
                                        @endforeach
                                        <tr style="font-weight: bold; background-color: #ddd;">
                                            <td>Summe</td>
                                            <td style="text-align: center;">{{$terminationWorktimeArray['cumulative']['fte_medium_string']}}</td>
                                            <td style="text-align: center;">{{$terminationWorktimeArray['cumulative']['paid_hours_string']}}</td>
                                            <td style="text-align: center; font-style: italic;">{{$terminationSalesDataArray['kdwSalesData']['cumulative']['sumDistinctCasesString']}}</td>
                                            <td style="text-align: right; font-style: italic;">{{$terminationSalesDataArray['kdwSalesData']['cumulative']['revenueCaseString']}} €</td>
                                            <td style="text-align: right; font-style: italic;">{{$terminationSalesDataArray['kdwSalesData']['cumulative']['revenueSumString']}} €</td>
                                            @if($terminationCoreDataArray['cumulative']['revenuePaidHour'] >= $defaultVariablesArray['revenue_hour_should']['1u1_terminationadministration'])
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$terminationCoreDataArray['cumulative']['revenuePaidHourString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$terminationCoreDataArray['cumulative']['revenuePaidHourString']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$terminationWorktimeArray['cumulative']['revenue_should_string']}} €</td>
                                            @if($terminationCoreDataArray['cumulative']['revenueDelta'] >= 0)
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$terminationCoreDataArray['cumulative']['revenueDeltaString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$terminationCoreDataArray['cumulative']['revenueDeltaString']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$terminationCoreDataArray['cumulative']['attainmeint']}}%, rgba(221, 221, 221,1) {{$terminationCoreDataArray['cumulative']['attainmeint']}}%);">{{$terminationCoreDataArray['cumulative']['attainmeintString']}} %</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="max-main-container">  
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: flex;">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" style="vertical-align: text-top;">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </div>
                                <div style="margin-left: 5px;">
                                    Information
                                </div>
                            </div>
                            <div class="max-panel-content">
                                <ul class="mb-0">
                                    <li style="font-style: italic;">Vorläufige Werte aus dem KDW-Tracking die teilweise approximiert sind.</li>
                                    <li>Feste Werte.</li>
                                    <li>"FTE-Bestand" und "Std. bezahlt" berücksichtigen die Projektzuordnung der Mitarbeiter zum heutigen Datum. Vergangene Projektzuordnungen können durch den Aufbau der KDW-Datenbank nicht abgebildet werden. Zurückliegende Reporte können deshalb Mitarbeiter berücksichtigen, die zu diesem Zeitpunkt nicht in Projekt aktiv waren.</li>
                                    <li>KDW Sales werden aus dem Tracking mit einem Faktor von {{$terminationSalesDataArray['information']['kueTdr']}}% für Kündigungen und {{$terminationSalesDataArray['information']['brlTdr']}}% für Briefrückläufer zu Distinct Cases approximiert.</li>
                                    <li>Umsätze / Distinct Case werden wie folgt berücksichtigt:</li>
                                    <ul>
                                        <li>Kündigung: {{$terminationSalesDataArray['information']['kueRevenue']}} €</li>
                                        <li>Briefrückläufer: {{$terminationSalesDataArray['information']['brlRevenue']}} €</li>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($defaultVariablesArray['project'] == 'telefonica_outbound')
            <div class="row">  
                <div class="col-md-12">
                    <div class="max-main-container">
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 15px; white-space: nowrap; overflow-x: auto;">
                                <p style="margin: 0; margin-right: auto">Umsatzmeldung</p>
                                <p style="margin: 0; text-align: center">Telefonica Outbound</p>
                                <p style="margin: 0; margin-left: auto;">{{$defaultVariablesArray['startdate']}} - {{$defaultVariablesArray['enddate']}}</p>
                            </div>
                            <div class="max-panel-content">
                                <div style="min-width: 100%; display: flex; border: 1px solid grey; margin-bottom: 10px; overflow-x: auto; white-space: nowrap; background-color: rgb(247, 247, 247);">
                                    <div style="padding: 5px; margin-top: auto; margin-bottom: auto; flex-grow: 1; font-weight: bold; text-align: center;">Planumsatz gesamter Zeitraum</div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Umsatzsoll:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">DB2 Aktuell:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey;">>>></div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey;">>>></div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; font-weight: bold;">{{$telefonicaCoreDataArray['overview']['revenueShouldString']}} €</div>
                                        @if($telefonicaCoreDataArray['overview']['db2'] >= 0)
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$telefonicaCoreDataArray['overview']['db2String']}} %</div>
                                        @else
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; font-weight: bold; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$telefonicaCoreDataArray['overview']['db2String']}} %</div>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; font-weight: bold; text-align: right;">Zielerreichung:</div>
                                        <div style="width: 100%; padding: 5px; border-left: 1px solid grey; font-weight: bold; text-align: right;">Umsatzdelta:</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1">
                                    <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; border-bottom: 1px solid grey; text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$telefonicaCoreDataArray['overview']['attainment']}}%, rgba(247, 247, 247,1) {{$telefonicaCoreDataArray['overview']['attainment']}}%);">{{$telefonicaCoreDataArray['overview']['attainmentString']}} %</div>
                                        @if($telefonicaCoreDataArray['overview']['revenueDelta'] >= 0)
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(0,97,0); background-color: rgb(198,239,206);">{{$telefonicaCoreDataArray['overview']['revenueDeltaString']}} €</div>
                                        @else
                                        <div style="font-weight: bold; width: 100%; padding: 5px; border-left: 1px solid grey; text-align: center; color: rgb(156,0,6); background-color: rgb(255,199,206);">{{$telefonicaCoreDataArray['overview']['revenueDeltaString']}} €</div>
                                        @endif
                                    </div>
                                </div>
                                <div style="font-style: italic">Development Information: Qualitätsbonus-Berechnung über Projektmanagement hinzufügen.</div>
                                <div style="width: 100%; overflow-x: auto;">
                                <table class="max-table">
                                    <thead>
                                        <tr style="width: 100%">
                                            <th>Datum</th>
                                            <th>FTE Bestand</th>
                                            <th>Std. bezahlt</th>
                                            <th>Takes</th>
                                            <th>Ø€ / Take</th>
                                            <th>Umsatz Takes</th>
                                            <th>Umsatz Qualitätsbonus</th>
                                            <th>Umsatz IST</th>
                                            <th>Umsatz / bez. Std.</th>
                                            <th>Umsatz SOLL</th>
                                            <th>Deckung</th>
                                            <th>Zielerreichung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($defaultVariablesArray['days'] as $key => $day)
                                        <tr>
                                            <td>{{$defaultVariablesArray['app_data'][$day]['date_european']}} - {{$defaultVariablesArray['app_data'][$day]['weekday']}}</td>
                                            @if(isset($telefonicaWorktimeArray[$day]['unemployment']) or isset($telefonicaWorktimeArray[$day]['employment']) or isset($telefonicaWorktimeArray[$day]['unproductive']))
                                                <td style="text-align: center;"><abbr title="@if(isset($telefonicaWorktimeArray[$day]['unemployment'])){{''}}@foreach($telefonicaWorktimeArray[$day]['unemployment'] as $user )Austritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($telefonicaWorktimeArray[$day]['employment']))@foreach($telefonicaWorktimeArray[$day]['employment'] as $user )Einritt: {{$user}}&#010;@endforeach{{''}}@endif{{''}}@if(isset($telefonicaWorktimeArray[$day]['unproductive']))@foreach($telefonicaWorktimeArray[$day]['unproductive'] as $user){{$user}}&#010;@endforeach{{''}}@endif">{{$telefonicaWorktimeArray[$day]['FTE_string']}}</abbr></td>
                                                @else
                                                <td style="text-align: center;">{{$telefonicaWorktimeArray[$day]['FTE_string']}}</td>
                                            @endif
                                            <td style="text-align: center;">{{$telefonicaWorktimeArray[$day]['work_hours_string']}}</td>
                                            <td style="text-align: center; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['sumTakes']}}</td>
                                            <td style="text-align: right; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenuePerTakeString']}} €</td>
                                            <td style="text-align: right; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueTakesString']}} €</td>
                                            <td style="text-align: right; font-style: italic">0 €</td>
                                            <td style="text-align: right; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['daily'][$day]['revenueSumString']}} €</td>
                                            @if($telefonicaCoreDataArray['daily'][$day]['revenuePaidHour'] >= $defaultVariablesArray['revenue_hour_should']['telefonica_outbound'])
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$telefonicaCoreDataArray['daily'][$day]['revenuePaidHourString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$telefonicaCoreDataArray['daily'][$day]['revenuePaidHourString']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$telefonicaWorktimeArray[$day]['revenue_should_string']}} €</td>
                                            @if($telefonicaCoreDataArray['daily'][$day]['revenueDelta'] >= 0)
                                                <td style="text-align: right; color: rgb(0,97,0); background-color: rgb(132,220,149,0.5);">{{$telefonicaCoreDataArray['daily'][$day]['revenueDeltaString']}} €</td>
                                                @else
                                                <td style="text-align: right; color: rgb(156,0,6); background-color: rgb(255,91,111,0.35);">{{$telefonicaCoreDataArray['daily'][$day]['revenueDeltaString']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$telefonicaCoreDataArray['daily'][$day]['attainmeint']}}%, rgba(247, 247, 247,0.5) {{$telefonicaCoreDataArray['daily'][$day]['attainmeint']}}%);">{{$telefonicaCoreDataArray['daily'][$day]['attainmeintString']}} %</td>
                                        </tr>
                                        @endforeach
                                        <tr style="font-weight: bold; background-color: #ddd;">
                                            <td>Summe</td>
                                            <td style="text-align: center;">{{$telefonicaWorktimeArray['cumulative']['fte_medium_string']}}</td>
                                            <td style="text-align: center;">{{$telefonicaWorktimeArray['cumulative']['paid_hours_string']}}</td>
                                            <td style="text-align: center; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['cumulative']['sumTakes']}}</td>
                                            <td style="text-align: right; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenuePerTakeString']}} €</td>
                                            <td style="text-align: right; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueTakesString']}} €</td>
                                            <td style="text-align: right; font-style: italic">0 €</td>
                                            <td style="text-align: right; font-style: italic">{{$telefonicaSalesDataArray['kdwSalesData']['cumulative']['revenueSumString']}} €</td>
                                            @if($telefonicaCoreDataArray['cumulative']['revenuePaidHour'] >= $defaultVariablesArray['revenue_hour_should']['telefonica_outbound'])
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$telefonicaCoreDataArray['cumulative']['revenuePaidHourString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$telefonicaCoreDataArray['cumulative']['revenuePaidHourString']}} €</td>
                                            @endif
                                            <td style="text-align: right;">{{$telefonicaWorktimeArray['cumulative']['revenue_should_string']}} €</td>
                                            @if($telefonicaCoreDataArray['cumulative']['revenueDelta'] >= 0)
                                                <td style="color: rgb(0,97,0); background-color: rgb(132,220,149,0.5); text-align: right;">{{$telefonicaCoreDataArray['cumulative']['revenueDeltaString']}} €</td>
                                                @else
                                                <td style="color: rgb(156,0,6); background-color: rgb(255,91,111,0.35); text-align: right;">{{$telefonicaCoreDataArray['cumulative']['revenueDeltaString']}} €</td>
                                            @endif
                                            <td style="text-align: center; background: linear-gradient(90deg, rgba(37,122,255,0.5) {{$telefonicaCoreDataArray['cumulative']['attainmeint']}}%, rgba(221, 221, 221,1) {{$telefonicaCoreDataArray['cumulative']['attainmeint']}}%);">{{$telefonicaCoreDataArray['cumulative']['attainmeintString']}} %</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="max-main-container">  
                        <div class="max-panel">
                            <div class="max-panel-title" style="display: flex;">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" style="vertical-align: text-top;">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </div>
                                <div style="margin-left: 5px;">
                                    Information
                                </div>
                            </div>
                            <div class="max-panel-content">
                                <ul class="mb-0">
                                    <li style="font-style: italic;">Vorläufige Werte aus dem KDW-Tracking die teilweise approximiert sind.</li>
                                    <li>Feste Werte.</li>
                                    <li>"FTE-Bestand" und "Std. bezahlt" berücksichtigen die Projektzuordnung der Mitarbeiter zum heutigen Datum. Vergangene Projektzuordnungen können durch den Aufbau der KDW-Datenbank nicht abgebildet werden. Zurückliegende Reporte können deshalb Mitarbeiter berücksichtigen, die zu diesem Zeitpunkt nicht in Projekt aktiv waren.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif   
        
    </div>
@endsection