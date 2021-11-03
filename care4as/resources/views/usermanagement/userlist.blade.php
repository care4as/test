@extends('general_layout')
@section('pagetitle')
    Mitarbeiterverwaltung: Mitarbeiterliste
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
    .dt-buttons{
        margin-bottom: 10px;
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
                        <div class="col-md-3">
                            <div class="max-panel">
                                <div class="max-panel-title">Projekt</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                        <label for="project" style="margin: auto;">Auswahl:</label>
                                        <select id="project" class="form-control" name="project" style="color:black;">
                                            @if($defaultVariables['project'] == 'all')
                                                <option value="all" selected>Alle</option>
                                            @else
                                                <option value="all">Alle</option>
                                            @endif
                                            @if($defaultVariables['project'] == 'Care4as')
                                                <option value="Care4as" selected>Organisation</option>
                                            @else
                                                <option value="Care4as">Organisation</option>
                                            @endif
                                            @if($defaultVariables['project'] == '1und1 DSL Retention')
                                                <option value="1und1 DSL Retention" selected>1und1 DSL Retention</option>
                                            @else
                                                <option value="1und1 DSL Retention">1und1 DSL Retention</option>
                                            @endif
                                            @if($defaultVariables['project'] == '1und1 Offline')b
                                                <option value="1und1 Offline" selected>1und1 Kündigungsadministration</option>
                                            @else
                                                <option value="1und1 Offline">1und1 Kündigungsadministration</option>
                                            @endif
                                            @if($defaultVariables['project'] == '1und1 Retention')
                                                <option value="1und1 Retention" selected>1und1 Mobile Retention</option>
                                            @else
                                                <option value="1und1 Retention">1und1 Mobile Retention</option>
                                            @endif
                                            @if($defaultVariables['project'] == 'Telefonica')
                                                <option value="Telefonica" selected>Telefonica</option>
                                            @else
                                                <option value="Telefonica">Telefonica</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="max-panel">
                                <div class="max-panel-title">Betriebszugehörigkeit</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                        <label for="inputEmployee" style="margin: auto;">Auswahl:</label>
                                        <select id="inputEmployee" class="form-control" name="inputEmployee" style="color:black;">
                                            @if($defaultVariables['inputEmployee'] == 'active')
                                                <option value="active" selected>Aktivierte Mitarbeiter</option>
                                            @else
                                                <option value="active">Aktivierte Mitarbeiter</option>
                                            @endif
                                            @if($defaultVariables['inputEmployee'] == 'inactive')
                                                <option value="inactive" selected>Deaktivierte Mitarbeiter</option>
                                            @else
                                                <option value="inactive">Deaktivierte Mitarbeiter</option>
                                            @endif
                                            @if($defaultVariables['inputEmployee'] == 'all')
                                                <option value="all" selected>Alle Mitarbeiter</option>
                                            @else
                                                <option value="all">Alle Mitarbeiter</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="max-panel">
                                <div class="max-panel-title">Liste anzeigen</div>
                                <div class="max-panel-content" style="display: flex; justify-content: space-around;">
                                    <form action="" method="">
                                        <button type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Liste anzeigen</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="max-panel">
                                <div class="max-panel-title">KDW Synchronisation</div>
                                <div class="max-panel-content" style="display: flex; justify-content: space-around;">
                                    <form action="{{route('userlist.sync')}}" method="post()">
                                        <button type="submit" class="btn btn-warning btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Synchronisieren</button>
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
@if($defaultVariables['project'] != null)
<div class="row" id="userListContainer" style="display: none;">
    <div class="col-md-12">
        <div class="max-main-container">
            <div class="max-panel-content">
                <div style="width: 100%;">
                    <table class="max-table" id="userTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Bearbeiten</th>
                                <th>Name</th>
                                <th>Nutzername</th>
                                <th>Wochenstunden</th>
                                <th>Projekt</th>
                                <th>Abteilung</th>
                                <th>Team</th>
                                <th>Rolle</th>
                                <th>Eintritt</th>
                                <th>Austritt</th>
                                <th>KDW ID</th>
                                <th>KDW Tracking ID</th>
                                <th>1u1 Personen ID</th>
                                <th>1u1 Agenten ID</th>
                                <th>1u1 SSE Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            <tr>
                                <td>
                                    <div style="display: flex;">
                                        <button type="button" data-toggle="modal" data-target="#modal{{$user['ds_id']}}" class="btn btn-primary btn-sm" style="margin: auto; padding-top: 0; padding-bottom: 0;"><i class="now-ui-icons business_badge"></i></button>
                                    </div>
                                </td>
                                <td>{{$user['full_name']}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['work_hours']}}</td>
                                <td>{{$user['project']}}</td>
                                <td>{{$user['department']}}</td>
                                <td>{{$user['team']}}</td>
                                <td>{{$user['role']}}</td>
                                <td>{{$user['entry_date']}}</td>
                                <td>{{$user['leave_date']}}</td>
                                <td>{{$user['ds_id']}}</td>
                                <td>{{$user['kdw_tracking_id']}}</td>
                                <td>{{$user['1u1_person_id']}}</td>
                                <td>{{$user['1u1_agent_id']}}</td>
                                <td>{{$user['1u1_sse_name']}}</td>
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
@endsection

