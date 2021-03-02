@extends('general_layout')

@section('additional_css')
<style media="screen">
  .table td, th
  {
    font-size: 0.8vw !important;
  }
</style>

@endsection

@section('content')

<div class="container-fluid bg-light m-1 ">
  <div class="row justify-content-center align-self-center">
      <h4>Präsentation des aktuellen Moduls: {{$modul ?? ''}}</h4>
  </div>
  <div class="row bg-white shadow  m-1" id="filtermenu">
    <div class="col-12 d-flex justify-content-center align-self-center">
      <h5>Filtermenü</h5>
    </div>
    <div class="col-12 d-flex justify-content-center align-self-center">
      <form class="mt-2 w-50" action="route('user.stats',['id' => $user->id])" method="get">
      <div class="col p-0">
        <div class="row m-2 justify-content-center">
          <div class="col-sm-3">
            <label for="datefrom">Von:</label>
             <input type="date" id="start_date" name="start_date" class="form-control" placeholder="">
           </div>
           <div class="col-sm-3">
             <label for="dateTo">Bis:</label>
             <input type="date" id="end_date" name="end_date" class="form-control" placeholder="">
           </div>
        </div>
        <div class="row m-2 justify-content-center">
          <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="row m-2 bg-white shadow justify-content-center align-self-center" >
    <div class="col p-1">
      <table class="table table-hover table-striped table-responsive table-bordered" id="tableoverview">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Team</th>
            <th>Calls</th>
            <th>Calls/h</th>
            <th>AHT</th>
            <th>Saves</th>
            <th>KÜRÜ</th>
            <th>SSC</th>
            <th>BSC</th>
            <th>Portal</th>
            <th>SSE</th>
            <th>Saves/h</th>
            <th>RLZ+24 %</th>
            <th>GO CR</th>
            <th>RET GeVo CR</th>
            <th>SSC CR</th>
            <th>BSC CR</th>
            <th>Portal CR</th>
            <th>KüRü CR</th>
            <th>Umsatz</th>
            <th>Umsatz/h bez</th>
            <th>Umsatz/h Std. prod</th>
            <th>Optionen</th>
          </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->surname}} {{$user->lastname}}</td>
            <!-- <td>{{$user->name}}</td> -->
            <td>{{$user->team}}</td>
            <td>{{$user->salesdata['calls']}}</td>
            @if($user->dailyhours and $user->salesdata['workedDays'] != 0)
              <td>{{round($user->salesdata['calls'] / ($user->salesdata['workedDays']* $user->dailyhours),2)}}</td>
              @else
              <td>@if(!$user->dailyhours) Fehler Agent @else Fehler Retention Details @endif</td>
            @endif
            <td>dailyAgent</td>
            <td>{{$sumSaves = $user->salesdata['sscOrders'] + $user->salesdata['bscOrders'] + $user->salesdata['portalOrders']}}</td>
            <td>KüRü</td>
            <td>{{$user->salesdata['sscOrders']}}</td>
            <td>{{$user->salesdata['bscOrders']}}</td>
            <td>{{$user->salesdata['portalOrders']}}</td>
            <td>SSE</td>
            @if($user->dailyhours and $user->salesdata['workedDays'] != 0)
              <td>{{round($sumSaves/($user->salesdata['workedDays'] * $user->dailyhours),2)}}</td>
              @else
              <td>fehler</td>
              @endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              anzeigen/<a href="">löschen</a>
            </td>
          <tr>
        @endforeach
      </tbody>
  </table>
    </div>
  </div>
</div>

@endsection
