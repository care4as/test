@extends('general_layout')

@section('additional_css')
<style media="screen">
td
{
  border: 2px solid black;
  border-collapse: collapse;
}
th
{
  border: 2px solid black;
  border-collapse: collapse;
}
</style>
<style media="print">

  td
  {
    border: 2px solid black;
    border-collapse: collapse;
  }
  th
  {
    border: 2px solid black;
    border-collapse: collapse;
  }
  .printBorder
  {
    border: 2px solid black;
  }
  .no-print
  {
      display: none !important;
  }

  .page-break
  {
      page-break-after: always;
  }

  .last-page{
      page-break-after: avoid;
  }

</style>
@endsection
@section('content')
<div class="container-fluid bg-light printer" style="width: 75vw; border-radius: 15px;">
    <div class="row bg-white align-items-center">
      <div class="col">
        <label for="title">Titel:</label>
        <input type="text" name="title" value="" placeholder="Titel"  class="form-control w-50" id="title" aria-describedby="title">
      </div>
      <div class="col w-100 m-2">
        <div class="d-block float-right">
          <table class="">
            <tr>
              <td>Ersteller:</td>
              <td> <input type="text" name="creator" value="" placeholder="Titel" class="form-control" id="creator" aria-describedby="creator" disabled></td>
            </tr>
            <tr class="">
              <td>erstellt am:</td>
              <td> <input type="date" name="title" value="19.09.84" disabled></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="row bg-white">
      <div class="col">
          <label for="lead_by">Gespräch geführt mit:</label>
          <select name="with_user" class="form-control w-25" id="lead_by" aria-describedby="title" autocomplete="off" onchange="location = this.value;">
            @foreach($users as $user)
              <option value="{{route('feedback.print' , ['userid' => $user->id])}}"   @if($user->id == request('userid')) selected @endif>{{$user->name}}</option>
            @endforeach
          </select>
      </div>
    </div>
    @if(isset($userreport))
    <div class="row mt-3 bg-white">
      <div class="col-12 d-flex  justify-content-center">
        <table class="table table-hover table-striped" >
          <thead class="thead-dark">
            <tr>
              <th>{{Carbon\Carbon::now()->year}}</th>
              <th>
                @php
                  $week = Carbon\Carbon::now()->weekOfYear;
                @endphp
                KW{{$week -4}}
              </th>
              <th>
                KW{{$week - 3}}
              </th>
              <th>
                KW{{$week - 2}}
              </th>
              <th>
                KW{{$week - 1}}
              </th>
            </tr>
            <tr>
              <td>#</td>
              <td>KB | <b>Abteilung</b></td>
              <td>KB | <b>Abteilung</b></td>
              <td>KB | <b>Abteilung</b></td>
              <td>KB | <b>Abteilung</b></td>
            </tr>
          </thead>
          <tr>
            <td>Calls</td>
            <td>{{$weekperformance['3']['calls']}} | <b>{{$teamweekperformance['3']['callsTeam']}}</b> </td>
            <td>{{$weekperformance['2']['calls']}} | <b>{{$teamweekperformance['2']['callsTeam']}}</b> </td>
            <td>{{$weekperformance['1']['calls']}} | <b>{{$teamweekperformance['1']['callsTeam']}}</b> </td>
            <td>{{$weekperformance['0']['calls']}} | <b>{{$teamweekperformance['0']['callsTeam']}}</b> </td>
          </tr>
          <tr>
            <td>Saves SSC GeVo (RET + PREV)</td>
            <td>{{$weekperformance['3']['savesssc']}} | <b>{{$teamweekperformance['3']['sscTeam']}}</b> </td>
            <td>{{$weekperformance['2']['savesssc']}} | <b>{{$teamweekperformance['2']['sscTeam']}}</b> </td>
            <td>{{$weekperformance['1']['savesssc']}} | <b>{{$teamweekperformance['1']['sscTeam']}}</b> </td>
            <td>{{$weekperformance['0']['savesssc']}} | <b>{{$teamweekperformance['0']['sscTeam']}}</b></td>
          </tr>
          <tr>
            <td>Saves BSC GeVo</td>
            <td>{{$weekperformance['3']['savesbsc']}} | <b>{{$teamweekperformance['3']['bscTeam']}}</b> </td>
            <td>{{$weekperformance['2']['savesbsc']}} |  <b>{{$teamweekperformance['2']['bscTeam']}}</b> </td>
            <td>{{$weekperformance['1']['savesbsc']}}  | <b>{{$teamweekperformance['1']['bscTeam']}}</b>  </td>
            <td>{{$weekperformance['0']['savesbsc']}}  | <b>{{$teamweekperformance['0']['bscTeam']}}</b> </td>
          </tr>
          <tr>
            <td>Portal Saves</td>
            <td>{{$weekperformance['3']['savesportal']}} | <b>{{$teamweekperformance['3']['portalTeam']}}</b>  </td>
            <td>{{$weekperformance['2']['savesportal']}} | <b>{{$teamweekperformance['2']['portalTeam']}}</b> </td>
            <td>{{$weekperformance['1']['savesportal']}}  | <b>{{$teamweekperformance['1']['portalTeam']}}</b> </td>
            <td>{{$weekperformance['0']['savesportal']}}  | <b>{{$teamweekperformance['0']['portalTeam']}}</b></td>
          </tr>
          <tr>
            <td>Saves Gesamt</td>
            <td>Saves Gesamt</td>
            <td>Saves Gesamt</td>
            <td>Saves Gesamt</td>
            <td>Saves Gesamt</td>
          </tr>
          <tr>
            <td>RLZ 24</td>
            @if($weekperformance['3']['rlzPlus'] + $weekperformance['3']['mvlzneu'] == 0)
              <td class="tooLow  border-white">Fehler RLZ24 + MVLZ ergibt 0</td>
            @else
              <td>{{round($weekperformance['3']['rlzPlus']/($weekperformance['3']['rlzPlus'] + $weekperformance['3']['mvlzneu'])*100,2)}}%</td>
            @endif
            @if($weekperformance['2']['rlzPlus'] + $weekperformance['2']['mvlzneu'] == 0)
              <td class="tooLow  border-white">Fehler: RLZ24 + MVLZ ergibt 0</td>
            @else
              <td>{{round($weekperformance['2']['rlzPlus']/($weekperformance['2']['rlzPlus'] + $weekperformance['2']['mvlzneu']),2)*100}}%</td>
            @endif
            @if($weekperformance['1']['rlzPlus'] + $weekperformance['1']['mvlzneu'] == 0)
              <td class="tooLow  border-white">Fehler: RLZ24 + MVLZ ergibt 0</td>
            @else
              <td>{{round($weekperformance['1']['rlzPlus']/($weekperformance['1']['rlzPlus'] + $weekperformance['1']['mvlzneu']),2)*100}}%</td>
            @endif
            @if($weekperformance['0']['rlzPlus'] + $weekperformance['0']['mvlzneu'] == 0)
              <td class="tooLow  border-white">Fehler RLZ24 + MVLZ ergibt 0</td>
            @else
              <td>{{round($weekperformance['0']['rlzPlus']/($weekperformance['0']['rlzPlus'] + $weekperformance['0']['mvlzneu']),2)*100}}%</td>
            @endif
          </tr>
          <tr>
              <td>Anteil Pause</td>
              @if($workdata[3]['gesamt'] == 0)
                <td class="tooLow">Fehler DailyAgent </td>
              @else
                <td>{{ round(($workdata[3]['pause']*100)/$workdata[3]['gesamt'],2) }}%</td>
              @endif
              @if($workdata[2]['gesamt'] == 0)
                <td class="tooLow">Fehler DailyAgent </a></td>
              @else
                <td>{{ round(($workdata[2]['pause']*100)/$workdata[2]['gesamt'],2) }}%</td>
              @endif
              @if($workdata[1]['gesamt'] == 0)
                <td class="tooLow">Fehler DailyAgent </td>
              @else
                <td>{{ round(($workdata[1]['pause']*100)/$workdata[1]['gesamt'],2) }}%</td>
              @endif
              @if($workdata[0]['gesamt'] == 0)
                <td class="tooLow">Fehler DailyAgent </td>
              @else
                <td>{{ round(($workdata[0]['pause']*100)/$workdata[0]['gesamt'],0) }}%</td>
              @endif
          </tr>
          <tr>
            <td>Anteil Nacharbeit</td>
            @if($workdata[3]['gesamt'] == 0)
              <td class="tooLow">Gesamtzeit ergibt 0</td>
            @else
              <td>{{ round(($workdata[3]['nacharbeit']*100)/$workdata[3]['gesamt'],2) }}%</td>
            @endif
            @if($workdata[2]['gesamt'] == 0)
              <td class="tooLow">Gesamtzeit ergibt 0</td>
            @else
              <td>{{ round(($workdata[2]['nacharbeit']*100)/$workdata[2]['gesamt'],2) }}%</td>
            @endif
            @if($workdata[1]['gesamt'] == 0)
              <td class="tooLow">Gesamtzeit ergibt 0</td>
            @else
              <td>{{ round(($workdata[1]['nacharbeit']*100)/$workdata[1]['gesamt'],2) }}%</td>
            @endif
            @if($workdata[0]['gesamt'] == 0)
              <td class="tooLow">Gesamtzeit ergibt 0</td>
            @else
              <td>{{ round(($workdata[0]['nacharbeit']*100)/$workdata[0]['gesamt'],2) }}%</td>
            @endif
          </tr>
          <tr>
            <td>AHT</td>
            @if($userreport->agent_id)
              <td>{{round($workdata[3]['aht'],0)}}</td>
              <td>{{round($workdata[2]['aht'],0)}}</td>
              <td>{{round($workdata[1]['aht'],0)}}</td>
              <td>{{round($workdata[0]['aht'],0)}}</td>
            @else
              <td class="text-center">keine Werte/ kein agent_id im Datensatz <a class="no-print" href="{{route('user.stats',['id' => $userreport->id])}}">zum User</a> </td>
            @endif
          </tr>
        </table>
      </div>
    </div>
    @endif
    <div class="row mt-3 bg-white">
      <div class="col w-100 d-flex justify-content-center">
        <h5>Gesprächsinhalt:</h5>
      </div>
    </div>
    <div class="row bg-white justify-content-center">
      <div class="col w-100 d-flex justify-content-center">
        <textarea name="content" class="printBorder" rows="8" cols="200" style="height: 300px; max-width: 100%"></textarea>
      </div>
    </div>
    <div class="row mt-3 bg-white">
      <div class="col w-100 d-flex justify-content-center">
        <h5>Ziele:</h5>
      </div>
    </div>
    <div class="row bg-white ">
      <div class="col w-100 d-flex justify-content-center">
      <textarea name="content" class="printBorder" rows="8" cols="200" style="height: 300px; max-width: 100%"></textarea>
      </div>
    </div>

</div>

<button onclick="printPage()" class="no-print btn-lg border-round" > Drucken </button>

@endsection
@section('additional_js')
<script>
  $(document).ready(function() {
    $(function () {
    $('[data-toggle="popover"]').popover()
  })

    // Javascript method's body can be found in assets/js/demos.js
    // demo.initDashboardPageCharts();

  });
</script>
@endsection
