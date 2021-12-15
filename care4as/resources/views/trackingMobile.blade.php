@extends('general_layout')
@section('pagetitle')
Tracking mit Vertragsnummer
@endsection
@section('content')
@section('additional_css')
<style>
    .tracking_container{
        padding: 10px;
    }

    .tracking_description{
        font-size: 0.8em;
        text-align: center;
    }

    .tracking_title{
        border-bottom: 1px solid gray;
        text-align: center;
        padding: 10px 0;
        font-size: 1.3rem;
    }

    .tracking-table{
        white-space: nowrap;
        width:100%;
    }

    .tracking-table th, td{
        border: 1px solid black;
        padding: 0 5px;
    }

    .tracking-table th{
        text-align: center;
    }

    .tracking_errormessage{
        font-size: 0.8em;
        text-align: center;
        color: #f96332;
        border: 1px solid #f96332;
        max-width: 600px;
        margin: 10px auto auto auto;
        border-radius: 5px;
        display: flex;
    }

    .btn-check {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
    }

    .btn-outline-primary:hover{
        color: white;
        background-color: #f96332;;
    }

    .btn-check:checked + label{
    color: white;
    background-color: #f96332;;
    border: 1px solid #f96332;
    }

    .first-btn-group-element{
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
    }

    .last-btn-group-element{
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }

    .btn-group > .btn:not(:first-child){
        margin-left: -2px;
    }

    .btn{
        padding: 5px 10px !important;
        margin-top: 0;
        margin-bottom: 0;
        min-width: 75px;
    }

    .btn-group-container{
        display: flex;
        justify-content: center;
    }

    .btn-tracking-change{
        min-width: 50px;
    }

    .form-control[disabled]{
        cursor: default;
    }

    .tr {
        background-color:  black !important;
    }


</style>
@endsection

