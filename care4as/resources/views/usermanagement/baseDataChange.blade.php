@extends('general_layout')
@section('pagetitle')
Mitarbeiterverwaltung: Stammdatenänderungen
@endsection
@section('additional_css')
<style>
    table.dataTable {
        border-collapse: collapse;
    }

    .form-control {
        color: black;

    }

    table.dataTable tbody td,
    table.dataTable tfoot td,
    table.dataTable thead th {
        padding: 0px 15px;
    }

    .sorting_desc,
    .sorting_asc {
        background-blend-mode: luminosity;
    }

    .dataTables_wrapper .dataTables_length select {
        width: 65px;
        margin-left: 4px;
        margin-right: 4px;
    }

    label {
        display: flex;
        align-items: center;
    }

    .DTFC_LeftBodyLiner {
        overflow-x: hidden;
    }

    .hoverRow {
        background-color: #ddd !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: transparent;
    }    

    .form-control[readonly] {
        cursor: default;
    }

    .dataTables_filter{
        width: 300px;
    }

    .dataTables_length{
        width: max-content;
    }

    .page-item.active .page-link {
        background-color: #FA7A50;
        border-color: #FA7A50;
    }

    .page-item:hover{
        border-color: #FA7A50;
    }

    .page-link{
        margin: 5px !important;
    }

    .paginate_button:hover{
        border: none !important;
    }

    .page-link:hover{
        border-color: #FA7A50;
    }

    .pagination{
        width: min-content;
        margin: 5px auto;
    }

    #value_selector_project{
        display: none;
    }
    #value_selector_contract_hours{
        display: none;
    }

    #value_selector_project{
        display: none;
    }
    #value_selector_contract_hours{
        display: none;
    }


