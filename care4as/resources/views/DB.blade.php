@extends('general_layout')

@section('additional_css')

<style media="screen">

  th, td
  {
    /* font-size: 1.4em !important; */
    text-align: center;
    margin: 0;
    border: 0;
    /* color: #746e58; */
    white-space: nowrap;
    border-radius: 15px;

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

  .fixedright
  {

    position: fixed;
    right: 15px;
    z-index: 200;
    cursor: pointer;
  }
  .LexikaButton
  {
    height: 75px;
    width: 75px;
    top: 40%;
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
  @keyframes blink {
  from {color: black;}
  to {color: white;}
  }

</style>

@endsection

@section('content')
<div class="fixedright LexikaButton " id="LexikaButton">
  <button type="button" class="" name="button" onclick="rotateButton()">
    <span class="material-icons" style="font-size: 3em;">
      autorenew
    </span>
  </button>
</div>
<div class="fixedright Lexika" style="" id="Lexika">
  <div class="row gradientColor text-white ">
    <div class="col-1 ">
      Spalte
    </div>
    <div class="col-2">
      Name
    </div>
    <div class="col">
      Beschreibung
    </div>
  </div>

  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      3
    </div>
    <div class="col-2">
      AHT
    </div>
    <div class="col">
      die AHT gibt die durschnittliche Bearbeitungszeit eines Telefonats + Nacharbeit an.
      Der Wert muss mit dem Wert aus dem DailyAgent f??r den entsprechenden Zeitraum ??bereinstimmen.
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      4
    </div>
    <div class="col-2">
      KDW Stunden bezahlt
    </div>
    <div class="col">
      die Stunden die der MA im KDW Tool eingetragen hat
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      5
    </div>
    <div class="col-2">
      h anwesend
    </div>
    <div class="col">
        die Stunden die der MA in der <b>CCU</b> eingeloggt war. Es z??hlen dabei alle Status der CCU
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      6
    </div>
    <div class="col-2">
        h produktiv
    </div>
    <div class="col">
        die Stunden die der MA in der <b>CCU</b> eingeloggt war. Es z??hlen dabei nur die produktiven Status der CCU
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      7
    </div>
    <div class="col-2">
      PQ (Produktivquote)
    </div>
    <div class="col">
      der prozentuale Anteil der produktiven CCU-Status gegen??ber der anwesenden Stunden aus dem KDW Tool. Vereinfacht: der Wert aus Spalte 6 durch dem Wert aus Spalte 4
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      8
    </div>
    <div class="col-2">
      1&1 PQ
    </div>
    <div class="col">
      der prozentuale Anteil der produktiven CCU-Status gegen??ber der anwesenden Stunden aus der.Spalte 5 durch Spalte 6
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      9
    </div>
    <div class="col-2">
      Saves
    </div>
    <div class="col">
      die Gesamtzahl der Saves ohne K??R??s aus dem Retention Details Report
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      10
    </div>
    <div class="col-2">
      GeVo Saves
    </div>
    <div class="col">
      die Gesamtzahl der Saves ohne K??R??s aus dem GeVo Rohdatenexport, teilweise gibt es Abweichungen zum Retention Detailsreport daher als KPI mit aufgenommen
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
      10
    </div>
    <div class="col-2">
      Calls
    </div>
    <div class="col">
      -
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    11
    </div>
    <div class="col-2">
      Calls/h
    </div>
    <div class="col">
      die Calls durch den Wert der anwesenden Stunden im KDW Tool
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    12
    </div>
    <div class="col-2">
      SSC
    </div>
    <div class="col">
      SSC Saves (nur Mobile) gema?? den Retention Details
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    13
    </div>
    <div class="col-2">
      BSC
    </div>
    <div class="col">

    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    14
    </div>
    <div class="col-2">
      Portale
    </div>
    <div class="col">

    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    15
    </div>
    <div class="col-2">
      SSE
    </div>
    <div class="col">
      Die Saves aus der SSE bzw. dem Retention Tracking Rohdatenexport
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    16
    </div>
    <div class="col-2">
      Saves/h
    </div>
    <div class="col">
      Die Saves aus der SSE durch die KDW anwesend Zeit
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    17
    </div>
    <div class="col-2">
      RLZ +24%
    </div>
    <div class="col">
      Der Anteil von neuen VLZ gegen??ber Verl??ngerungen mit zus??tzlicher Vertragslaufzeit. ACHTUNG: Diese Quote weicht von der 1&1 Quote ab da seitens 1&1 nicht die einfachste Mathematik verwendet wird
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    18
    </div>
    <div class="col-2">
      RET GeVo CR
    </div>
    <div class="col">
      Alle Calls durch alle Sales ohne die K??R??S aus dem Retention Details Report. Dieser Wert soll mittelfristig die GeVo CR aus den DB Dateien abl??sen. Da dies einer der wichtigsten KPI's ist, sollte der Wert ??fters mal gegengepr??ft werden um Fehler m??glichst fr??h zu vermeiden.
    </div>
  </div>
  <div class="row gradientColor text-white borderwhite">
    <div class="col-1">
    19
    </div>
    <div class="col-2">
      SSC CR
    </div>
    <div class="col">
      Alle SSC Calls durch alle SSC Sales ohne die K??R??S aus dem Retention Details Report.
    </div>
  </div>
</div>

<div class="container-fluid bg-cool m-1">
  <div class="row m-1 justify-content-center align-self-center m-1">
      <h4 class="unit-translucent p-1">Pr??sentation des aktuellen Moduls: {{$modul ?? ''}}</h4>
  </div>
  <div class="row m-1 mt-4">
    <div class="col-12">
    </div>
    <div class="col-12 text-left">
      <table class="table table-borderless tablespacing">
        <caption class="text-center unit-translucent m-2">Aktueller Datenstand</caption>
        <tr class="unit-translucent">
          <td>
            @if(!App\DailyAgent::min('date'))
              <h5>keine Daten eingegeben</h5>
            @else
              <div class="loadingerDA">Lade Daten DailyAgent...</div>
              <span id="dailyagentData" style="display: none;">  </span>
            @endif
          </td>
          <td>  <a href="{{route('dailyagent.removeDuplicates')}}"><button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a></td>
          <td>  <a href="{{route('excel.dailyAgent.import')}}"><button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a></td>
        </tr>
        <tr class="unit-translucent">
          <td>
            @if(!App\Hoursreport::min('work_date'))
              <h5>keine Daten eingegeben</h5>
            @else
              <div class="loadingerHR">Lade Daten Stundenreport...</div>
              <span id="HoursreportData" style="display: none;">Daily Agent im Zeitraum vom Test  </span>
            @endif
          </td>
          <td><a href="{{route('reports.reportHours.update')}}"><button type="button" class="btn btn-sm border-round" name="button">Stundenreport Updaten</button></a></td>
          <td><a href="{{route('user.connectUsersToKDW')}}"><button type="button" class="btn btn-sm btn-success border-round" name="button">Userdaten verkn??pfen</button></a></td>
        </tr>
        <tr class="unit-translucent">
          <td>
            @if(!App\RetentionDetail::min('call_date'))
              <h5>keine Daten eingegeben</h5>
            @else
              <div class="loadingerRD">Lade Daten Retention Details...</div>
              <span id="RDDataStatus" style="display: none;">Daily Agent im Zeitraum vom Test  </span>
            @endif
          </td>
          <td>  <a href="{{route('retentiondetails.removeDuplicates')}}">  <button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a></td>
          <td><a href="{{route('reports.report')}}">  <button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a></td>
        </tr>
        <tr class="unit-translucent">
          <td>
            @if(!App\SAS::min('date'))
              <h5>keine Daten eingegeben</h5>
            @else
              <div class="loadingerSAS">Lade Daten SAS...</div>
              <span id="SASDataStatus" style="display: none;">Daily Agent im Zeitraum vom Test  </span>
            @endif
          </td>
          <td>  <a href="{{route('retentiondetails.removeDuplicates')}}">  <button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a></td>
          <td><a href="{{route('reports.report')}}">  <button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a></td>
        </tr>
        <tr class="unit-translucent">
          <td>
            @if(!App\Optin::min('date'))
              <h5>keine Daten eingegeben</h5>
            @else
              <div class="loadingerOptin">Lade Daten Optin...</div>
              <span id="OptinDataStatus" style="display: none;">Daily Agent im Zeitraum vom Test  </span>
            @endif
          </td>
          <td>  <a href="{{route('retentiondetails.removeDuplicates')}}">  <button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a></td>
          <td><a href="{{route('reports.report')}}">  <button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a></td>
        </tr>
      </table>
    </div>
    <hr>
  </div>

  <div class="row unit-translucent  m-2 mt-2" id="filtermenu">
    <div class="col-12 d-flex justify-content-center align-self-center">
      <a class="" data-toggle="collapse" href="#collapseFiltermenu" role="button" aria-expanded="false" aria-controls="collapseFiltermenu">
        <h5>Filtermen?? &#128269;</h5>
      </a>
    </div>
    <div class="col-12">
      <div class="collapse" id="collapseFiltermenu">
        <form class="mt-2 w-100" action="{{route('presentation')}}" method="get">
          <div class="row m-0 justify-content-center">
            <div class="col-6 p-0" style="border-right: 2px solid black;">
              <div class="row m-2 justify-content-end">
                <div class="col-4 ml-1 p-0">
                  <label for="department">Abteilung:</label>
                  <select class="form-control" name="department" id="department" style="width:218px;">
                    <option value="" @if(!request('department')) selected @endif disabled>W??hle die Abteilung</option>
                    <option value="1&1 DSL Retention" @if(request('department') == '1&1 DSL Retention') selected @endif>1&1 DSL Retention</option>
                    <option value="1&1 Mobile Retention" @if(request('department') == '1&1 Mobile Retention') selected @endif>1&1 Mobile Retention</option>
                  </select>
                </div>
                <div class="col-3 p-0 mr-2">
                  <label for="department">Welche MA:</label>
                  <select multiple class="form-control" name="employees[]" id="exampleFormControlSelect2" style="height: 150px; overflow:scroll;">

                  </select>
                </div>
              </div>
            </div>
            <div class="col-6 p-0">
              <div class="row m-2 justify-content-start">
                <div class="col-sm-3">
                  <label for="datefrom">Von:</label>
                   <input type="date" id="start_date" name="start_date" class="form-control" placeholder="" value="{{request('start_date')}}">
                 </div>
                 <div class="col-sm-3">
                   <label for="dateTo">Bis:</label>
                   <input type="date" id="end_date" name="end_date" class="form-control" placeholder="" value="{{request('end_date')}}">
                 </div>
              </div>
            </div>
          </div>
          <div class="col-12 p-0">
            <div class="row m-2 justify-content-center">
              <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
            </div>
          </div>
          </form>
      </div>
    </div>

  </div>
  <div class="row m-2 mt-4 justify-content-center align-self-center" >
    <div class="col-12">
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

      <div class="auswahl">
        <div class="subauswahl aktiv" id="allData">
          Alle Daten
        </div>
        <div class="subauswahl" id="teamleiterview" >
          Teamleiterdaten
        </div>
        <div class="subauswahl"  id="crview" >
          CR Daten
        </div>
        <div class="subauswahl"  id="timesview">
          Zeit Daten
        </div>
        <div class="subauswahl" id="revenueview" >
          Umsatz/SAS/Optin
        </div>
      </div>
      <table class="table table-borderless tablespacing text-white" id="tableoverview">
        <thead class="thead">
          <tr class="unit-translucent">
            <th>#</th>
            <th>Name</th>
            <th>AHT</th>
            <th>h bezahlt </th>
            <th>h anwesend</th>
            <th>h produktiv</th>
            <th>PQ</th>
            <th>1&1 PQ</th>
            <th>Saves</th>
            <th>GeVo Saves</th>
            <th>Calls</th>
            <th>Calls/h</th>
            <th>SSC</th>
            <th>BSC</th>
            <th>Portal</th>
            <th>SSE</th>
            <th>Saves/h</th>
            <th>RLZ+24 %</th>
            <th>GO CR</th>
            <th>RET GeVo CR</th>
            <th>RET GeVo CR 2</th>
            <th>SSC CR</th>
            <th>BSC CR</th>
            <th>Portal CR</th>
            <th>SaS</th>
            <th>OptIn</th>
            <th>Umsatz</th>
            <th>Umsatz/h bez</th>
            <th>Umsatz/h prod</th>
            <th>Kr h</th>
            <th>KQ</th>
            <th>Optionen</th>
          </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr class="unit-translucent">
            <td style="width: auto;  background-color: rgba(0,0,0,1);">{{$user->id}}</td>
            <td data-order="{{$user->lastname}}" style="text-align: left; background-color: rgba(0,0,0,1); "><span>{{$user->surname}} {{$user->lastname}}</span></td>
            <td data-order="{{$user->salesdata['aht']}}">
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
            @if($user->salesdata['payedtime11'] != 0)
              <td data-order="{{round($user->salesdata['productive']*100/$user->salesdata['payedtime11'],2)}}">{{round($user->salesdata['productive']*100/$user->salesdata['payedtime11']),2}}%</td>
            @else
              <td data-order="0">0%</td>
            @endif
            @if($user->department == '1&1 DSL Retention')
              <td data-order="{{$user->salesdata['orders']}}">{{$user->salesdata['orders']}}</td>
            @else
              <td data-order="{{$user->salesdata['sscOrders'] + $user->salesdata['bscOrders'] + $user->salesdata['portalOrders']}}">{{$sumSaves = $user->salesdata['sscOrders'] + $user->salesdata['bscOrders'] + $user->salesdata['portalOrders']}}</td>
            @endif
            <td data-order="{{$user->gevo->where('change_cluster','Upgrade')->count() + $user->gevo->where('change_cluster','Sidegrade')->count() +$user->gevo->where('change_cluster','Downgrade')->count()}}">
              <div class="center_items" style="position: relative; height: 65px; width: 100%;">
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
            <td data-order="{{$user->salesdata['calls']}}">{{$user->salesdata['calls']}}</td>
            @if($user->salesdata['workedHours'] != 0)
              <td data-order="{{round($user->salesdata['calls'] / $user->salesdata['workedHours'],2)}}">{{round($user->salesdata['calls'] / $user->salesdata['workedHours'],2)}}</td>
              @else
              <td data-order="0">0</td>
            @endif
            <td data-order="{{$user->salesdata['sscOrders']}}">{{$user->salesdata['sscOrders']}}</td>
            <td data-order="{{$user->salesdata['bscOrders']}}">{{$user->salesdata['bscOrders']}}</td>
            <td data-order="{{$user->salesdata['portalOrders']}}">{{$user->salesdata['portalOrders']}}</td>
            <td data-order="{{$user->salesdata['ssesaves']}}">{{$user->salesdata['ssesaves']}}</td>
            @if($user->salesdata['workedHours'] != 0)
              @if($user->department == '1&1 DSL Retention')
                <td>{{round($user->salesdata['ssesaves']/($user->salesdata['workedHours']),2)}}</td>
              @else
                <td>{{round($sumSaves/($user->salesdata['workedHours']),2)}}</td>
              @endif
            @else
              <td>0</td>
            @endif
            <td data-order="{{$user->salesdata['RLZ24Qouta']}}">{{$user->salesdata['RLZ24Qouta']}}%</td>
            <td>50</td>
            @if($user->department == '1&1 Mobile Retention')
              <td data-order="{{$user->salesdata['GeVo-Cr']}}" > {{$user->salesdata['GeVo-Cr']}}%</td>
            @else
              <td data-order="{{$user->salesdata['GeVo-Cr']}}" style= "font-size: 900; color: @if($user->salesdata['GeVo-Cr'] > 40) green @elseif ($user->salesdata['GeVo-Cr'] > 35) #ffc107 @else red @endif;"> {{$user->salesdata['GeVo-Cr']}}%</td>
            @endif
            <td data-order="{{$user->salesdata['gevocr2']}}">{{$user->salesdata['gevocr2']}}%</td>
            <td data-order="{{$user->salesdata['sscQuota']}}">{{$user->salesdata['sscQuota']}}%</td>
            <td data-order="{{$user->salesdata['bscQuota']}}">{{$user->salesdata['bscQuota']}}%</td>
            <td data-order="{{$user->salesdata['portalQuota']}}">{{$user->salesdata['portalQuota']}}%</td>
            <td data-order="{{$user->sasquota}}">{{$user->sasquota}}</td>
            <td data-order="{{$user->optinQuota}}">{{$user->optinQuota}}%</td>
            <td data-order="{{$user->salesdata['orders'] * $pricepersave}}">{{$user->salesdata['orders'] * $pricepersave}}???</td>
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
            <td data-order="{{$user->salesdata['sicknessquota']}}">{{$user->salesdata['sicknessquota']}}%</td>
            <!-- <td>round($user->salesdata['sicknessquota'],2)%</td> -->
            <td class="" style="text-align:center; font-size: 1.4em;">
              <a class="text-muted" href="{{route('user.stats', ['id' => $user->id])}}">
                <span class="material-icons text-white">preview</span>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="">
        <tr class="unit-translucent" id='footerdata'>
          <td>Total:</td>
          <td>1</td>
          <td id="aht">2</td>
          <td id="kdw">3</td>
          <td id="payed11avg">4</td>
          <td id="productive11avg">5</td>
          <td id="produktivequote">6</td>
          <td id="savessum">7</td>
          <td id="savessum">8</td>
          <td id="gevo">9</td>
          <td id="callsPerHourAVG">10</td>
          <td id="sscSum">11</td>
          <td id="bscSum">12</td>
          <td id="portalSum">13</td>
          <td id="sse">14</td>
          <td id="savesPerHourAVG">15</td>
          <td id="rlz">16</td>
          <td id="gocr">17</td>
          <td id="gevoCrAVG">18</td>
          <td id="gevocr2">18</td>
          <td id="sscCrAVG">19</td>
          <td id="bscCrAVG">20</td>
          <td id="portalCrAVG">21</td>
          <td id="sas">22</td>
          <td id="optin">23</td>
          <td id="revenue">28</td>
          <td id="revenuePerHourPayedAVG">29</td>
          <td id="revenuePerHourProductiveAVG">30</td>
          <td id="sick hours">31</td>
          <td id="sicknessquotaAVG">32</td>
          <td>total</td>
        </tr>
      </tfoot>
    </table>
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

<script type="text/javascript">
  $(document).ready(function(){

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
            $(api.column( 2 ).footer() ).html('<b>'+Math.round(api.column(2).data().average()*100)/100 +'s</b>');
            $(api.column( 3 ).footer() ).html('<b>'+Math.round(api.column(3).data().sum()) +'h</b>');
            $(api.column( 4 ).footer() ).html('<b>'+Math.round(api.column(4).data().sum()) +'h</b>')
            $(api.column( 5 ).footer() ).html('<b>'+Math.round(api.column(5).data().sum()) +'h</b>')
            $(api.column( 6 ).footer() ).html('<b>'+getQuota(6).toFixed(2)+'%</b>')
            $(api.column( 7 ).footer() ).html('<b>'+getQuota(7).toFixed(2)+'%</b>')
            $(api.column( 8 ).footer() ).html('<b>'+Math.round(api.column(8).data().sum()) +'</b>')
            $(api.column( 9 ).footer() ).html('<b>'+Math.round(api.column(9).data().sum()) +'</b>')
            $(api.column( 10 ).footer() ).html('<b>'+Math.round(api.column(10).data().average()) +'</b>')
            $(api.column( 11 ).footer() ).html('<b>'+Math.round(api.column(11).data().sum()) +'</b>')
            $(api.column( 12 ).footer() ).html('<b>'+Math.round(api.column(12).data().sum()) +'</b>')
            $(api.column( 13 ).footer() ).html('<b>'+Math.round(api.column(13).data().sum()) +'</b>')
            $(api.column( 14 ).footer() ).html('<b>'+Math.round(api.column(14).data().sum()) +'</b>')
            $(api.column( 15 ).footer() ).html('<b>'+(Math.round(api.column(15).data().average())*100)/100 +'/h</b>')
            $(api.column( 16 ).footer() ).html('<b>'+getQuota(16).toFixed(2)+'%</b>')
            $(api.column( 17 ).footer() ).html('<b>'+Math.round(api.column(17).data().average()) +'%</b>')
            $(api.column( 18 ).footer() ).html('<b>'+getQuota(18).toFixed(2)+'%</b>')
            $(api.column( 19 ).footer() ).html('<b>'+getQuota(19).toFixed(2)+'%</b>')
            $(api.column( 20 ).footer() ).html('<b>'+getQuota(20).toFixed(2)+'%</b>')
            $(api.column( 21 ).footer() ).html('<b>'+getQuota(21).toFixed(2)+'%</b>')
            $(api.column( 22 ).footer() ).html('<b>'+getQuota(22).toFixed(2)+'%</b>')
            $(api.column( 23 ).footer() ).html('<b>'+Math.round(api.column(23).data().sum()) +'???</b>')
            $(api.column( 24 ).footer() ).html('<b>'+Math.round(api.column(24).data().average()) +'???</b>')
            $(api.column( 25 ).footer() ).html('<b>'+Math.round(api.column(25).data().average()) +'???</b>')
            $(api.column( 26 ).footer() ).html('<b>'+Math.round(api.column(26).data().average()) +'h</b>')
            $(api.column( 27 ).footer() ).html('<b>'+Math.round(api.column(27).data().sum()) +'</b>')
            $(api.column( 28 ).footer() ).html('<b>'+Math.round(api.column(28).data().sum()) +'</b>')
            $(api.column( 29 ).footer() ).html('<b>'+getQuota(29).toFixed(2)+'%</b>')
            $(api.column( 30 ).footer() ).html('<b> test</b>')
            $(api.column( 31 ).footer() ).html('<b> Total</b>')
          },
          select: true,
          dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100],
              ['10', '25', '50 ', '100']
          ],
          buttons: [
                  { extend: 'csv', text: '<i class="fas fa-file-csv fa-2x"></i>' },
                  { extend: 'excel', text: '<i class="fas fa-file-excel fa-2x"></i>' },
                  // 'excel',
              ],
        rowReorder: true,
        colReorder: true,
        scrollX: true,
        scrollY: "600px",
        scrollCollapse: true,
        fixedColumns:   {
          leftColumns: 2,
          // rightColumns: 1,
        },
        fnInitComplete: function(){
           // $('#footerdata').style.display = 'hidden';
       },
       "columnDefs": [
            { "width": "60px", "targets": "_all" },
          ],
        });

        if (document.querySelector('.subauswahl')) {
          document.querySelectorAll('.subauswahl').forEach((elem) => {
            elem.addEventListener("click", function(event) {

              $('.subauswahl').each(function(){
                  this.className=''
                  this.className='subauswahl'
              });
              event.target.className = 'subauswahl aktiv';
              switch(event.target.id) {
                case 'allData':
                    table.colReorder.reset();
                    table.columns().visible( false );
                    table.columns().visible( true );
                    // table.draw()
                  break;
                case 'teamleiterview':
                  table.colReorder.reset();
                  table.columns().visible( false );

                  table.columns([0,1,3,4,30,29,6,7,8,9,15,16,17,23,24,25,27,31]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order([0,1,3,4,30,29,6,7,8,9,15,16,17,23,24,25,17,31]);
                  // table.colReorder.order([0,1,3,31,32,4,6,7,9,10,8,24,18,22,23,29,30]);
                  // table.colReorder.order( [0,1,3,4,31,32,5,7,9,10,8,17,18,23,24,25,27],true);
                  break;
                case 'crview':
                  table.colReorder.reset();
                  table.columns().visible( false );
                  table.columns([0,1,8,9,11,12,13,14,17,18,19,20,21,22,30,31]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order( [0,1,8,9,11,12,13,14,17,18,19,20,21,22,30,31]);
                  // table.columns.adjust().draw();
                break;
                case 'timesview':
                  table.colReorder.reset();
                  table.columns().visible( false );
                  table.columns([0,1,2,3,4,5,6,7,10,29,30]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order( [0,1,2,3,4,5,6,7,10,29,30]);
                  // table.columns.adjust().draw();
                break;
                case 'revenueview':
                  table.colReorder.reset();
                  table.columns().visible( false );
                  table.columns([0,1,22,23,24,25,26,27,28,29,30]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order( [0,1,28,29,30,27,26,25,24,22,23]);
                  // table.columns.adjust().draw();
                break;
              }

              // var item = event.target.id;

            });
          });
        }
        $('#department').change(function() {

          $('#exampleFormControlSelect2').empty()
          let dep = this.value
          var host = window.location.host;
          // axios.get('http://'+host+'/user/getUsersByDep/'+ dep)

          axios.get('http://'+host+'/user/getUsersByDep/'+ dep)
          // axios.get('http://'+host+'/care4as/care4as/public/user/getUsersByDep/'+ dep)
          .then(response => {
            // console.log(response)
            let users = response.data

            users.forEach(function(user){
              let option = document.createElement("option");
              let name = user.surname + ' ' + user.lastname;

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
            $('#failModal').modal('show')
            console.log(err.response);
          })
        })
      });
</script>
@endsection