<div style="font-size: 1em;">
    <!-- START TRACKING -->
    <div class="row">
        <div class="col-sm-12">
            <div class="max-main-container">
                <div class="btn-group-container" style="margin: 20px auto">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="product_category" value="SSC" id="group1" autocomplete="off" onchange="" checked>
                        <label class="btn btn-outline-primary first-btn-group-element" for="group1" style="min-width: 150px;" >Tracking</label>
                        <input type="radio" class="btn-check" name="product_category" value="BSC" id="group2" autocomplete="off" onchange="">
                        <label class="btn btn-outline-primary" for="group2" style="min-width: 150px;">Historie</label>

                        <input type="radio" class="btn-check" name="product_category" value="Portale" id="group3" autocomplete="off" onchange="">
                        <label class="btn btn-outline-primary last-btn-group-element" for="group3" style="min-width: 150px;">Monatsübersicht</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-12 ">
            <div class="max-main-container">
                <div class="tracking_title">
                    Calls (Gesamt: {{$trackcalls->sum('calls')}})
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; margin: 10px; row-gap: 10px;" >
                    <div style="font-weight: bold;">Queue</div>
                    <div style="text-align: center; font-weight: bold;">Calls</div>
                    <div style="text-align: center; font-weight: bold;">Saves</div>
                    <div style="text-align: center; font-weight: bold;">CR</div>
                    <div>SSC</div>
                    <div>
                        <div style="display: flex; width: min-content; margin: auto;">
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 1, 'updown' => 0])}}" role="button">-</a>
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',1)->first()) {{$trackcalls->where('category',1)->first()->calls}} @else 0   @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 1, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                    <div style="text-align: center"><i class="fas fa-tools"></i></div>
                    <div>BSC</div>
                    <div>
                        <div style="display: flex; width: min-content; margin: auto;">
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 2, 'updown' => 0])}}" role="button">-</a>
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',2)->first()) {{$trackcalls->where('category',2)->first()->calls}} @else 0   @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 2, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                    <div style="text-align: center"><i class="fas fa-tools"></i></div>
                    <div>Portale</div>
                    <div>
                        <div style="display: flex; width: min-content; margin: auto;">
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 3, 'updown' => 0])}}" role="button">-</a>
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',3)->first()) {{$trackcalls->where('category',3)->first()->calls}} @else 0   @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 3, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                    <div style="text-align: center"><i class="fas fa-tools"></i></div>
                    <div>Sonstige</div>
                    <div>
                        <div style="display: flex; width: min-content; margin: auto;">
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 4, 'updown' => 0])}}" role="button">-</a>
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',4)->first()) {{$trackcalls->where('category',4)->first()->calls}} @else 0   @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 4, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                    <div style="text-align: center"><i class="fas fa-tools"></i></div>
                </div>
            </div>
            <div class="max-main-container" style="margin-top: 40px">
                <div class="tracking_title">
                    Sonstige KPI
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; margin: 10px; row-gap: 10px;" >
                    <div style="font-weight: bold;">Bezeichnung</div>
                    <div style="text-align: center; font-weight: bold;">Wert</div>
                    <div>RLZ+24 Anteil</div>
                    <div style="text-align: center"><i class="fas fa-tools"></i></div>
                    <div>OptIn Quote</div>
                    <div style="text-align: center"><i class="fas fa-tools"></i></div>
                </div>
            </div>
        </div>
        <!-- START ORDERS -->
          <div class="col-xl-6 col-lg-12">
            <form class="" action="{{route('mobile.tracking.agents.post')}}" method="post">
              @csrf
                <div class="max-main-container">
                    <div class="tracking_title">
                        Saves
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Vertragsnummer</div>
                        <input type="text" class="form-control" name="contract_number" style="max-width: 300px; margin: 0 auto;" onchange="tracking_input()" onkeyup="tracking_input()">
                        <div class="tracking_errormessage" id="contract_number_errormessage" style="display: none;">
                            <div style="margin: auto; padding: 0 5px;"><i class="far fa-times-circle"></i></div>
                            <div >Fehlerhafter Wert: Bitte trage eine gültige Vertragsnummer ohne Buchstaben, Leer- oder Sonderzeichen ein.</div>
                        </div>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Produktgruppe</div>
                        <div class="btn-group-container">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="product_category" value="SSC" id="product_category1" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary first-btn-group-element" for="product_category1">SSC</label>
                                <input type="radio" class="btn-check" name="product_category" value="BSC" id="product_category2" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary" for="product_category2">BSC</label>

                                <input type="radio" class="btn-check" name="product_category" value="Portale" id="product_category3" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="product_category3">Portal</label>
                            </div>
                        </div>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Bearbeitung</div>
                        <div class="btn-group-container">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="event_category" value="Save" id="event_category1" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary first-btn-group-element" for="event_category1">Save</label>

                                <input type="radio" class="btn-check" name="event_category" value="Cancel" id="event_category2" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary" for="event_category2">Cancel</label>

                                <input type="radio" class="btn-check" name="event_category" value="Service" id="event_category3" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary" for="event_category3">Service</label>

                                <input type="radio" class="btn-check" name="event_category" value="KüRü" id="event_category4" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary" for="event_category4">KüRü</label>

                                <input type="radio" class="btn-check" name="event_category" value="NaBu" id="event_category5" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="event_category5">NaBu</label>
                            </div>
                        </div>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Zieltarif</div>
                        <input type="text" class="form-control" name="target_tariff" style="max-width: 600px; margin: 0 auto;" onchange="tracking_input()" onkeyup="tracking_input()" disabled>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">OptIn gesetzt</div>
                        <div class="btn-group-container">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="optin" value="1" id="optin1" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary first-btn-group-element" for="optin1">Ja</label>

                                <input type="radio" class="btn-check" name="optin" value="0" id="optin2" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="optin2">Nein</label>
                            </div>
                        </div>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Restlaufzeit+24</div>
                        <div class="btn-group-container">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="runtime" value="1" id="runtime1" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary first-btn-group-element" for="runtime1">Ja</label>

                                <input type="radio" class="btn-check" name="runtime" value="0" id="runtime2" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="runtime2">Nein</label>
                            </div>
                        </div>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">An Nacharbeit</div>
                        <div class="btn-group-container">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="backoffice" value="1" id="backoffice1" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary first-btn-group-element" for="backoffice1">Ja</label>

                                <input type="radio" class="btn-check" name="backoffice" value="0" id="backoffice2" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="backoffice2">Nein</label>
                            </div>
                        </div>
                    </div>
                    <div class="tracking_container" style="display: flex;">
                        <input type="submit" value="Speichern" class="btn btn-primary" style="margin: 0 auto; min-width: 150px;" id="submit_tracking" disabled>
                    </div>
                </div>
              </div>
            </form>
        </div>
    </div>
    <!-- END ORDERS -->
    <!-- <div class="row">

        <div class="col-md-12">
            <div class="max-main-container">
                <div class="tracking_title">
                    Monatsübersicht
                </div>
                <div style="display: flex; margin: 10px; column-gap: 100px; row-gap: 20px; flex-wrap: wrap; justify-content: space-around;">
                    <div id="month_saves">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; row-gap: 10px; text-align: center; column-gap:10px;" >
                            <div style="text-align: left; font-weight: bold;">Queue</div>
                            <div style="font-weight: bold;">Calls</div>
                            <div style="font-weight: bold;">Saves</div>
                            <div style="font-weight: bold;">CR</div>
                            <div style="text-align: left;">SSC</div>
                            <div>{Wert}</div>
                            <div>{Wert}</div>
                            <div>{Wert}%</div>
                            <div style="text-align: left;">BSC</div>
                            <div>{Wert}</div>
                            <div>{Wert}</div>
                            <div>{Wert}%</div>
                            <div style="text-align: left;">Portale</div>
                            <div>{Wert}</div>
                            <div>{Wert}</div>
                            <div>{Wert}%</div>
                        </div>
                    </div>
                    <div id="month_carecoins">
                        <div style="display: grid; grid-template-columns: 1fr 1fr ; row-gap: 10px; text-align: center;" >
                            <div style="text-align: left; font-weight: bold;"></div>
                            <div style="font-weight: bold;">CareCoins</div>
                            <div style="text-align: left;">Soll</div>
                            <div>{Wert}</div>
                            <div style="text-align: left;">Ist</div>
                            <div>{Wert}</div>
                            <div style="text-align: left;">Differenz</div>
                            <div>{Wert}</div>
                        </div>
                    </div>
                    <div id="provision_goals" style="white-space: nowrap;">
                        <div style="text-align: center; font-weight: bold;">
                            Provisionsziele
                        </div>
                        <div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 1: CareCoin Ist >= CareCoin Soll
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 2: OptIn Quote >= 15,0%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 3: SSC CR >= 50,0%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 4: BSC CR >= 17,0%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 5: Portale CR >= 64,0%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 6: Ziel 1 + SSC CR >= 60,0%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 7: Ziel 1 + BSC CR >= 25,0%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Ziel 8: Ziel 1 + Portale CR >= 80,0%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="provision_value">
                        <div style="text-align: center; font-weight: bold;">
                            Geschätzte Provision
                        </div>
                        <div class="tracking_description">
                            Berücksichtigt werden die im Tool hinterlegten Werte des laufenden Monats und nicht die tatsächlich bestätigten Geschäftsvorfälle.
                        </div>
                        <div style="text-align: center; font-size: 2em;">
                            100.000,00€
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> -->
    <div class="row">
        <!-- END ORDERS -->
        <!-- START HISTORY -->
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="tracking_title">
                    Historie
                </div>
                <div style="margin: 10px 2px 10px 10px; overflow: scroll;">
                    <table class="tracking-table">
                        <thead>
                            <th>Erstellt</th>
                            <th>Vertragsnummer</th>
                            <th>Produktgruppe</th>
                            <th>Bearbeitung</th>
                            <th>Zieltarif</th>
                            <th>OptIn</th>
                            <th>RLZ+24</th>
                            <th>Nacharbeit</th>
                        </thead>
                        <tbody>
                        @foreach($history as $record)
                        <tr>
                            <td>{{$record->created_at}}</td>
                            <td>{{$record->contract_number}}</td>
                            <td>{{$record->product_category}}</td>
                            <td>{{$record->event_category}}</td>
                            <td>{{$record->target_tariff}}</td>
                            <td>@if($record->optin == 1) Ja @else Nein @endif</td>
                            <td>@if($record->runtime == 1) Ja @else Nein @endif</td>
                            <td>@if($record->backoffice == 1) Ja @else Nein @endif</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END HISTORY -->
    </div>
    <!-- END TRACKING -->
