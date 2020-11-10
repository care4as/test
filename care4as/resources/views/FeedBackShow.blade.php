@extends('general_layout')

@section('content')

<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">
  <form class="" action="{{route('feedback.update')}}" method="post">
    @csrf
    <input type="hidden" name="feedbackid" value="{{$feedback->id}}">
    <div class="row align-items-center">
      <div class="col">
        <label for="title">Titel:</label>
        <input type="text" name="title" value="{{$feedback->title}}" placeholder="Titel"  class="form-control w-50" id="title" aria-describedby="title" @if(!$feedback->creator == Auth::id()) disabled @endif>
      </div>
      <div class="col w-100 m-2">
        <div class="d-block float-right">
          <table class="">
            <tr>
              <td>Ersteller:</td>
              <td> <input type="text" name="creator" value="{{$feedback->Creator->name}}" placeholder="Titel" class="form-control" id="creator" aria-describedby="creator" disabled></td>
            </tr>
            <tr class="">
              <td>erstellt am:</td>

              <td> <input type="date" name="date" value="{{$feedback->created_at->format('yy-m-d')}}" @if($feedback->creator != Auth::id()) disabled @endif></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
          <label for="lead_by">Gespräch geführt mit:</label>
          <select name="with_user" class="form-control w-25" id="with_user" aria-describedby="title" autocomplete="off" @if($feedback->creator != Auth::id()) disabled @endif>
            @foreach($users as $user)
             <option value="{{$user->id}}" @if($user->id == $feedback->with_user)  {{'selected'}} @endif>{{$user->name}} </option>
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
      <div class="col w-100" style="height: 20em;">
        <textarea name="content" class="form-control" rows="20" cols="200" style="max-height: 100%;" @if($feedback->creator != Auth::id()) disabled @endif>{{$feedback->content}}</textarea>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <h5>Ziele:</h5>
      </div>
    </div>
    <div class="row">
      <div class="col" style="height: 20em;">
        <textarea name="goals" class="form-control" rows="20" cols="200" style="max-height: 100%;" @if($feedback->creator != Auth::id()) disabled @endif>{{$feedback->goals}}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col">
         <button type="submit" class="btn btn-block btn-lg btn-primary" @if($feedback->creator != Auth::id()) disabled @endif>Ändern</button>
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
