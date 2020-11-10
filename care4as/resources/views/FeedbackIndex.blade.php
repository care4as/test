@extends('general_layout')

@section('content')
<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">

  <div class="row" id='firstLevelRow'>
    <div class="firstLevelCol w-100">
      <table class='table table-hover w-100'>
        <tr>
          <th>#</th>
          <th>title</th>
          <th>erstellt am</th>
          <th>erstellt von</th>
          <th>geändert am</th>
          <th>mit</th>
          <th>optionen</th>
        </tr>
          @foreach($feedbacks as $feedback)
            <tr>
              <td>{{$feedback->id}}</td>
              <td>{{$feedback->title}}</td>
              <td>{{$feedback->created_at}}</td>
              <td>{{$feedback->Creator->name}}</td>
              <td>{{$feedback->updated_at}}</td>
              <td>{{$feedback->withUser->name}}</td>
              <td><a href="{{route('feedback.show', ['id' => $feedback->id])}}"> <i class="now-ui-icons ui-1_zoom-bold"></i></a></td>
            </tr>
          @endforeach
      </table>

    </div>
  </div>
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
