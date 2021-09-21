@extends('general_layout')
@section('pagetitle')
    Controlling: Projekt KPI
@endsection
@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="max-panel">
                            <div class="max-panel-title">Projekt</div>
                            <div class="max-panel-content">
                                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                    <label for="inputState" style="margin: auto;">Auswahl:</label>
                                    <select id="inputState" class="form-control" style="color:black;">
                                        <option selected>1u1 DSL Retention</option>
                                        <option>1u1 Mobile Retention</option>
                                        <option>1u1 Kündigungsadministration</option>
                                        <option>Telefonica Outbound</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="max-panel">
                            <div class="max-panel-title">Zeitraum</div>
                            <div class="max-panel-content">
                                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                    <p style="margin: auto;">Von:</p>
                                    <input type="date" id="datefrom" name="from" class="form-control" placeholder="" style="color:black;">
                                    <p style="margin: auto;">Bis:</p>
                                    <input type="date" id="datefrom" name="from" class="form-control" placeholder="" style="color:black;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="max-panel">
                            <div class="max-panel-title">Darstellung</div>
                            <div class="max-panel-content">
                                <p style="font-style: italic;">Vorrübergehend nur "kummuliert" auswählbar.</p>
                                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                    <label for="inputState" style="margin: auto;">Auswahl:</label>
                                    <select id="inputState" class="form-control" style="color:black;">
                                        <option selected>Kumuliert</option>
                                        <!-- 
                                        <option>Monat</option>
                                        <option>Woche</option>
                                        <option>Tag</option>
                                        -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="display:flex; margin-top: 20px; margin-bottom: 20px;">
                        <button class="btn btn-primary" style="margin: auto;">Bericht erzeugen</button>
                    </div>
                </div>
            </div>  
        </div>    
    </div>
    <div class="row">  
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="card card-nav-tabs card-plain">
                    <div class="card-header card-header-danger">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <!--
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#project" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Projekt</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#team" data-toggle="tab" style="font-size: 16px; font-weight: bold;"style="font-size: 16px; font-weight: bold;">Team</a>
                                    </li>
                                    -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="#employee" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Kundenberater</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content text-center">
                            <div class="tab-pane" id="project">

    <!-- Darstellung nur als Beispiel. In zukunft sollen Daten mithilfe eines Array übergeben werden. Dieses Array füllt die entsprechenden Divs automatisch. -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="max-info-panel-kategorie">
                                            Stunden
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- DSL Stunden: Bezahlt -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">Stunden bezahlt</div>
                                            <div class="max-info-panel-value">3684</div>
                                        </div>
                                    </div>
                                    <!-- DSL Stunden: Produktiv -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">Stunden produktiv</div>
                                            <div class="max-info-panel-value">1819</div>
                                        </div>
                                    </div>
                                    <!-- DSL Stunden: Produktiv in % -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">Stunden produktiv in %</div>
                                            <div class="max-info-panel-value">48,9%</div>
                                        </div>
                                    </div>
                                    <!-- DSL Stunden: Pause -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">Stunden Pause</div>
                                            <div class="max-info-panel-value">879</div>
                                        </div>
                                    </div>
                                    <!-- DSL Stunden: Pause in % -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">Stunden Pause in %</div>
                                            <div class="max-info-panel-value">20,6%</div>
                                        </div>
                                    </div>
                                    <!-- DSL Stunden: Krank -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">Stunden Krank</div>
                                            <div class="max-info-panel-value">12</div>
                                        </div>
                                    </div>
                                    <!-- DSL Stunden: Krank in % -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">Stunden Krank in %</div>
                                            <div class="max-info-panel-value">8,5%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="max-info-panel-kategorie">
                                            Calls
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="max-info-panel-kategorie">
                                            Sonstige
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="max-info-panel-kategorie">
                                            Umsatz
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                    <!-- DSL AHT -->
                                    <div class="col-md-3">
                                        <div class="max-info-panel">
                                            <div class="max-info-panel-title">AHT in Sekunden</div>
                                            <div class="max-info-panel-value">583</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="team">
                                Wie Projekt nur mit dem Filter auf Team1, Team2, ...
                            </div>
                            <div class="tab-pane active" id="employee">
                                <div class="max-panel-content">
                                    <div style="width: 100%; overflow-x: auto;">
                                        <table class="max-table">
                                            <thead>
                                                <tr style="width: 100%">
                                                    <th>Team</th>
                                                    <th>Name</th>
                                                    <th>Vorname</th>
                                                    <th>Stunden bezahlt</th>
                                                    <th>Stunden produktiv</th>
                                                    <th>Stunden produktiv (%)</th>
                                                    <th>Stunden pause</th>
                                                    <th>Stunden pause (%)</th>
                                                    <th>Stunden krank</th>
                                                    <th>Stunden krank (%)</th>
                                                    <th>Calls in Stk.</th>
                                                    <th>Calls / Std.</th>
                                                    <th>AHT</th>
                                                    <th>GeVo CR DSL</th>
                                                    <th>Gesamt CR</th>
                                                    <th>OptIn Quote (%)</th>
                                                    <th>RLZ+24 Quote</th>
                                                    <th>SAS in Stk.</th>
                                                    <th>Umsatz (€)</th>
                                                    <th>Umsatz / Std. bez.</th>
                                                    <th>Umsatz / Std. prod.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- For Each schleife! -->
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                    <td>%</td>
                                                <!-- Summe -->
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
@endsection