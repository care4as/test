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
                                            <select id="inputState" class="form-control" name="project" style="color:black;">
                                                <option value="wfm_dsl_availbench">WFM DSL Availbench</option>
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
                                            <input type="date" id="dateFrom" name="startDate" class="form-control" placeholder="" value="" style="color: black;">
                                            <p style="margin: auto;">Bis:</p>
                                            <input type="date" id="dateTo" name="endDate" class="form-control" placeholder="" value="" style="color: black;">
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

        <!-- WFM DSL Availbench -->
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
                                                <!-- For Each schleife! -->
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                <!-- Summe -->
                                                <tr style="font-weight: bold; background-color: #ddd;">
                                                    <td>Gesamt</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
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
                                                    <th>Tag</th>
                                                    <th>Intervall</th>
                                                    <th>Erfüllung</th>
                                                    <th>Name1</th>
                                                    <th>Name2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- For Each schleife! -->
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                <!-- Summe -->
                                                <tr style="font-weight: bold; background-color: #ddd;">
                                                    <td>Gesamt</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                </tr>
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
        <!-- END WFM DSL Availbench -->

    </div>
@endsection