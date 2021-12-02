@extends('general_layout')
@section('pagetitle')
Controlling: Projektmeldung
@endsection
@section('content')
@section('additional_css')
<style>
    .A4Paper {
        width: 21cm;
        height: 29.7cm;
        background: white;
        margin: 20px auto;
        box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.4);
        padding: 1cm;
        font-size: 10pt;
        font-family: 'Segoe UI';
    }

    .form-control[disabled]{
        cursor: default;
    }

</style>
<style type="text/css" media="print">
    @page {
        size: auto;
        /* auto is the initial value */
        margin: 0mm;
        /* this affects the margin in the printer settings */
    }
</style>

@endsection

<div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('feedback.showfeedback')}}" method="get()">
                @csrf
                <div class="max-main-container">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#newEntry" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Neuer Eintrag</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#monthList" data-toggle="" style="font-size: 16px; font-weight: bold;">Monatsliste</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#allEntries" data-toggle="" style="font-size: 16px; font-weight: bold;">Alle Einträge</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="newEntry">
                            <div class="row">
                                <div class="col-md-6 col-xl-4">
                                    <div class="max-panel">
                                        <div class="max-panel-title">
                                            Projektauswahl
                                        </div>
                                        <div class="max-panel-content">
                                            <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                                <label for="project" style="margin: auto;">Auswahl:</label>
                                                <select id="project" class="form-control" name="project" style="color:black;" onchange="updateUserSelection()">
                                                    <option disabled selected value>Wähle ein Projekt</option>
                                                    @foreach($feedbackArray['projects'] as $key => $entry)
                                                        <option value="{{$key}}" <?php if($feedbackArray['userformSelection']['selected_project'] == $key): ?> selected <?php endif ?>>{{$entry['name']}}</option>
                                                    @endforeach                                                
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="max-panel">
                                        <div class="max-panel-title">
                                            Mitarbeiterauswahl
                                        </div>
                                        <div class="max-panel-content">
                                        <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                                <label for="userSelection" style="margin: auto;">Auswahl:</label>
                                                <select id="userSelection" class="form-control" name="userSelection" style="color:black;" onchange="updateFeedbackTable()">                                      
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="max-panel">
                                        <div class="max-panel-title">
                                            Kalenderwoche
                                        </div>
                                        <div class="max-panel-content">
                                            <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                                <p style="margin: auto;">Datum:</p>
                                                <input type="date" id="week" name="week" class="form-control" placeholder="" style="color:black;" onchange="updateWeekSelection()" value="{{$feedbackArray['userformSelection']['selected_startDate']}}">
                                            </div>
                                            <div style="display: grid; grid-template-columns: 1fr 1fr; column-gap: 10px; row-gap: 5px; margin-top: 10px; text-align:center;" >
                                                <div style="font-weight: bold;">Von</div>
                                                <div style="font-weight: bold;">Bis</div>
                                                <div>
                                                    <input id="startDate" type="date" name="startDate" class="form-control" disabled value="{{$feedbackArray['timespan']['first_week_start_date']}}">
                                                </div>
                                                <div>
                                                    <input id="endDate" type="date" name="endDate" class="form-control" disabled value="{{$feedbackArray['timespan']['last_week_end_date']}}">
                                                </div>
                                                <div>
                                                    <input id="startWeek" type="text" class="form-control" disabled value="KW {{$feedbackArray['timespan']['first_week_number']}}">
                                                </div>
                                                <div>
                                                    <input id="endWeek" type="text" class="form-control" disabled value="KW {{$feedbackArray['timespan']['last_week_number']}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="max-panel">
                                        <div class="max-panel-title">
                                            Aktionen
                                        </div>
                                        <div class="max-panel-content">
                                            <button type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0; width: 100%; font-size: 14px;">Zeitraum anpassen</button>
                                            <hr>
                                            <button type="button" onclick="PrintDiv()" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0px; margin-bottom: 0; width: 100%; font-size: 14px;">Drucken</button>
                                            <button disabled type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 10px; margin-bottom: 0; width: 100%; font-size: 14px;">Speichern</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="monthList">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="max-panel">
                                        <div class="max-panel-title">
                                            TAB2
                                        </div>
                                        <div class="max-panel-content">
                                            1,2,3...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="allEntries">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="max-panel">
                                        <div class="max-panel-title">
                                            TAB3
                                        </div>
                                        <div class="max-panel-content">
                                            1,2,3...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- <input type="button" onclick="PrintDiv()" value="print a div!" /> -->

    <!-- START FEEDBACKVIEW -->
    <div style="width: 21cm; height: 29.7cm; margin: 0mm auto; box-shadow: 0px 0px 20px 5px rgba(0,0,0,0.4); padding: 1cm; font-size: 12pt; background-color: white; display: none;" id="feedBackView">

        <div id="divToPrint" style="height: 100%">
            <div id="header" style="display: flex">
                <div style="width: 60%; display: flex; flex-direction: column; font-family:Calibri;">
                    <div id="title" style="font-weight: bold; font-size: 16pt">Feedbackgespräch</div>
                    <div id="feedback_table_project">1und1 DSL Retention</div>
                    <div id="feedback_table_date">18.11.2021</div>
                </div>
                <div id="image" style="width: 40%;">
                    <img src="{{asset('images/Logo_Care4as_2 - Kopie.png')}}" style="max-width: 100%;">
                </div>
            </div>
            <div id="participants" style="width: 100%; display: flex; margin-top: 40pt; font-family:Calibri;">
                <div id="who" style="width: 50%; text-align: center;">
                    <div id="feedback_table_for" style="font-size: 16pt; font-weight: bold;">Maximilian Steinberg</div>
                    <div style="width:70%; height: 2px; background-color: #EC7429; margin: 0 auto;"></div>
                    <div style="font-size: 12pt;">geführt mit</div>
                </div>
                <div id="width" style="width: 50%; text-align: center;">
                    <div id="feedback_table_from" style="font-size: 16pt; font-weight: bold;">{{$feedbackArray['userformSelection']['current_user']}}</div>
                    <div style="width:70%; height: 2px; background-color: #EC7429; margin: 0 auto;"></div>
                    <div style="font-size: 12pt;">geführt von</div>
                </div>
            </div>
            <div id="salesperformance" style="font-family:Calibri; margin-top: 40pt;">
                <div style="font-size: 16pt; font-weight: bold;">Salesperformance</div>
                <table style="width: 100%; border: none; border-radius: 4pt; border-collapse: collapse;">
                    <tbody style="text-align: center;">
                        <tr>
                            <td rowspan="2" id="feedback_table_year" colspan="2" style="font-weight: bold; background-color: #EC7429; border-top-left-radius: 8px; color: white;"></td>
                            <td colspan="2" id="feedback_table_first_week" style="font-weight: bold; background-color: #EC7429; color: white;"></td>
                            <td colspan="2" id="feedback_table_last_week" style="font-weight: bold; background-color: #EC7429; border-top-right-radius: 8px; color: white;"></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white; -webkit-print-color-adjust: exact;">KB</td>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white;-webkit-print-color-adjust: exact;">Projekt</td>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white;-webkit-print-color-adjust: exact;">KB</td>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white;-webkit-print-color-adjust: exact;">Projekt</td>
                        </tr>
                        <!-- DSL START -->
                        <tr class="dsl_row">
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">Calls</td>
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">DSL</td>
                            <td style="background-color: #f4f2f3;" id="first_week_user_calls_dsl">0</td>
                            <td style="background-color: #f4f2f3;" id="first_week_project_calls_dsl">0</td>
                            <td style="background-color: #f4f2f3;" id="last_week_user_calls_dsl">0</td>
                            <td style="background-color: #f4f2f3;" id="last_week_project_calls_dsl">0</td>
                        </tr>
                        <tr class="dsl_row">
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">Saves</td>
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">DSL</td>
                            <td style="background-color: #e0e0e0;" id="first_week_user_orders_dsl">0</td>
                            <td style="background-color: #e0e0e0;" id="first_week_project_orders_dsl">0</td>
                            <td style="background-color: #e0e0e0;" id="last_week_user_orders_dsl">0</td>
                            <td style="background-color: #e0e0e0;" id="last_week_project_orders_dsl">0</td>
                        </tr class="dsl_row">
                        <tr style="border-bottom: 2px solid #EC7429;" class="dsl_row">
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">CR</td>
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">DSL</td>
                            <td style="background-color: #f4f2f3;" id="first_week_user_cr_dsl">0%</td>
                            <td style="background-color: #f4f2f3;" id="first_week_project_cr_dsl">0%</td>
                            <td style="background-color: #f4f2f3;" id="last_week_user_cr_dsl">0%</td>
                            <td style="background-color: #f4f2f3;" id="last_week_project_cr_dsl">0%</td>
                        </tr>
                        <!-- DSL END -->
                        <!-- MOBILE START -->
                            <!-- CALLS START -->
                                <tr class="mobile_row">
                                    <td rowspan="3" style="font-weight: bold; background-color: #EF9223; color: white;">Calls</td>   
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">SSC</td>
                                    <td style="background-color: #f4f2f3;" id="first_week_user_calls_ssc">0</td>
                                    <td style="background-color: #f4f2f3;" id="first_week_project_calls_ssc">0</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_user_calls_ssc">0</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_project_calls_ssc">0</td> 
                                </tr>
                                <tr  class="mobile_row">
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">BSC</td> 
                                    <td style="background-color: #e0e0e0;" id="first_week_user_calls_bsc">0</td>
                                    <td style="background-color: #e0e0e0;" id="first_week_project_calls_bsc">0</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_user_calls_bsc">0</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_project_calls_bsc">0</td>
                                </tr>
                                <tr class="mobile_row"> 
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">Portale</td> 
                                    <td style="background-color: #f4f2f3;" id="first_week_user_calls_portale">0</td>
                                    <td style="background-color: #f4f2f3;" id="first_week_project_calls_portale">0</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_user_calls_portale">0</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_project_calls_portale">0</td>
                                </tr>
                            <!-- CALLS END -->
                            <!-- SAVES START -->
                                <tr class="mobile_row">
                                    <td rowspan="3" style="font-weight: bold; background-color: #EF9223; color: white;">Saves</td>   
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">SSC</td>
                                    <td style="background-color: #e0e0e0;" id="first_week_user_orders_ssc">0</td>
                                    <td style="background-color: #e0e0e0;" id="first_week_project_orders_ssc">0</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_user_orders_ssc">0</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_project_orders_ssc">0</td> 
                                </tr>
                                <tr class="mobile_row">
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">BSC</td> 
                                    <td style="background-color: #f4f2f3;" id="first_week_user_orders_bsc">0</td>
                                    <td style="background-color: #f4f2f3;" id="first_week_project_orders_bsc">0</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_user_orders_bsc">0</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_project_orders_bsc">0</td>
                                </tr>
                                <tr class="mobile_row"> 
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">Portale</td> 
                                    <td style="background-color: #e0e0e0;" id="first_week_user_orders_portale">0</td>
                                    <td style="background-color: #e0e0e0;" id="first_week_project_orders_portale">0</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_user_orders_portale">0</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_project_orders_portale">0</td>
                                </tr>
                            <!-- SAVES END -->
                            <!-- CR START -->
                                <tr class="mobile_row">
                                    <td rowspan="3" style="font-weight: bold; background-color: #EF9223; color: white;">CR</td>   
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">SSC</td> 
                                    <td style="background-color: #f4f2f3;" id="first_week_user_cr_ssc">0%</td>
                                    <td style="background-color: #f4f2f3;" id="first_week_project_cr_ssc">0%</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_user_cr_ssc">0%</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_project_cr_ssc">0%</td>
                                </tr>
                                <tr class="mobile_row">
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">BSC</td> 
                                    <td style="background-color: #e0e0e0;" id="first_week_user_cr_bsc">0%</td>
                                    <td style="background-color: #e0e0e0;" id="first_week_project_cr_bsc">0%</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_user_cr_bsc">0%</td>
                                    <td style="background-color: #e0e0e0;" id="last_week_project_cr_bsc">0%</td>
                                </tr>
                                <tr class="mobile_row" style="border-bottom: 2px solid #EC7429;"> 
                                    <td style="font-weight: bold; background-color: #EF9223; color: white;">Portale</td> 
                                    <td style="background-color: #f4f2f3;" id="first_week_user_cr_portale">0%</td>
                                    <td style="background-color: #f4f2f3;" id="first_week_project_cr_portale">0%</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_user_cr_portale">0%</td>
                                    <td style="background-color: #f4f2f3;" id="last_week_project_cr_portale">0%</td>
                                </tr>
                            <!-- CR END -->                                
                        <!-- MOBILE END -->
                    </tbody>
                </table>
            </div>
            <div id="qualitaetsformance" style="font-family:Calibri; margin-top: 25pt;">
                <div style="font-size: 16pt; font-weight: bold;">Qualitätsperformance</div>
                <table style="width: 100%; border: none; border-radius: 4pt; border-collapse: collapse;">
                    <tbody style="text-align: center;">
                        <tr>
                            <td rowspan="2" id="feedback_table_year2" colspan="1" style="font-weight: bold; background-color: #EC7429; border-top-left-radius: 8px; color: white;"></td>
                            <td colspan="2" id="feedback_table_first_week2" style="font-weight: bold; background-color: #EC7429; color: white;"></td>
                            <td colspan="2" id="feedback_table_last_week2" style="font-weight: bold; background-color: #EC7429; border-top-right-radius: 8px; color: white;"></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white; -webkit-print-color-adjust: exact;">KB</td>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white;-webkit-print-color-adjust: exact;">Projekt</td>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white;-webkit-print-color-adjust: exact;">KB</td>
                            <td style="width: 20%; font-weight: bold; background-color: #EC7429; color: white;-webkit-print-color-adjust: exact;">Projekt</td>
                        </tr>
                        <!-- ALL START -->
                        <tr>
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">OptIn Quote</td>
                            <td style="background-color: #f4f2f3;" id="first_week_user_optin">0%</td>
                            <td style="background-color: #f4f2f3;" id="first_week_project_optin">0%</td>
                            <td style="background-color: #f4f2f3;" id="last_week_user_optin">0%</td>
                            <td style="background-color: #f4f2f3;" id="last_week_project_optin">0%</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">RLZ+24 Quote</td>
                            <td style="background-color: #e0e0e0;" id="first_week_user_rlz">0%</td>
                            <td style="background-color: #e0e0e0;" id="first_week_project_rlz">0%</td>
                            <td style="background-color: #e0e0e0;" id="last_week_user_rlz">0%</td>
                            <td style="background-color: #e0e0e0;" id="last_week_project_rlz">0%</td>
                        </tr>
                        <tr style="border-bottom: 2px solid #EC7429;">
                            <td style="font-weight: bold; background-color: #EF9223; color: white;">AHT</td>
                            <td style="background-color: #f4f2f3;" id="first_week_user_aht">0</td>
                            <td style="background-color: #f4f2f3;" id="first_week_project_aht">0</td>
                            <td style="background-color: #f4f2f3;" id="last_week_user_aht">0</td>
                            <td style="background-color: #f4f2f3;" id="last_week_project_aht">0</td>
                        </tr>
                        <!-- ALL END -->
                    </tbody>
                </table>
            </div>
            <div id="qualitaetsformance" style="font-family:Calibri; font-size: 12pt; margin-top: 25pt;">
                <div style="font-size: 16pt; font-weight: bold;">Vereinbarung</div>
                <textarea id="textAreaInput" style="width: 100%; height: 200px; font-family:Calibri; font-size: 12pt; border: 2px solid #EC7429;"></textarea>
            </div>
        </div>

    </div>
    <!-- END FEEDBACKVIEW -->
    <div style="height: 25px;">

    </div>

