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
                    <div style="text-align: center; font-weight: bold;">CR (ohne KüRüs)</div>
                    <div>Retention Access</div>
                    <div>
                      <div style="display: flex; width: min-content; margin: auto;">
                        <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 5, 'updown' => 0])}}" role="button">-</a>
                        <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if($trackcalls->where('category',5)->first()){{ $RetentionCalls = $trackcalls->where('category',5)->first()->calls}} @else 0 @endif</div>
                        <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 5, 'updown' => 1])}}" role="button">+</a>
                      </div>
                    </div>
                    <div style="text-align: center">{{$SavesRet = $history->where('event_category','Save')->where('product_category', 'Retention')->count()}}</div>
                    <div style="text-align: center">{{roundUp($allCallsD,$Saves = $SavesRet + $SavesPrev = $history->where('event_category','Save')->where('product_category', 'Prevention')->count())}}%</div>
                    <div>Prevention</div>
                    <div>
                      <div style="display: flex; width: min-content; margin: auto;">
                        <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 6, 'updown' => 0])}}" role="button">-</a>
                        <div style="padding: 0 5px; min-width: 50px; text-align: center; margin: auto;">@if( $trackcalls->where('category',6)->first()) {{$preventioncalls = $trackcalls->where('category',6)->first()->calls}} @else 0   @endif</div>
                        <a class="btn btn-primary btn-tracking-change" href="{{route('mobile.tracking.call.track',[ 'type'=> 6, 'updown' => 1])}}" role="button">+</a>
                      </div>
                    </div>
                      <div style="text-align: center">{{$SavesPrev }}</div>
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
                    <div style="text-align: center">{{roundUP($Saves, $allCallsD)}}%</i></div>
                    <div>OptIn Quote</div>
                    <div style="text-align: center">{{roundUp($allCallsD,$history->where('optin',1)->count())}}%</i></div>
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
                      <input type="text" class="form-control" id="contract_number" name="contract_number" style="max-width: 300px; margin: 0 auto;" onchange="tracking_input()" onkeyup="tracking_input()">
                      <div class="tracking_errormessage" id="contract_number_errormessage" style="display: none;">
                          <div style="margin: auto; padding: 0 5px;"><i class="far fa-times-circle"></i><small>Bitte trage eine gültige Vertragsnummer ohne Buchstaben, Leer- oder Sonderzeichen ein</small></div>
                      </div>
                    </div>
                    <!-- <input type="hidden" class="btn-check" name="product_category" value="DSL" id="product_category1" autocomplete="off" onchange="tracking_input()"> -->
                    <div class="tracking_container">
                        <div class="tracking_description">Queue</div>
                        <div class="btn-group-container">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="product_category" value="Retention" id="product_category1" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary " for="product_category1">Retention</label>
                                <input type="radio" class="btn-check" name="product_category" value="Prevention" id="product_category2" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary" for="product_category2">Prevention</label>
                            </div>
                        </div>
                    </div>
                    <div class="tracking_container">
                        <div class="tracking_description">Ergebnis</div>
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
                            </div>
                          </div>
                          <div class="tracking_description mt-2">Sonderfälle</div>
                          <div class="btn-group-container ">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="event_category" value="Umzug" id="event_category5" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="event_category5">Umzug</label>
                                <input type="radio" class="btn-check" name="event_category" value="NV_DSL" id="event_category6" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="event_category6">NV DSL</label>
                                <input type="radio" class="btn-check" name="event_category" value="NV_Mobile" id="event_category7" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="event_category7">NV Mobile</label>
                                <input type="radio" class="btn-check" name="event_category" value="Angebot" id="event_category8" autocomplete="off" onchange="tracking_input()">
                                <label class="btn btn-outline-primary last-btn-group-element" for="event_category8">Angebot</label>
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
                    <div class="tracking_container">
                        <div class="tracking_description">Warenkorb</div>
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
                            <div style="text-align: left;">Retention Access</div>
                            <div id="sscCalls">{{$allCalls = 50}}</div>
                            <div id="sscSaves">{{$allSaves = 10}}</div>
                            <div style="display:flex; justify-content: Center;">
                                <div id="CR">{{roundUp($allCalls,$allSaves)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;">Überlauf</div>
                            <div id="sscCalls">{{$allCalls = 50}}</div>
                            <div id="sscSaves">{{$allSaves = 10}}</div>
                            <div style="display:flex; justify-content: center;">
                                <div id="CR">{{roundUp($allCalls,$allSaves)}}</div>
                                <div>%</div>
                            </div>
                            <div style="text-align: left;justify-content: center;">OptIn</div>
                            <div id="optinCalls">{{$optinCalls = $trackcallsM->where('category','!=',4)->sum('calls')}}</div>
                            <div id="optinSaves">{{$optin = $monthSP->where('optin',1)->count()}}</div>
                            <div style="display:flex; justify-content: center;">
                                <div id="optinCr">{{roundUp($optinCalls,$optin)}}</div>
                                <div>%</div>
                            </div>
                        </div>
                    </div>
                    @php
                      $Allsaves = $allSaves;
                    @endphp
                    <div id="month_carecoins">
                        <div style="display: grid; grid-template-columns: 1fr 1fr ; row-gap: 10px; text-align: center;" >
                            <div style="font-weight: bold; grid-column: 1 / span 2;">CareCoins</div>
                            <div style="text-align: left;">Soll</div>
                              <div id="careCoinShould">

                                @if($userdata)
                                  @if($userdata->soll_h_day == 8) {{$CCTreshold = 5000 -($userVacation*28.5)}}
                                    @elseif($userdata->soll_h_day == 7) {{$CCTreshold = 4375 -($userVacation*28.5)}}
                                    @elseif($userdata->soll_h_day == 6) {{$CCTreshold = 3750 -($userVacation*28.5)}}
                                    @elseif($userdata->soll_h_day == 5) {{$CCTreshold = 3125 -($userVacation*28.5)}}
                                    @elseif($userdata->soll_h_day == 4) {{$CCTreshold = 2500 -($userVacation*28.5)}}
                                    @elseif($userdata->soll_h_day == 3) {{$CCTreshold = 1875 -($userVacation*28.5)}}
                                    @else Fehler Sollstunden KDW {{$CCTreshold = 0}}
                                  @endif
                                @else
                                  keine Userdaten
                                  {{$CCTreshold = 0}}
                                @endif</div>
                            <div  style="text-align: left;">Ist</div>
                            <div id="careCoinIs">{{$CCState = $Allsaves * 20}}</div>
                            <div style="text-align: left;">Differenz</div>
                            <div id="careCoinDifference">{{$CCTreshold - $CCState}} </div>
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
                                <abbr title="@if(false) Save +1,00€ @else Save +0,50€@endif" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment1" onchange="calcProvision()">
                                    Ziel 1: CareCoin Ist >= CareCoin Soll
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="@if(false) Save +0,75€ @else Save +0,50€@endif" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment2" onchange="calcProvision()">
                                    Ziel 2: OptIn Quote >= 16,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="@if(false) Save +1,00€ @else Save +0,50€@endif" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment3" onchange="calcProvision()">
                                    Ziel 3: CR >= 43,2%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="@if(false) Save +1,50€ @else Save +1,00€@endif" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment4" onchange="calcProvision()">
                                    Ziel 4:CR >= 45,00%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="@if(false) Save +0,75€ @else Save +0,50€@endif" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment5" onchange="calcProvision()">
                                    Ziel 5: RLZ24 >= 60%
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <abbr title="wirkt sich auf die Provision allgemein aus" style="margin-right: 5px;"><i class="far fa-question-circle"></i></abbr>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" id="attainment6" onchange="calcProvision()">
                                    Ziel 6: AHT < 630 Sekunden
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
                        <div id="provisionSum" style="text-align: center; font-size: 2em; margin-top: 30px; margin-bottom:30px;">
                            0,00€
                        </div>
                        <div style="width:max-content;margin:auto;">
                            <div style="text-align: center">Vergütung je Save</div>
                            <div style="display: flex">
                                <div style="display:flex; margin:0 20px">
                                    <div>Retention:</div>
                                    <div style="margin-left:5px" id="">0,00 €</div>
                                </div>
                                <div style="display:flex; margin:0 20px">
                                    <div>Prevention:</div>
                                    <div style="margin-left:5px" id="">0,00 €</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="history_container" style="display: none">
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
        let errorDiv = document.getElementById('contract_number_errormessage')
        let contractnumber = $("#contract_number");

        if(contract_field == ''){
            errorDiv.style.display = 'none';
            contractnumber.css("border","1px solid #f96332")
            error_counter += 1;
        } else if (Math.floor(contract_field) == contract_field) {
          contractnumber.css("border","1px solid #f96332")
            errorDiv.style.display = 'none';
        } else {
            // contractnumber.css('border-width', '0');
            contractnumber.css("border","3px solid red")
            errorDiv.style.display = 'flex';
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
            console.log(error_counter)
            document.getElementById('submit_tracking').disabled = false;
        } else {
            document.getElementById('submit_tracking').disabled = true;
        }

    }

</script>

<script>
    var trackingContainer = document.getElementById('tracking_container');
    var monthContainer = document.getElementById('month_container');
    var historyContainer = document.getElementById('history_container');

    function updateShowContainer(){
        var selectedShowContainer = document.querySelector('input[name="show_container"]:checked')?.value;
        // console.log(selectedShowContainer);

        if(selectedShowContainer == 'show_tracking_container'){
            trackingContainer.style.display = 'flex';
            monthContainer.style.display = 'none';
            historyContainer.style.display = 'none';
        } else if (selectedShowContainer == 'show_month_container'){
            trackingContainer.style.display = 'none';
            monthContainer.style.display = 'flex';
            historyContainer.style.display = 'none';
        } else if (selectedShowContainer == 'show_history_container'){
            trackingContainer.style.display = 'none';
            monthContainer.style.display = 'none';
            historyContainer.style.display = 'flex';
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

    $(document).ready(function() {
        checkAttainment();
        calcProvision();
    });

    function checkAttainment(){
        //Attainment 1
        if(careCoinIs >= careCoinShould){
            document.getElementById('attainment1').checked = true;
        } else {
            document.getElementById('attainment1').checked = false;
        }

        //Attainment 2
        if(optinCr >= 15){
            document.getElementById('attainment2').checked = true;
        } else {
            document.getElementById('attainment2').checked = false;
        }

        //Attainment 3
        if(sscCr >= 50){
            document.getElementById('attainment3').checked = true;
        } else {
            document.getElementById('attainment3').checked = false;
        }

        //Attainment 4
        if(bscCr >= 17){
            document.getElementById('attainment4').checked = true;
        } else {
            document.getElementById('attainment4').checked = false;
        }

        //Attainment 5
        if(portaleCr >= 64){
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

</script>
@endsection