</div>
@endsection

@section('additional_js')
<!-- <script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>b
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> -->


<script>

function tracking_input(){
    var contract_field = document.querySelector('input[name="contract_number"]').value;
    var product_category_field = document.querySelector('input[name="product_category"]:checked')?.value;
    var event_category_field = document.querySelector('input[name="event_category"]:checked')?.value;
    var target_tariff_field = document.querySelector('input[name="target_tariff"]').value;
    var optin = document.querySelector('input[name="optin"]:checked')?.value;
    var runtime = document.querySelector('input[name="runtime"]:checked')?.value;
    var backoffice = document.querySelector('input[name="backoffice"]:checked')?.value;



    if(event_category_field == 'Save'){
        document.querySelector('input[name="target_tariff"]').disabled = false;
    } else {
        document.querySelector('input[name="target_tariff"]').value = '';
        document.querySelector('input[name="target_tariff"]').disabled = true;
    }

    var error_counter = 0;



    if(contract_field == ''){
        document.getElementById('contract_number_errormessage').style.display = 'none';
        error_counter += 1;
    } else if (Math.floor(contract_field) == contract_field) {
        document.getElementById('contract_number_errormessage').style.display = 'none';
    } else {
        document.getElementById('contract_number_errormessage').style.display = 'flex';
        error_counter += 1;
    }

    if(product_category_field == undefined){
        error_counter += 1;
    }

    if(event_category_field == undefined){
        error_counter += 1;
    } else if (event_category_field == 'Save'){
        if (target_tariff_field == ''){
            error_counter += 1;
        }
    }

    if(optin == undefined){
        error_counter += 1;
    }

    if(runtime == undefined){
        error_counter += 1;
    }

    if(backoffice == undefined){
        error_counter += 1;
    }

    if(error_counter == 0){
        document.getElementById('submit_tracking').disabled = false;
    } else {
        document.getElementById('submit_tracking').disabled = true;
    }

}


</script>




@endsection
