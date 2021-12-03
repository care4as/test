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
    <!-- START KPI
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                KPI
            </div>
        </div>
    </div>
     END KPI-->

    <!-- START TRACKING -->
    <div class="row">
      <div class="col-lg-6 col-sm-12">
              <div class="max-main-container">
                  <div class="tracking_title">
                      Calls {{$trackcalls->sum('calls')}}
                  </div>
                  <div class="tracking_container">
                      <div>SSC: @if($trackcalls->where('category',1)->first()) {{$trackcalls->where('category',1)->first()->calls}} @else 0   @endif</div>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 1, 'updown' => 0])}}" role="button">-</a>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 1, 'updown' => 1])}}" role="button">+</a>
                  </div>
                  <div class="tracking_container">
                      <div>BSC: @if($trackcalls->where('category',2)->first()) {{$trackcalls->where('category',2)->first()->calls}} @else 0   @endif</div>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 2, 'updown' => 0])}}" role="button">-</a>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 2, 'updown' => 1])}}" role="button">+</a>
                  </div>
                  <div class="tracking_container">
                      <div>Portale: @if($trackcalls->where('category',3)->first()) {{$trackcalls->where('category',3)->first()->calls}} @else 0   @endif</div>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 3, 'updown' => 0])}}" role="button">-</a>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 3, 'updown' => 1])}}" role="button">+</a>
                  </div>
                  <div class="tracking_container">
                      <div>Sonstige: @if($trackcalls->where('category',4)->first()) {{$trackcalls->where('category',4)->first()->calls}} @else 0   @endif</div>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 4, 'updown' => 0])}}" role="button">-</a>
                      <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 4, 'updown' => 1])}}" role="button">+</a>
                  </div>
              </div>
      </div>
        <!-- START ORDERS -->
          <div class="col-lg-6 col-sm-12">
            <form class="" action="{{route('mobile.tracking.agents.post')}}" method="post">
              @csrf
                <div class="max-main-container">
                    <div class="tracking_title">
                        Saves
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Vertragsnummer</div>
                        <input type="text" class="form-control" name="contract_number" style="max-width: 300px; margin: 0 auto;" onchange="tracking_input()">
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
                                <label class="btn btn-outline-primary last-btn-group-element" for="event_category4">KüRü</label>
                            </div>
                        </div>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Zieltarif</div>
                        <input type="text" class="form-control" name="target_tariff" style="max-width: 600px; margin: 0 auto;" onchange="tracking_input()" disabled>
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
        <!-- END ORDERS -->
        <!-- START HISTORY -->
        <div class="col-sm-12">
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

    console.log(contract_field);
    console.log(product_category_field)
    console.log(event_category_field)
    console.log(target_tariff_field)
    console.log(optin)
    console.log(runtime)
    console.log(backoffice)

    if(event_category_field == 'Save'){
        document.querySelector('input[name="target_tariff"]').disabled = false;
    } else {
        document.querySelector('input[name="target_tariff"]').value = '';
        document.querySelector('input[name="target_tariff"]').disabled = true;
    }

    var error_counter = 0;

    if(contract_field == ''){
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








    console.log(error_counter);



}


</script>




@endsection