</style>
@endsection
@section('content')
<div>
    <form action="{{route('userlist')}}" method="get()">
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Auswahl</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; gap:5px">
                                        <label for="project" style="margin: auto 0 auto auto;">Datum:</label>
                                        <input type="date" id="date" name="date" class="form-control" placeholder="" style="color:black;" value="">
                                        <label for="project" style="margin: auto 0 auto auto;">Typ:</label>
                                        <select id="project" class="form-control" name="project" style="color:black;" onchange="changeValueSelector()">
                                            <option value="false" disabled selected>Bitte wählen</option>
                                            <option value="project">Projektwechsel</option>
                                            <option value="contract_hours">Vertragsstunden</option>
                                        </select>
                                        <label for="project" style="margin: auto 0 auto auto;">Mitarbeiter:</label>
                                        <select id="project" class="form-control" name="project" style="color:black;">
                                            <option value="false" disabled selected>Bitte wählen</option>
                                            @foreach($data['employees'] as $key => $entry)
                                            <option value="{{$entry->ds_id}}">{{$entry->familienname}}, {{$entry->vorname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Änderungen</div>
                                <div class="max-panel-content">
                                    <div style="grid-template-columns: auto 1fr; gap: 5px;" id="value_selector_project">
                                        <label for="value_old" style="margin: auto 0 auto auto;">Alt:</label>
                                        <select id="value_old" class="form-control" name="value_old" style="color:black;">
                                            <option value="false" disabled selected>Bitte wählen</option>
                                            @foreach($data['projects'] as $key => $entry)
                                                <option value="{{$entry->ds_id}}">{{$entry->bezeichnung}}</option>
                                            @endforeach
                                        </select>
                                        <label for="value_new" style="margin: auto 0 auto auto;">Neu:</label>
                                        <select id="value_new" class="form-control" name="value_new" style="color:black;">
                                            <option value="false" disabled selected>Bitte wählen</option>
                                            @foreach($data['projects'] as $key => $entry)
                                                <option value="{{$entry->ds_id}}">{{$entry->bezeichnung}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="grid-template-columns: auto 1fr; gap: 5px;" id="value_selector_contract_hours">
                                        <label for="value_old" style="margin: auto 0 auto auto;">Alt:</label>
                                        <select id="value_old" class="form-control" name="value_old" style="color:black;">
                                            <option value="false" disabled selected>Bitte wählen</option>
                                            <option value="40" >40</option>
                                            <option value="35" >35</option>
                                            <option value="30" >30</option>
                                            <option value="25" >25</option>
                                            <option value="20" >20</option>
                                            <option value="15" >15</option>
                                            <option value="10" >10</option>
                                            <option value="5" >5</option>
                                        </select>
                                        <label for="value_new" style="margin: auto 0 auto auto;">Neu:</label>
                                        <select id="value_new" class="form-control" name="value_new" style="color:black;">
                                            <option value="false" disabled selected>Bitte wählen</option>
                                            <option value="40" >40</option>
                                            <option value="35" >35</option>
                                            <option value="30" >30</option>
                                            <option value="25" >25</option>
                                            <option value="20" >20</option>
                                            <option value="15" >15</option>
                                            <option value="10" >10</option>
                                            <option value="5" >5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Funktionen</div>
                                <div class="max-panel-content" style="display: flex; justify-content: space-around;">
                                    <button type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Eintrag speichern</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row" id="projectTableContainer" style="display: none;">
    <div class="col-md-12">
        <div class="max-main-container">
            <div class="max-panel-content">
                <div style="width: 100%;">
                    <table class="max-table" id="projectTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Typ</th>
                                <th>Name</th>
                                <th>Wert ALT</th>
    	                        <th>Wert NEU</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
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
@endsection


<!-- Javascript -->
@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script src='https://cdn.datatables.net/plug-ins/1.10.24/api/sum().js'></script>
<script src='https://cdn.datatables.net/plug-ins/1.10.24/api/average().js'></script>
<script src='https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js'></script>
<script src='https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let table = $('#projectTable').DataTable({
            "language": {
                "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
                "zeroRecords": "Keinen Eintrag gefunden",
                "info": "Seite _PAGE_ von _PAGES_",
                "infoEmpty": "Keinen Eintrag gefunden",
                "infoFiltered": "(gefiltert von _MAX_ total Einträgen)",
                "loadingRecords": "Lädt...",
                "processing": "Lädt...",
                "search": "<p style='margin-bottom: 0; margin-right: 5px;'>Suche:</p>",
                "paginate": {
                    "first": "Erste",
                    "last": "Letzte",
                    "next": "Nächste",
                    "previous": "Zurück"
                },
            },
            "lengthMenu": [
                [-1, 3, 5, 10, 25, 50, 100],
                ["alle", 3, 5, 10, 25, 50, 100]
            ],
            scrollX: true,
            scrollCollapse: false,
            fixedColumns: false,
            select: true,
            order: [
                [1, "asc"]
            ],
            dom: 'Blfrtip',
            buttons: [{
                extend: 'csv',
                    text: 'CSV Export',
                    className: 'btn btn-primary',
                    title: null,
                    filename: 'Mitarbeiterliste_Export',
                },
                {
                    extend: 'excel',
                    text: 'Excel Export',
                    className: 'btn btn-primary',
                    footer: 'true',
                    title: null,
                    sheetName: 'MA-Liste',
                    filename: 'Mitarbeiterliste_Export',
                    autoFilter: 'true',
                },
            ],
        });
        document.getElementById('projectTableContainer').style.display = "block";
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    })
</script>

<!-- Funktion zur Anzeige der Statusänderung -->
<script type="text/javascript">
    function changeValueSelector(){
        var selector = document.getElementById('project').value;
        console.log(selector);

        if (selector == 'project'){
            document.getElementById('value_selector_contract_hours').style.display = 'none';
            document.getElementById('value_selector_project').style.display = '';     
        } else if (selector == 'contract_hours'){
            document.getElementById('value_selector_contract_hours').style.display = 'grid';
            document.getElementById('value_selector_project').style.display = 'none';       
        }
    }

</script>
@endsection
