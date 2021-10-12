@extends('general_layout')
@section('pagetitle')
    Controlling: Projektmeldung
@endsection
@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('projectReport')}}" method="get()"> 
            @csrf
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Projekt</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                        <label for="inputState" style="margin: auto;">Auswahl:</label>
                                        <select id="inputState" class="form-control" style="color:black;" name="project">
                                            <option selected value="1u1_dsl_ret">1u1 DSL Retention</option>
                                            <option value="1u1_mobile_ret">1u1 Mobile Retention</option>
                                            <option value="1u1_offline">1u1 Kündigungsadministration</option>
                                            <option value="telefonica_outbound">Telefonica Outbound</option>
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
                                        <input type="date" id="datefrom" name="startDate" class="form-control" placeholder="" style="color:black;" value="{{$defaultVariablesArray['startDate']}}">
                                        <p style="margin: auto;">Bis:</p>
                                        <input type="date" id="datefrom" name="endDate" class="form-control" placeholder="" style="color:black;" value="{{$defaultVariablesArray['endDate']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="col-md-3">
                            <div class="max-panel">
                                <div class="max-panel-title">Darstellung</div>
                                <div class="max-panel-content">
                                    <p style="font-style: italic;">Vorrübergehend nur "kummuliert" auswählbar.</p>
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                        <label for="inputState" style="margin: auto;">Auswahl:</label>
                                        <select id="inputState" class="form-control" style="color:black;">
                                            <option selected>Kumuliert</option>
                                
                                            <option>Monat</option>
                                            <option>Woche</option>
                                            <option>Tag</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="col-md-4" style="display:flex; margin-top: 20px; margin-bottom: 20px;">
                            <button class="btn btn-primary" style="margin: auto;" type="submit">Bericht erzeugen</button>
                        </div>
                    </div>
                </div>
            </form>  
        </div>    
    </div>

<!-- START PROJECT: DSL -->
    @if($defaultVariablesArray['project'] == '1u1_dsl_ret')
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
                                    <input type="text" id="tableFilter" onkeyup="masterSearch('dslMaTable')" placeholder="Mitarbeiter filtern..." style="padding-left: 5px; width: 100%; font-size: 16px;" autofocus>
                                </div>
                                <div class="max-panel-content">
                                    <div style="width: 100%; overflow-x: auto;">
                                        <table class="max-table" id="dslMaTable">
                                            <thead>
                                                <tr style="width: 100%">
                                                    <th colspan="1">Mitarbeiter</th>
                                                    <th colspan="7">Stunden</th>
                                                    <th colspan="3">Calls</th>
                                                    <th colspan="2">Sales</th>
                                                    <th colspan="4">OptIn</th>
                                                    <th colspan="2">SaS</th>
                                                    <th>RLZ+24</th>
                                                    <th colspan="5">Umsatz</th>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <th>Name</th>
                                                    <th>Bezahlt</th>
                                                    <th>Produktiv</th>
                                                    <th>← in %</th>
                                                    <th>Pause</th>
                                                    <th>← in %</th>
                                                    <th>Krank</th>
                                                    <th>← in %</th>
                                                    <th>Summe</th>
                                                    <th>Pro Stunde</th>
                                                    <th>AHT</th>
                                                    <th>GeVo</th>
                                                    <th>CR</th>
                                                    <th>Summe</th>
                                                    <th>← in %</th>
                                                    <th>Möglich</th>
                                                    <th>← in %</th>
                                                    <th>SaS</th>
                                                    <th>← in ‰</th>
                                                    <th>Quote</th>
                                                    <th>Availbench</th>
                                                    <th>Sales</th>
                                                    <th>Gesamt</th>
                                                    <th>Je Std. bez.</th>
                                                    <th>Je Std. prod.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dataArray['employees'] as $key => $employee)
                                                    <tr>
                                                    <!--Name-->         <td style="text-align: left;">{{$employee['full_name']}}</td>
                                                    <!--Std. bez.-->    <td></td>
                                                    <!--Std. prod.-->   <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--Pause-->        <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--Krank-->        <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--Summe Calls-->  <td></td>
                                                    <!--Pro Std.-->     <td></td>
                                                    <!--AHT-->          <td></td>
                                                    <!--GeVo Sales-->   <td></td>
                                                    <!--GeVo CR-->      <td></td>
                                                    <!--OptIn Summe-->  <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--OptIn Möglich--><td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--SaS Summe-->    <td></td>
                                                    <!--in ‰-->         <td></td>
                                                    <!--RLZ Quote-->    <td></td>
                                                    <!--U. Availbench--><td></td>
                                                    <!--U. Sales-->     <td></td>
                                                    <!--U. Gesamt-->    <td></td>
                                                    <!--U. / bez.-->    <td></td>
                                                    <!--U. / prod.-->   <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr style="font-weight: bold; background-color: #ddd;">
                                                    <!--Name-->         <td>Summe</td>
                                                    <!--Std. bez.-->    <td></td>
                                                    <!--Std. prod.-->   <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--Pause-->        <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--Krank-->        <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--Summe Calls-->  <td></td>
                                                    <!--Pro Std.-->     <td></td>
                                                    <!--AHT-->          <td></td>
                                                    <!--GeVo Sales-->   <td></td>
                                                    <!--GeVo CR-->      <td></td>
                                                    <!--OptIn Summe-->  <td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--OptIn Möglich--><td></td>
                                                    <!--in %-->         <td></td>
                                                    <!--SaS Summe-->    <td></td>
                                                    <!--in ‰-->         <td></td>
                                                    <!--RLZ Quote-->    <td></td>
                                                    <!--U. Availbench--><td></td>
                                                    <!--U. Sales-->     <td></td>
                                                    <!--U. Gesamt-->    <td></td>
                                                    <!--U. / bez.-->    <td></td>
                                                    <!--U. / prod.-->   <td></td>
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
    </div>
    @endif     
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
@endsection

@section('additional_js')
    <script>
        function masterSearch(id){
            //Show all Cells
            table = document.getElementById(id);
            tr = table.getElementsByTagName("tr");

            for(i = 2; i < tr.length; i++){
                //td = tr[i].getElementsByTagName("td")[1].innerText;
                tr[i].style.display = "";
            }

            //Hide Search mismatch
            searchTable(id);
        }



        /** Searches all table Cells and hides rows not matching search filter */
        function searchTable(id){
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("tableFilter");
            filter = input.value.toUpperCase();
            table = document.getElementById(id);
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 2; i < tr.length - 1; i++) {
                match = 0;
                for(j = 0; j < 1; j++){
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td){
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            match++;
                        }
                    }
                }
                if (match == 0){
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
@endsection