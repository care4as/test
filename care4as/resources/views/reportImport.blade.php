@extends('general_layout')
@section('pagetitle')
    Reporte: Import
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="max-main-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="max-panel">
                        <div class="max-panel-title">Reporte importieren</div>
                        <div class="max-panel-content">
                            <table class="table" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">Report</th>
                                        <th>Daten von</th>
                                        <th>Daten bis</th>
                                        <th>Import</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: left;">1u1 Availbench</td>
                                        <td>xx.xx.xxxx</td>
                                        <td>xx.xx.xxxx</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">1u1 Daily Agent</td>
                                        <td>xx.xx.xxxx</td>
                                        <td>xx.xx.xxxx</td>
                                        <td><button type="button" class="btn btn-primary">Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">1u1 OptIn Report</td>
                                        <td>xx.xx.xxxx</td>
                                        <td>xx.xx.xxxx</td>
                                        <td><button type="button" class="btn btn-primary">Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">1u1 Retention Details</td>
                                        <td>xx.xx.xxxx</td>
                                        <td>xx.xx.xxxx</td>
                                        <td><button type="button" class="btn btn-primary">Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">KDW Stundenreport</td>
                                        <td>xx.xx.xxxx</td>
                                        <td>xx.xx.xxxx</td>
                                        <td><button type="button" class="btn btn-primary">Importieren</button></td>
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

<!-- Modal -->




@endsection
@section('additional_modal')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Availbench</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px;">
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                    Datenstand
                </div>
                <div style="width: 100%; overflow-x: auto; margin-bottom: 20px;">
                    <table class="max-table" id="userListTable">
                        <thead>
                            <tr style="width: 100%">
                                <th>Von</th>
                                <th>Bis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">Datum1</td>
                                <td style="text-align: center">Datum2</td>
                            </tr>
                        </tbody>
                    </table>   
                </div>
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                    Datei auswählen
                </div>
                <button type="button" class="btn btn-primary" style="margin-top: 0; margin-bottom: 20px;">Durchsuchen</button>
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                    Import konfigurieren
                </div>
                <div style="display: grid; grid-template-columns: auto 1fr;">
                    <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                    <div><input type="text" class="form-control" placeholder="Wert..."></div>
                    <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                    <div><input type="text" class="form-control" placeholder="Wert..."></div>
                </div>
            </div>
            <div class="modal-footer" style="font-size: 14px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>
@endsection