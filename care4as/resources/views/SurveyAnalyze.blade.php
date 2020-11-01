
@extends('general_layout')

@section('content')

<div class="container-fluid" style="width: 75vw;">
  <div class="row ">
    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
      
      <table class="table table-hover">
        <tr>
          <th>#</th>
          <th>Mitarbeiterumfrage</th>
          <th>aktiv</th>
          <th>aktivieren/deaktiveren</th>
          <th>Fragen ansehen</th>
        </tr>
          @foreach($surveys as $survey)
          <tr>
            <td>{{$survey->id}}</td>
            <td>{{$survey->Title}}</td>
            <td>@if($survey->active == 0) nicht aktiv @else aktiv @endif</td>
            <td>@if($survey->active == 0) <a href="{{route('survey.changeStatus', ['action' => 'activate', 'id' => $survey->id])}}">aktivieren</a> @else <a href="{{route('survey.changeStatus', ['action' => 'deactivate', 'id' => $survey->id])}}"> deaktiveren @endif</td>
            <td><a href="{{route('survey.show', ['id' => $survey->id])}}">link</a></td>
          </tr>
          @endforeach
      </table>
    </div>
  </div>
</div>

@endsection
