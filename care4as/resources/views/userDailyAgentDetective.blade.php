@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row m-1 bg-light rounded">
    <form class="mt-2 w-100" action="{{route('user.daDetex.index')}}" method="get">
      @csrf
      <div class="row m-0">
        <div class="col p-0">
          <div class="row m-2 justify-content-center">
            <div class="col-sm-3">
              <label for="datefrom">Von:</label>
               <input type="date" id="datefrom" name="start_date" class="form-control" placeholder="">
             </div>
             <div class="col-sm-3">
               <label for="dateTo">Bis:</label>
               <input type="date" id="dateTo" name="end_date" class="form-control" placeholder="">
             </div>
          </div>
          <div class="row m-2 justify-content-center">
            <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="row m-1">
    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
    @if($users->first())
      <table class="table table-striped" id="userdata">
        <thead class="thead-dark">
          <tr>
            <th>User</th>
            <th>start</th>
            <th>ende</th>
            <th>gesamt</th>
            <th>produktiv</th>
            <th>produktivquote</th>
            <th>on Hold</th>
            <th>away</th>
            <th>occupied</th>
            <th>screenbreak</th>
            <th>Optionen</th>
          </tr>
      </thead>
      <tbody>

          @foreach($users as $user)
          @if($user)
            <tr>
              <td>{{$user->surname}} {{$user->lastname}}</td>
              <td>
                @if($user->start)
                  {{$user->start}}
                @else
                  keine Daten für den {{Carbon\Carbon::today()->subDays(1)->format('d.m')}}.
                @endif
                </td>
              <td>{{$user->last}} </td>
              <td>{{$user->whole}} </td>
              <td>{{$user->productive}} h</td>
              <td>{{$user->prquota}} %</td>
              <td>{{$user->onhold}}</td>
              <td>{{$user->away}}</td>
              <td>{{$user->occu}}</td>
              <td>{{$user->screenbreak}}</td>
              <td>

                <a href="{{route('user.daDetex.single', ['id' => $user->id])}}">
                <button class="btn btn-success btn-fab btn-icon btn-round">
                  <i class="now-ui-icons ui-1_zoom-bold"></i>
                </button>
                </a>

              </td>
            </tr>
            @endif
          @endforeach

      </tbody>
  </table>
  @else
  <h4 class="text-dark">bisher keine Daten eingepflegt</h4>

  @endif
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
