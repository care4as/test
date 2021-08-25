@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw; margin-top: 2em;">
  <div class="row unit-translucent">
    <div class="col text-center text-white" style="border-radius: 15px;">
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
      <div class="card-body">
          <div class="tab-content text-center">
              <div class="tab-pane active" id="userinfo">
                <table class="table tablespacing" id="userdata">
                <thead class="thead-dark">
                  <tr class="unit-translucent">
                    <th class="">#</th>
                    <th>username</th>
                    <th>Name</th>
                    <th>team</th>
                    <th>status</th>
                    <th>Abteilung</th>
                    <th>Rolle</th>
                    <th>Person-ID</th>
                    <th>Agent-ID</th>
                    <th>KDW-ID</th>
                    <th>Tracking-ID</th>
                    <th>options</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                    <tr class="unit-translucent">
                      <td>{{$user->id}}</td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->surname}} {{$user->lastname}} </td>
                      <td>{{$user->team}} </td>
                      <td>@if($user->status == 1) aktiv @else inaktiv @endif</td>
                      <td>{{$user->department}} </td>
                      <td>{{$user->role}}</td>
                      <td>{{$user->person_id}}</td>
                      <td>{{$user->agent_id}}</td>
                      <td>{{$user->ds_id}}</td>
                      <td>{{$user->tracking_id}}</td>
                      <td>
                        @if(in_array('deleteUser',Auth()->user()->getRights()))
                          <a href="{{route('user.delete', ['id' => $user->id])}}">
                          <button class="btn btn-danger btn-fab btn-icon btn-round">
                              <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                          </a>
                        @endif
                        <a href="{{route('user.stats', ['id' => $user->id])}}">
                        <button class="btn btn-success btn-fab btn-icon btn-round">
                          <i class="now-ui-icons ui-1_zoom-bold"></i>
                        </button>
                        </a>
                        <a href="{{route('user.deactivate', ['id'=> $user->id])}}">
                        <button class="btn btn-primary btn-fab btn-icon btn-round">
                          <i class="fas fa-pause"></i>
                        </button>
                        </a>
                        <a href="{{route('user.activate', ['id'=> $user->id])}}">
                        <button class="btn btn-primary btn-fab btn-icon btn-round">
                          <i class="far fa-play-circle"></i>
                        </button>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
              </div>
              <div class="tab-pane fade" id="userstats">
                <div class="row text-dark">
                  <table class="table table-striped">
                  <thead>
                    <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>Calls</th>
                    <th>Saves SSC</th>
                    <th>Cancels SSC</th>
                    <th>Service SSC</th>
                    <th>Saves BSC</th>
                    <th>Cancels BSC</th>
                    <th>Service BSC</th>
                    <th>Saves Portal</th>
                    <th>Cancels Portal</th>
                    <th>Service Portal</th>
                    <th>Optionen</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                      <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->sum('calls')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Retention')->sum('save')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Retention')->sum('cancel')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Retention')->sum('service')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Retention')->sum('save')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Retention')->sum('cancel')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Retention')->sum('service')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Retention')->sum('save')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Retention')->sum('cancel')}} @else 0 @endif</td>
                        <td>@if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Retention')->sum('service')}} @else 0 @endif</td>
                        <td>
                          <a href="">
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
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
<script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){

  let table = $('#userdata').DataTable({
    ordering: true,
    dom: 'Blfrtip',
    buttons: [
            // { extend: 'csv', text: '<i class="fas fa-file-csv fa-2x"></i>' },
            { extend: 'excel', text: '<i class="fas fa-file-excel fa-2x"></i>' },
            // 'excel',
        ],
  });
});
</script>

@endsection
