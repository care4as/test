@extends('general_layout')

@section('additional_css')
<style media="screen">
  .table td, th
  {
    font-size: 0.8vw !important;
  }
  .loader {
  font-size: 2px;
  /* margin: 50px auto; */
  text-indent: -9999em;
  width: 11em;
  height: 11em;
  border-radius: 50%;
  /* background: #ffffff; */
  /* background: -moz-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: -webkit-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: -o-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: -ms-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: linear-gradient(to right, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  position: relative;
  -webkit-animation: load3 1.4s infinite linear;
  animation: load3 1.4s infinite linear;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.loader:before {
  width: 50%;
  height: 50%;
  background: #0dc5c1;
  border-radius: 100% 0 0 0;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
}
.loader:after {
  background: #ffffff;
  width: 75%;
  height: 75%;
  border-radius: 50%;
  content: '';
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
@-webkit-keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
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
    <div class="col-12">
      <form class="mt-2 w-100" action="{{route('presentation')}}" method="get">
        <div class="row m-0 justify-content-center">
          <div class="col-6 p-0" style="border-right: 2px solid black;">
            <div class="row m-2 justify-content-end">
              <div class="col-6 p-0">
                <label for="department">Abteilung:</label>
                <select class="form-control" name="department" id="department" style="width:218px;">
                  <option value="" @if(!request('department')) selected @endif disabled>Wähle die Abteilung</option>
                  <option value="1&1 DSL Retention" @if(request('department') == '1&1 DSL Retention') selected @endif>1&1 DSL Retention</option>
                  <option value="1&1 Mobile Retention" @if(request('department') == '1&1 Mobile Retention') selected @endif>1&1 Mobile Retention</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-6 p-0">
            <div class="row m-2 justify-content-start">
              <div class="col-sm-3">
                <label for="datefrom">Von:</label>
                 <input type="date" id="start_date" name="start_date" class="form-control" placeholder="">
               </div>
               <div class="col-sm-3">
                 <label for="dateTo">Bis:</label>
                 <input type="date" id="end_date" name="end_date" class="form-control" placeholder="">
               </div>
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
  <div class="row m-2 bg-white shadow justify-content-center align-self-center" >
    <div class="col p-1">
      @php
        if(request('department') == '1&1 DSL Retention')
        {
          $pricepersave = 15;
        }
        else
        {
          $pricepersave = 16;
        }
      @endphp
      <table class="table table-hover table-striped  table-bordered" id="tableoverview">
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
            <th>Umsatz({{$pricepersave}} )</th>
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
            <td>
              <div class="d-flex w-100 justify-content-center">
                <div class="loader" style="display:none;">Loading...</div>
                <div class="aht ">
                  <button type="button" name="button" class="btn-sm btn-info rounded" onclick="getAHT(1,2)">AHT</button>
                </div>
              </div>

            </td>
            @if($user->department == '1&1 DSL Retention')
              <td>{{$user->salesdata['orders']}}</td>
            @else
              <td>{{$sumSaves = $user->salesdata['sscOrders'] + $user->salesdata['bscOrders'] + $user->salesdata['portalOrders']}}</td>
            @endif
            <td>KüRü</td>
            <td>{{$user->salesdata['sscOrders']}}</td>
            <td>{{$user->salesdata['bscOrders']}}</td>
            <td>{{$user->salesdata['portalOrders']}}</td>
            <td>SSE</td>
            @if($user->dailyhours and $user->salesdata['workedDays'] != 0)
              @if($user->department == '1&1 DSL Retention')
                <td>{{round($user->salesdata['orders']/($user->salesdata['workedDays'] * $user->dailyhours),2)}}</td>
              @else
                <td>{{round($sumSaves/($user->salesdata['workedDays'] * $user->dailyhours),2)}}</td>
              @endif
            @else
              <td>fehler</td>
            @endif
            <td>{{$user->salesdata['RLZ24Qouta']}}</td>
            <td>Go CR</td>
            <td> {{$user->salesdata['GeVo-Cr']}}</td>
            <td>{{$user->salesdata['sscQuota']}}</td>
            <td>{{$user->salesdata['bscQuota']}}</td>
            <td>{{$user->salesdata['portalQuota']}}</td>
            <td>KüRü Quote?</td>
            <td>{{$user->salesdata['orders'] * $pricepersave}}</td>
            <td></td>
            <td></td>
            <td>
              <a href="{{route('user.stats', ['id' => $user->id])}}">anzeigen</a>
              /<a href="">löschen</a>
            </td>
          <tr>
        @endforeach
      </tbody>
  </table>
    </div>
  </div>
</div>

@endsection
