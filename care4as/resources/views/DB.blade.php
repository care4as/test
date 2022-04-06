@extends('general_layout')
@section('pagetitle')
Deckungsbeitrag
@php
function getQuota($calls, $orders)
{
  if($calls == 0)
  {
    $quota = 0;
  }
  else {
    $quota = round(($orders/$calls)*100,2);
  }
  return $quota;
}
@endphp
@endsection
@section('additional_css')

<style media="screen">
* {
  scrollbar-width: thin;
  scrollbar-color: #f1f1f1;
}
th{
  cursor: pointer;
}
::-webkit-scrollbar {
  width: 10px;
  height: 5px;
  padding: 1px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}
tfoot td
{
    font-weight: bold !important;
}
  th, td
  {
    font-size: 0.95em !important;
    text-align: center;
    margin: 0;
    border: 0;
    padding: 0px;
    border-collapse: collapse !important;
    /* color: #746e58; */
    white-space: nowrap;
    /* width: 75px !important; */

    }
  .fixedCol
  {
    color:white;
    font-weight: bold;
  }
  div .dataTables_scrollFoot{
     /* display: none; */
   }
  div .DTFC_RightFootWrapper
  {
    display: none;
  }
  div .DTFC_LeftFootWrapper
  {
    display: none;
  }
  .DTFC_LeftBodyLiner
  {
    overflow: hidden !important;;
  }

  .DTFC_RightBodyLiner
  {
    overflow: hidden !important;;
  }
  .DTFC_LeftBodyWrapper
  {
    overflow: hidden !important;

  }
  .DTFC_RightWrapper
  {
    right: 0px !important;
  }
  #footerdata
  {
    display: hidden;
  }

  .loadingerDA, .loadingerHR, .loadingerRD
  {
    animation: blink 2s infinite;
  }
  @keyframes blink {
  from {color: black;}
  to {color: white;}
  }

  .fixedright
  {

    position: fixed;
    right: 25px;
    z-index: 200;
    cursor: pointer;
  }
  .LexikaButton
  {
    height: 75px;
    width: 65px;
    top: 40%;
    border-radius: 	50%;
    z-index: 210;
  }
  .Lexika
  {
    height: 10em;
    width: 82%;
    padding: 5px;
    bottom: 0em;
    left: 15%;
    overflow: scroll;
    display: none;

  }
  .button1{
    height: 5.5em;
    width: 9.5em;
    border-radius: 25px;
    background: rgba(245, 208, 32, 0.5);
    background-image: linear-gradient(315deg, #f5d020 0%, #f53803 74%);
  }
  .label
  {
    height: 5.5em;
    width: 5.5em;
    border-radius: 25px;
    background: rgba(245, 208, 32, 0.5);
    background-image: linear-gradient(315deg, #f5d020 0%, #f53803 74%);
    opacity: 0.5;
    font-size: 1.19em;
    font-weight: bold;
    color: white;
    text-align: center;
  }
  input[type="checkbox"]
  {
    display:none;
  }
  input[type="checkbox"]:checked+label
  {
    background-color: #f5d020;
    background-image: linear-gradient(315deg, #f5d020 0%, #f53803 74%);
    opacity: 1;
  }
  .label > input {
    display: none;
  }
</style>

@endsection

@section('content')

<div class="max-main-container">
  <div class="max-panel-content">
    <div class="row m-3 mt-2" id="filtermenu">
      <div class="col-1 h-100">
        <div class="row h-100 center_items">
            <button class="button1" data-toggle="modal" data-target="#modalFilter" role="button" aria-expanded="false" style="">
              <h5>Filtermenü &#128269;</h5>
            </button>
        </div>
        <div class="row mt-2 center_items">
          <button class="button1" data-toggle="modal" data-target="#modalData" role="button" aria-expanded="false"  style="">
              <h5>Datenstand</h5>
          </button>
        </div>
      </div>
      <div class="col-2 offset-5">
        <div class="row h-100 center_items mr-2">
          <p style="font-size: 20px; font-weight: bold;">  Wähle die Daten:</p>
        </div>
      </div>
      <div class="col-1 ">
        <div class="row">
          <input class="form-check-input" type="checkbox" value="" id="DataComplete">
          <label class="label" for="DataComplete">
            <div class="center_items w-100 h-100">
            Alle Daten
            </div>
            </label>
        </div>
        <div class="row">
          <input class="form-check-input" type="checkbox" value="" id="DataRD" >
          <label class="label" for="DataRD">
          <div class="center_items w-100 h-100">
            Retention Details
          </div>
          </label>
        </div>
      </div>
      <div class="col-1">
        <div class="row">
          <input class="form-check-input" type="checkbox" value="" id="DataRev">
          <label class="label" for="DataRev">
            <div class="center_items w-100 h-100">
            Umsatz
            </div>
          </label>
        </div>
        <div class="row">
          <input class="form-check-input" type="checkbox" value="" id="DataGeVo">
          <label class="label" for="DataGeVo">
          <div class="center_items w-100 h-100">
          GeVo Daten
          </div>
          </label>
        </div>
      </div>
      <div class="col-1">
        <div class="row">
          <input class="form-check-input" type="checkbox" value="" id="DataDA">
          <label class="label" for="DataDA">
            <div class="center_items w-100 h-100">
            DailyAgent
            </div>
          </label>
        </div>
        <div class="row">
          <input class="form-check-input" type="checkbox" value="" id="DataSick">
          <label class="label" for="DataSick">
          <div class="center_items w-100 h-100">
            Krankheit
          </div>
          </label>
        </div>
      </div>
      <div class="col-1">
        <div class="row">
          <input class="form-check-input" type="checkbox" value="" id="DataPS">
          <label class="label" for="DataPS">
            <div class="center_items w-100 h-100">
            Opt-ins/SAS
            </div>
          </label>
        </div>
        <div class="row">
            <input class="form-check-input" type="checkbox" value="" id="">
            <label class="label" for="DataSick">
              <div class="center_items w-100 h-100">
                xxx
              </div>
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-3 center_items">
          <small class=""><b>Scroll über die Überschrift der jeweiligen Spalte für eine Erklärung zu der KPI</b></small>
        </div>
      </div>
    </div>
  </div>
  <div class="max-main-container">
    <div class="max-panel-content">
      <div class="row m-2 mt-4 justify-content-center align-self-center" >
        <div class="col p-1">
          @php
            if(request('department') == '1&1 DSL Retention')
            {
              $pricepersave = 15;
            }
            else
            {
              $pricepersave = 15;
            }
          @endphp
          <table class="max-table" id="tableoverview">
            <thead class="thead">
              <tr class="">
                <th># </th>
                <th>Name</th>
                <th data-toggle="tooltip" data-placement="top" title="durschnittliche Bearbeitungszeit eines Cases in Sekunden">AHT</th>
                <th data-toggle="tooltip" data-placement="top" title="Stundenreport KDW bezahlte Stunden">h bezahlt </th>
                <th data-toggle="tooltip" data-placement="top" title="eingeloggte Zeit in der CCU">h anwesend</th>
                <th data-toggle="tooltip" data-placement="top" title="Zeit in der CCU auf produktiven Status">h produktiv</th>
                <th data-toggle="tooltip" data-placement="top" title="Produktivquote aus Spalte h bezahlt (KDW) und h produktiv (DA)">PQ</th>
                <th data-toggle="tooltip" data-placement="top" title="Produktivquote aus den DailyAgent Daten ">1&1 PQ</th>
                <th data-toggle="tooltip" data-placement="top" title="RD Calls / KDW bezahlte Stunden">Calls/h</th>
                <th data-toggle="tooltip" data-placement="top" title="RD Gesamtsaves / KDW bezahlte Stunden">Saves/h</th>
                <th data-toggle="tooltip" data-placement="top" title="Gesamtanzahl Calls aus dem DailyAgent">DA Calls</th>
                <th data-toggle="tooltip" data-placement="top" title="Saves insgesamt aus dem GeVo Tracking, mit einem Klick auf die Zahl wird die Verteilung angezeigt, Abweichungen zu RD Saves sehr wahrscheinlich">GeVo Saves</th>
                <th data-toggle="tooltip" data-placement="top" title="Saves aus dem SSE Tracking Report, Abweichungen zu RD Saves sehr wahrscheinlich">SSE Tracking</th>
                <th data-toggle="tooltip" data-placement="top" title="Gesamtanzahl Calls aus dem Retention Details Report">RD Calls</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details SSC Calls">RD SSC Calls</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details BSC Calls">RD BSC Calls</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details Portal Calls">RD Portal Calls</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details alle Saves ohne Kürüs">RD Saves</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details SSC Saves">RD SSC</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details BSC Saves">RD BSC</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details Portal Saves">RD Portal</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details SSC CR">RD SSC CR</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details BSC CR">RD BSC CR</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details Portal CR">RD Portal CR</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details Overall CR inkl. KüRüs">GO CR</th>
                <th data-toggle="tooltip" data-placement="top" title="Retention Details CR ohne KüRüs">RD CR</th>
                <th data-toggle="tooltip" data-placement="top" title="RLZ24 Quote, Berechnung zur 1&1 Berechung weicht ab">RLZ+24 %</th>
                <th data-toggle="tooltip" data-placement="top" title="eine alternative CR zu der RD CR. Die Berechnung erfolgt aus den Saves aus dem GeVo Report und den Calls aus dem DailyAgent">CR 2</th>
                <th data-toggle="tooltip" data-placement="top" title="SAS Quote">SaS</th>
                <th data-toggle="tooltip" data-placement="top" title="Optinquote">OptIn</th>
                <th data-toggle="tooltip" data-placement="top" title='Umsatz bei kalkulierten 15€ pro Save'>Umsatz</th>
                <th data-toggle="tooltip" data-placement="top" title='Umsatz pro bezahlter Stunde(KDW)'>Umsatz/h bez</th>
                <th data-toggle="tooltip" data-placement="top" title='Umsatz pro produktiver Stunde(DailyAgent)'>Umsatz/h prod</th>
                <th data-toggle="tooltip" data-placement="top" title='alle Krankenstunden'>Kr h</th>
                <th data-toggle="tooltip" data-placement="top" title='Quote bezahlte Stunden / Krankheitsstunden'>KQ</th>
                <th>Optionen</th>
              </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr class="">
                <td data-order="{{$user->id}}" class="fixedCol" style="width: auto;  background-color: rgba(0,0,0,1);">{{$user->id}}</td>
                <td data-order="{{$user->name}}" class="fixedCol" style="text-align: left; background-color: rgba(0,0,0,1); "><span>{{$user->surname}} {{$user->lastname}} </span></td>
                <td data-order="{{$user->salesdata['aht']}}" style= "font-size: 900; color: @if($user->salesdata['aht'] < 750 && $user->salesdata['aht'] != 0) green @else red @endif;">
                  {{$user->salesdata['aht']}}
                </td>
                <td data-order="{{$user->salesdata['workedHours']}}">{{$user->salesdata['workedHours']}}</td>
                <td data-order="{{$user->salesdata['payedtime11']}}">{{$user->salesdata['payedtime11']}}</td>
                <td data-order="{{$user->salesdata['productive']}}">{{$user->salesdata['productive']}}</td>
                @if($user->salesdata['workedHours'] != 0)
                  <td data-order="{{round($user->salesdata['productive']*100/$user->salesdata['workedHours'],2)}}">{{round($user->salesdata['productive']*100/$user->salesdata['workedHours'],2)}}%</td>
                @else
                  <td data-order="0">0%</td>
                @endif
                <!-- 1&1 Produktivquote -->
                @if($user->salesdata['payedtime11'] != 0)
                  <td data-order="{{round($user->salesdata['productive']*100/$user->salesdata['payedtime11'],2)}}">{{round($user->salesdata['productive']*100/$user->salesdata['payedtime11']),2}}%</td>
                @else
                  <td data-order="0">0%</td>
                @endif
                <!-- /1&1 Produktivquote -->
                <!-- Calls per hour-->
                @if($user->salesdata['workedHours'] != 0)
                  <td data-order="{{round($user->salesdata['calls'] / $user->salesdata['workedHours'],2)}}">{{round($user->salesdata['calls'] / $user->salesdata['workedHours'],2)}}</td>
                  @else
                  <td data-order="0">0</td>
                @endif
                <!-- /Calls per hour-->
                <!-- Saves/h -->
                @if($user->salesdata['workedHours'] != 0)
                  @if($user->department == '1&1 DSL Retention')
                    <td data-order="{{$user->salesdata['orders']/$user->salesdata['workedHours']}}">{{round($user->salesdata['orders']/($user->salesdata['workedHours']),2)}}</td>
                  @else
                    <td data-order="{{$sumSaves = $user->salesdata['sscOrders'] + $user->salesdata['bscOrders'] + $user->salesdata['portalOrders']}}">{{round($sumSaves/($user->salesdata['workedHours']),2)}}</td>
                  @endif
                @else
                  <td data-order="0">0</td>
                @endif
                <!-- /Saves/h -->

                <!-- Calls DailyAgent -->
                <td data-order="{{$user->salesdata['dailyagentCalls']}}">{{$user->salesdata['dailyagentCalls']}}</td>
                <!-- /Calls DailyAgent -->

                <!-- GeVo SAVES -->
                <td data-order="{{$user->gevo->where('change_cluster','Upgrade')->count() + $user->gevo->where('change_cluster','Sidegrade')->count() +$user->gevo->where('change_cluster','Downgrade')->count()}}">
                  <div class="center_items" style="position: relative; height: auto; width: 100%;">
                    <div class="" style="position: absolute; display:block;">
                      <a onclick="showDetails({{$user->id}})" style="cursor:pointer;">  {{$user->gevo->where('change_cluster','Upgrade')->count() + $user->gevo->where('change_cluster','Sidegrade')->count() +$user->gevo->where('change_cluster','Downgrade')->count()}}</a>
                    </div>
                    <div class="bg-light text-dark" style="position: absolute; display:none; z-index: 200;" id="details{{$user->id}}" onclick="hide(this)">
                      <div class="">
                        Upgrades:{{$user->gevo->where('change_cluster','Upgrade')->count()}}
                      </div>
                      <div class="">
                        Sidegrades:{{$user->gevo->where('change_cluster','Sidegrade')->count()}}
                      </div>
                      <div class="">
                        Downgrades:{{$user->gevo->where('change_cluster','Downgrade')->count()}}
                      </div>
                    </div>
                  </div>
                </td>
                <!-- /GeVo SAVES -->
                <!-- All SSE Saves -->
                <td data-order="{{$user->salesdata['ssesaves']}}">{{$user->salesdata['ssesaves']}}</td>
                <!-- All SSE Saves -->
                <!-- All RD Calls -->
                <td data-order="{{$user->salesdata['calls']}}">{{$user->salesdata['calls']}}</td>
                <!-- /All RD Calls -->
                <td>{{$user->salesdata['sumSSCCalls']}}</td>
                <td>{{$user->salesdata['sumBSCCalls']}}</td>
                <td>{{$user->salesdata['sumPortalCalls']}}</td>
                <!-- Gesamtsaves -->
                @if($user->department == '1&1 DSL Retention')
                  <td data-order="{{$user->salesdata['orders']}}">{{$user->salesdata['orders']}}</td>
                @else
                  <td data-order="{{$sumSaves = $user->salesdata['sscOrders'] + $user->salesdata['bscOrders'] + $user->salesdata['portalOrders']}}">{{$sumSaves}}</td>
                @endif
                <!-- /Gesamtsaves -->
                <td data-order="{{$user->salesdata['sscOrders']}}">{{$user->salesdata['sscOrders']}}</td>
                <td data-order="{{$user->salesdata['bscOrders']}}">{{$user->salesdata['bscOrders']}}</td>
                <td data-order="{{$user->salesdata['portalOrders']}}">{{$user->salesdata['portalOrders']}}</td>
                <td data-order="{{$user->salesdata['sscQuota']}}" style= "font-size: 900; color: @if($user->salesdata['sscQuota'] > 60) green @elseif ($user->salesdata['sscQuota'] > 51) #ffc107 @else red @endif;"> {{$user->salesdata['sscQuota']}}%</td>
                <td data-order="{{$user->salesdata['bscQuota']}}" style= "font-size: 900; color: @if($user->salesdata['bscQuota'] > 18) green @else red @endif;">{{$user->salesdata['bscQuota']}}% </td>
                <td data-order="{{$user->salesdata['portalQuota']}}" style= "font-size: 900; color: @if($user->salesdata['portalQuota'] > 65) green @else red @endif;">{{$user->salesdata['portalQuota']}}%</td>
                <!-- CR with KüRü -->
                <td data-order="50">GO CR</td>
                <!-- /CR with KüRü  -->

                <!-- RD Gevo CR-->
                @if($user->department == '1&1 Mobile Retention')
                  <td data-order="{{$user->salesdata['GeVo-Cr']}}" > {{$user->salesdata['GeVo-Cr']}}%</td>
                @else
                  <td data-order="{{$user->salesdata['GeVo-Cr']}}" style= "font-size: 900; color: @if($user->salesdata['GeVo-Cr'] > 40) green @elseif ($user->salesdata['GeVo-Cr'] > 35) #ffc107 @else red @endif;"> {{$user->salesdata['GeVo-Cr']}}%</td>
                @endif
                <!--/RD CR-->

                <!--RD RLZ-->
                  <td data-order="{{$user->salesdata['RLZ24Qouta']}}" style=" color: @if($user->salesdata['RLZ24Qouta'] > 70) green @else red @endif;">@if($user->salesdata['RLZ24Qouta'] != 0){{$user->salesdata['RLZ24Qouta']}}% @else 0% @endif</td>
                <!--/RD RLZ-->
                <!-- Gevo/DA CR-->
                <td data-order="{{$user->salesdata['gevocr2']}}">{{$user->salesdata['gevocr2']}}%</td>
                <!-- /Gevo/DA CR-->

                <td data-order="{{$user->sasquota}}">{{$user->sasquota}}</td>
                <td data-order="{{$user->optinQuota}}" style= "font-size: 900; color: @if($user->optinQuota > 16) green @else red @endif;">{{$user->optinQuota}}%</td>
                <td data-order="{{$user->salesdata['orders'] * $pricepersave}}">{{$user->salesdata['orders'] * $pricepersave}}€</td>
                @if($user->salesdata['workedHours'] != 0)
                  <td data-order="{{round(($user->salesdata['orders'] * $pricepersave)/($user->salesdata['workedHours']),2)}}">{{round(($user->salesdata['orders'] * $pricepersave)/($user->salesdata['workedHours']),2)}}</td>
                @else
                  <td data-order="0">0</td>
                @endif
                @if($user->salesdata['productive'] != 0)
                  <td data-order="{{round(($user->salesdata['orders'] * $pricepersave) / $user->salesdata['productive'],2) }}">{{round(($user->salesdata['orders'] * $pricepersave) / $user->salesdata['productive'],2) }}</td>
                @else
                    <td data-order="0">0</td>
                @endif
                <td data-order="{{$user->salesdata['sickhours']}}">{{$user->salesdata['sickhours']}}</td>
                <td data-order="{{$user->salesdata['sicknessquota']}}" style=" color: @if($user->salesdata['sicknessquota'] < 9) green @else red @endif;">{{$user->salesdata['sicknessquota']}}%</td>
                <!-- <td>round($user->salesdata['sicknessquota'],2)%</td> -->
                <td data-order="{{$user->id}}" class="" style="text-align:center; font-size: 1.4em;">
                  <a class="text-muted" href="{{route('user.stats', ['id' => $user->id])}}">
                    <span class="material-icons">preview</span>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot class="">
            <tr class="" id='footerdata'>
              <td>Total:</td>
              <td id="countMA">{{$users->count()}}</td>
              <td id="aht">{{$footerdata['avgAHT']}}s</td>
              <td id="kdw">kdw</td>
              <td id="payed11avg">bez1u1</td>
              <td id="productive11avg">prod1u1</td>
              <td id="produktivequote">pq</td>
              <td id="produktivequote11">pq1u1</td>
              <td id="callsPerHour">
                {{getQuota($allCalls = $footerdata['allSSCCalls'] + $footerdata['allBSCCalls'] + $footerdata['allPortaleCalls'], $footerdata['allWorkedHours'])/100}}
              </td>
              <td id="savesPerHour">{{getQuota($allSaves = $footerdata['allSSCSaves'] + $footerdata['allBSCSaves'] + $footerdata['allPortaleSaves'],$footerdata['allWorkedHours'])/100}}</td>
              <td id="allDailyAgentCalls"></td>
              <td id="allGeVoSaves">{{$footerdata['allGeVoSaves']}}</td>
              <td id="sseSaves">k.D.</td>
              <td id="RD Calls">{{$footerdata['allSSCCalls'] + $footerdata['allBSCCalls'] + $footerdata['allPortaleCalls']}}</td>
              <td id="RD SSC Calls"></td>
              <td id="RD BSC Calls">/td>
              <td id="RD Portal Calls"></td>
              <td id="RD Saves">RD Saves</td>
              <td id="RD SSC Saves">RD SSC Saves</td>
              <td id="RD BSC Saves">RD BSC Saves</td>
              <td id="RD Portal Saves">RD Portal Saves</td>
              <td id="RD SSC CR">{{getQuota($footerdata['allSSCCalls'],$footerdata['allSSCSaves'])}}%</td>
              <td id="RD BSC CR">{{getQuota($footerdata['allBSCCalls'],$footerdata['allBSCSaves'])}}%</td>
              <td id="RD Portale CR">{{getQuota($footerdata['allPortaleCalls'],$footerdata['allPortaleSaves'])}}%</td>
              <td id="Go Cr">GO CR</td>
              <td id="RD CR">{{getQuota($allCalls,$allSaves)}}%</td>
              <td id="RLZ24">
                @if($footerdata['allRLZ24'] + $footerdata['allMVLZ'] == 0)
                0

                @else
                {{round((($footerdata['allRLZ24'] / ($footerdata['allRLZ24'] + $footerdata['allMVLZ']))*100),2)}}%

                @endif
              </td>
              <td id="CR2">{{getQuota($footerdata['allDailyAgentCalls'], $footerdata['allGeVoSaves'])}}%</td>
              <td id="SAS">{{getQuota($allCalls, $footerdata['allSAS'])}}%</td>
              <td id="Optin">{{getQuota($footerdata['allOptinCalls'], $footerdata['allOptinRequests'])}}%</td>
              <td id="Revenue">revenue</td>
              <td id="Revenue payed">Revenue payed</td>
              <td id="Revenue productive">Revenue productive</td>
              <td id="Sickness Hours">Sickness Hours</td>
              <td id="Sickness Quota">Sickness Quota</td>
              <td>total</td>
            </tr>
          </tfoot>
        </table>
        </div>
      </div>
    </div>
</div>


@endsection

@section('additional_modal')
<div class="modal show" id="modalData" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-center" role="document" style="margin: 20vh auto;">
        <div class="modal-content">
          <div class="modal-body p-0" style="font-size: 14px;">
              <div class="row" id="dataState">
                <div class="col-12 text-left" >
                  <div class="max-panel m-0 bg-none">
                      <div class="max-panel-title">Datenstand</div>
                      <div class="max-panel-content">
                          <table class="table" style="text-align: center;">
                              <thead>
                                  <tr>
                                      <th style="text-align: left;">Report Test</th>
                                      <th>Daten von</th>
                                      <th>Daten bis</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr id="availbench">
                                      <td style="text-align: left; font-weight: 600;">1u1 Availbench</td>
                                      <td>Max kann kein Javascript</td>
                                      <td> sonst würde hier was stehen </td>
                                  </tr>
                                  <tr class="loadingerDA">
                                      <td style="text-align: left; font-weight: 600;">1u1 Daily Agent</td>
                                      <td id="" >Daten werden geladen</td>
                                      <td id=""></td>
                                  </tr>
                                  <tr id="dailyagentData" style="display:none;">
                                      <td style="text-align: left; font-weight: 600;">1u1 Daily Agent</td>
                                      <td id="dailyAgentStart">1</td>
                                      <td id="dailyAgentEnd">1</td>
                                  </tr>
                                  <tr class="loadingerOptin">
                                      <td style="text-align: left; font-weight: 600;">1u1 OptIn</td>
                                      <td id="">Daten werden geladen</td>
                                      <td id=""></td>
                                  <tr id="OptinDataStatus" style="display:none;">
                                      <td style="text-align: left; font-weight: 600;">1u1 OptIn</td>
                                      <td id="optinStart">1</td>
                                      <td id="optinEnd">1</td>
                                  </tr>
                                  <tr class="loadingerRD" >
                                      <td style="text-align: left; font-weight: 600;">1u1 Retention Details</td>
                                      <td id="">Daten werden geladen</td>
                                      <td id=""></td>
                                  </tr>
                                  <tr id="RDDataStatus" style="display:none;">
                                      <td style="text-align: left; font-weight: 600;">1u1 Retention Details</td>
                                      <td id="retDetailsStart">xxx</td>
                                      <td id="retDetailsEnd">xxx</td>
                                  </tr>
                                  <tr class="loadingerSAS">
                                      <td style="text-align: left; font-weight: 600;">1u1 SaS</td>
                                      <td id="">Daten werden geladen</td>
                                      <td id=""></td>
                                  <tr id="SASDataStatus" style="display:none;">
                                      <td style="text-align: left; font-weight: 600;">1u1 SaS</td>
                                      <td id="sasStart">sas</td>
                                      <td id="sasEnd">sas</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>
                <hr>
              </div>
              </div>
              <div class="modal-footer" style="font-size: 14px;">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
              </div>
            </div>
          </div>
        </div>
<div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-center" role="document" style="z-index: 50000; margin: 20vh auto;">
        <div class="modal-content" style="z-index: 50000;">
            <div class="modal-header ">
              <h5 class="modal-title w-100 text-center" id="" style="font-size: 1.45em;">Welche Daten sollen angezeigt werden?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="mt-2 w-100" action="{{route('1u1_deckungsbeitrag')}}" method="get">
            <div class="modal-body" style="font-size: 14px;">
              <div class="row m-3 mt-4" id="dataState">
                <div class="col-12 text-left" >
                      <div class="row m-0">
                        <div class="col-12 p-0" style="border-right: 2px solid black;">
                          <label for="department">Abteilung:</label>
                          <select class="form-control" name="department" id="department" style="width:218px; z-index: 50100;" required>
                            <option value="" @if(!request('department')) selected @endif disabled>Wähle die Abteilung</option>
                            <option value="1und1 DSL Retention" @if(request('department') == '1und1 DSL Retention') selected @endif>1&1 DSL Retention</option>
                            <option value="1und1 Retention" @if(request('department') == '1und1 Retention') selected @endif>1&1 Mobile Retention</option>
                          </select>
                        </div>
                        <div class="col-12 p-0">
                          <label for="team">Team:</label>
                            <select class="form-control" name="team" id="team" style="width:218px;">
                            <option value="" selected>Wähle das Team</option>
                            @foreach(DB::table('users')->where('status',1)->where('department','Agenten')->groupBy('team')->pluck('team') as $team)
                            <option value="{{$team}}">{{$team}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-12 p-0">
                          <label for="department">Welche MA:</label>
                            <select multiple class="form-control" name="employees[]" id="exampleFormControlSelect2" style="height: 150px; overflow:scroll;">
                            </select>
                        </div>
                        <div class="col-12 p-0">
                          <label for="datefrom">Von:</label>
                          <input type="date" id="start_date" name="start_date" class="form-control w-25" placeholder="" value="{{request('start_date')}}">
                         </div>
                         <div class="col-sm-12 p-0">
                           <label for="dateTo">Bis:</label>
                           <input type="date" id="end_date" name="end_date" class="form-control w-25" placeholder="" value="{{request('end_date')}}">
                         </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="font-size: 14px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" data-backdrop="false">Schließen</button>
                    <button type="submit" class="btn btn-primary">Anzeigen</button>
                  </div>
              </form>
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

<script type="text/javascript">
function toogleModal(modalid)
{
  console.log('testmodal')
  $('#'+modalid).toggle()
}
  $(document).ready(function(){

    function toogleModal(modalid)
    {
      // console.log('testmodal')
      $('#'+modalid).toggle()
    }
    $('#DataComplete').prop( "checked",true )

    loadData('dailyAgentDataStatus','#dailyagentData','.loadingerDA')
    loadData('SASStatus','#SASDataStatus','.loadingerSAS')
    loadData('OptinStatus','#OptinDataStatus','.loadingerOptin')
    loadData('HRDataStatus','#HoursreportData', '.loadingerHR')
    loadData('RDDataStatus','#RDDataStatus', '.loadingerRD')

    let table = $('#tableoverview').DataTable({

    "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation

            var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?  i : 0;
            };
            if (data['var']==1)
            total = api.column().data().reduce( function (a, b) {
            return intVal(a) + intVal(b);
            },0 );

            function getQuota(column)
            {
              let productiveQuota = api.column(column).nodes().toArray().map(function(node) {
                return $(node).attr('data-order');
              });
              let counter = 0;
              let sumPQ = productiveQuota.reduce(function (sum, currentValue) {
                if(currentValue != 0)
                {
                  counter = counter + 1
                  return  (1*parseFloat(sum) + 1*parseFloat(currentValue))
                }
                else {
                  return 1*parseFloat(sum)
                }
              }, 0)

              let Quota = sumPQ/counter
              return Quota
            }
            // $(api.column( 1 ).footer() ).html('<b>23</b>');
            // $(api.column( 2 ).footer() ).html('<b>'+Math.round(api.column(2).data().average()*100)/100 +'s</b>');
            $(api.column( 3 ).footer() ).html('<b>'+Math.round(api.column(3).data().sum()) +'h</b>');
            $(api.column( 4 ).footer() ).html('<b>'+Math.round(api.column(4).data().sum()) +'h</b>')
            $(api.column( 5 ).footer() ).html('<b>'+Math.round(api.column(5).data().sum()) +'h</b>')
            $(api.column( 6 ).footer() ).html('<b>'+getQuota(6).toFixed(2)+'%</b>')
            $(api.column( 7 ).footer() ).html('<b>'+getQuota(7).toFixed(2)+'%</b>')
            // $(api.column( 8 ).footer() ).html('<b>'+Math.round(api.column(8).data().sum()) +'</b>')
            // $(api.column( 9 ).footer() ).html('<b>'+Math.round(api.column(9).data().sum()) +'</b>')
            $(api.column( 10 ).footer() ).html('<b>'+Math.round(api.column(10).data().sum()) +'</b>')
            // $(api.column( 11 ).footer() ).html('<b>'+Math.round(api.column(11).data().sum()) +'</b>')
            $(api.column( 12 ).footer() ).html('<b>'+Math.round(api.column(12).data().sum()) +'</b>')
            $(api.column( 13 ).footer() ).html('<b>'+Math.round(api.column(13).data().sum()) +'</b>')
            $(api.column( 14 ).footer() ).html('<b>'+Math.round(api.column(14).data().sum()) +'</b>')
            $(api.column( 15 ).footer() ).html('<b>'+Math.round(api.column(15).data().sum()) +'</b>')
            $(api.column( 16 ).footer() ).html('<b>'+Math.round(api.column(16).data().sum())+'</b>')
            $(api.column( 17 ).footer() ).html('<b>'+Math.round(api.column(17).data().sum()) +'</b>')
            $(api.column( 18 ).footer() ).html('<b>'+Math.round(api.column(18).data().sum()) +'</b>')
            $(api.column( 19 ).footer() ).html('<b>'+Math.round(api.column(19).data().sum()) +'</b>')
            $(api.column( 20 ).footer() ).html('<b>'+Math.round(api.column(20).data().sum()) +'</b>')
            $(api.column( 30 ).footer() ).html('<b>'+Math.round(api.column(30).data().sum())  +'€</b>')
            $(api.column( 31 ).footer() ).html('<b>'+(Math.round(api.column(30).data().sum()) / Math.round(api.column(3).data().sum())).toFixed(2) +'€/h</b>')
            $(api.column( 32 ).footer() ).html('<b>'+(Math.round(api.column(30).data().sum()) / Math.round(api.column(4).data().sum())).toFixed(2) +'€/h</b>')
            $(api.column( 33 ).footer() ).html('<b> '+Math.round(api.column(33).data().sum()) +'h</b>')
            $(api.column( 34 ).footer() ).html('<b> '+(Math.round(api.column(3).data().sum()) / Math.round(api.column(34).data().sum())).toFixed(2) +'%</b>')
            // $(api.column( 31 ).footer() ).html('<b> options</b>')
          },
          bAutoWidth: false ,
          select: true,
          dom: 'Blfrtip',
          lengthMenu: [
              [-1,10, 25, 50, 100],
              ['alle','10', '25', '50 ', '100']
          ],
          buttons: [
                  { extend: 'csv', text: '<i class="fas fa-file-csv fa-2x"></i>' , footer:true },
                  { extend: 'excel', text: '<i class="fas fa-file-excel fa-2x"></i>', footer:true },
                  // 'excel',
              ],
        rowReorder: true,
        colReorder: true,
        scrollX: true,
        scrollY: "800px",
        scrollCollapse: true,
        fixedColumns: {
          leftColumns: 2,
          // rightColumns: 1,
        },
        language: {
          "paginate": {
            "next": "Nächste Seite",
            "previous": "Vorherige Seite",
          }
        },
        fnInitComplete: function(){
           // $('#footerdata').style.display = 'hidden';
           // columns.adjust()
       },
       "columnDefs": [
            { "width": "60px", "targets": "_all" },
          ],
        });

        let rights = {!! json_encode(Auth()->user()->getRights()) !!}
        $('#DataComplete').change(function(){
          if ( $( this ).is( ":checked" ) )
          {
              $('#DataRD').prop('checked', false)
              $('#DataGeVo').prop('checked', false)
              $('#DataDA').prop('checked', false)
              table.columns().visible( true );
          }
          else {
            table.columns().visible( false );
          }
        })

        $('#DataRD').change(function(){
          if ( $( this ).is( ":checked" ) )
          {
              if($('#DataComplete').is( ":checked" ))
              {
                $('#DataComplete').prop('checked', false)
                table.columns().visible( false );
                table.columns([1,8,9,13,14,15,16,17,18,19,20,21,22,23,24,25,26,35]).visible( true );
              }
              else {
                table.columns([8,9,13,14,15,16,17,18,19,20,21,22,23,24,25,26,35]).visible( true );
              }
          }
          else {
            table.columns([8,9,13,14,15,16,17,18,19,20,21,22,23,24,25,26,35]).visible( false );
          }
        })
        $('#DataGeVo').change(function(){
          if ( $( this ).is( ":checked" ) )
          {
            if($('#DataComplete').is( ":checked" ))
            {
              $('#DataComplete').prop('checked', false)
              table.columns().visible( false );
              table.columns([1,11,27]).visible( true );
            }
            else {
              table.columns([11,27]).visible( true );
            }
          }
          else {
            table.columns([11,27]).visible( false );
          }
        })
        $('#DataDA').change(function(){
          if ( $( this ).is( ":checked" ) )
          {
            if($('#DataComplete').is( ":checked" ))
            {
              $('#DataComplete').prop('checked', false)
              table.columns().visible( false );
              table.columns([1,2,3,4,5,6,7,8,9,10,27]).visible( true );
            }
            else {
              table.columns([2,3,4,5,6,7,8,9,10,27]).visible( true );
            }
              }
          else {
            table.columns([2,3,4,5,6,7,8,9,10,27]).visible( false );
          }
        })
        $('#DataSick').change(function(){
          if ( $( this ).is( ":checked" ) )
          {
            if($('#DataComplete').is( ":checked" ))
            {

              $('#DataComplete').prop('checked', false)
              table.columns().visible( false );
              table.columns([1,33,34]).visible( true );
            }
            else {
              table.columns([33,34]).visible( true );
            }
                }
          else {
            table.columns([33,34]).visible( false );
          }
        })
        $('#DataPS').change(function(){
          if ( $( this ).is( ":checked" ) )
          {
            if($('#DataComplete').is( ":checked" ))
            {

              $('#DataComplete').prop('checked', false)
              table.columns().visible( false );
              table.columns([1,28,29]).visible( true );
            }
            else {
              table.columns([28,29]).visible( true );
            }
                }
          else {
            table.columns([28,29]).visible( false );
          }
        })
        $('#DataRev').change(function(){
          if ( $( this ).is( ":checked" ) )
          {
            if($('#DataComplete').is( ":checked" ))
            {

              $('#DataComplete').prop('checked', false)
              table.columns().visible( false );
              table.columns([1,5,6,7,8,9,30,31,32]).visible( true );
            }
            else {
              table.columns([5,6,7,8,9,30,31,32]).visible( true );
            }
                }
          else {
            table.columns([5,6,7,8,9,30,31,32]).visible( false );
          }
        })


        $('#department').change(function() {

          $('#exampleFormControlSelect2').empty()
          let dep = this.value
          var host = window.location.host;
          axios.get('http://'+host+'/user/getUsersByDep/'+ dep)
          // axios.get('http://'+host+'/care4as/care4as/public/user/getUsersByDep/'+ dep)
          .then(response => {
            console.log(response)
            let users = response.data

            users.forEach(function(user){
              let option = document.createElement("option");
              let name = user.name;

              option.value = user.id;
              option.innerHTML = name;

              $('#exampleFormControlSelect2').append(option);
              // console.log(option)
              })
            })
          .catch(function (err) {

            $('#failContent').html('Fehler: '+ err.response.data.message)
            $('#failFile').html('Datei: '+ err.response.data.file)
            $('#failLine').html('Line: '+ err.response.data.line)
            $('#failModal').modal('toggle')

            // var display = $('.modal-backdrop')
            //  display.css("display");
            //   if(display!="none") {
            //     display.attr("style", "display:none");
            //   }
            console.log(err.response);
          })
        })
      });
</script>
@endsection
