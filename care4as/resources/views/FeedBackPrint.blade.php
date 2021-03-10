@extends('general_layout')

@section('additional_css')
<style media="screen">
  tr
  {
    border: 2px solid black;
  }
  td
  {
    border: 2px solid black;
  }
  .printBorder
  {
    border: 2px solid black;
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
          <label for="lead_by">Gespräch geführt:</label>
          <select name="with_user" class="form-control w-25" id="lead_by" aria-describedby="title" autocomplete="off" onchange="location = this.value;">
            @foreach($users as $user)
              <option value="{{route('feedback.print' , ['userid' => $user->id])}}"   @if($user->id == request('userid')) selected @endif>{{$user->surname}} {{$user->lastname}}</option>
            @endforeach
          </select>
      </div>
    </div>
    @if(isset($userreport))
    <div class="row mt-3 bg-white">
      <div class="col-12 d-flex  justify-content-center">
        <table class="table table-hover table-striped" style="border: 3px solid black;">
          <thead class="thead-dark">
            <tr>
              <th>2021</th>
              <th>
                KW{{$weekperformance['3']['name']}}
              </th>
              <th>
                KW{{$weekperformance['2']['name']}}
              </th>
              <th>
                KW{{$weekperformance['1']['name']}}
              </th>
              <th>
                KW{{$weekperformance['0']['name']}}
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
            <td>{{$weekperformance['3']['calls']}} | <b>{{$weekperformance['3']['callsTeam']}}</b> </td>
            <td>{{$weekperformance['2']['calls']}} | <b>{{$weekperformance['2']['callsTeam']}}</b> </td>
            <td>{{$weekperformance['1']['calls']}} | <b>{{$weekperformance['1']['callsTeam']}}</b> </td>
            <td>{{$weekperformance['0']['calls']}} | <b>{{$weekperformance['0']['callsTeam']}}</b> </td>
          </tr>
          <tr>
            <td>Saves SSC GeVo (RET + PREV)</td>
            <td>{{$weekperformance['3']['savesssc']}} | <b>{{$weekperformance['3']['sscTeam']}}</b> </td>
            <td>{{$weekperformance['2']['savesssc']}} | <b>{{$weekperformance['2']['sscTeam']}}</b> </td>
            <td>{{$weekperformance['1']['savesssc']}} | <b>{{$weekperformance['1']['sscTeam']}}</b> </td>
            <td>{{$weekperformance['0']['savesssc']}} | <b>{{$weekperformance['0']['sscTeam']}}</b></td>
          </tr>
          <tr>
            <td>Saves BSC GeVo</td>
            <td>{{$weekperformance['3']['savesbsc']}} | <b>{{$weekperformance['3']['bscTeam']}}</b> </td>
            <td>{{$weekperformance['2']['savesbsc']}} |  <b>{{$weekperformance['2']['bscTeam']}}</b> </td>
            <td>{{$weekperformance['1']['savesbsc']}}  | <b>{{$weekperformance['1']['bscTeam']}}</b>  </td>
            <td>{{$weekperformance['0']['savesbsc']}}  | <b>{{$weekperformance['0']['bscTeam']}}</b> </td>
          </tr>
          <tr>
            <td>Portal Saves</td>
            <td>{{$weekperformance['3']['savesportal']}} | <b>{{$weekperformance['3']['portalTeam']}}</b>  </td>
            <td>{{$weekperformance['2']['savesportal']}} | <b>{{$weekperformance['2']['portalTeam']}}</b> </td>
            <td>{{$weekperformance['1']['savesportal']}}  | <b>{{$weekperformance['1']['portalTeam']}}</b> </td>
            <td>{{$weekperformance['0']['savesportal']}}  | <b>{{$weekperformance['0']['portalTeam']}}</b></td>
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
            <td>{{$weekperformance['3']['rlzPlus']/($weekperformance['3']['rlzPlus'] + $weekperformance['3']['mvlzneu'])}}</td>
            <td>{{$weekperformance['2']['rlzPlus']/($weekperformance['2']['rlzPlus'] + $weekperformance['2']['mvlzneu'])}}</td>
            <td>{{$weekperformance['1']['rlzPlus']/($weekperformance['1']['rlzPlus'] + $weekperformance['1']['mvlzneu'])}}</td>
            <td>{{$weekperformance['0']['rlzPlus']/($weekperformance['0']['rlzPlus'] + $weekperformance['0']['mvlzneu'])}}</td>
          </tr>
          <tr>
            <td>AHT</td>
            @if($userreport->agent_id)
            <td>{{$workdata[3]['aht']}}</td>
            <td>{{$workdata[2]['aht']}}</td>
            <td>{{$workdata[1]['aht']}}</td>
            <td>{{$workdata[0]['aht'] }}</td>
            @else
            <td colspan=4 class="text-center">keine Werte/ kein agent_id im Datensatz <a href="{{route('user.stats',['id' => $userreport->id])}}">zum User</a> </td>
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

<button onclick="printPage()" class="noPrint btn-lg border-round" > Drucken </button>

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
