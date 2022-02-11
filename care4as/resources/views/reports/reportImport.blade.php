@extends('general_layout')
@section('pagetitle')
    Reporte: Übersicht
@endsection
@section('content')

@section('additional_css')
<link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
<style media="screen">
  .loadingerDA, .loadingerAB, .loadingerRD,.loadingerOptin,.loadingerSAS
  {
    animation: blink 2s infinite;
  }

  @keyframes blink {
  from {color: black;}
  to {color: white;}
  }
  table.dataTable {
        border-collapse: collapse;
    }
    .form-control{
        color:black;

    }
    .dataTables_filter{
        width: 300px;
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
    .form-control[readonly]{
        cursor: default;
    }
    #loaderDiv
    {
      display: none;
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
</style>
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="max-main-container">

            <div class="row">
                <div class="col-md-12">
                    <div class="max-panel bg-none">
                        <div class="max-panel-title">Reporte Import und Export</div>
                        <div class="max-panel-content">
                            <table class="table" style="text-align: center; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">Bezeichnung</th>
                                        <th>Daten von</th>
                                        <th>Daten bis</th>
                                        <th>Import</th>
                                        <th>Export</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="availbench">
                                        <td style="text-align: left; font-weight: 600;">1u1 Availbench</td>
                                        @if(isset($refinedDataTables['availbench_report']['min_date']))
                                            <td>{{$refinedDataTables['availbench_report']['min_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        @if(isset($refinedDataTables['availbench_report']['max_date']))
                                            <td>{{$refinedDataTables['availbench_report']['max_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#availbenchModal">Importieren</button></td>
                                        <td></td>
                                    </tr>
                                    <tr id="dailyAgent">
                                        <td style="text-align: left; font-weight: 600;">1u1 Daily Agent</td>
                                        @if(isset($refinedDataTables['dailyAgent_report']['min_date']))
                                            <td>{{$refinedDataTables['dailyAgent_report']['min_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        @if(isset($refinedDataTables['dailyAgent_report']['max_date']))
                                            <td>{{$refinedDataTables['dailyAgent_report']['max_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dailyAgentModal">Importieren</button></td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dailyAgentExportModal">Exportieren</button></td>
                                    </tr>
                                    <tr id="optin">
                                        <td style="text-align: left; font-weight: 600;">1u1 OptIn</td>
                                        @if(isset($refinedDataTables['optin_report']['min_date']))
                                            <td>{{$refinedDataTables['optin_report']['min_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        @if(isset($refinedDataTables['optin_report']['max_date']))
                                            <td>{{$refinedDataTables['optin_report']['max_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#optinModal">Importieren</button></td>
                                        <td></td>
                                    </tr>
                                    <tr id="sas">
                                        <td style="text-align: left; font-weight: 600;">1u1 Retention Details</td>
                                        @if(isset($refinedDataTables['details_report']['min_date']))
                                            <td>{{$refinedDataTables['details_report']['min_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        @if(isset($refinedDataTables['details_report']['max_date']))
                                            <td>{{$refinedDataTables['details_report']['max_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#retDetailsModal">Importieren</button></td>
                                        <td></td>
                                    </tr>
                                    <tr id="sas">
                                        <td style="text-align: left; font-weight: 600;">1u1 SaS</td>
                                        @if(isset($refinedDataTables['sas_report']['min_date']))
                                            <td>{{$refinedDataTables['sas_report']['min_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        @if(isset($refinedDataTables['sas_report']['max_date']))
                                            <td>{{$refinedDataTables['sas_report']['max_date']}}</td>
                                        @else
                                            <td>Keine Daten verfügbar</td>
                                        @endif
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sasModal">Importieren</button></td>
                                        <td></td>
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

<div class="row">
    <div class="col-md-12">
        <div class="max-main-container">
            <form action="{{route('reportImport')}}" method="get()">
            @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="max-panel bg-none">
                            <div class="max-panel-title">
                                Datenstand Tagesfilter
                            </div>
                            <div class="max-panel-content">
                                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                    <p style="margin: auto;">Von:</p>
                                    <input type="date" id="dateFrom" name="startDate" class="form-control" placeholder="" value="{{$defaultVariablesArray['startDate']}}" style="color: black;">
                                    <p style="margin: auto;">Bis:</p>
                                    <input type="date" id="dateTo" name="endDate" class="form-control" placeholder="" value="{{$defaultVariablesArray['endDate']}}" style="color: black;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="display: flex;">
                        <button class="btn btn-primary" style="margin: auto;" type="submit">Reportübersicht anzeigen</button>
                    </div>
                </div>
            </form>
            @if($defaultVariablesArray['recordFilterSet'] == 'true')
            <div class="row" id="userListContainer" style="display: none;">
                <div class="col-md-12">
                    <div class="max-panel bg-none">
                        <div class="max-panel-title">Datenstand</div>
                        <div class="max-panel-content">
                            <div style="width: 100%;">
                                <table class="max-table" id="timespanTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Datum</th>
                                            <th>Availbench (DSL)</th>
                                            <th>Availbench (Mobile)</th>
                                            <th>Daily Agent (DSL)</th>
                                            <th>Daily Agent (Mobile)</th>
                                            <th>OptIn (DSL)</th>
                                            <th>OptIn (Mobile)</th>
                                            <th>Retention Details (DSL)</th>
                                            <th>Retention Details (Mobile)</th>
                                            <th>SaS (DSL)</th>
                                            <th>SaS (Mobile)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datatablesDates as $key => $entry)
                                        <tr style="text-align: center">
                                            <td>{{date('d.m.Y', strtotime($key))}}</td>
                                            <!-- Availench -->
                                            @if($entry['availbench_dsl'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif
                                            @if($entry['availbench_mobile'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif

                                            <!-- Daily Agent -->
                                            @if($entry['daily_agent_dsl'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif
                                            @if($entry['daily_agent_mobile'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif

                                            <!-- OptIn -->
                                            @if($entry['optin_dsl'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif
                                            @if($entry['optin_mobile'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif

                                            <!-- Retention Details -->
                                            @if($entry['retention_details_dsl'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif
                                            @if($entry['retention_details_mobile'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif

                                            <!-- SAS -->
                                            @if($entry['sas_dsl'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif
                                            @if($entry['sas_mobile'] == 'true')
                                                <td style='color: green; font-weight: 600;'>✓</td>
                                            @else
                                                <td style='color: red; font-weight: 600;'>✗</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($defaultVariablesArray['recordFilterSet'] == 'error')
            <div class="row">
                <div class="col-md-12">
                    <div class="max-panel bg-none">
                        <div class="max-panel-title">Fehler</div>
                        <div class="max-panel-content">
                            Fehlerhafte Datumseingabe. Bitte überprüfen Sie die gesetzten Werte.
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
@section('additional_modal')
<!-- Availbench -->
<!-- ALT
<div class="modal fade" id="availbenchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
          <div class="loaderDiv" id="loaderDiv1" style="display:flex;">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
          </div>
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Availbench</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width: 100%; font-size: 16px; font-weight: 600;">
                        Dateiformat
                    </div>
                    <div style="width: 100%;">
                        Dateiname: Ohne Konvention
                    </div>
                    <div style="width: 100%;">
                        Dateiformat: <i>.txt</i>
                    </div>
                    <div style="width: 100%;">
                        Hinweis: Die Datei, kann unverändert übernommen werden.
                    </div>

                    <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                     Datei auswählen
                    </div>
                    DEBUG
                    <form action="{{route('availbench.upload')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                        <input type="file" name="file" id="file">
                        <button type="submit">Test</button>
                    </form>

                    <form action="{{route('availbench.upload')}}" class="dropzone" id="availbenchDropzone" enctype="multipart/form-data" style="padding: 0;">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="availbenchContainer" style="margin-top: 0px; margin-bottom: 0px; min-height: 150px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                            <button type="button" id="availbenchDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
-->
<!-- Availbench -->
<div class="modal fade" id="availbenchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
          <div class="loaderDiv" id="loaderDiv1">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
          </div>
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Availbench</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <div id="debug_div" style="font-size: 12px">
                Debug
                <form action="{{route('availbenchKdw.upload')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="file" name="file" id="">
                    <button type="submit">Hochladen</button>
                </form>
            </div> -->
            <!-- <div id="app">
                 <div class="tab-pane">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#availbenchCare4as" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Upload Care4as (DSL)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#availbenchKdw" data-toggle="tab" style="font-size: 16px; font-weight: bold;" style="font-size: 16px; font-weight: bold;">Upload KDW (Mobile)</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="availbenchCare4as"> -->
                            <div class="modal-body" style="font-size: 14px;">
                                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                                    Dateiformat
                                </div>
                                <div style="width: 100%;">
                                    Dateiname: Ohne Konvention
                                </div>
                                <div style="width: 100%;">
                                    Dateiformat: <i>.txt</i>
                                </div>
                                <div style="width: 100%;">
                                    Hinweis: Die Datei, kann unverändert übernommen werden.
                                </div>
                                <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                                Datei auswählen
                                </div>
                                <form action="{{route('availbench.upload')}}" class="dropzone" id="availbenchDropzone" enctype="multipart/form-data" style="padding: 0;">
                                @csrf
                                    <div class="form-row dropzone-previews dz-default dz-message" id="availbenchContainer" style="margin-top: 0px; margin-bottom: 0px; min-height: 150px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                                        <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                                    </div>
                                </div>
                                    <div class="modal-footer" style="font-size: 14px;">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                                        <button type="button" id="availbenchDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                                    </div>
                                </form>
                            </div>
                        <!-- <div class="tab-pane" id="availbenchKdw">
                            <div class="modal-body" style="font-size: 14px;">
                                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                                    Dateiformat
                                </div>
                                <div style="width: 100%;">
                                    Dateiname: Ohne Konvention
                                </div>
                                <div style="width: 100%;">
                                    Dateiformat: <i>.txt</i>
                                </div>
                                <div style="width: 100%;">
                                    Hinweis: Die Datei, kann unverändert übernommen werden.
                                </div>
                                <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                                Datei auswählen
                                </div>
                                <form action="{{route('availbenchKdw.upload')}}" class="dropzone" id="availbenchKdwDropzone" enctype="multipart/form-data" style="padding: 0;">
                                @csrf
                                    <div class="form-row dropzone-previews dz-default dz-message" id="availbenchKdwContainer" style="margin-top: 0px; margin-bottom: 0px; min-height: 150px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                                        <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                                    </div>
                            </div>
                                    <div class="modal-footer" style="font-size: 14px;">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                                        <button type="button" id="availbenchKdwDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                                    </div>
                                </form>
                        </div> 
                    </div> 
                </div>
            </div> -->
        </div>
    </div>
</div>

<!-- Daily Agent -->
<div class="modal fade" id="dailyAgentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
          <div class="loaderDiv" id="loaderDiv2">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
          </div>
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Daily Agent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="tab-pane">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#dailyAgentCsv" data-toggle="tab" style="font-size: 16px; font-weight: bold;">CSV Upload</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#dailyAgentXlsx" data-toggle="tab" style="font-size: 16px; font-weight: bold;" style="font-size: 16px; font-weight: bold;">XLSX Upload</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dailyAgentCsv">
                            <div class="modal-body" style="font-size: 14px;">
                                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                                    Dateiformat
                                </div>
                                <div style="width: 100%;">
                                    Dateiname: <i>Keine Konvention</i>
                                </div>
                                <div style="width: 100%;">
                                    Dateiformat: <i>.csv</i>
                                </div>
                                <div style="width: 100%;">
                                    Hinweis: In Ordner <i>Agentenreporte</i> werden Dateien bereits im CSV Fortmat abgelegt. Ansonsten bei herunterladen das richtige Format auswählen.
                                </div>

                                <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                                Datei auswählen
                                </div>
                                <form action="{{route('dailyAgent.uploadCsv')}}" class="dropzone" id="dailyAgentDropzone" enctype="multipart/form-data"  style="padding: 0;">
                                @csrf
                                    <div class="form-row dropzone-previews dz-default dz-message" id="dailyAgentContainer" style="margin-top: 0px; margin-bottom: 0px; min-height: 150px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                                        <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                                    </div>
                                </div>
                                    <div class="modal-footer" style="font-size: 14px;">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                                        <button type="button" id="dailyAgentDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                                    </div>
                                </form>
                            </div>
                        <div class="tab-pane" id="dailyAgentXlsx">
                        <div class="modal-body" style="font-size: 14px;">
                                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                                    Dateiformat
                                </div>
                                <div style="width: 100%;">
                                    Dateiname: <i>DAI_YYYY_MM_TT</i>
                                </div>
                                <div style="width: 100%;">
                                    Dateiformat: <i>.xlsx</i> (übliche Excel Datei)
                                </div>
                                <div style="width: 100%;">
                                    Hinweis: Die Datei muss unbedingt in den oben genannten Dateinamen umbenannt werden.
                                </div>

                                <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                                Datei auswählen
                                </div>
                                <form action="{{route('excel.dailyAgent.upload')}}" class="dropzone" id="dailyAgentXlsxDropzone" enctype="multipart/form-data"  style="padding: 0;">
                                @csrf
                                    <div class="form-row dropzone-previews dz-default dz-message" id="dailyAgentXlsxContainer" style="margin-top: 0px; margin-bottom: 16px; min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                                        <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                                    </div>
                                    <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                                        Import konfigurieren
                                    </div>
                                    <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                                        <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                                        <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="1"></div>
                                        <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                                        <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                                    </div>
                                </div>
                                    <div class="modal-footer" style="font-size: 14px;">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                                        <button type="button" id="dailyAgentXlsxDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daily Agent Export -->
<div class="modal fade" id="dailyAgentExportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="loaderDiv" id="loaderDiv2">
                <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Daily Agent Export</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('dailyAgent.exportXlsx')}}"  style="padding: 0;" onformchange="">
                @csrf
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width:100%">
                        Hinweis: Aufgrund des Datenumfangs und entsprechender Größe der Exportdatei sollte der Exportzeitraum einen Monat nicht überschreiten!
                    </div>
                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px; margin-top: 16px;">
                        <p style="margin: auto 0 auto auto;">Startdatum:</p>
                        <input type="date" id="dailyAgentStartDate" name="dailyAgentStartDate" class="form-control" placeholder="" style="color:black;" onchange="enableExportButton('dailyAgentStartDate', 'dailyAgentEndDate', 'dailyAgentExportButton')">
                        <p style="margin: auto 0 auto auto;">Enddatum:</p>
                        <input type="date" id="dailyAgentEndDate" name="dailyAgentEndDate" class="form-control" placeholder="" style="color:black;" onchange="enableExportButton('dailyAgentStartDate', 'dailyAgentEndDate', 'dailyAgentExportButton')">
                        <p style="text-align:center;margin-bottom:0;grid-column:1/-1;">Status:</p>
                        <div style="display:grid;grid-template-columns:1fr 1fr;grid-column:1/-1;font-size:12px;">
                            <!-- Initizialized -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus1" value="true">Initialized<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Logged Out -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus2" value="true">Logged Out<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Available -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus3" value="true">Available<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Comm Fault -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus4" value="true">Comm Fault<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- In Call -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus5" value="true">In Call<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- On Hold -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus6" value="true">On Hold<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Ringing -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus7" value="true">Ringing<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Wrap Up -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus8" value="true">Wrap Up<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (01_screen break) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus9" value="true">Released (01_screen break)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (02_lunch break) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus10" value="true">Released (02_lunch break)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (03_away) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus11" value="true">Released (03_away)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (04_offline work) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus12" value="true">Released (04_offline work)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (05_occupied) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus13" value="true">Released (05_occupied)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (06_practice) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus14" value="true">Released (06_practice)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (07_meeting) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus15" value="true">Released (07_meeting)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (08_organization) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus16" value="true">Released (08_organization)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (09_outbound) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus17" value="true">Released (09_outbound)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                            <!-- Released (no code) -->
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" checked name="dailyAgentStatus18" value="true">Released (no code)<span class="form-check-sign"><span class="check"></span></span>
                                </label>
                            </div>
                        </div>
                        <p style="margin: auto 0 auto auto;">Weiterer Filter:</p>
                        <select name="dailyAgentFilter" id="dailyAgentFilter" class="form-control" onchange="dailyAgentExportFilter()">
                            <option value="false">Nein</option>
                            <option value="agent_group_name">Agent Group</option>
                            <option value="agent_id">Agent ID</option>
                        </select>
                        <p style="margin: auto 0 auto auto; display: none;" id="dailyAgentAgentGroupNameTitle">Agent Group:</p>
                        <select name="dailyAgentAgentGroupName" id="dailyAgentAgentGroupNameInput" class="form-control" style="display: none;">
                            <option value="DE_KDW_Retention_Mobile_Flensburg">DE_KDW_Retention_Mobile_Flensburg</option>
                            <option value="DE_care4as_RT_DSL_Eggebek">DE_care4as_RT_DSL_Eggebek</option>
                        </select>
                        <p style="margin: auto 0 auto auto; display: none;" id="dailyAgentAgentIdTitle">Agent ID:</p>
                        <input type="number" name="dailyAgentAgentId" id="dailyAgentAgentIdInput" class="form-control" style="display: none;">
                    </div>
                </div>
                <div class="modal-footer" style="font-size: 14px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                    <button type="submit" class="btn btn-primary" id="dailyAgentExportButton" disabled>Exportieren</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OptIn -->
<div class="modal fade" id="optinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
          <div class="loaderDiv" id="loaderDiv3">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
          </div>
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">OptIn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width: 100%; font-size: 16px; font-weight: 600;">
                        Dateiformat
                    </div>
                    <div style="width: 100%;">
                        Dateiname: Ohne Konvention.
                    </div>
                    <div style="width: 100%;">
                        Dateiformat: <i>.xlsx</i> (übliche Excel Datei)
                    </div>
                    <div style="width: 100%;">
                        Hinweis: Datei aus Zip entnehmen -> öffnen -> als .xlsx Datei speichern. Im ursprünglichen Verzeichnis liegt die Datei lediglich im Binärformat vor.
                    </div>

                    <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                     Datei auswählen
                    </div>
                    <form action="{{route('reports.OptIn.upload')}}" class="dropzone" id="optinDropzone" enctype="multipart/form-data" style="padding: 0;">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="optinContainer" style="margin-top: 0px; margin-bottom: 16px; min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="1"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                            <button type="button" id="optinDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- Retention Details -->
<div class="modal fade" id="retDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
          <div class="loaderDiv" id="loaderDiv4">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
          </div>
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Retention Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Debug
                <form action="{{route('excel.test')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="file" name="file" id="">
                    <button type="submit">Hochladen</button>
                </form> -->
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                        Dateiformat
                    </div>
                    <div style="width: 100%;">
                        Dateiname: Ohne Konvention.
                    </div>
                    <div style="width: 100%;">
                        Dateiformat: <i>.xlsx</i> (übliche Excel Datei)
                    </div>
                    <div style="width: 100%;">
                        Hinweis: Datei aus Zip entnehmen -> öffnen -> als .xlsx Datei speichern. Im ursprünglichen Verzeichnis liegt die Datei lediglich im Binärformat vor.
                    </div>

                    <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                     Datei auswählen
                    </div>
                    <form action="{{route('excel.test')}}" class="dropzone" id="retDetailsDropzone" enctype="multipart/form-data" style="padding: 0;">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="retDetailsContainer" style="margin-top: 0px; margin-bottom: 16px; min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="6"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                            <button type="button" id="retDetailsDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- SaS -->
<div class="modal fade" id="sasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
          <div class="loaderDiv" id="loaderDiv5">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
          </div>
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">SaS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                        Dateiformat
                    </div>
                    <div style="width: 100%;">
                        Dateiname: Ohne Konvention.
                    </div>
                    <div style="width: 100%;">
                        Dateiformat: <i>.xlsx</i> (übliche Excel Datei)
                    </div>
                    <div style="width: 100%;">
                        Hinweis: Datei aus Zip entnehmen -> öffnen -> als .xlsx Datei speichern. Im ursprünglichen Verzeichnis liegt die Datei lediglich im Binärformat vor.
                    </div>

                    <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 16px;">
                     Datei auswählen
                    </div>
                    <form action="{{route('reports.SAS.upload')}}" class="dropzone" id="sasDropzone" enctype="multipart/form-data" style="padding: 0;">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="sasContainer" style="margin-top: 0px; margin-bottom: 16px; min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="2"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Schließen</button>
                            <button type="button" id="sasDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
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

<script type="text/javascript">
  $(document).ready(function(){
    let table = $('#timespanTable').DataTable({
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
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excel',
                    text: 'Excel Export',
                    className: 'btn btn-primary'
                },
            ],
    });
    document.getElementById('userListContainer').style.display = "block";
    $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
})
</script>

<script type="text/javascript">

Dropzone.options.availbenchDropzone = {
  previewsContainer: "#availbenchContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 120, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  timeout: 1200000,
  parallelUploads: 10,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#availbenchDropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv1').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv1').css('display','none');
      });
      this.on("success", function(file, response) {
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv1').css('display','none');
      });
      this.on("complete", function(file) {

      });
    }
};

Dropzone.options.availbenchKdwDropzone = {
  previewsContainer: "#availbenchKdwContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 120, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  timeout: 1200000,
  parallelUploads: 10,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#availbenchKdwDropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv1').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv1').css('display','none');
      });
      this.on("success", function(file, response) {
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv1').css('display','none');
      });
      this.on("complete", function(file) {

      });
    }
};


Dropzone.options.dailyAgentDropzone = {
  previewsContainer: "#dailyAgentContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 12000, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  timeout: 1200000,
  parallelUploads: 64,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#dailyAgentDropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv2').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv2').css('display','none');
      });
      this.on("success", function(file, response) {
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv2').css('display','none');
      });
      this.on("complete", function(file) {
        // this.removeAllFiles()
      });
    }
};

Dropzone.options.dailyAgentXlsxDropzone = {
  previewsContainer: "#dailyAgentXlsxContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 12000, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  timeout: 1200000,
  parallelUploads: 64,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#dailyAgentXlsxDropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv2').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv2').css('display','none');
      });
      this.on("success", function(file, response) {
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv2').css('display','none');
      });
      this.on("complete", function(file) {
        // this.removeAllFiles()
      });
    }
};

Dropzone.options.optinDropzone = {
  previewsContainer: "#optinContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 120, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  timeout: 1200000,
  parallelUploads: 10,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#optinDropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv3').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv3').css('display','none');
      });
      this.on("success", function(file, response) {
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv3').css('display','none');
      });
      this.on("complete", function(file) {
        // this.removeAllFiles()
      });
    }
};

Dropzone.options.retDetailsDropzone = {
  previewsContainer: "#retDetailsContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 120, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  timeout: 1200000,
  parallelUploads: 10,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#retDetailsDropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv4').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv4').css('display','none');
      });
      this.on("success", function(file, response) {
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv4').css('display','none');
      });
      this.on("complete", function(file) {
        // this.removeAllFiles()
      });
    }
};

Dropzone.options.sasDropzone = {
  previewsContainer: "#sasContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 120, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  timeout: 1200000,
  parallelUploads: 10,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#sasDropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv5').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv5').css('display','none');
      });
      this.on("success", function(file, response) {
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv5').css('display','none');
      });
      this.on("complete", function(file) {
      });
    }
};

</script>

<script type="text/javascript">

$( document ).ready(function() {
  loadData('dailyAgentDataStatus','#dailyagentData','.loadingerDA')

  loadData('SASStatus','#SASDataStatus','.loadingerSAS')
  //
  loadData('OptinStatus','#OptinDataStatus','.loadingerOptin')
  //
  loadData('RDDataStatus','#RDDataStatus', '.loadingerRD')

});
$(function(){

  document.addEventListener('keydown', function(event) {
  if (event.ctrlKey && event.key === 'g') {
    $('#debugroute').toggle()
  }
})})
</script>


<!-- Export Buttons aktivieren, wenn Zeitraum ordentlich gesetzt ist -->
<script>

    function enableExportButton(startDateId, endDateId, buttonId){
        var startDate = document.getElementById(startDateId).value;
        var endDate = document.getElementById(endDateId).value;

        if(startDate != "" && endDate != "" && startDate <= endDate){
            document.getElementById(buttonId).disabled = false;
        } else {
            document.getElementById(buttonId).disabled = true;
        }
    }
</script>

<!-- Filter Funktionen Umsetzen -->
<script>

    // Daily Agent
    function dailyAgentExportFilter(){
        var filter = document.getElementById('dailyAgentFilter').value;

        // Alle Elemente zurücksetzten
        document.getElementById('dailyAgentAgentGroupNameInput').value = null;
        document.getElementById('dailyAgentAgentIdInput').value = null;

        switch (filter){
            case 'false':
                document.getElementById('dailyAgentAgentGroupNameTitle').style.display = 'none';
                document.getElementById('dailyAgentAgentGroupNameInput').style.display = 'none';
                document.getElementById('dailyAgentAgentIdTitle').style.display = 'none';
                document.getElementById('dailyAgentAgentIdInput').style.display = 'none';
            break;

            case 'agent_group_name':
                document.getElementById('dailyAgentAgentGroupNameTitle').style.display = 'block';
                document.getElementById('dailyAgentAgentGroupNameInput').style.display = 'block';
                document.getElementById('dailyAgentAgentIdTitle').style.display = 'none';
                document.getElementById('dailyAgentAgentIdInput').style.display = 'none';
            break;

            case 'agent_id':
                document.getElementById('dailyAgentAgentGroupNameTitle').style.display = 'none';
                document.getElementById('dailyAgentAgentGroupNameInput').style.display = 'none';
                document.getElementById('dailyAgentAgentIdTitle').style.display = 'block';
                document.getElementById('dailyAgentAgentIdInput').style.display = 'block';
            break;
        }

    }

</script>

@endsection
