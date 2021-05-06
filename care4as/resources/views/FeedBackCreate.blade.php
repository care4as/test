@extends('general_layout')

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
        <table class="table table-hover table-striped  table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>2021</th>
              <th>
                KW1
              </th>
              <th>
                KW2
              </th>
              <th>
                KW3
              </th>
              <th>
                KW4
              </th>
            </tr>
            <tr>
              <td>#</td>
              <td>KB | Team</td>
              <td>KB | Team</td>
              <td>KB | Team</td>
              <td>KB | Team</td>
            </tr>
          </thead>
          <tr>
            <td>Calls</td>
            <td>CallsKWfirst | CallTeamsKWfirst </td>
            <td>CallsKWsecond | CallTeamsKWsecond </td>
            <td>CallsKWthird | CallTeamsKWthird </td>
            <td>CallsKWfourth | CallTeamsKWfourth</td>

          </tr>
          <tr>
            <td>Saves SSC GeVo</td>
          </tr>
          <tr>
            <td>Saves BSC GeVo</td>
          </tr>
          <tr>
            <td>BCR Calls</td>
          </tr>
          <tr>
            <td>Saves Gesamt</td>
          </tr>
        </table>
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
