@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row ">
    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
      <div class="card card-nav-tabs card-plain">
      <div class="card-header card-header-danger">
          <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
          <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
              <ul class="nav nav-tabs" data-tabs="tabs">
                  <li class="nav-item">
                      <a class="nav-link active" href="#userinfo" data-toggle="tab">Userdaten</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#userstats" data-toggle="tab">Userstatistiken</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#history" data-toggle="tab">Weitere Funktion</a>
                  </li>
              </ul>
            </div>
          </div>
      </div>
      <div class="card-body ">
          <div class="tab-content text-center">
            <h2 class="text-dark">DailyAgent {{$user->surname}} {{$user->lastname}}</h2>
              <div class="tab-pane active" id="userinfo">
                <table class="table table-striped" id="userdata">
                <thead class="thead-dark">
                  <tr>
                    <th class="">#</th>
                    <th>Datum</th>
                    <th>status</th>
                    <th>start</th>
                    <th>ende</th>
                    <th>Zeit</th>
                    <th>options</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user->dailyAgent as $day)
                    <tr>
                      <td>{{$day->id}}</td>
                      <td>{{$day->date}}</td>
                      <td>{{$day->status}}</td>
                      <td>{{$day->start_time}}</td>
                      <td>{{$day->end_time}}</td>
                      <td>{{round($day->time_in_state/60,0)}}</td>

                      <td>X</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
              </div>
              <div class="tab-pane fade" id="userstats">

              </div>
            </div>

            <div class="tab-pane" id="history">
            </div>
          </div>
      </div>
    </div>
    </div>
  </div>
</div>

@endsection

@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script type="text/javascript">
$(document).ready(function(){

  let table = $('#userdata').DataTable({
    ordering: true,
  });

});
</script>

@endsection
