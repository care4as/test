@extends('general_layout')
@section('pagetitle')
    Projektverwaltung: Userliste
@endsection
@section('content')

    <!-- Auswahl -->
    
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Projekt</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                        <label for="inputState" style="margin: auto;">Auswahl:</label>
                                        <select id="inputState" onchange="masterSearch()" class="form-control" name="project" style="color:black;">
                                            <option value="all">Alle</option>
                                            <option value="1">Care4as</option>
                                            <option value="10">1und1 DSL Retention</option>
                                            <option value="7">1und1 Mobile Retention</option>
                                            <option value="6">1und1 Kündigungsadministration</option>
                                            <option value="14">Telefonica</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Betriebszugehörigkeit</div>
                                <div class="max-panel-content">
                                    <div style="display: flex; justify-content: space-around;">
                                        <button class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;" disabled>Aktive Mitarbeiter</button>
                                        <button class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Deaktivierte Mitarbeiter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Suche</div>
                                <div class="max-panel-content">
                                    <input type="text" id="tableFilter" onkeyup="masterSearch()" placeholder="Suche.." style="padding-left: 5px; width: 100%; font-size: 16px;" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="max-panel">
                                <div class="max-panel-title" style="display: flex; justify-content: space-between;">
                                    <div>
                                        Übersicht
                                    </div>
                                    <div style="margin-top: auto; margin-bottom: auto;">
                                        <button class="btn" style="margin:0; padding: 0px 5px; background-color: #ddd;" onclick="overviewToggle()"><i id="overviewToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                    </div>
                                </div>
                                <div class="max-panel-content" style="display: none;" id="overviewToggleContent">
                                    Test
                                </div>
                            </div>
                            </div>
                        <div class="col-md-6">
                            <div class="max-panel">
                                <div class="max-panel-title" style="display: flex; justify-content: space-between;">
                                    <div>
                                        Filter
                                    </div>
                                    <div style="margin-top: auto; margin-bottom: auto;">
                                        <button class="btn" style="margin:0; padding: 0px 5px; background-color: #ddd;" onclick="filterToggle()"><i id="filterToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                    </div>
                                </div>
                                <div class="max-panel-content" style="display: none;" id="filterToggleContent">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="max-panel">
                                                <div class="max-panel-title">
                                                    Funktion
                                                </div>
                                                <div class="max-panel-content">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" onchange="masterSearch()"  checked="true" type="checkbox" id="funktionCheckbox1"> Projektmanagement
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" onchange="masterSearch()" type="checkbox" checked="true" id="funktionCheckbox2"> Teamleitung
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" onchange="masterSearch()" type="checkbox" checked="true" id="funktionCheckbox3"> Training
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" onchange="masterSearch()" type="checkbox" checked="true" id="funktionCheckbox4"> Backoffice
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" onchange="masterSearch()" type="checkbox" checked="true" id="funktionCheckbox5"> Agenten
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" onchange="masterSearch()" type="checkbox" checked="true" id="funktionCheckbox6"> Sonstige
                                                            <span class="form-check-sign"></span>
                                                        </label>
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
            </div>    
        </div>
    </div>

    <!-- Tabelle -->
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="max-panel">
                            <div class="max-panel-title">
                                Mitarbeiterliste
                            </div>
                            <div class="max-panel-content">
                                <div style="width: 100%; overflow-x: auto;">
                                    <table class="max-table" id="userListTable">
                                        <thead>
                                            <tr style="width: 100%">
                                                <th>Projekt 
                                                    <button class="btn" onclick="sortTable(0)" style="margin:0; padding: 0px 5px; background-color: #ddd;"><i id="overviewToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                                </th>
                                                <th>Name
                                                    <button class="btn" onclick="sortTable(1)" style="margin:0; padding: 0px 5px; background-color: #ddd;"><i id="overviewToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                                </th>
                                                <th>Vorname
                                                    <button class="btn" onclick="sortTable(2)" style="margin:0; padding: 0px 5px; background-color: #ddd;"><i id="overviewToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                                </th>
                                                <th>WS</th>
                                                <th>FTE</th>
                                                <th>Funktion
                                                    <button class="btn" onclick="sortTable(5)" style="margin:0; padding: 0px 5px; background-color: #ddd;"><i id="overviewToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                                </th>
                                                <th>Eintritt
                                                    <button class="btn" onclick="sortTable(6)" style="margin:0; padding: 0px 5px; background-color: #ddd;"><i id="overviewToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                                </th>
                                                <th>Austritt
                                                    <button class="btn" onclick="sortTable(7)" style="margin:0; padding: 0px 5px; background-color: #ddd;"><i id="overviewToggleButton" class="now-ui-icons arrows-1_minimal-down" style="font-size: 16px; color: black; display: flex;"></i></button>
                                                </th>
                                                <th>Abwesenheit</th>
                                                <th>KDW Kennung</th>
                                                <th>1u1 Personen ID</th>
                                                <th>1u1 SSE ID</th>
                                                <th>1u1 CosmoCom ID</th>
                                                <th>Bearbeiten</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($refinedUserList['active'] as $key => $user)
                                            <tr>
                                                <td>{{$user['projekt_kennzeichnung']}}</td>
                                                <td>{{$user['name']}}</td>
                                                <td>{{$user['vorname']}}</td>
                                                <td>{{$user['soll_h_woche']}}</td>
                                                <td>{{$user['fte']}}</td>
                                                <td>{{$user['funktions_kennzeichnung']}}</td>
                                                <td>{{$user['eintritt']}}</td>
                                                <td>{{$user['austritt']}}</td>
                                                <td>%</td>
                                                <td>{{$user['kdw_kennung']}}</td>
                                                <td>%</td>
                                                <td>%</td>
                                                <td>%</td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <button class="btn btn-primary btn-sm" style="margin: auto; padding-top: 0; padding-bottom: 0;"><i class="now-ui-icons business_badge"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
    @endsection
    @section('additional_js')
    <!-- JavaScrip Funktionen -->
    <script>
        function dateToggle(option){
            masterSearch();
            if(option=="filter"){
                document.getElementById('collapseDate').className = 'collapse.show';
            }
            if(option=="current"){
                document.getElementById('collapseDate').className = 'collapse';
            }
        }

        function filterToggle(){
            if(document.getElementById('filterToggleContent').style.display == ''){
                document.getElementById('filterToggleContent').style.display = 'none';
                document.getElementById('filterToggleButton').className = 'now-ui-icons arrows-1_minimal-down'
            } else {
                document.getElementById('filterToggleContent').style.display = '';
                document.getElementById('filterToggleButton').className = 'now-ui-icons arrows-1_minimal-up'
            }
        }

        function overviewToggle(){
            if(document.getElementById('overviewToggleContent').style.display == ''){
                document.getElementById('overviewToggleContent').style.display = 'none';
                document.getElementById('overviewToggleButton').className = 'now-ui-icons arrows-1_minimal-down'
            } else {
                document.getElementById('overviewToggleContent').style.display = '';
                document.getElementById('overviewToggleButton').className = 'now-ui-icons arrows-1_minimal-up'
            }
        }

        function masterSearch(){
            //Show all Cells
            table = document.getElementById("userListTable");
            tr = table.getElementsByTagName("tr");

            for(i = 1; i < tr.length; i++){
                td = tr[i].getElementsByTagName("td")[7].innerText;
                tr[i].style.display = "";
            }

            //Hide Project mismatch
            filterProject();
            //Hife Function mismatch
            filterFunction()
            //Hide Search mismatch
            searchTable();
        }



        /** Searches all table Cells and hides rows not matching search filter */
        function searchTable(){
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("tableFilter");
            filter = input.value.toUpperCase();
            table = document.getElementById("userListTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 1; i < tr.length; i++) {
                match = 0;
                for(j = 0; j < tr[i].getElementsByTagName("td").length; j++){
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

        window.addEventListener("load", function(){
            let today = new Date().toISOString().slice(0, 10)

            document.getElementById('dateFrom').value = today;
            document.getElementById('dateTo').value = today;

            filterDate();
        });

        /** Funktion nicht mehr in Gebrauch */
        function filterDate(){
            var filter = document.getElementById('timeInputState').value;
            var today = new Date().toISOString().slice(0, 10);
            
            if(filter == 'current'){
                table = document.getElementById("userListTable");
                tr = table.getElementsByTagName("tr");
                
                /** Schleife über alle Eintritte */
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[6].innerText;
                    if(td){
                        if(td > today){
                            tr[i].style.display = "none";
                        }
                    }
                }

                /** Schleife über alle Austritte */
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[7].innerText;
                    if(td){
                        if(td < today){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            if(filter == 'filter'){
                table = document.getElementById("userListTable");
                tr = table.getElementsByTagName("tr");
                dateFrom = document.getElementById('dateFrom').value;
                dateTo = document.getElementById('dateTo').value;

                /** Schleife über alle Eintritte */
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[6].innerText;
                    if(td){
                        if(td > dateFrom){
                            tr[i].style.display = "none";
                        }
                    }
                }
                /** Schleife über alle Austritte */
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[7].innerText;
                    if(td){
                        if(td < dateTo){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }

        function filterProject(){
            filter = document.getElementById('inputState').value
            table = document.getElementById("userListTable");
            tr = table.getElementsByTagName("tr");
            if(filter == 10){
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[0].innerText;
                    if(td){
                        if(td != '1und1 DSL Retention'){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            if(filter == 7){
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[0].innerText;
                    if(td){
                        if(td != '1und1 Retention'){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            if(filter == 6){
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[0].innerText;
                    if(td){
                        if(td != '1und1 Offline'){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            if(filter == 14){
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[0].innerText;
                    if(td){
                        if(td != 'Telefonica'){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            if(filter == 1){
                for(i = 1; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[0].innerText;
                    if(td){
                        if(td != 'Care4as'){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }

        function filterFunction(){
            table = document.getElementById("userListTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5].innerText;
                if(td){
                    if(document.getElementById('funktionCheckbox1').checked == false){
                        if(td == 'Projektmanagement'){
                            tr[i].style.display = "none";
                        }
                    }
                    if(document.getElementById('funktionCheckbox2').checked == false){
                        if(td == 'Teamleitung'){
                            tr[i].style.display = "none";
                        }
                    }
                    if(document.getElementById('funktionCheckbox3').checked == false){
                        if(td == 'Training'){
                            tr[i].style.display = "none";
                        }
                    }
                    if(document.getElementById('funktionCheckbox4').checked == false){
                        if(td == 'Backoffice'){
                            tr[i].style.display = "none";
                        }
                    }
                    if(document.getElementById('funktionCheckbox5').checked == false){
                        if(td == 'Agenten'){
                            tr[i].style.display = "none";
                        }
                    }
                    if(document.getElementById('funktionCheckbox6').checked == false){
                        if((td != 'Projektmanagement') && (td != 'Teamleitung') && (td != 'Training') && (td != 'Backoffice') && (td != 'Agenten')){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }

        function sortTable(td){
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("userListTable");
            switching = true;
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[td];
                y = rows[i + 1].getElementsByTagName("TD")[td];
                // Check if the two rows should switch place:
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
                }
                if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                }
            }
        }

    </script>
@endsection