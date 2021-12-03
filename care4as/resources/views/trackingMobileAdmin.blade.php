@extends('general_layout')
@section('pagetitle')
    Mobile Tracking
@endsection
@section('content')
@section('additional_css')
<style>
    .tracking_title{
        border-bottom: 1px solid gray;
        text-align: center;
        font-size: 1.3rem;
    }

    .tracking-table{
        width: 100%;
        white-space: nowrap;
        border: 2px solid grey;
    }

    .tracking-table th, td{
        border: 1px solid grey;
        padding: 0 5px;
    }

    .tracking-table th{
        text-align: center;
    }
</style>
@endsection

<div style="font-size: 1em">
    <!-- START MAIN-->
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="card card-nav-tabs card-plain">
                    <div class="card-header card-header-danger">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#overview" data-toggle="tab">Übersicht</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#history" data-toggle="tab">Historie</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content text-center">
                            <div class="tab-pane active" id="overview">
                                <div style="margin: 10px 2px 10px 10px; overflow: scroll;">
                                    <table class="tracking-table">
                                        <thead>
                                            <tr>
                                                <th rowspan="3" style="border-right: 2px solid grey">Name</th>
                                                <th colspan="3" style="border-right: 2px solid grey">Gesamt</th>
                                                <th colspan="9" style="border-right: 2px solid grey">SSC</th>
                                                <th colspan="9" style="border-right: 2px solid grey">BSC</th>
                                                <th colspan="9" style="border-right: 2px solid grey">Portal</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">Calls</th>
                                                <th rowspan="2">Cancel</th>
                                                <th rowspan="2" style="border-right: 2px solid grey">Service</th>
                                                <th rowspan="2">Calls</th>
                                                <th colspan="4">Saves</th>
                                                <th colspan="2">Negativ</th>
                                                <th colspan="2" style="border-right: 2px solid grey">CR</th>
                                                <th rowspan="2">Calls</th>
                                                <th colspan="4">Saves</th>
                                                <th colspan="2">Negativ</th>
                                                <th colspan="2" style="border-right: 2px solid grey">CR</th>
                                                <th rowspan="2">Calls</th>
                                                <th colspan="4">Saves</th>
                                                <th colspan="2">Negativ</th>
                                                <th colspan="2" style="border-right: 2px solid grey">CR</th>
                                                <th>Sonstige</th>
                                                <th colspan="2">OptIn</th>
                                            </tr>
                                            <tr>
                                                <th>Σ GeVo Saves</th>
                                                <th>← Gebucht</th>
                                                <th>← Nacharbeit</th>
                                                <th>KüRü</th>
                                                <th>Cancel</th>
                                                <th>Service</th>
                                                <th>Gebucht</th>
                                                <th style="border-right: 2px solid grey">Gesamt</th>
                                                <th>Σ GeVo Saves</th>
                                                <th>← Gebucht</th>
                                                <th>← Nacharbeit</th>
                                                <th>KüRü</th>
                                                <th>Cancel</th>
                                                <th>Service</th>
                                                <th>Gebucht</th>
                                                <th style="border-right: 2px solid grey">Gesamt</th>
                                                <th>Σ GeVo Saves</th>
                                                <th>← Gebucht</th>
                                                <th>← Nacharbeit</th>
                                                <th>KüRü</th>
                                                <th>Cancel</th>
                                                <th>Service</th>
                                                <th>Gebucht</th>
                                                <th style="border-right: 2px solid grey">Gesamt</th>
                                                <th>Calls</th>
                                                <th>Anzahl</th>
                                                <th>Quote</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border-right: 2px solid grey">{Name1}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                            </tr>                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="border-right: 2px solid grey">Summe</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td style="border-right: 2px solid grey">{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="history">
                                <div style="margin: 10px 2px 10px 10px; overflow: scroll;">
                                    <table class="tracking-table">
                                        <thead>
                                            <th>Erstellt</th>
                                            <th>Kundenberater</th>
                                            <th>Vertragsnummer</th>
                                            <th>Produktgruppe</th>
                                            <th>Bearbeitung</th>
                                            <th>Zieltarif</th>
                                            <th>OptIn</th>
                                            <th>RLZ+24</th>
                                            <th>Nacharbeit</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                            </tr>
                                            <tr>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                                <td>{Wert}</td>
                                            </tr>
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
    <!-- END MAIN-->
</div>
@endsection

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

@endsection
