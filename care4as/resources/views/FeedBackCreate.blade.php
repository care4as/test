@extends('general_layout')

@section('additional_css')

<style media="screen">

span{
  display:inline-block;
  width:45%;
  padding:0px
}
td,th
{
  width: 20%;
  text-align: center;
}
</style>
@endsection
@section('content')
<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">
  <div class="row bg-white">
    <div class="col">
        <label for="lead_by">Gespräch geführt mit:</label>
            <select name="with_user" class="form-control w-25" id="lead_by" aria-describedby="title" autocomplete="off" onchange="location = this.value;">
              @foreach($users as $user)
                <option value="{{route('feedback.view' , ['userid' => $user->id])}}"  @if($user->id == request('userid')) selected @endif >{{$user->surname}} {{$user->lastname}}</option>
              @endforeach
            </select>
      </div>
  </div>
  <form class="" action="{{route('feedback.store')}}" method="post">
    @csrf
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

    <div class="row mt-3 bg-white">
      <div class="col-12 d-flex  justify-content-center">
        <form class="" action="index.html" method="post">
          @csrf
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
              @for($i = 4; $i >= 1 ; $i--)
                <td><span><input type="text" name="Calls_KW{{$week - $i}}" class="form-control w-100 text-center" value="{{$weekperformance[$week - $i]['calls']}}"/> </span>|<span><input type="text" name="Calls_KW{{$week -$i}}" class="form-control text-center w-100" value="{{$weekperformance[$week -$i]['teamcalls']}}"/></span></td>
              @endfor

            </tr>
            <tr>
              <td>SSC GeVo CR</td>
              @for($i = 4; $i >= 1 ; $i--)
                <td><span><input type="text" name="Calls_KW{{$week - $i}}" class="form-control w-100 text-center" value="@if($weekperformance[$week - $i]['callsssc'] != 0) {{round(($weekperformance[$week - $i]['sscSaves']*100)/ $weekperformance[$week - $i]['callsssc'],2)}}% @else 0 @endif"/> </span>|<span><input type="text" name="Calls_KW{{$week -$i}}" class="form-control text-center w-100" value="@if($weekperformance[$week -$i]['teamcalls_ssc'] != 0) {{round(($weekperformance[$week -$i]['teamsaves_ssc']*100)/ $weekperformance[$week -$i]['teamcalls_ssc'],2)}}% @else 0 @endif"/></span></td>
              @endfor


            <tr>
              <td>BSC GeVo CR</td>
              @for($i = 4; $i >= 1 ; $i--)
                <td><span><input type="text" name="Calls_KW{{$week - $i}}" class="form-control w-100 text-center" value="@if($weekperformance[$week - $i]['callsbsc'] != 0) {{round(($weekperformance[$week - $i]['bscSaves']*100)/ $weekperformance[$week - $i]['callsbsc'],2)}}% @else 0 @endif"/> </span>|<span><input type="text" name="Calls_KW{{$week -$i}}" class="form-control text-center w-100" value="@if($weekperformance[$week -$i]['teamcalls_bsc'] != 0) {{round(($weekperformance[$week -$i]['teamsaves_bsc']*100)/ $weekperformance[$week -$i]['teamcalls_bsc'],2)}}% @else 0 @endif"/></span></td>
              @endfor
            </tr>
            <tr>
              <td>BSC Calls</td>
              @for($i = 4; $i >= 1 ; $i--)
                <td><span><input type="text" name="Calls_KW{{$week - $i}}" class="form-control w-100 text-center" value="{{$weekperformance[$week - $i]['callsbsc']}}"/> </span>|<span><input type="text" name="Calls_KW{{$week -$i}}" class="form-control text-center w-100" value="{{$weekperformance[$week -$i]['teamcalls_bsc']}}"/></span></td>
              @endfor
            </tr>
            <tr>
              <td>BSC Saves</td>
              @for($i = 4; $i >= 1 ; $i--)
                <td><span><input type="text" name="Calls_KW{{$week - $i}}" class="form-control w-100 text-center" value="{{$weekperformance[$week - $i]['callsbsc']}}"/> </span>|<span><input type="text" name="Calls_KW{{$week -$i}}" class="form-control text-center w-100" value="{{$weekperformance[$week -$i]['teamcalls_bsc']}}"/></span></td>
              @endfor
            </tr>
            <tr>
              <td>Portal Saves</td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
            </tr>
            <tr>
              <td>Saves Gesamt</td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
            </tr>
            <tr>
              <td>RLZ 24</td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
            </tr>
            <tr>
                <td>Anteil Pause</td>
                <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
                <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
                <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
                <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
            </tr>
            <tr>
              <td>Anteil Nacharbeit</td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
            </tr>
            <tr>
              <td>AHT</td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>
              <td><span><input type="text" name="Calls_KW{{$week -4}}" class="form-control w-100 text-center" value="100"/></span>|<span><input type="text" name="Calls_KW{{$week -4}}" class="form-control text-center w-100" value="1200"/></span></td>

            </tr>
          </table>

        </form>

      </div>
    </div>
    <div class="row mt-3 bg-white">
      <div class="col float-right">
        <h5>Gesprächsinhalt:</h5>
      </div>
    </div>
    <div class="row bg-white">
      <div class="col w-100">
        <textarea name="content" class="form-control" rows="8" cols="200"></textarea>
      </div>
    </div>
    <div class="row mt-3 bg-white">
      <div class="col">
        <h5>Ziele:</h5>
      </div>
    </div>
    <div class="row bg-white">
      <div class="col">
        <textarea name="goals" class="form-control" rows="8" cols="200"></textarea>
      </div>
    </div>
    <div class="row bg-white">
      <div class="col">
         <button type="submit" class="btn btn-block btn-lg btn-primary">Speichern</button>
      </div>
    </div>
  </form>
</div>

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
