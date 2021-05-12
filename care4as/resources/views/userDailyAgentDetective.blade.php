@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row m-1 bg-light rounded">
    <form class="mt-2 w-100" action="{{route('user.startEnd')}}" method="get">
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
      <table class="table table-striped" id="userdata">
        <thead class="thead-dark">
          <tr>
            <th>User</th>
            <th>start</th>
            <th>ende</th>
            <th>gesamt</th>
            <th>produktiv</th>
            <th>abwesend</th>
            <th>Optionen</th>
          </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{$user->surname}} {{$user->lastname}}</td>
            <td>{{$user->start}} </td>
            <td>{{$user->last}}</td>
            <td></td>
            <td>{{$user->productive}}</td>
            <td>{{$user->away}}</td>
            <td>
              <a href="">
              <button class="btn btn-danger btn-fab btn-icon btn-round">
                  <i class="now-ui-icons ui-1_simple-remove"></i>
              </button>
              </a>
              <a href="">
              <button class="btn btn-success btn-fab btn-icon btn-round">
                <i class="now-ui-icons ui-1_zoom-bold"></i>
              </button>
              </a>
              <a href="">
              <button class="btn btn-primary btn-fab btn-icon btn-round">
                <i class="now-ui-icons ui-1_settings-gear-63"></i>
              </button>
              </a>
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

  let table = $('#userdata').DataTable({
    ordering: true,
  });

});
</script>

@endsection
