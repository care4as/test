@extends('general_layout')
@section('pagetitle')
    Mobile Retention: Tracking Differenz
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
        width: 60px;
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
    .form-control[readonly]{
        cursor: default;
    }

</style>
@endsection
@section('content')
<div>
    <form action="{{route('mobileTrackingDifference')}}" method="get()">
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
</div>
@if($defaultVariablesArray['startDate'] != null && $defaultVariablesArray['endDate'] != null)
<div class="row" id="userListContainer" style="display: none;"> <!-- display: none -->
    <div class="col-md-12">
        <div class="max-main-container">
            <div class="max-panel-content">
                <div style="width: 100%;">
                    <table class="max-table" id="userTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>KDW SSC Calls</th>
                                <th>1u1 SSC Calls</th>
                                <th>SSC Calls Differenz</th>
                                <th>KDW BSC Calls</th>
                                <th>1u1 BSC Calls</th>
                                <th>BSC Calls Differenz</th>
                                <th>KDW Portal Calls</th>
                                <th>1u1 Portal Calls</th>
                                <th>Portal Calls Differenz</th>
                                <th>KDW SSC Saves</th>
                                <th>1u1 SSC Saves</th>
                                <th>SSC Saves Differenz</th>
                                <th>KDW BSC Saves</th>
                                <th>1u1 BSC Saves</th>
                                <th>BSC Saves Differenz</th>
                                <th>KDW Portal Saves</th>
                                <th>1u1 Portal Saves</th>
                                <th>Portal Saves Differenz</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach(...) -->
                            <tr>
                                <td>Name</td>
                                <td>KDW SSC Calls</td>
                                <td>1u1 SSC Calls</td>
                                <td>SSC Calls Differenz</td>
                                <td>KDW BSC Calls</td>
                                <td>1u1 BSC Calls</td>
                                <td>BSC Calls Differenz</td>
                                <td>KDW Portal Calls</td>
                                <td>1u1 Portal Calls</td>
                                <td>Portal Calls Differenz</td>
                                <td>KDW SSC Saves</td>
                                <td>1u1 SSC Saves</td>
                                <td>SSC Saves Differenz</td>
                                <td>KDW BSC Saves</td>
                                <td>1u1 BSC Saves</td>
                                <td>BSC Saves Differenz</td>
                                <td>KDW Portal Saves</td>
                                <td>1u1 Portal Saves</td>
                                <td>Portal Saves Differenz</td>
                            </tr>
                             <!-- endforeach -->
                        </tbody>
                    </table>    
                </div>
            </div>           
        </div>
    </div>
</div>
@endif
@endsection

<!-- Modals -->

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
  $(document).ready(function(){
    let table = $('#userTable').DataTable({
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Keinen Eintrag gefunden",
            "info": "Seite _PAGE_ von _PAGES_",
            "infoEmpty": "Keinen Eintrag gefunden",
            "infoFiltered": "(gefiltert von _MAX_ total Einträgen)",
            "loadingRecords": "Lädt...",
            "processing":     "Lädt...",
            "search":         "Suche:",
            "paginate": {
                "first":      "Erste",
                "last":       "Letzte",
                "next":       "Nächste",
                "previous":   "Zurück"
            },
        },
        "lengthMenu": [ [-1, 3, 5, 10, 25, 50, 100], ["alle", 3, 5, 10, 25, 50, 100] ],
        scrollX: true,
        scrollCollapse: false,
        fixedColumns: false,
        select: true,
        order: [[0, "asc"]],
    });
    document.getElementById('userListContainer').style.display = "block";
    $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
})
</script>
@endsection