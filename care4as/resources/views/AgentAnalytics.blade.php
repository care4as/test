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
                  <th>TestID2</th>
                  <td>testwert</td>
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
        <div class="col-12 d-flex justify-content-center">
          {{$reports->appends(Request::except('page'))->links()}}
        </div>
        <div class="col">
          <div class="d-flex p-3 w-100 justify-content-center">
            <table class="table table-bordered w-50" style="width:;">
              <tr>
                <th>Datum</th>
                <th>Calls handled</th>
                <th>Abschlüsse</th>
                <th>Tages CR</th>
                <th>vergebenes Guthaben</th>
                <th>VLZ 24 Monate neu</th>
                <th>VLZ RLZ + 24 Monate</th>
              </tr>
              @foreach($reports as $report)
              <tr>
                <td>{{$report->call_date}}</td>
                <td>{{$report->calls_handled}}</td>
                <td>{{$report->Orders_TWVVL_RET + $report->Orders_TWVVL_PREV}}</td>
                @php $CR = (($report->Orders_TWVVL_RET + $report->Orders_TWVVL_PREV) / $report->calls_handled)*100 @endphp
                <td style="@if($CR < 40) background-color: red; color: white;@endif"> {{round($CR,2)}}</td>

                <td>{{$report->Rabatt_Guthaben_Brutto_Mobile}}</td>
                <td>{{$report->MVLZ_Mobile}}</td>
                <td>{{$report->RLZ_Plus_MVLZ_Mobile}}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
        <div class="col d-block align-items-center">
          <div class="row w-100 justify-content-center">
            <div class="d-flex w-100 justify-content-center">
              <h4>Gesamt</h4>
            </div>

            <div class="d-flex w-100 justify-content-center">
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
                  <td style="@if($RLZQoute < 80) background-color: red; color: white;@endif">@if($sumrlz24 + $sumNMlz == 0) 0 @else {{round($RLZQoute,2)}} @endif</td>
                </tr>
              </table>
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
      </div>
    </div>
  </div>
</div>
@endsection
