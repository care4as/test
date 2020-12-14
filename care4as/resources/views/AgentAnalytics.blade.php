@extends('general_layout')

@section('content')
<div class="container-fluid mt-5" style="border-radius: 15px;width: 75vw;">
  <a href="{{ url()->previous() }}" class="btn btn-rounded btn-primary btn-outline">Zurück</a>
  <div class="row bg-light" id="mainrow"  style="border-radius: 35px;">
    <div class="col p-0" id="maincol">
      <div class="row m-0">
        <div class="col">
          <h4 class="text-center">{{$user->name}}</h4>
          <div class="row m-1 p-3 justify-content-center" style="background-color: rgba(0,0,0, 0.1);">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAeh7PE8nk_9Ya4K06e8OkFWBAeqHOfamUuKOdOVDN&s" alt="" style="width: 160px; border-radius: 45%; border: 2px solid black; opacity: 1;">
          </div>
        </div>
        <div class="col">
        <h4 class="text-left">Daten</h4>
          <div class="row p-3 justify-content-left">
            <form class="" action="{{route('user.update', ['id' => $user->id])}}" method="post">
              @csrf
              <table class="table table-bordered w-50" style="">
                <tr>
                  <th>test</th>
                  <td>testname</td>
                </tr>
                <tr>
                  <th>Alter</th>
                  <td>testname</td>
                </tr>
                <tr>
                  <th>PersonID</th>
                  <td><input type="text" name="person_id" value="{{$user->person_id}}"></td>
                </tr>
                <tr>
                  <th>tägliche Arbeitszeit</th>
                  <td><input type="text" name="dailyhours" value="{{$user->dailyhours}}"></td>
                </tr>
              </table>
              <button type="submit" class="btn btn-rounded btn-primary rounded-pill"name="button">Daten ändern</button>
            </form>

          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col">
          <h2 class="text-center">Statistiken laut Retention Details</h2>
        </div>
      </div>
      <div class="row">
        <div class="col d-block align-items-center">
          <div class="row w-100 justify-content-center">
            <div class="d-flex w-100 justify-content-center">
              <h4>Gesamt</h4>
            </div>
            <div class="d-flex w-100 justify-content-center">
              @if($user->person_id)
              <table class="table table-hover w-50">
                <tr>
                  <th>Calls</th>
                  <th>Abschlüsse</th>
                  <th>RLZ +24</th>
                  <th>24 Monate</th>
                  <th>Anteil RLZ+24</th>
                </tr>
                <tr>
                  <td>{{$sumcalls}}</td>
                  <td>{{$sumorders}}</td>
                  <td>{{$sumrlz24 }}</td>
                  <td>{{$sumNMlz}}</td>
                  @php $RLZQoute =  ($sumrlz24 / ($sumrlz24 + $sumNMlz))*100; @endphp
                  <td style="@if($RLZQoute < 70) background-color: red; color: white;@endif">@if($sumrlz24 + $sumNMlz == 0) 0 @else {{round($RLZQoute,2)}} @endif</td>
                </tr>
              </table>
              @endif
            </div>

          </div>
          <hr width="40%" size="5" align="center" >
            <div class="row m-0 w-100">
              <form class="mt-2 w-100" action="{{route('user.stats',['id' => $user->id])}}" method="get">
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

        <div class="col-12 d-flex justify-content-center mt-3">
          {{$reports->appends(Request::except('page'))->links()}}
        </div>
        <div class="col">
          <div class="d-flex p-3 w-100 justify-content-center">
            @if($user->person_id)
            <table class="table table-bordered w-50" style="width:auto;">
              <tr>
                <th>Datum</th>
                <th>Calls</th>
                <th>Calls/hour</th>
                <th>Abschlüsse</th>
                <th>GeVo-CR</th>
                <th>SSC Calls/<b>Abschlüsse</b></th>
                <th>BSC Calls/<b>Abschlüsse</b></th>
                <th>Portale Calls/<b>Abschlüsse</b></th>
                <th>SSC CR</th>
                <th>BSC CR</th>
                <th>Portale CR</th>
                <th>Opt-In</th>

                <!-- <th>vergebenes Guthaben</th> -->
                <th>24 Monate</th>
                <th>RLZ+24</th>
              </tr>
              @foreach($reports as $report)
              <tr>
                <td>{{$report->call_date}}</td>
                <td>{{$report->calls}}</td>
                <td>@if($user->dailyhours) round($report->calls/$user->dailyhours,2) @else keine Arbeitszeit eingetragen @endif</td>
                <td>{{$report->orders}}</td>
                @php $CR = (($report->orders) / $report->calls)*100;

                  if($report->calls_smallscreen == 0)
                  {
                    $sscCR = 0;
                  }

                  else
                  {
                     $sscCR = (($report->orders_smallscreen) / $report->calls_smallscreen)*100;
                  }

                  if($report->calls_bigscreen == 0)
                  {

                    $bscCR = 0;
                  }
                  else
                  {
                    $bscCR = (($report->orders_bigscreen) / $report->calls_bigscreen)*100;
                  }
                  if($report->calls_portale == 0)
                  {
                     $portalCR = 0;
                  }
                  else
                  {
                    $portalCR = (($report->orders_portale) / $report->calls_portale)*100;
                  }
                @endphp
                <td @if($CR < 40) class="tooLow" @endif> {{round($CR,2)}}</td>

                <td>{{$report->calls_smallscreen}}/ <b>{{$report->orders_smallscreen}}</b> </td>
                <td>{{$report->calls_bigscreen}}/<b>{{$report->orders_bigscreen}}</b></td>
                <td>{{$report->calls_portale}}/<b>{{$report->orders_portale}}</b></td>
                <td @if($sscCR < 46 && $report->calls_smallscreen != 0) class="tooLow" @elseif($report->calls_smallscreen == 0) class="stillOK"  @endif> {{round($sscCR,2)}}</td>
                <td @if($bscCR < 17 && $report->calls_bigscreen != 0) class="tooLow" @elseif($report->calls_bigscreen == 0) class="stillOK" @endif> {{round($bscCR,2)}}</td>
                <td @if($portalCR < 60 && $report->calls_portale != 0) class="tooLow" @elseif($report->calls_portale == 0) class="stillOK" @endif> {{round($portalCR,2)}}</td>
                <td>noch keine Datenquelle</td>
                <!-- <td>{{$report->Rabatt_Guthaben_Brutto_Mobile}}</td> -->
                <td>{{$report->mvlzNeu}}</td>
                <td>{{$report->rlzPlus}}</td>
              </tr>
              @endforeach
            </table>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
