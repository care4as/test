@extends('general_layout')

@section('content')
<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">
  <form class="" action="{{route('feedback.store')}}" method="post">
    @csrf
    <div class="row align-items-center">
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
    <div class="row">
      <div class="col">
          <label for="lead_by">Gespräch geführt:</label>
          <select name="with_user" class="form-control w-25" id="lead_by" aria-describedby="title" autocomplete="off">
            @foreach($users as $user)
              <option value="{{$user->id}}" >{{$user->name}}</option>
            @endforeach
          </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col float-right">
        <h5>Gesprächsinhalt:</h5>
      </div>
    </div>
    <div class="row">
      <div class="col w-100">
        <textarea name="content" class="form-control" rows="8" cols="200"></textarea>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <h5>Ziele:</h5>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <textarea name="goals" class="form-control" rows="8" cols="200"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col">
         <button type="submit" class="btn btn-block btn-lg btn-primary">Absenden</button>
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
