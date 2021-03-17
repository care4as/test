@extends('general_layout')

@section('additional_css')

<style media="screen">
  th, td
  {
    font-size: 0.8vw !important;
    text-align: left;
    min-width: 70px;
    overflow: hidden;
    text-overflow: ellipsis;

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

<div class="container-fluid bg-light m-1">
  <div class="row justify-content-center align-self-center m-1">
      <h4 >Präsentation des aktuellen Moduls: {{$modul ?? ''}}</h4>
  </div>

  <div class="row bg-white shadow m-1">
    <div class="col-12">
      <h4 class="text-center">Aktueller Datenstand:</h4>
    </div>
    <div class="col-8">
      <h5>Retention Details vom <u>{{Carbon\Carbon::parse(App\RetentionDetail::min('call_date'))->format('d.m.Y')}}</u> bis zum <u>{{Carbon\Carbon::parse(App\RetentionDetail::max('call_date'))->format('d.m.Y')}}</u></h5>
    </div>
    <div class="col-4">
    <a href="{{route('dailyagent.removeDuplicates')}}">  <button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a>
    </div>
    <div class="col-8">
      @if(!App\DailyAgent::min('date'))
        <h5>keine Daten eingegeben</h5>
      @else
        <h5>Daily Agent im Zeitraum vom <u>{{Carbon\Carbon::parse(App\DailyAgent::min('date'))->format('d.m.Y')}}</u>  bis zum <u>{{Carbon\Carbon::parse(App\DailyAgent::max('date'))->format('d.m.Y')}}</u> </h5>
      @endif
    </div>
    <div class="col-4">
      <a href="{{route('dailyagent.removeDuplicates')}}"><button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a>
    </div>
    <div class="col-8">
      @if(!App\Hoursreport::min('date'))
        <h5>keine Daten eingegeben</h5>
      @else
        <h5>Stundenreport im Zeitraum vom <u>{{Carbon\Carbon::parse(App\Hoursreport::min('date'))->format('d.m.Y H:i:s')}}</u>  bis zum <u>{{Carbon\Carbon::parse(App\Hoursreport::max('date'))->format('d.m.Y H:i:s')}}</u> </h5>
      @endif
    </div>
    <div class="col-2">
      <a href="{{route('hoursreport.removeDuplicates')}}"><button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a>
    </div>
    <div class="col-2">
      <a href="{{route('hoursreport.sync')}}"><button type="button" class="btn btn-sm btn-success border-round" name="button">Userdaten verknüpfen</button></a>
    </div>
  </div>

  <div class="row bg-white shadow  m-1 mt-4" id="filtermenu">
    <div class="col-12 d-flex justify-content-center align-self-center">
      <h5>Filtermenü</h5>
    </div>
    <div class="col-12">
      <form class="mt-2 w-100" action="{{route('presentation')}}" method="get">
        <div class="row m-0 justify-content-center">
          <div class="col-6 p-0" style="border-right: 2px solid black;">
            <div class="row m-2 justify-content-end">
              <div class="col-4 ml-1 p-0">
                <label for="department">Abteilung:</label>
                <select class="form-control" name="department" id="department" style="width:218px;">
                  <option value="" @if(!request('department')) selected @endif disabled>Wähle die Abteilung</option>
                  <option value="1&1 DSL Retention" @if(request('department') == '1&1 DSL Retention') selected @endif>1&1 DSL Retention</option>
                  <option value="1&1 Mobile Retention" @if(request('department') == '1&1 Mobile Retention') selected @endif>1&1 Mobile Retention</option>
                </select>
              </div>
              <div class="col-3 p-0 mr-2">
                <label for="department">Welche MA:</label>
                <select multiple class="form-control" name="employees[]" id="exampleFormControlSelect2" style="height: 50px; overflow:scroll;">
                  @if(request('department'))
                    @foreach($users1 = App\User::where('department',request('department'))->where('role','agent')->get() as $user)
                      <option value="{{$user->id}}">{{$user->surname}} {{$user->lastname}}</option>
                    @endforeach
                  @else
                    @foreach($users1 = App\User::where('role','agent')->where('department','1&1 Mobile Retention')->get() as $user)
                      <option value="{{$user->id}}">{{$user->surname}} {{$user->lastname}}</option>
                    @endforeach
                  @endif
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
    </div>
    <div class="col-12 p-0">
      <div class="row m-2 justify-content-center">
        <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
      </div>
    </div>
    </form>
  </div>
  <div class="row m-2 mt-4 bg-white shadow justify-content-center align-self-center" >
    <div class="col-12">

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

      <table class="table table-hover table-striped table-bordered table-responsive overflow-scroll" id="tableoverview">
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
            <th>KQ</th>
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
            <td>50</td>
            <td>{{$user->salesdata['sscOrders']}}</td>
            <td>{{$user->salesdata['bscOrders']}}</td>
            <td>{{$user->salesdata['portalOrders']}}</td>
            <td>50</td>
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
            <td>50</td>
            <td> {{$user->salesdata['GeVo-Cr']}}</td>
            <td>{{$user->salesdata['sscQuota']}}</td>
            <td>{{$user->salesdata['bscQuota']}}</td>
            <td>{{$user->salesdata['portalQuota']}}</td>
            <td>50</td>
            <td>{{$user->salesdata['orders'] * $pricepersave}}</td>
            @if(($user->salesdata['workedDays'] * $user->dailyhours) != 0)
              <td>{{round(($user->salesdata['orders'] * $pricepersave)/($user->salesdata['workedDays'] * $user->dailyhours),2)}}€</td>
            @else
              <td>Fehler</td>
            @endif
            @if($user->salesdata['workedHours'] != 0)
              <td>{{round(($user->salesdata['orders'] * $pricepersave) / $user->salesdata['workedHours'],2) }}€</td>
            @else
                <td>Fehler Arbeitsstunden</td>
            @endif
            <td>{{$user->salesdata['workedHours'] }} / {{$user->salesdata['sickHours'] }}</td>
            <!-- <td>round($user->salesdata['sicknessquota'],2)%</td> -->
            <td>
              <a href="{{route('user.stats', ['id' => $user->id])}}">anzeigen</a>
            </td>
          </tr>
        @endforeach
      </tbody>

  </table>
    </div>
  </div>
</div>

@endsection

@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>

<script type="text/javascript">
  $(document).ready(function(){

    let table = $('#tableoverview').DataTable({
      ordering: true,
    });

  });
</script>
@endsection