<!-- Modals -->
@section('additional_modal')
    @foreach($users as $key => $user)
      @if($user['role'] != "superadmin")
        <div class="modal fade" id="modal{{$user['ds_id']}}" tabindex="-1" role="dialog" aria-labelledby="modal{{$user['ds_id']}}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="z-index: 500000;">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="modal{{$user['ds_id']}}Label" style="font-size: 1.45em;">{{$user['full_name']}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#userdata{{$user['ds_id']}}" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Stammdaten</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#id{{$user['ds_id']}}" data-toggle="tab" style="font-size: 16px; font-weight: bold;"style="font-size: 16px; font-weight: bold;">Auftraggeberinformation</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#administration{{$user['ds_id']}}" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Administration</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <!-- Stammdaten -->
                        <div class="tab-pane active" id="userdata{{$user['ds_id']}}">
                            <div class="modal-body" style="font-size: 14px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Person</h5>
                                        <div style="width: 100%; display: grid; grid-template-columns: auto 1fr; grid-column-gap: 25px; grid-row-gap: 5px">
                                            <div style="margin-top: auto; margin-bottom: auto">MA-ID:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" readonly name="ds_id" value="{{$user['ds_id']}}"></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Nutzername:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['name']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Nachname:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['lastname']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Vorname:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['firstname']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Geburtstag:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['birthdate']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Geschlecht:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['gender']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">PLZ:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['zipcode']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Ort:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['location']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Straße:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['street']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Telefon:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['phone']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Mobil:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['mobile']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">E-Mail:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['mail']}}" readonly></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Vertrag</h5>
                                        <div style="width: 100%; display: grid; grid-template-columns: auto 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">
                                            <div style="margin-top: auto; margin-bottom: auto">Eintritt:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['entry_date']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Austritt:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['leave_date']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Wochenstunden:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['work_hours']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Standort:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['work_location']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Projekt:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['project']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Team:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['team']}}" readonly></div>
                                            <div style="margin-top: auto; margin-bottom: auto">Funktion:</div>
                                            <div><input class="form-control" id="disabledInput" type="text" value="{{$user['department']}}" readonly></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="font-size: 14px;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                            </div>
                        </div>
                        <!-- Auftraggeberinformation -->
                        <div class="tab-pane" id="id{{$user['ds_id']}}">
                            <form action="{{route('userlist.updateuser')}}" method="post()" style="width: 100%">
                                <div class="modal-body" style="font-size: 14px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>KDW</h5>
                                            <div style="width: 100%; display: grid; grid-template-columns: auto 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">
                                                <div style="margin-top: auto; margin-bottom: auto">MA-ID:</div>
                                                <div><input class="form-control" id="disabledInput" type="text" readonly name="ds_id" value="{{$user['ds_id']}}"></div>
                                                <div style="margin-top: auto; margin-bottom: auto">Tracking ID:</div>
                                                <div><input class="form-control" type="text" placeholder="Bitte einen Wert eingeben ..." name="tracking_id" value="{{$user['kdw_tracking_id']}}"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>1und1</h5>
                                            <div style="width: 100%; display: grid; grid-template-columns: auto 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">
                                                <div style="margin-top: auto; margin-bottom: auto">Personen ID:</div>
                                                <div><input class="form-control" type="text" placeholder="Bitte einen Wert eingeben ..." name="person_id" value="{{$user['1u1_person_id']}}"></div>
                                                <div style="margin-top: auto; margin-bottom: auto">Agenten ID:</div>
                                                <div><input class="form-control" type="text" placeholder="Bitte einen Wert eingeben ..." name="agent_id" value="{{$user['1u1_agent_id']}}"></div>
                                                <div style="margin-top: auto; margin-bottom: auto">SSE ID:</div>
                                                <div><input class="form-control" type="text" placeholder="Bitte einen Wert eingeben ..." name="sse_id" value="{{$user['1u1_sse_name']}}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="font-size: 14px;">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                                    <button type="submit" class="btn btn-primary">Speichern</button>
                                </div>
                            </form>
                        </div>
                        <!-- Administration -->
                        <div class="tab-pane" id="administration{{$user['ds_id']}}">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#roles{{$user['ds_id']}}" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Rollen und Rechte</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#password{{$user['ds_id']}}" data-toggle="tab" style="font-size: 16px; font-weight: bold;"style="font-size: 16px; font-weight: bold;">Passwort zurücksetzen</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <!-- Rollen und Rechte -->
                                <div class="tab-pane active" id="roles{{$user['ds_id']}}">
                                    <form action="{{route('userlist.updateUserRole')}}" method="post()" style="width: 100%">
                                        <div class="modal-body" style="font-size: 14px;">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <h5>Rollenverwaltung</h5>
                                                    <div style="width: 100%; display: grid; grid-template-columns: auto 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">
                                                        <div style="margin-top: auto; margin-bottom: auto">MA-ID:</div>
                                                        <div><input class="form-control" id="disabledInput" type="text" readonly name="ds_id" value="{{$user['ds_id']}}"></div>
                                                        <div style="margin-top: auto; margin-bottom: auto">Aktuelle Rolle:</div>
                                                        <div><input class="form-control" type="text" readonly name="current_role" value="{{$user['role']}}"></div>
                                                        <div style="margin-top: auto; margin-bottom: auto">Neue Rolle:</div>
                                                        <div>
                                                            <select id="new_role" class="form-control" name="new_role" style="color:black;">
                                                                <option selected value="null">Keine Rolle</option>
                                                                @foreach($roleArray as $key => $role)
                                                                  @if($key != "superadmin")
                                                                    <option value="{{$key}}">{{$key}}</option>
                                                                  @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <h5>Aktuelle Berechtigungen</h5>
                                                    @if($user['role'] == null)
                                                    <div style="width: 100%; display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">
                                                            @foreach($roleArray[array_key_first($roleArray)]['rights'] as $key => $entry)
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input disabled class="form-check-input" type="checkbox" value="" disabled>
                                                                    {{$entry['name']}}
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div style="width: 100%; display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">

                                                            @foreach($roleArray[$user['role']]['rights'] as $key => $entry)
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input @if($entry['has_right'] == 'true') checked @endif disabled class="form-check-input" type="checkbox" value="" disabled>
                                                                    {{$entry['name']}}
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="font-size: 14px;">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                                            <button type="submit" class="btn btn-primary">Speichern</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Passwort zurücksetzen -->
                                <div class="tab-pane" id="password{{$user['ds_id']}}">
                                    <form action="{{route('userlist.updateUserPassword')}}" method="post()" style="width: 100%">
                                        <div class="modal-body" style="font-size: 14px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5>Passwort</h5>
                                                    <div style="width: 100%; display: grid; grid-template-columns: auto 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">
                                                        <div style="margin-top: auto; margin-bottom: auto">MA-ID:</div>
                                                        <div><input class="form-control" id="disabledInput" type="text" readonly name="ds_id" value="{{$user['ds_id']}}"></div>
                                                        <div style="margin-top: auto; margin-bottom: auto">Neues Passwort:</div>
                                                        <div><input class="form-control" type="text" placeholder="Bitte einen Wert eingeben ..." name="new_password" value="care4as2021!"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="font-size: 14px;">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                                            <button type="submit" class="btn btn-primary">Zurücksetzen</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
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
        order: [[1, "asc"]],
        dom: 'Blfrtip',
        buttons: [
            { extend: 'csv', text: 'CSV Export', className: 'btn btn-primary' },
            { extend: 'excel', text: 'Excel Export', className: 'btn btn-primary' },
        ],
    });
    document.getElementById('userListContainer').style.display = "block";
    $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
})
</script>
@endsection
