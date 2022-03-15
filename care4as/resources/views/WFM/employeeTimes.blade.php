@extends('general_layout')
@section('pagetitle')
    WFM: Mitarbeiter Zeiten
@endsection
@section('additional_css')
<style>
    table.dataTable {
        border-collapse: collapse;
    }
    .form-control{
        color:black;
    }
    table.dataTable tbody td, table.dataTable tfoot td, table.dataTable thead th {
        padding: 0px 15px;
    }
    .sorting_desc, .sorting_asc {
        background-blend-mode: luminosity;
    }
    .dataTables_wrapper .dataTables_length select{
        width: 65px;
        margin-left: 4px;
        margin-right: 4px;
    }
    label{
        display: flex;
        align-items: center;
    }
    .DTFC_LeftBodyLiner {
        overflow-x: hidden;
    }
    .hoverRow{
        background-color: #ddd !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        border: 1px solid transparent;
        background: transparent;
    }
    .page-item.active .page-link{
        background-color: #FA7A50;
        border-color: #FA7A50;
    }
    .dataTables_filter{
        width: 300px;
    }

    .dataTables_length{
        width: max-content;
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

</style>
@endsection

@section('content')
<div>
    <form action="{{route('wfm.master')}}" method="get">
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
                                        <label for="projectSelection" style="margin: auto 0 auto auto;">Projekt:</label>
                                        <select id="projectSelection" class="form-control" style="color:black;" name="project">
                                                <option selected value="10">1u1 DSL Retention</option>
                                                <option value="7">1u1 Mobile Retention</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Datum</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <p style="margin: auto 0 auto auto;">Datum:</p>
                                        <input type="date" id="datefrom" name="date" class="form-control" value="{{$param['date']}}" style="color:black;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Liste anzeigen</div>
                                <div class="max-panel-content" style="display: flex; justify-content: space-around;">
                                    <form action="" method="">
                                        <button type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Liste anzeigen</button>
                                    </form>
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
                                <div class="max-panel-content">
                                    <table class="max-table" id="datatable" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Agent ID</th>
                                                <th>Datum</th>
                                                <th>Beginn KDW</th>
                                                <th>Ende KDW</th>
                                                <th>Dauer Schicht</th>
                                                <th>Beginn Langpause</th>
                                                <th>Ende Langpause</th>
                                                <th>Dauer Langpause</th>
                                                <th>Dauer Kurzpause</th>
                                                <th>Anzahl Kurzpause</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($data as $key => $entry)
                                            <tr>
                                                <td>{{$entry['name']}}</td>
                                                <td>{{$entry['agent_id']}}</td>
                                                <td>{{$entry['date']}}</td>
                                                <td>{{$entry['work_beginn_kdw']}}</td>
                                                <td>{{$entry['work_end_kdw']}}</td>
                                                <td>{{$entry['work_duration']}}</td>
                                                <td>{{$entry['lunch_break_beginn']}}</td>
                                                <td>{{$entry['lunch_break_end']}}</td>
                                                <td>{{$entry['lunch_break_duration']}}</td>
                                                <td>{{$entry['short_break_duration']}}</td>
                                                <td>{{$entry['short_break_count']}}</td>
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
    @endif

</div>
@endsection

@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script src='https://cdn.datatables.net/plug-ins/1.10.24/api/sum().js'></script>
<script src='https://cdn.datatables.net/plug-ins/1.10.24/api/average().js'></script>
<script src='https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js'></script>
<script src="https://cdn.datatables.net/v/dt/fh-3.2.1/datatables.min.js"></script>
<script src='https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function(){
    let table = $('#datatable').DataTable({
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Keinen Eintrag gefunden",
            "info": "Seite _PAGE_ von _PAGES_",
            "infoEmpty": "Keinen Eintrag gefunden",
            "infoFiltered": "(gefiltert von _MAX_ total Einträgen)",
            "loadingRecords": "Lädt...",
            "processing":     "Lädt...",
            "search":         "<p style='margin-bottom: 0; margin-right: 5px;'>Suche:</p>",
            "paginate": {
                "first":      "Erste",
                "last":       "Letzte",
                "next":       "Nächste",
                "previous":   "Zurück"
            },
        },
        "lengthMenu": [ [-1, 3, 5, 10, 25, 50, 100], ["alle", 3, 5, 10, 25, 50, 100] ],
        select: true,
        dom: 'Blfrtip',
            buttons: [{
                    extend: 'csv',
                    text: 'CSV Export',
                    className: 'btn btn-primary',
                    footer: 'true',
                    title: null,
                    filename: 'Stunden_Export',
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel Export',
                    className: 'btn btn-primary',
                    footer: 'true',
                    title: null,
                    sheetName: 'Export',
                    filename: 'Stunden_Export',
                    autoFilter: 'true',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                data = $('<p>' + data + '</p>').text();
                                return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                            },
                            footer: function(data, row, column, node) {
                                data = $('<p>' + data + '</p>').text();
                                return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                            }
                        }
                    },
                },
            ],
        });    
    })

</script>
@endsection