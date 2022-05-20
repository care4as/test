@extends('general_layout')
@section('pagetitle')
Tracking mit Vertragsnummer
@endsection

@php
function roundUp($calls,$quotient)
{
  if($calls == 0)
  {
    $quota = 0;
  }
  else
  {
    $quota = round($quotient*100/$calls, 2);
  }

  return $quota;
}
@endphp

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
        /* border: 1px solid #f96332; */
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

    @if(Auth::user()->name == 's.reimer')
    <!-- Line Situation -->
    <div class="row">
        <div class="col-sm-12">
            <div class="max-main-container">
                <div style="margin: 10px">
                    <div>Administrator Einstellungen</div>
                    @if(rand(1,10) >= 8)
                      <div style="font-size: medium;">Line Situation: Gute Line</div>
                    @else
                      <div style="font-size: medium;">Line Situation: Schlechte Line</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- START TRACKING -->
    <div class="row">
      <div class="col-sm-12">
        <div class="max-main-container">
          <div class="btn-group-container" style="margin: 20px auto">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
              <input type="radio" class="btn-check" name="show_container" value="show_tracking_container" id="show_tracking_container" autocomplete="off" onchange="updateShowContainer()" checked>
              <label class="btn btn-outline-primary first-btn-group-element" for="show_tracking_container" style="min-width: 150px;" >Tracking</label>
              <input type="radio" class="btn-check" name="show_container" value="show_history_container" id="show_history_container" autocomplete="off" onchange="updateShowContainer()">
              <label class="btn btn-outline-primary" for="show_history_container" style="min-width: 150px;">Historie</label>
              <input type="radio" class="btn-check" name="show_container" value="show_week_container" id="show_week_container" autocomplete="off" onchange="updateShowContainer()">
              <label class="btn btn-outline-primary" for="show_week_container" style="min-width: 150px;">Wochenübersicht</label>
              <input type="radio" class="btn-check" name="show_container" value="show_month_container" id="show_month_container" autocomplete="off" onchange="updateShowContainer()">
              <label class="btn btn-outline-primary last-btn-group-element" for="show_month_container" style="min-width: 150px;">Monatsübersicht</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" id="tracking_container">
        <div class="col-xl-6 col-lg-12">
            <div class="max-main-container">
                <div class="tracking_title">
                    Calls (Gesamt: {{$allCallsD = $trackcalls->sum('calls')}})
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
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if( $trackcalls->where('category',1)->first()) {{ $sscCalls = $trackcalls->where('category',1)->first()->calls}} @else {{$sscCalls = 0 }}  @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 1, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                    <div style="text-align: center">{{$sscSaves = $history->where('product_category','SSC')->where('event_category', 'Save')->count()}}</div>
                    <div style="text-align: center">{{roundUp($sscCalls,$sscSaves)}}%</div>
                    <div>BSC</div>
                    <div>
                        <div style="display: flex; width: min-content; margin: auto;">
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 2, 'updown' => 0])}}" role="button">-</a>
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',2)->first()) {{$bscCalls = $trackcalls->where('category',2)->first()->calls}} @else {{$bscCalls = 0 }}  @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 2, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                    <div style="text-align: center">{{$bscSaves = $history->where('product_category','BSC')->where('event_category', 'Save')->count()}}</div>
                    <div style="text-align: center">{{roundUp($bscCalls,$bscSaves)}}%</div>
                    <div>Portale</div>
                    <div>
                        <div style="display: flex; width: min-content; margin: auto;">
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 3, 'updown' => 0])}}" role="button">-</a>
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',3)->first()) {{$portaleCalls = $trackcalls->where('category',3)->first()->calls}} @else {{$portaleCalls = 0 }}  @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 3, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                    <div style="text-align: center">{{$portaleSaves = $history->where('product_category','Portale')->where('event_category', 'Save')->count()}}</div>
                    <div style="text-align: center">{{roundUp($portaleCalls,$portaleSaves)}}%</div>
                    <div>Sonstige</div>
                    <div>
                        <div style="display: flex; width: min-content; margin: auto;">
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 4, 'updown' => 0])}}" role="button">-</a>
                            <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',4)->first()) {{$trackcalls->where('category',4)->first()->calls}} @else 0   @endif</div>
                            <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 4, 'updown' => 1])}}" role="button">+</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-main-container" style="margin-top: 40px">
                <div class="tracking_title">
                    Zielerreichung
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; margin: 10px; row-gap: 10px;" >
                    <div style="font-weight: bold;">Bezeichnung</div>
                    <div style="text-align: center; font-weight: bold;">Wert</div>
                    <div>Saves Heute</div>
                    <div style="text-align: center">
                        @if($userdata->soll_h_day == 8) {{$history->whereIn('product_category',["SSC", "BSC", "Portale"])->where('event_category', 'Save')->count()}} / {{$value = ceil((31.25 * 40) / 100)}}
                        @elseif($userdata->soll_h_day == 7) {{$history->whereIn('product_category',["SSC", "BSC", "Portale"])->where('event_category', 'Save')->count()}} / {{$value = ceil((31.25 * 35) / 100)}}
                        @elseif($userdata->soll_h_day == 6) {{$history->whereIn('product_category',["SSC", "BSC", "Portale"])->where('event_category', 'Save')->count()}} / {{$value = ceil((31.25 * 30) / 100)}}
                        @elseif($userdata->soll_h_day == 5) {{$history->whereIn('product_category',["SSC", "BSC", "Portale"])->where('event_category', 'Save')->count()}} / {{$value = ceil((31.25 * 25) / 100)}}
                        @elseif($userdata->soll_h_day == 4) {{$history->whereIn('product_category',["SSC", "BSC", "Portale"])->where('event_category', 'Save')->count()}} / {{$value = ceil((31.25 * 20) / 100)}}
                        @elseif($userdata->soll_h_day == 3) {{$history->whereIn('product_category',["SSC", "BSC", "Portale"])->where('event_category', 'Save')->count()}} / {{$value = ceil((31.25 * 15) / 100)}}
                        @else Fehler Sollstunden KDW
                        @endif
                    </div>
                    <div>Saves Woche (fortlaufend)</div>
                    <div style="text-align: center">
                    @if(date('w') <= 5)
                        @if($userdata->soll_h_day == 8) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (40 - $userVacation)) / 100) * date('w'))}}
                        @elseif($userdata->soll_h_day == 7) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (35 - $userVacation)) / 100) * date('w'))}}
                        @elseif($userdata->soll_h_day == 6) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (30 - $userVacation)) / 100) * date('w'))}}
                        @elseif($userdata->soll_h_day == 5) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (25 - $userVacation)) / 100) * date('w'))}}
                        @elseif($userdata->soll_h_day == 4) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (20 - $userVacation)) / 100) * date('w'))}}
                        @elseif($userdata->soll_h_day == 3) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (15 - $userVacation)) / 100) * date('w'))}}
                        @else Fehler Sollstunden KDW
                        @endif
                    @else
                        @if($userdata->soll_h_day == 8) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (40 - $userVacation)) / 100) * 5)}}
                        @elseif($userdata->soll_h_day == 7) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (35 - $userVacation)) / 100) * 5)}}
                        @elseif($userdata->soll_h_day == 6) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (30 - $userVacation)) / 100) * 5)}}
                        @elseif($userdata->soll_h_day == 5) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (25 - $userVacation)) / 100) * 5)}}
                        @elseif($userdata->soll_h_day == 4) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (20 - $userVacation)) / 100) * 5)}}
                        @elseif($userdata->soll_h_day == 3) {{$weekSP->whereIn("product_category",["SSC", "BSC", "Portale"])->where("event_category","Save")->count()}} / {{$value = ceil(((31.25 * (15 - $userVacation)) / 100) * 5)}}
                        @else Fehler Sollstunden KDW
                        @endif
                    @endif
                    </div>
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
                    <div style="text-align: center">{{roundUP(($allSavesD = $sscSaves + $bscSaves + $portaleSaves),$rlzP = $history->where('event_category','Save')->where('runtime', 1)->count())}}%</div>
                    <div>OptIn Quote</div>
                    <div style="text-align: center">{{roundUp($allCallsD,$history->where('optin',1)->count())}}%</div>
                </div>
            </div>    
        </div>
        <!-- START ORDERS -->
            <div class="col-xl-6 col-lg-12">
                <form class="" action="{{route('mobile.tracking.agents.post')}}" method="post">
                @csrf
                    <div class="max-main-container">
                        <div class="tracking_title">
                            Save eintragen
                        </div>
                        <div class="tracking_container">
                            <div class="tracking_description">Vertragsnummer</div>
                            <input type="text" class="form-control" id="contract_number" name="contract_number" style="max-width: 300px; margin: 0 auto;" onchange="tracking_input()" onkeyup="tracking_input()">
                            <div>
                                <div class="tracking_errormessage collapse" id="contract_number_errormessage">
                                    <div style="margin: auto; padding: 0 5px;"><i class="far fa-times-circle"></i><small>Bitte trage eine gültige Vertragsnummer ohne Buchstaben, Leer- oder Sonderzeichen ein</small></div>
                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="product_category_container">
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
                        </div>

                        <div class="collapse" id="tracking_description_container">
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
                        </div>
                        
                        <div class="collapse" id="al_group_container">
                            <div class="tracking_container">
                                <div class="tracking_description">Angebotsleiter</div>
                                <div class="btn-group-container">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="al_group" value="0" id="al_group0" autocomplete="off" onchange="tracking_input()">
                                        <label class="btn btn-outline-primary first-btn-group-element" for="al_group0">Keine</label>

                                        <input type="radio" class="btn-check" name="al_group" value="1" id="al_group1" autocomplete="off" onchange="tracking_input()">
                                        <label class="btn btn-outline-primary" for="al_group1">1</label>

                                        <input type="radio" class="btn-check" name="al_group" value="2" id="al_group2" autocomplete="off" onchange="tracking_input()">
                                        <label class="btn btn-outline-primary" for="al_group2">2</label>

                                        <input type="radio" class="btn-check" name="al_group" value="3" id="al_group3" autocomplete="off" onchange="tracking_input()">
                                        <label class="btn btn-outline-primary" for="al_group3">3</label>

                                        <input type="radio" class="btn-check" name="al_group" value="4" id="al_group4" autocomplete="off" onchange="tracking_input()">
                                        <label class="btn btn-outline-primary" for="al_group4">4</label>

                                        <input type="radio" class="btn-check" name="al_group" value="5" id="al_group5" autocomplete="off" onchange="tracking_input()">
                                        <label class="btn btn-outline-primary last-btn-group-element" for="al_group5">5</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="collapse" id="target_tariff_container">
                            <div class="tracking_container">
                                <div class="tracking_description">Zieltarif</div>
                                <input type="text" class="form-control" name="target_tariff" style="max-width: 600px; margin: 0 auto;" onchange="tracking_input()" onkeyup="tracking_input()">
                            </div>
                        </div>

                        <div class="collapse" id="comment_container">
                            <div class="tracking_container">
                                <div class="tracking_description">Kommentar (optional)</div>
                                <input type="text" class="form-control" name="comment" style="max-width: 600px; margin: 0 auto;" onchange="tracking_input()" onkeyup="tracking_input()">
                            </div>
                        </div>
                        
                        <div class="collapse" id="optin_container">
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
                        </div>
                        
                        <div class="collapse" id="rlz_container">
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
                        </div>

                        <div class="collapse" id="bo_container">
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
    <!-- WEEK CONTAINER -->
    <div class="row" id="week_container" style="display: none;">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="tracking_title">
                    Wochenübersicht
                </div>
                <div style="display: flex; margin: 10px; row-gap: 20px; flex-wrap: wrap; justify-content: space-around;">
                    <div id="week_saves">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; row-gap: 10px; text-align: center; column-gap:10px;" >
                            <div style="text-align: left; font-weight: bold;">Queue</div>
                            <div style="font-weight: bold;">Calls</div>
                            <div style="font-weight: bold;">Saves</div>
                            <div style="font-weight: bold;">CR</div>
                            <div style="text-align: left;">SSC</div>
                            <div id="sscCalls">{{$sscCallsW = $trackcallsW->where('category',1)->sum('calls')}}</div>
                            <div id="sscSaves">{{$sscSavesW = $weekSP->where("product_category","SSC")->where("event_category","Save")->count()}}</div>
                            <div style="display:flex">
                                <div id="sscCr">{{roundUp($sscCallsW,$sscSavesW)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;">BSC</div>
                            <div id="bscCalls">{{$bscCallsW = $trackcallsW->where('category',2)->sum('calls')}}</div>
                            <div id="bscSaves">{{$bscSavesW = $weekSP->where("product_category","BSC")->where("event_category","Save")->count()}}</div>
                            <div style="display:flex">
                                <div id="bscCr">{{roundUp($bscCallsW,$bscSavesW)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;">Portale</div>
                            <div id="portaleCalls">{{$portalCallsW = $trackcallsW->where('category',3)->sum('calls')}}</div>
                            <div id="portaleSaves">{{$portaleSavesW = $weekSP->where("product_category","Portale")->where("event_category","Save")->count()}}</div>
                            <div style="display:flex">
                                <div id="portaleCr">{{roundUp($portalCallsW,$portaleSavesW)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;">OptIn</div>
                            <div id="optinCalls">{{$optinCallsW = $trackcallsW->where('category','!=',4)->sum('calls')}}</div>
                            <div id="optinSaves">{{$optinW = $weekSP->where('optin',1)->count()}}</div>
                            <div style="display:flex">
                                <div id="optinCr">{{roundUp($optinCallsW,$optinW)}}</div>
                                <div>%</div>
                            </div>
                        </div>
                    </div>
                    @php
                      $AllsavesW = $sscSavesW + $bscSavesW + $portaleSavesW;
                    @endphp
                    <div id="week_carecoins">
                        <div style="display: grid; grid-template-columns: 1fr 1fr ; row-gap: 10px; text-align: center;" >
                            <div style="font-weight: bold; grid-column: 1 / span 2;">CareCoins</div>
                            <div style="text-align: left;">Soll:</div>
                              <div id="careCoinShould">
                                @if($userdata)
                                  @if($userdata->soll_h_day == 8) {{$CCTreshold = ((40 - $userVacation) * 31.25)}}
                                    @elseif($userdata->soll_h_day == 7) {{$CCTreshold = ((35 - $userVacation) * 31.25)}}
                                    @elseif($userdata->soll_h_day == 6) {{$CCTreshold = ((30 - $userVacation) * 31.25)}}
                                    @elseif($userdata->soll_h_day == 5) {{$CCTreshold = ((25 - $userVacation) * 31.25)}}
                                    @elseif($userdata->soll_h_day == 4) {{$CCTreshold = ((20 - $userVacation) * 31.25)}}
                                    @elseif($userdata->soll_h_day == 3) {{$CCTreshold = ((15 - $userVacation) * 31.25)}}
                                    @else Fehler Sollstunden KDW {{$CCTreshold = 0}}
                                  @endif
                                @else
                                  keine Userdaten
                                  {{$CCTreshold = 0}}
                                @endif</div>
                            <div  style="text-align: left;">Ist:</div>
                            <div id="careCoinIs">{{$CCState = $AllsavesW * 20}}</div>
                            <div style="text-align: left;">Differenz:</div>
                            <div id="careCoinDifference">{{$CCState - $CCTreshold}} </div>
                            <div style="text-align: left;">Saves zum Wochenziel:</div>
                            <div>{{floor(($CCState - $CCTreshold) / 20)}} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="tracking_title">
                    Provisionsschätzer
                </div>
                <div style="display: grid; margin: 10px; grid-template-columns: auto 1fr; gap: 10px;">
                    <div id="provision_goals" style="white-space: nowrap;">
                        <div style="text-align: center; font-weight: bold;">
                            Ziele
                        </div>
                        <div>
                            <div class="form-check">
                                <abbr title="SSC Save: +1,25€&#013;BSC Save: +1,25€&#013;Portale Save: +1,25€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment1" onchange="calcProvision()">
                                    Ziel 1: CareCoin Ist >= CareCoin Soll
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="SSC Save: +0,50€&#013;BSC Save: +0,50€&#013;Portale Save: +0,50€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment2" onchange="calcProvision()">
                                    Ziel 2: OptIn Quote >= 13,50%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="SSC Save: +1,25€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment3" onchange="calcProvision()">
                                    Ziel 3: SSC CR >= 51,50%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="BSC Save: +0,75€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment4" onchange="calcProvision()">
                                    Ziel 4: BSC CR >= 18,50%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="Portale Save: +0,75€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment5" onchange="calcProvision()">
                                    Ziel 5: Portale CR >= 68,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="SSC Save: +2,00€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment6" onchange="calcProvision()">
                                    Ziel 6: Ziel 1 + SSC CR >= 60,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="BSC Save: +2,50€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment7" onchange="calcProvision()">
                                    Ziel 7: Ziel 1 + BSC CR >= 25,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="Portale Save: +2,50€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment8" onchange="calcProvision()">
                                    Ziel 8: Ziel 1 + Portale CR >= 80,00%
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
                            Berücksichtigt werden die im Tool hinterlegten Werte der laufenden Woche und nicht die tatsächlich bestätigten Geschäftsvorfälle.
                        </div>
                        <div id="provisionSum" style="text-align: center; font-size: 2em; margin-top: 30px; margin-bottom:30px;">
                            0,00€
                        </div>
                        <div style="width:max-content;margin:auto;">
                            <div style="text-align: center">Vergütung je Save</div>
                            <div style="display: flex">
                                <div style="display:flex; margin:0 20px">
                                    <div>SSC:</div>
                                    <div style="margin-left:5px" id="sscSaveValue">0,00 €</div>
                                </div>
                                <div style="display:flex; margin:0 20px">
                                    <div>BSC:</div>
                                    <div style="margin-left:5px" id="bscSaveValue">0,00 €</div>
                                </div>
                                <div style="display:flex; margin:0 20px">
                                    <div>Portale:</div>
                                    <div style="margin-left:5px" id="portaleSaveValue">0,00 €</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WEEK CONTAINER -->
    <!-- MONTH CONTAINER -->
    <div class="row" id="month_container" style="display: none;">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="tracking_title">
                    Monatsübersicht
                </div>
                <div style="display: flex; margin: 10px; row-gap: 20px; flex-wrap: wrap; justify-content: space-around;">
                    <div id="month_saves">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; row-gap: 10px; text-align: center; column-gap:10px;" >
                            <div style="text-align: left; font-weight: bold;">Queue</div>
                            <div style="font-weight: bold;">Calls</div>
                            <div style="font-weight: bold;">Saves</div>
                            <div style="font-weight: bold;">CR</div>
                            <div style="text-align: left;">SSC</div>
                            <div id="sscCallsM">{{$sscCallsM = $trackcallsM->where('category',1)->sum('calls')}}</div>
                            <div id="sscSavesM">{{$sscSavesM = $monthSP->where("product_category","SSC")->where("event_category","Save")->count()}}</div>
                            <div style="display:flex">
                                <div id="sscCrM">{{roundUp($sscCallsM,$sscSavesM)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;">BSC</div>
                            <div id="bscCallsM">{{$bscCallsM = $trackcallsM->where('category',2)->sum('calls')}}</div>
                            <div id="bscSavesM">{{$bscSavesM = $monthSP->where("product_category","BSC")->where("event_category","Save")->count()}}</div>
                            <div style="display:flex">
                                <div id="bscCrM">{{roundUp($bscCallsM,$bscSavesM)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;">Portale</div>
                            <div id="portaleCallsM">{{$portalCallsM = $trackcallsM->where('category',3)->sum('calls')}}</div>
                            <div id="portaleSavesM">{{$portaleSavesM = $monthSP->where("product_category","Portale")->where("event_category","Save")->count()}}</div>
                            <div style="display:flex">
                                <div id="portaleCrM">{{roundUp($portalCallsM,$portaleSavesM)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;">OptIn</div>
                            <div id="optinCallsM">{{$optinCallsM = $trackcallsM->where('category','!=',4)->sum('calls')}}</div>
                            <div id="optinSavesM">{{$optinM = $monthSP->where('optin',1)->count()}}</div>
                            <div style="display:flex">
                                <div id="optinCrM">{{roundUp($optinCallsM,$optinM)}}</div>
                                <div>%</div>
                            </div>
                        </div>
                    </div>
                    @php
                      $AllsavesM = $sscSavesM + $bscSavesM + $portaleSavesM;
                    @endphp
                    <div id="month_carecoins">
                        <div style="display: grid; grid-template-columns: 1fr 1fr ; row-gap: 10px; text-align: center;" >
                            <div style="font-weight: bold; grid-column: 1 / span 2;">CareCoins</div>
                            <div style="text-align: left;">Soll:</div>
                              <div id="careCoinShouldM">
                                @if($userdata)
                                    @if($userdata->soll_h_day == 8) {{$CCTresholdM = 5000 -($userVacationM*28.5)}}
                                    @elseif($userdata->soll_h_day == 7) {{$CCTresholdM = 4375 -($userVacationM*28.5)}}
                                    @elseif($userdata->soll_h_day == 6) {{$CCTresholdM = 3750 -($userVacationM*28.5)}}
                                    @elseif($userdata->soll_h_day == 5) {{$CCTresholdM = 3125 -($userVacationM*28.5)}}
                                    @elseif($userdata->soll_h_day == 4) {{$CCTresholdM = 2500 -($userVacationM*28.5)}}
                                    @elseif($userdata->soll_h_day == 3) {{$CCTresholdM = 1875 -($userVacationM*28.5)}}
                                    @else Fehler Sollstunden KDW {{$CCTresholdM = 0}}
                                  @endif
                                @else
                                  keine Userdaten
                                  {{$CCTresholdM = 0}}
                                @endif</div>
                            <div  style="text-align: left;">Ist:</div>
                            <div id="careCoinIsM">{{$CCStateM = $AllsavesM * 20}}</div>
                            <div style="text-align: left;">Differenz:</div>
                            <div id="careCoinDifferenceM">{{$CCStateM - $CCTresholdM}} </div>
                            <div style="text-align: left;">Saves zum Monatsziel:</div>
                            <div>{{floor(($CCStateM - $CCTresholdM) / 20)}} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="tracking_title">
                    Provisionsschätzer
                </div>
                <div style="display: grid; margin: 10px; grid-template-columns: auto 1fr; gap: 10px;">
                    <div id="provision_goalsM" style="white-space: nowrap;">
                        <div style="text-align: center; font-weight: bold;">
                            Ziele
                        </div>
                        <div>
                            <div class="form-check">
                                <abbr title="SSC Save: +1,25€&#013;BSC Save: +1,25€&#013;Portale Save: +1,25€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment1M" onchange="calcProvisionM()">
                                    Ziel 1: CareCoin Ist >= CareCoin Soll
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="SSC Save: +0,50€&#013;BSC Save: +0,50€&#013;Portale Save: +0,50€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment2M" onchange="calcProvisionM()">
                                    Ziel 2: OptIn Quote >= 13,50%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="SSC Save: +1,25€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment3M" onchange="calcProvisionM()">
                                    Ziel 3: SSC CR >= 51,50%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="BSC Save: +0,75€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment4M" onchange="calcProvisionM()">
                                    Ziel 4: BSC CR >= 18,50%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="Portale Save: +0,75€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment5M" onchange="calcProvisionM()">
                                    Ziel 5: Portale CR >= 68,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="SSC Save: +2,00€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment6M" onchange="calcProvisionM()">
                                    Ziel 6: Ziel 1 + SSC CR >= 60,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="BSC Save: +2,50€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment7M" onchange="calcProvisionM()">
                                    Ziel 7: Ziel 1 + BSC CR >= 25,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="Portale Save: +2,50€" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment8M" onchange="calcProvisionM()">
                                    Ziel 8: Ziel 1 + Portale CR >= 80,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="provision_valueM">
                        <div style="text-align: center; font-weight: bold;">
                            Geschätzte Provision
                        </div>
                        <div class="tracking_description">
                            Berücksichtigt werden die im Tool hinterlegten Werte des laufenden Monats und nicht die tatsächlich bestätigten Geschäftsvorfälle.
                        </div>
                        <div id="provisionSumM" style="text-align: center; font-size: 2em; margin-top: 30px; margin-bottom:30px;">
                            0,00€
                        </div>
                        <div style="width:max-content;margin:auto;">
                            <div style="text-align: center">Vergütung je Save</div>
                            <div style="display: flex">
                                <div style="display:flex; margin:0 20px">
                                    <div>SSC:</div>
                                    <div style="margin-left:5px" id="sscSaveValueM">0,00 €</div>
                                </div>
                                <div style="display:flex; margin:0 20px">
                                    <div>BSC:</div>
                                    <div style="margin-left:5px" id="bscSaveValueM">0,00 €</div>
                                </div>
                                <div style="display:flex; margin:0 20px">
                                    <div>Portale:</div>
                                    <div style="margin-left:5px" id="portaleSaveValueM">0,00 €</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MONTH CONTAINER -->
    <div class="row" id="history_container" style="display: none">
        <!-- END ORDERS -->
        <!-- START HISTORY -->
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="tracking_title">
                  Historie
                </div>
                <div style="margin: 10px 2px 10px 10px; overflow: scroll;">
                    <table class="tracking-table" id="historyNews">
                        <thead>
                          <th>Erstellt</th>
                          <th>Vertragsnummer</th>
                          <th>Produktgruppe</th>
                          <th>Bearbeitung</th>
                          <th>Zieltarif</th>
                          <th>OptIn</th>
                          <th>RLZ+24</th>
                          <th>Nacharbeit</th>
                          <th>Kommentar</th>
                        </thead>
                        <tbody>
                        @foreach($history2 as $record)
                        <tr>
                          <td>{{$record->created_at}}</td>
                          <td>{{$record->contract_number}}</td>
                          <td>{{$record->product_category}}</td>
                          <td>{{$record->event_category}}</td>
                          <td>{{$record->target_tariff}}</td>
                          <td>@if($record->optin == 1) Ja @else Nein @endif</td>
                          <td>@if($record->runtime == 1) Ja @else Nein @endif</td>
                          <td>@if($record->backoffice == 1) Ja @else Nein @endif</td>
                          <td>{{$record->comment}} </td>
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
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<!-- <script src='https://cdn.datatables.net/plug-ins/1.10.24/api/sum().js'></script> -->
<!-- <script src='https://cdn.datatables.net/plug-ins/1.10.24/api/average().js'></script> -->
<!-- <script src='https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js'></script> -->
<!-- <script src='https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js'></script> -->
<!-- <script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> -->

<script>

    function tracking_input(){

        // Fehler Counter
        var error_counter = 0;
        let errorDiv = document.getElementById('contract_number_errormessage')
        let contractnumber = $("#contract_number");

        // Vertragsnummer
        var contract_field = document.querySelector('input[name="contract_number"]').value;
        if(contract_field == ''){
            contractnumber.css("border","1px solid #f96332")
            error_counter += 1;
            $('#product_category_container').collapse("hide");
            $('#contract_number_errormessage').collapse("hide");
            $('input[name="product_category"]').prop("checked", false);
        } else if (Math.floor(contract_field) == contract_field) {
          contractnumber.css("border","1px solid #f96332")
            $('#product_category_container').collapse("show");
            $('#contract_number_errormessage').collapse("hide");
        } else {
            contractnumber.css("border","1px solid red")
            error_counter += 1;
            $('#product_category_container').collapse("hide");
            $('#contract_number_errormessage').collapse("show");
        }

        // Produktgruppe
        var product_category_field = document.querySelector('input[name="product_category"]:checked')?.value;
        if(product_category_field == undefined){
            error_counter += 1;
            $('#tracking_description_container').collapse("hide");
            $('input[name="event_category"]').prop("checked", false);
        } else {
            $('#tracking_description_container').collapse("show");
        }

        // Bearbeitung
        var event_category_field = document.querySelector('input[name="event_category"]:checked')?.value;
        if(event_category_field == undefined){
            error_counter += 1;
            $('input[name="al_group"]').prop("checked", false);
            document.querySelector('input[name="comment"]').value = '';
            $('#al_group_container').collapse("hide"); 
            $('#target_tariff_container').collapse("hide");
            document.querySelector('input[name="target_tariff"]').value = '';
            $('#comment_container').collapse("hide");
        } else if (event_category_field == 'Save' || event_category_field == 'NaBu'){
            $('#al_group_container').collapse("show");
            $('#comment_container').collapse("hide");
            document.querySelector('input[name="comment"]').value = '';

            // AL Stufe
            var al_group_field = document.querySelector('input[name="al_group"]:checked')?.value;
            if(al_group_field == undefined){
                error_counter += 1;
                $('#target_tariff_container').collapse("hide");
            } else {
                $('#target_tariff_container').collapse("show");
            }

            // Zieltarif
            var target_tariff_field = document.querySelector('input[name="target_tariff"]').value;
            if (target_tariff_field == ''){
                error_counter += 1;
            }

        } else {
            $('#target_tariff_container').collapse("hide");
            document.querySelector('input[name="target_tariff"]').value = '';
            $('input[name="al_group"]').prop("checked", false);
            $('#al_group_container').collapse("hide");
            $('#comment_container').collapse("show");
        }

        // Optin
        if(error_counter == 0){
            $('#optin_container').collapse("show");
        } else {
            $('#optin_container').collapse("hide");
            $('input[name="optin"]').prop("checked", false);
        }

        var optin = document.querySelector('input[name="optin"]:checked')?.value;

        if(optin == undefined){
            error_counter += 1;
        } 

        // RLZ
        if(error_counter == 0){
            $('#rlz_container').collapse("show");
        } else {
            $('#rlz_container').collapse("hide");
            $('input[name="runtime"]').prop("checked", false);
        }

        var runtime = document.querySelector('input[name="runtime"]:checked')?.value;
        if(runtime == undefined){
            error_counter += 1;
        } 

        // Backoffice
        if(error_counter == 0){
            $('#bo_container').collapse("show");
        } else {
            $('#bo_container').collapse("hide");
            $('input[name="backoffice"]').prop("checked", false);
        }

        var backoffice = document.querySelector('input[name="backoffice"]:checked')?.value;
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

<script>
    var trackingContainer = document.getElementById('tracking_container');
    var weekContainer = document.getElementById('week_container');
    var monthContainer = document.getElementById('month_container');
    var historyContainer = document.getElementById('history_container');

    function updateShowContainer(){
        var selectedShowContainer = document.querySelector('input[name="show_container"]:checked')?.value;
        // console.log(selectedShowContainer);

        if(selectedShowContainer == 'show_tracking_container'){
            trackingContainer.style.display = 'flex';
            weekContainer.style.display = 'none';
            historyContainer.style.display = 'none';
            monthContainer.style.display = 'none';
        } else if (selectedShowContainer == 'show_week_container'){
            trackingContainer.style.display = 'none';
            weekContainer.style.display = 'flex';
            historyContainer.style.display = 'none';
            monthContainer.style.display = 'none';
        } else if (selectedShowContainer == 'show_history_container'){
            trackingContainer.style.display = 'none';
            weekContainer.style.display = 'none';
            historyContainer.style.display = 'flex';
            monthContainer.style.display = 'none';
        } else if (selectedShowContainer == 'show_month_container'){
            trackingContainer.style.display = 'none';
            weekContainer.style.display = 'none';
            historyContainer.style.display = 'none';
            monthContainer.style.display = 'flex';
        }
    }

</script>

<script>
    var sscCalls = document.getElementById('sscCalls').innerText
    var sscSaves = document.getElementById('sscSaves').innerText
    var sscCr = document.getElementById('sscCr').innerText
    var bscCalls = document.getElementById('bscCalls').innerText
    var bscSaves = document.getElementById('bscSaves').innerText
    var bscCr = document.getElementById('bscCr').innerText
    var portaleCalls = document.getElementById('portaleCalls').innerText
    var portaleSaves = document.getElementById('portaleSaves').innerText
    var portaleCr = document.getElementById('portaleCr').innerText
    var optinCr = document.getElementById('optinCr').innerText
    var careCoinShould = document.getElementById('careCoinShould').innerText
    var careCoinIs = document.getElementById('careCoinIs').innerText
    var careCoinDifference = document.getElementById('careCoinDifference').innerText

    // Month
    var sscCallsM = document.getElementById('sscCallsM').innerText
    var sscSavesM = document.getElementById('sscSavesM').innerText
    var sscCrM = document.getElementById('sscCrM').innerText
    var bscCallsM = document.getElementById('bscCallsM').innerText
    var bscSavesM = document.getElementById('bscSavesM').innerText
    var bscCrM = document.getElementById('bscCrM').innerText
    var portaleCallsM = document.getElementById('portaleCallsM').innerText
    var portaleSavesM = document.getElementById('portaleSavesM').innerText
    var portaleCrM = document.getElementById('portaleCrM').innerText
    var optinCrM = document.getElementById('optinCrM').innerText
    var careCoinShouldM = document.getElementById('careCoinShouldM').innerText
    var careCoinIsM = document.getElementById('careCoinIsM').innerText
    var careCoinDifferenceM = document.getElementById('careCoinDifferenceM').innerText

    $(document).ready(function() {
        checkAttainment();
        calcProvision();
        checkAttainmentM();
        calcProvisionM();
        $('#historyNews').DataTable({
           "order": [[ 0, "desc" ]]
        })
    });

    function checkAttainment(){
        //Attainment 1
        if(careCoinDifference >= 0){
            document.getElementById('attainment1').checked = true;
        } else {
            document.getElementById('attainment1').checked = false;
        }

        //Attainment 2
        if(optinCr >= 13.5){
            document.getElementById('attainment2').checked = true;
        } else {
            document.getElementById('attainment2').checked = false;
        }

        //Attainment 3
        if(sscCr >= 51.5){
            document.getElementById('attainment3').checked = true;
        } else {
            document.getElementById('attainment3').checked = false;
        }

        //Attainment 4
        if(bscCr >= 18.5){
            document.getElementById('attainment4').checked = true;
        } else {
            document.getElementById('attainment4').checked = false;
        }

        //Attainment 5
        if(portaleCr >= 68){
            document.getElementById('attainment5').checked = true;
        } else {
            document.getElementById('attainment5').checked = false;
        }

        //Attainment 6
        if(careCoinIs >= careCoinShould && sscCr >= 60){
            document.getElementById('attainment6').checked = true;
        } else {
            document.getElementById('attainment6').checked = false;
        }

        //Attainment 7
        if(careCoinIs >= careCoinShould && bscCr >= 25){
            document.getElementById('attainment7').checked = true;
        } else {
            document.getElementById('attainment7').checked = false;
        }

        //Attainment 8
        if(careCoinIs >= careCoinShould && portaleCr >= 80){
            document.getElementById('attainment8').checked = true;
        } else {
            document.getElementById('attainment8').checked = false;
        }
    }
    function checkAttainmentM(){
        //Attainment 1
        if(careCoinDifferenceM >= 0){
            document.getElementById('attainment1M').checked = true;
        } else {
            document.getElementById('attainment1M').checked = false;
        }

        //Attainment 2
        if(optinCrM >= 13.5){
            document.getElementById('attainment2M').checked = true;
        } else {
            document.getElementById('attainment2M').checked = false;
        }

        //Attainment 3
        if(sscCrM >= 51.5){
            document.getElementById('attainment3M').checked = true;
        } else {
            document.getElementById('attainment3M').checked = false;
        }

        //Attainment 4
        if(bscCrM >= 18.5){
            document.getElementById('attainment4M').checked = true;
        } else {
            document.getElementById('attainment4M').checked = false;
        }

        //Attainment 5
        if(portaleCrM >= 68){
            document.getElementById('attainment5M').checked = true;
        } else {
            document.getElementById('attainment5M').checked = false;
        }

        //Attainment 6
        if(careCoinIsM >= careCoinShouldM && sscCrM >= 60){
            document.getElementById('attainment6M').checked = true;
        } else {
            document.getElementById('attainment6M').checked = false;
        }

        //Attainment 7
        if(careCoinIsM >= careCoinShouldM && bscCrM >= 25){
            document.getElementById('attainment7M').checked = true;
        } else {
            document.getElementById('attainment7M').checked = false;
        }

        //Attainment 8
        if(careCoinIsM >= careCoinShouldM && portaleCrM >= 80){
            document.getElementById('attainment8M').checked = true;
        } else {
            document.getElementById('attainment8M').checked = false;
        }
    }

    function calcProvision(){
        var sscSaveSum = 0.00;
        var bscSaveSum = 0.00;
        var portaleSaveSum = 0.00;

        var provisionSum = document.getElementById('provisionSum').innerText

        //Attainment 1
        if(document.getElementById('attainment1').checked == true){
            sscSaveSum += 1.25;
            bscSaveSum += 1.25;
            portaleSaveSum += 1.25;
        }

        //Attainment 2
        if(document.getElementById('attainment2').checked == true){
            sscSaveSum += 0.50;
            bscSaveSum += 0.50;
            portaleSaveSum += 0.50;
        }

        //Attainment 3
        if(document.getElementById('attainment3').checked == true){
            sscSaveSum += 1.25;
        }

        //Attainment 4
        if(document.getElementById('attainment4').checked == true){
            bscSaveSum += 0.75;
        }

        //Attainment 5
        if(document.getElementById('attainment5').checked == true){
            portaleSaveSum += 0.75;
        }

        //Attainment 6
        if(document.getElementById('attainment6').checked == true){
            sscSaveSum += 2.00;
        }

        //Attainment 7
        if(document.getElementById('attainment7').checked == true){
            bscSaveSum += 2.50;
        }

        //Attainment 8
        if(document.getElementById('attainment8').checked == true){
            portaleSaveSum += 2.50;
        }

        provisionSum = (sscSaves * sscSaveSum) + (bscSaves * bscSaveSum) + (portaleSaves * portaleSaveSum);

        document.getElementById('provisionSum').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(provisionSum);
        document.getElementById('sscSaveValue').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(sscSaveSum);
        document.getElementById('bscSaveValue').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(bscSaveSum);
        document.getElementById('portaleSaveValue').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(portaleSaveSum);
    }

    function calcProvisionM(){
        var sscSaveSumM = 0.00;
        var bscSaveSumM = 0.00;
        var portaleSaveSumM = 0.00;

        var provisionSumM = document.getElementById('provisionSumM').innerText

        //Attainment 1
        if(document.getElementById('attainment1M').checked == true){
            sscSaveSumM += 1.25;
            bscSaveSumM += 1.25;
            portaleSaveSumM += 1.25;
        }

        //Attainment 2
        if(document.getElementById('attainment2M').checked == true){
            sscSaveSumM += 0.50;
            bscSaveSumM += 0.50;
            portaleSaveSumM += 0.50;
        }

        //Attainment 3
        if(document.getElementById('attainment3M').checked == true){
            sscSaveSumM += 1.25;
        }

        //Attainment 4
        if(document.getElementById('attainment4M').checked == true){
            bscSaveSumM += 0.75;
        }

        //Attainment 5
        if(document.getElementById('attainment5M').checked == true){
            portaleSaveSumM += 0.75;
        }

        //Attainment 6
        if(document.getElementById('attainment6M').checked == true){
            sscSaveSumM += 2.00;
        }

        //Attainment 7
        if(document.getElementById('attainment7M').checked == true){
            bscSaveSumM += 2.50;
        }

        //Attainment 8
        if(document.getElementById('attainment8M').checked == true){
            portaleSaveSumM += 2.50;
        }

        provisionSumM = (sscSavesM * sscSaveSumM) + (bscSavesM * bscSaveSumM) + (portaleSavesM * portaleSaveSumM);

        document.getElementById('provisionSumM').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(provisionSumM);
        document.getElementById('sscSaveValueM').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(sscSaveSumM);
        document.getElementById('bscSaveValueM').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(bscSaveSumM);
        document.getElementById('portaleSaveValueM').innerText = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(portaleSaveSumM);
    }

</script>
@endsection
