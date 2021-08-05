@extends('general_layout')
@section('pagetitle')
    Controlling: Umsatzmeldung
@endsection
@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="max-panel">
                                <div class="max-panel-title">Projektauswahl</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                        <label for="inputState" style="margin: auto;">Auswahl:</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Alle</option>
                                            <option>1u1 DSL Retention</option>
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
                                <div class="max-panel-title">Datumsauswahl</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <p style="margin: auto;">Von:</p>
                                        <input type="date" id="datefrom" name="from" class="form-control" placeholder="">
                                        <p style="margin: auto;">Bis:</p>
                                        <input type="date" id="datefrom" name="from" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="max-panel">
                                <div class="max-panel-title" style="display: flex">
                                    <div style="margin-right: auto;">Zielwerte</div>
                                    <div style="margin-left: auto; display: flex;" id="controlling_umsatzmeldung_zielwerte_toggle">
                                        <div style="display: flex;">
                                            <i class="now-ui-icons ui-1_check" style="margin: auto; padding-left: 4px; padding-right: 4px;"></i>
                                        </div>
                                        <div style="display: flex;">
                                            <i class="now-ui-icons ui-1_simple-remove" style="margin: auto; padding-left: 4px; padding-right: 4px;"></i>
                                        </div>
                                    </div>
                                    <div style="display: flex;" onclick="controlling_umsatzmeldung_zielwerte_toggle()">
                                        <i class="now-ui-icons ui-1_settings-gear-63" style="margin: auto; padding-left: 4px; padding-right: 4px;"></i>
                                    </div>
                                    
                                    <!-- //Informationsbutton
                                    <div style="margin-left: auto">
                                        <div>
                                            <a class="nav-link dropdown-toggle" id="controlling_zielwert_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0;">
                                            <i class="now-ui-icons travel_info"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="controlling_zielwert_dropdown" id="testdropdown">
                                                <p style="margin: 0;">Die Zielwerte werden für das ausgewählte Projekt angezeigt und können über die Schaltflächen angepasst werden. Änderungen sind persistent.</p>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                </div>
                                <div class="max-panel-content">
                                    <div>
                                        <p>In neuen Reiter "Projektverwaltung" schieben?</p>
                                    </div>
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <p style="margin: auto;">Krankenquote:</p>
                                        <input class="form-control" id="controlling_krankenquote_disabledInput" type="text" placeholder="8%" disabled>
                                        <p style="margin: auto;">Prod. in %:</p>
                                        <input class="form-control" id="controlling_krankenquote_disabledInput" type="text" placeholder="80%" disabled>
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
                    <div class="max-panel">
                        <div class="max-panel-title" style="display: grid; grid-template-columns: 1fr 1fr 1fr">
                            <p style="margin: 0">Umsatzmeldung</p>
                            <p style="margin: 0; margin-left: auto; margin-right: auto;">1u1 Mobile Retention</p>
                            <p style="margin: 0; margin-left: auto;">01.07.2021 - 05.07.2021</p>
                        </div>
                        <div class="max-panel-content" style="overflow-x: scroll;">
                            <table style="width: 100%; white-space: nowrap;">
                                <thead>
                                    <tr style="width: 100%">
                                        <th>Datum</th>
                                        <th>Std. bezahlt</th>
                                        <th>KQ (netto)</th>
                                        <th>Prod. in %</th>
                                        <th>CR SSC</th>
                                        <th>CR BSC</th>
                                        <th>CR Portal</th>
                                        <th>Umsatz IST</th>
                                        <th>Umsatz / bez. Std.</th>
                                        <th>Umsatz SOLL</th>
                                        <th>Deckung</th>
                                        <th>Zielerreichung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sa, 01.07.2021</td>
                                        <td>72,59</td>
                                        <td>0,0%</td>
                                        <td>89,0%</td>
                                        <td>56,0%</td>
                                        <td>18,4%</td>
                                        <td>118,8%</td>
                                        <td>3.464,31€</td>
                                        <td>47,72€</td>
                                        <td>2540,65€</td>
                                        <td>923,66€</td>
                                        <td>136,0%</td>
                                    </tr>
                                    <tr>
                                        <td>So, 02.07.2021</td>
                                        <td>72,59</td>
                                        <td>0,0%</td>
                                        <td>89,0%</td>
                                        <td>56,0%</td>
                                        <td>18,4%</td>
                                        <td>118,8%</td>
                                        <td>3.464,31€</td>
                                        <td>47,72€</td>
                                        <td>2540,65€</td>
                                        <td>923,66€</td>
                                        <td>136,0%</td>
                                    </tr>
                                    <tr>
                                        <td>Mo, 03.07.2021</td>
                                        <td>72,59</td>
                                        <td>0,0%</td>
                                        <td>89,0%</td>
                                        <td>56,0%</td>
                                        <td>18,4%</td>
                                        <td>118,8%</td>
                                        <td>3.464,31€</td>
                                        <td>47,72€</td>
                                        <td>2540,65€</td>
                                        <td>923,66€</td>
                                        <td>136,0%</td>
                                    </tr>
                                    <tr>
                                        <td>Di, 04.07.2021</td>
                                        <td>72,59</td>
                                        <td>0,0%</td>
                                        <td>89,0%</td>
                                        <td>56,0%</td>
                                        <td>18,4%</td>
                                        <td>118,8%</td>
                                        <td>3.464,31€</td>
                                        <td>47,72€</td>
                                        <td>2540,65€</td>
                                        <td>923,66€</td>
                                        <td>136,0%</td>
                                    </tr>
                                    <tr>
                                        <td>Mi, 05.07.2021</td>
                                        <td>72,59</td>
                                        <td>0,0%</td>
                                        <td>89,0%</td>
                                        <td>56,0%</td>
                                        <td>18,4%</td>
                                        <td>118,8%</td>
                                        <td>3.464,31€</td>
                                        <td>47,72€</td>
                                        <td>2540,65€</td>
                                        <td>923,66€</td>
                                        <td>136,0%</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
@endsection