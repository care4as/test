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
    <div class="row ">
      <table class="table table-hover table-striped" >
        <thead class="thead-dark">
          <tr>
            <th>{{Carbon\Carbon::now()->year}}</th>
            <th>
              @php
                $week = Carbon\Carbon::now()->weekOfYear;
              @endphp
              KW{{$week -4}}
            </th>
            <th>
              KW{{$week - 3}}
            </th>
            <th>
              KW{{$week - 2}}
            </th>
            <th>
              KW{{$week - 1}}
            </th>
          </tr>
          <tr>
            <td>#</td>
            <td>KB | <b>Abteilung</b></td>
            <td>KB | <b>Abteilung</b></td>
            <td>KB | <b>Abteilung</b></td>
            <td>KB | <b>Abteilung</b></td>
          </tr>
        </thead>
        <tr>
          <td>Calls</td>
          <td>100</td>
          <td>100</td>
          <td>100</td>
          <td>100</td>
        </tr>
        <tr>
          <td>Saves SSC GeVo (RET + PREV)</td>
          <td>66</td>
          <td>66</td>
          <td>66</td>
          <td>66</td>
        </tr>
        <tr>
          <td>Saves BSC GeVo</td>
          <td>55</td>
          <td>55</td>
          <td>55</td>
          <td>55</td>
        </tr>
        <tr>
          <td>Portal Saves</td>
          <td>44</td>
          <td>44</td>
          <td>44</td>
          <td>44</td>
        </tr>
        <tr>
          <td>Saves Gesamt</td>
          <td>Saves Gesamt</td>
          <td>Saves Gesamt</td>
          <td>Saves Gesamt</td>
          <td>Saves Gesamt</td>
        </tr>
        <tr>
          <td>RLZ 24</td>
          <td>33</td>
          <td>33</td>
          <td>33</td>
          <td>33</td>
        </tr>
        <tr>
            <td>Anteil Pause</td>
            <td>22</td>
            <td>22</td>
            <td>22</td>
            <td>22</td>
        </tr>
        <tr>
          <td>Anteil Nacharbeit</td>
          <td>11</td>
          <td>11</td>
          <td>11</td>
          <td>11</td>
        </tr>
        <tr>
          <td>AHT</td>
          <td>1</td>
          <td>1</td>
          <td>1</td>
          <td>1</td>

        </tr>
      </table>
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