</div>
@endsection

@section('additional_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script type="text/javascript">
    function PrintDiv() {
        var divToPrint = document.getElementById('divToPrint');
        var popupWin = window.open('', '_blank', 'width=730,height=900');
        var textAreaInput = document.getElementById('textAreaInput').value;
        popupWin.document.open();
        popupWin.document.write('<html<style type="text/css" media="print"></style><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.getElementById('textAreaInput').value = textAreaInput;
        popupWin.document.close();
    }

    var userArray = <?php echo json_encode($feedbackArray['users']) ?>;
    var timespanArray = <?php echo json_encode($feedbackArray['timespan']) ?>;
    var dataArray = <?php echo json_encode($feedbackArray['data']) ?>;
    var selectedUser = 
        <?php 
            if(isset($feedbackArray['userformSelection']['selected_user'])){
                echo $feedbackArray['userformSelection']['selected_user'];
            }
            else {
                echo 0;
            }
        ?>;

    $(document).ready(function() {
        updateUserSelection()
    });

    function updateUserSelection() {
        selectedProject = document.getElementById('project').value;
        userSelection = document.getElementById('userSelection');

        //Bestehende Einträge entfernen
        var child = userSelection.lastElementChild;
        while (child){
            userSelection.removeChild(child);
            child = userSelection.lastElementChild;
        }
        
        //Neue Einträge hinzufügen
        for(var i = 0; i < Object.keys(userArray[selectedProject]).length; i++){
            var newOption = document.createElement('option');
            newOption.value = userArray[selectedProject][i]['ds_id'];
            newOption.innerHTML = userArray[selectedProject][i]['name'];
            if(userArray[selectedProject][i]['ds_id'] == selectedUser){
                newOption.selected = true;
            }
            userSelection.appendChild(newOption);
        }
        updateFeedbackTable();
    }


    function updateWeekSelection() {
        var selectedDate = new Date(document.getElementById('week').value);
        var selectedDateNum = selectedDate.getTime();
        
        if(selectedDate.getDay() == 1){
            var startDateNum = selectedDateNum - (14 * 86400000);
        } else if(selectedDate.getDay() == 2){
            var startDateNum = selectedDateNum - (15 * 86400000);
        } else if(selectedDate.getDay() == 3){
            var startDateNum = selectedDateNum - (16 * 86400000);
        } else if(selectedDate.getDay() == 4){
            var startDateNum = selectedDateNum - (17 * 86400000);
        } else if(selectedDate.getDay() == 5){
            var startDateNum = selectedDateNum - (18 * 86400000);
        } else if(selectedDate.getDay() == 6){
            var startDateNum = selectedDateNum - (19 * 86400000);
        } else if(selectedDate.getDay() == 0){
            var startDateNum = selectedDateNum - (20 * 86400000);
        }
        var startDate = new Date(startDateNum);
        var endDateNumWeek = startDateNum + (7 * 86400000)
        var endDateNum = startDateNum + (13 * 86400000);
        var endDate = new Date(endDateNum);
        var endDateWeek = new Date(endDateNumWeek);


        let onejan = new Date(startDate.getFullYear(), 0, 1);
        let week = Math.floor((((startDate.getTime() - onejan.getTime()) / 86400000) + onejan.getDay() + 1) / 7);

        let onejanEnd = new Date(endDateWeek.getFullYear(), 0, 1);
        let weekEnd = Math.floor((((endDateWeek.getTime() - onejanEnd.getTime()) / 86400000) + onejanEnd.getDay() + 1) / 7);

        var startDate = new Date(startDateNum).toISOString().substring(0, 10);
        var endDate = new Date(endDateNum).toISOString().substring(0, 10);
        document.getElementById('startDate').value = startDate;
        document.getElementById('endDate').value = endDate;
        document.getElementById('startWeek').value = 'KW ' + week;
        document.getElementById('endWeek').value = 'KW ' + weekEnd;
    }

    function updateFeedbackTable() {
        document.getElementById('feedBackView').style.display = 'block';
        selectedProject = document.getElementById('project').value;
        selectedUser = document.getElementById('userSelection').value;
        dslFields = document.getElementsByClassName('dsl_row');
        mobileFields = document.getElementsByClassName('mobile_row');

        e = document.getElementById('project');
        document.getElementById('feedback_table_project').innerHTML = e.options[e.selectedIndex].text;

        document.getElementById('feedback_table_first_week').innerHTML = "KW " + timespanArray['first_week_number'];
        document.getElementById('feedback_table_first_week2').innerHTML = "KW " + timespanArray['first_week_number'];
        document.getElementById('feedback_table_last_week').innerHTML = "KW " + timespanArray['last_week_number'];
        document.getElementById('feedback_table_last_week2').innerHTML = "KW " + timespanArray['last_week_number'];
        today = new Date();
        document.getElementById('feedback_table_date').innerHTML = ("0" + today.getDate()).slice(-2) + "." + ("0" + today.getMonth()).slice(-2) + "." + today.getFullYear();
        startDate = new Date(timespanArray['first_week_start_date'])
        document.getElementById('feedback_table_year').innerHTML = startDate.getFullYear();
        document.getElementById('feedback_table_year2').innerHTML = startDate.getFullYear();

        e = document.getElementById('userSelection');
        document.getElementById('feedback_table_for').innerHTML = e.options[e.selectedIndex].text;

        //DSL
        if(selectedProject == '1und1 DSL Retention'){
            for (var i = 0; i < dslFields.length; i++){
                dslFields[i].style.display = 'table-row';
            }
            for (var i = 0; i < mobileFields.length; i++){
                mobileFields[i].style.display = 'none';
            }

            document.getElementById('first_week_user_calls_dsl').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['calls_dsl'];
            document.getElementById('first_week_project_calls_dsl').innerHTML = dataArray['first_week']['project_data'][selectedProject]['calls_dsl'];
            document.getElementById('last_week_user_calls_dsl').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['calls_dsl'];
            document.getElementById('last_week_project_calls_dsl').innerHTML = dataArray['last_week']['project_data'][selectedProject]['calls_dsl'];;
            document.getElementById('first_week_user_orders_dsl').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['orders_dsl'];
            document.getElementById('first_week_project_orders_dsl').innerHTML = dataArray['first_week']['project_data'][selectedProject]['orders_dsl'];
            document.getElementById('last_week_user_orders_dsl').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['orders_dsl'];
            document.getElementById('last_week_project_orders_dsl').innerHTML = dataArray['last_week']['project_data'][selectedProject]['orders_dsl'];
            document.getElementById('first_week_user_cr_dsl').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['cr_dsl'] + '%';
            document.getElementById('first_week_project_cr_dsl').innerHTML = dataArray['first_week']['project_data'][selectedProject]['cr_dsl'] + '%';
            document.getElementById('last_week_user_cr_dsl').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['cr_dsl'] + '%';
            document.getElementById('last_week_project_cr_dsl').innerHTML = dataArray['last_week']['project_data'][selectedProject]['cr_dsl'] + '%';
        //Mobile
        } else if (selectedProject == '1und1 Retention') {
            for (var i = 0; i < dslFields.length; i++){
                dslFields[i].style.display = 'none';
            }
            for (var i = 0; i < mobileFields.length; i++){
                mobileFields[i].style.display = 'table-row';
            }

            document.getElementById('first_week_user_calls_ssc').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['calls_ssc'];
            document.getElementById('first_week_project_calls_ssc').innerHTML = dataArray['first_week']['project_data'][selectedProject]['calls_ssc'];
            document.getElementById('first_week_user_calls_bsc').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['calls_bsc'];
            document.getElementById('first_week_project_calls_bsc').innerHTML = dataArray['first_week']['project_data'][selectedProject]['calls_bsc'];
            document.getElementById('first_week_user_calls_portale').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['calls_portale'];
            document.getElementById('first_week_project_calls_portale').innerHTML = dataArray['first_week']['project_data'][selectedProject]['calls_portale'];
            document.getElementById('last_week_user_calls_ssc').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['calls_ssc'];
            document.getElementById('last_week_project_calls_ssc').innerHTML = dataArray['last_week']['project_data'][selectedProject]['calls_ssc'];
            document.getElementById('last_week_user_calls_bsc').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['calls_bsc'];
            document.getElementById('last_week_project_calls_bsc').innerHTML = dataArray['last_week']['project_data'][selectedProject]['calls_bsc'];
            document.getElementById('last_week_user_calls_portale').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['calls_portale'];
            document.getElementById('last_week_project_calls_portale').innerHTML = dataArray['last_week']['project_data'][selectedProject]['calls_portale'];
            
            document.getElementById('first_week_user_orders_bsc').innerHTML =dataArray['first_week']['user_data'][selectedProject][selectedUser]['orders_ssc'];
            document.getElementById('first_week_project_orders_bsc').innerHTML = dataArray['first_week']['project_data'][selectedProject]['orders_ssc'];
            document.getElementById('first_week_user_orders_bsc').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['orders_bsc'];
            document.getElementById('first_week_project_orders_bsc').innerHTML = dataArray['first_week']['project_data'][selectedProject]['orders_bsc'];
            document.getElementById('first_week_user_orders_portale').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['orders_portale'];
            document.getElementById('first_week_project_orders_portale').innerHTML = dataArray['first_week']['project_data'][selectedProject]['orders_portale'];
            document.getElementById('last_week_user_orders_ssc').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['orders_ssc'];
            document.getElementById('last_week_project_orders_ssc').innerHTML = dataArray['last_week']['project_data'][selectedProject]['orders_ssc'];
            document.getElementById('last_week_user_orders_bsc').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['orders_bsc'];
            document.getElementById('last_week_project_orders_bsc').innerHTML = dataArray['last_week']['project_data'][selectedProject]['orders_bsc'];
            document.getElementById('last_week_user_orders_portale').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['orders_portale'];
            document.getElementById('last_week_project_orders_portale').innerHTML = dataArray['last_week']['project_data'][selectedProject]['orders_portale'];

            document.getElementById('first_week_user_cr_ssc').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['cr_ssc'] + '%';
            document.getElementById('first_week_project_cr_ssc').innerHTML = dataArray['first_week']['project_data'][selectedProject]['cr_ssc'] + '%';
            document.getElementById('first_week_user_cr_bsc').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['cr_bsc'] + '%';
            document.getElementById('first_week_project_cr_bsc').innerHTML = dataArray['first_week']['project_data'][selectedProject]['cr_bsc'] + '%';
            document.getElementById('first_week_user_cr_portale').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['cr_portale'] + '%';
            document.getElementById('first_week_project_cr_portale').innerHTML = dataArray['first_week']['project_data'][selectedProject]['cr_portale'] + '%';
            document.getElementById('last_week_user_cr_ssc').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['cr_ssc'] + '%';
            document.getElementById('last_week_project_cr_ssc').innerHTML = dataArray['last_week']['project_data'][selectedProject]['cr_ssc'] + '%';
            document.getElementById('last_week_user_cr_bsc').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['cr_bsc'] + '%';
            document.getElementById('last_week_project_cr_bsc').innerHTML = dataArray['last_week']['project_data'][selectedProject]['cr_bsc'] + '%';
            document.getElementById('last_week_user_cr_portale').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['cr_portale'] + '%'; 
            document.getElementById('last_week_project_cr_portale').innerHTML = dataArray['last_week']['project_data'][selectedProject]['cr_portale'] + '%';
        }

        document.getElementById('first_week_user_optin').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['optin_cr'] + '%';
        document.getElementById('first_week_project_optin').innerHTML = dataArray['first_week']['project_data'][selectedProject]['optin_cr'] + '%';
        document.getElementById('last_week_user_optin').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['optin_cr'] + '%';
        document.getElementById('last_week_project_optin').innerHTML = dataArray['last_week']['project_data'][selectedProject]['optin_cr'] + '%';
        document.getElementById('first_week_user_rlz').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['rlz_plus_percentage'] + '%';
        document.getElementById('first_week_project_rlz').innerHTML = dataArray['first_week']['project_data'][selectedProject]['rlz_plus_percentage'] + '%';
        document.getElementById('last_week_user_rlz').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['rlz_plus_percentage'] + '%';
        document.getElementById('last_week_project_rlz').innerHTML = dataArray['last_week']['project_data'][selectedProject]['rlz_plus_percentage'] + '%';
        document.getElementById('first_week_user_aht').innerHTML = dataArray['first_week']['user_data'][selectedProject][selectedUser]['aht'];
        document.getElementById('first_week_project_aht').innerHTML = dataArray['first_week']['project_data'][selectedProject]['aht'];
        document.getElementById('last_week_user_aht').innerHTML = dataArray['last_week']['user_data'][selectedProject][selectedUser]['aht'];
        document.getElementById('last_week_project_aht').innerHTML = dataArray['last_week']['project_data'][selectedProject]['aht'];

        
        
    }



</script>
@endsection