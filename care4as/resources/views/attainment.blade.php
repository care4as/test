@extends('general_layout')
@section('pagetitle')
    Controlling: Zielerreichung
@endsection
@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('attainment')}}" method="get()"> 
                    @csrf
                    <div class="max-main-container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="max-panel">
                                    <div class="max-panel-title">Ziel</div>
                                    <div class="max-panel-content">
                                        <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                            <label for="inputState" style="margin: auto;">Auswahl:</label>
                                            <select id="inputState" class="form-control" name="attainment" style="color:black;">
                                                @if($defaultVariablesArray['attainment'] == 'dsl_interval_attainment')
                                                    <option seleted value="dsl_interval_attainment">DSL Intervallerfüllung</option>
                                                @else
                                                    <option value="dsl_interval_attainment">DSL Intervallerfüllung</option>
                                                @endif
                                                @if($defaultVariablesArray['attainment'] == 'dsl_forecast_attainment')
                                                    <option selected value="dsl_forecast_attainment">DSL Forecasterfüllung</option>
                                                @else
                                                    <option value="dsl_forecast_attainment">DSL Forecasterfüllung</option>
                                                @endif
                                                @if($defaultVariablesArray['attainment'] == 'dsl_employee_surcharge')
                                                    <option selected value="dsl_employee_surcharge">MA Stundenuschlag</option>
                                                @else
                                                    <option value="dsl_employee_surcharge">MA Stundenzuschlag</option>
                                                @endif
                                                @if($defaultVariablesArray['attainment'] == 'mobile_employee_surcharge')
                                                    <option selected value="mobile_employee_surcharge">MA Stundenuschlag</option>
                                                @else
                                                    <option value="mobile_employee_surcharge">MA Stundenzuschlag</option>
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
                                            <input type="date" id="dateFrom" name="startDate" class="form-control" placeholder="" value="{{$defaultVariablesArray['startDate']}}" style="color: black;">
                                            <p style="margin: auto;">Bis:</p>
                                            <input type="date" id="dateTo" name="endDate" class="form-control" placeholder="" value="{{$defaultVariablesArray['endDate']}}" style="color: black;">
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

        <!-- DSL INTERVALLERFÜLLUNG -->
        @if($defaultVariablesArray['attainment'] == 'dsl_interval_attainment')
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                <div class="card card-nav-tabs card-plain">
                    <!-- Card Management -->
                    <div class="card-header card-header-danger">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#overview" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Übersicht</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#data" data-toggle="tab" style="font-size: 16px; font-weight: bold;"style="font-size: 16px; font-weight: bold;">Daten</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#information" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Informantion</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Content Cards -->
                    <div class="card-body ">
                        <div class="tab-content text-center">

                            <!-- Card: Overview -->
                            <div class="tab-pane active" id="overview">
                                <div class="max-panel-content">
                                    <div style="width: 100%; overflow-x: auto;">
                                        <table class="max-table">
                                            <thead>
                                                <tr style="width: 100%">
                                                    <th>Name</th>
                                                    <th>Berücksichtigte IV</th>
                                                    <th>Geschaffte IV</th>
                                                    <th>Verfehlte IV</th>
                                                    <th>IV-Erfüllung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach($attainmentArray['employees'] as $key => $employee)
                                                        <tr>
                                                            <td style="text-align: left;">{{$employee['lastname']}}, {{$employee['firstname']}}</td>
                                                            <td>{{$employee['count_considered_interval']}}</td>
                                                            <td>{{$employee['count_is_fullfilled']}}</td>
                                                            <td>{{$employee['count_is_not_fullfilled']}}</td>
                                                            <td>{{$employee['interval_fullfillment_ratio']}}%</td>
                                                        </tr>
                                                    @endforeach
                                                <!-- Summe -->
                                                <tr style="font-weight: bold; background-color: #ddd;">
                                                    <td>Gesamt</td>
                                                    <td>{{$attainmentArray['sum']['count_considered_interval']}}</td>
                                                    <td>{{$attainmentArray['sum']['count_is_fullfilled']}}</td>
                                                    <td>{{$attainmentArray['sum']['count_is_not_fullfilled']}}</td>
                                                    <td>{{$attainmentArray['sum']['interval_fullfillment_ratio']}}</td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                            </div>

                            <!-- Card: Data -->
                            <div class="tab-pane" id="data">
                                <div class="max-panel-content">
                                    <div style="width: 100%; overflow-x: auto;">
                                        <table class="max-table">
                                            <thead>
                                                <tr style="width: 100%">
                                                    <th>Intervall</th>
                                                    <th>Erfüllung</th>
                                                    @foreach($attainmentArray['employees'] as $key => $employee)
                                                        <th>{{$employee['lastname']}}, {{$employee['firstname']}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($attainmentArray['interval_list'] as $key => $date)
                                                    @if(isset($date['intervals']))
                                                        @foreach($date['intervals'] as $key => $interval)
                                                        <tr>
                                                            <td>{{$key}}</td>
                                                            @if($interval['fulfilled'] == 'yes')
                                                                <td>Ja</td>
                                                                @else
                                                                <td>Nein</td>
                                                            @endif
                                                            @foreach($interval['workforcer'] as $key => $workforceEmployee)
                                                                @if($workforceEmployee['present'] == 'yes')
                                                                    <td>Anwesend</td>
                                                                @else
                                                                    <td>-</td>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>{{$date['europeanDate']}}: Keine Rohdaten vorhanden.</td>
                                                        </tr>       
                                                    @endif
                                                @endforeach      
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                            </div>

                            <!-- Card: Information -->
                            <div class="tab-pane" id="information">
                                <div class="max-panel-content" style="text-align: left; overflow-x: auto;">
                                    <ul>
                                        <li>Die Intervallerfüllung wird direkt aus dem vorhandenen Availbench-Report berechnet.</li>
                                        <ul>
                                            <li>Ein rückwirkenes Überschreiben vorhandener Datensätze ist durch einpflegen aktueller Datensätze möglich.</li>
                                        </ul>
                                        <li>Ausschlaggebend für die Berücksichtigung eines Intervalls ist ein vorhandener Forecast >0.</li>
                                        <li>Die Intervallerfüllung ist vom Malus abhängig:</li>
                                        <ul>
                                            <li>Sofern kein Malus hinterlegt ist, gilt ein Intervall als geschafft.</li>
                                            <li>Sofern ein Malus hinterlegt ist, gilt ein Intervall als nicht geschafft.</li>
                                        </ul>
                                        <li>Die Intervallerfüllung wird über die Login-Zeit im KDW Management Tool zugeordnet.</li>
                                        <ul>
                                            <li>Besteht in Intervall "X" ein Anwesenheitsstatus, wird die Intervallerfüllung für diesen Intervall gewertet, sofern der Arbeitsanteil des Intervalls 15 Minuten überschreitet.</li>
                                        </ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>        
        @endif
        <!-- END DSL INTERVALLERFÜLLUNG -->

        <!-- DSL FORECASTERFÜLLUNG -->
        @if($defaultVariablesArray['attainment'] == 'dsl_forecast_attainment')
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                <div class="card card-nav-tabs card-plain">
                    <!-- Card Management -->
                    <div class="card-header card-header-danger">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#overview" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Übersicht</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#data" data-toggle="tab" style="font-size: 16px; font-weight: bold;"style="font-size: 16px; font-weight: bold;">Daten</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#information" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Informantion</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Content Cards -->
                    <div class="card-body ">
                        <div class="tab-content text-center">

                            <!-- Card: Overview -->
                            <div class="tab-pane active" id="overview">
                                <div class="max-panel-content">
                                    <div style="width: 100%; overflow-x: auto;">
                                        <table class="max-table">
                                            <thead>
                                                <tr style="width: 100%">
                                                    <th>Name</th>
                                                    <th>Berücksichtigte IV</th>
                                                    <th>Forecast Calls</th>
                                                    <th>Handled Calls</th>
                                                    <th>Forecast-Erfüllung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach($attainmentArray['employees'] as $key => $employee)
                                                        <tr>
                                                            <td style="text-align: left;">{{$employee['lastname']}}, {{$employee['firstname']}}</td>
                                                            <td>{{$employee['count_considered_interval']}}</td>
                                                            <td>{{$employee['count_forecast_calls']}}</td>
                                                            <td>{{$employee['count_handled_calls']}}</td>
                                                            <td>{{$employee['forecast_fullfillment_ratio']}}%</td>
                                                        </tr>
                                                    @endforeach
                                                <!-- Summe -->
                                                <tr style="font-weight: bold; background-color: #ddd;">
                                                    <td>Gesamt</td>
                                                    <td>{{$attainmentArray['sum']['count_considered_interval']}}</td>
                                                    <td>{{$attainmentArray['sum']['count_forecast_calls']}}</td>
                                                    <td>{{$attainmentArray['sum']['count_handled_calls']}}</td>
                                                    <td>{{$attainmentArray['sum']['forecast_fullfillment_ratio']}}%</td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                            </div>

                            <!-- Card: Data -->
                            <div class="tab-pane" id="data">
                                <div class="max-panel-content">
                                    <div style="width: 100%; overflow-x: auto;">
                                        <table class="max-table">
                                            <thead>
                                                <tr style="width: 100%">
                                                    <th>Intervall</th>
                                                    <th>Forecast Calls</th>
                                                    <th>Handled Calls</th>
                                                    @foreach($attainmentArray['employees'] as $key => $employee)
                                                        <th>{{$employee['lastname']}}, {{$employee['firstname']}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($attainmentArray['interval_list'] as $key => $date)
                                                    @if(isset($date['intervals']))
                                                        @foreach($date['intervals'] as $key => $interval)
                                                        <tr>
                                                            <td>{{$key}}</td>
                                                            <td>{{$interval['forecast_calls']}}</td>
                                                            <td>{{$interval['handled_calls']}}</td>
                                                            @foreach($interval['workforcer'] as $key => $workforceEmployee)
                                                                @if($workforceEmployee['present'] == 'yes')
                                                                    <td>Anwesend</td>
                                                                @else
                                                                    <td>-</td>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>{{$date['europeanDate']}}: Keine Rohdaten vorhanden.</td>
                                                        </tr>       
                                                    @endif
                                                @endforeach      
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                            </div>

                            <!-- Card: Information -->
                            <div class="tab-pane" id="information">
                                <div class="max-panel-content" style="text-align: left; overflow-x: auto;">
                                    <ul>
                                        <li>Die Forecasterfüllung wird direkt aus dem vorhandenen Availbench-Report berechnet.</li>
                                        <ul>
                                            <li>Ein rückwirkenes Überschreiben vorhandener Datensätze ist durch einpflegen aktueller Datensätze möglich.</li>
                                        </ul>
                                        <li>Ausschlaggebend für die Berücksichtigung eines Forecasts ist ein vorhandener Forecast >0.</li>
                                        <li>Die Forecasterfüllung berechnet sich folgend:</li>
                                        <ul>
                                            <li>Summe handled Calls / Summe forecast Calls</li>
                                        </ul>
                                        <li>Die Forecasterfüllung wird über die Login-Zeit im KDW Management Tool zugeordnet.</li>
                                        <ul>
                                            <li>Besteht in Intervall "X" ein Anwesenheitsstatus, wird die Forecasterfüllung für diesen Intervall gewertet, sofern der Arbeitsanteil des Intervalls 15 Minuten überschreitet.</li>
                                        </ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>        
        @endif
        <!-- END DSL FORECASTERFÜLLUNG -->

        <!-- MA DSL STUNDENZUSCHLAG -->
        @if($defaultVariablesArray['attainment'] == 'dsl_employee_surcharge')
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="max-panel">
                        <div class="max-panel-title">MA Stundenzuschlag</div>
                        <div class="max-panel-content">
                            <table class="max-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Wert</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Summe</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                          
                </div>
            </div>
        </div>        
        @endif
        <!-- END MA STUNDENZUSCHLAG -->


    </div>
@endsection