
@extends('general_layout')

@section('content')

<div class="container mt-2 shadow bg-dark" style="">
  <div class="nav-tabs-navigation ">
    <div class="nav-tabs-wrapper center_items bg-dark">
      <ul class="nav nav-tabs" data-tabs="tabs">
          <li class="nav-item ">
            <a class="nav-link active goldentext" href="#analysis" data-toggle="tab">Auswertung der Umfrage</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link goldentext" href="#questions" data-toggle="tab">enthaltene Fragen</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link goldentext" href="#addQuestions" data-toggle="tab">Fragen hinzufügen</a>
          </li>
          <!-- <li class="nav-item">
              <a class="nav-link" href="#history" data-toggle="tab">Weitere Funktion</a>
          </li> -->
      </ul>
    </div>
  </div>
  <div class="tab-content">
    <div id="analysis" class="tab-pane fade in show active">
      <div class="row">
        <div class="col text-center text-dark goldentext" style="border-radius: 15px;">
          <h2>Bewertungen</h2>
          <table class="table table-hover table-bordered">
            <tr>
              <th>Frage</th>
              <th>Durschnitt/ Anzahl Antworten</th>
            </tr>
            <!-- $results->answeredQuestions -->
              @foreach($questions as $question)

              <tr>
                <td>{{$question->question}}</td>
                <td>@if($results->answeredQuestions->where('question_id', $question->id)->count() != 0 ){{round($results->answeredQuestions->where('question_id', $question->id)->sum('value')/ $results->answeredQuestions->where('question_id', $question->id)->count(),2)}} / {{$results->answeredQuestions->where('question_id', $question->id)->count()}} @else 0 / 0 @endif</td>
              </tr>
              @endforeach
          </table>
        </div>
      </div>
    </div>
  <div id="questions" class="tab-pane fade in">
    <div class="row ">
      <div class="col text-center text-white goldentext" style="border-radius: 15px;">
        <h2 class="text-dark">Fragen in der Umfrage</h2>
        <table class="table table-hover">
          <tr>
            <th>#</th>
            <th>Frage</th>
            <th>Optionen</th>
          </tr>
            @foreach($survey->Questions as $question)
            <tr>
              <td style="width: 10%;">{{$question->question->id}}</td>
              <td>{{$question->question->question}}</td>
              <td><a href="{{route('survey.delete.question',['surveyid'=>$survey->id, 'questionid'=>$question->question->id])}}"><i class="now-ui-icons ui-1_simple-remove"></i></a> </td>
            </tr>
            @endforeach
        </table>
      </div>
    </div>
  </div>
  <div id="addQuestions" class="tab-pane fade in">
    <div class="row mt-2">
      <div class="col text-center " style="border-radius: 15px;">
        <form action="{{route('survey.edit.post')}}" method="post">
          <input type="hidden" name="surveyid" value="{{$survey->id}}">
          @csrf
          <table class="table table-hover goldentext">
          <tr>
            <th>Frage übernehmen?</th>
            <th>Frage</th>
          </tr>
            @foreach($freequestions as $question)
            <tr>
              <td style="width: 10%;">
                <input class="" name="questions[]" type="checkbox" value="{{$question->id}}">
              </td>
              <td>{{$question->question}}</td>
            </tr>
            @endforeach
          </table>
          <button type="submit" class="btn btn-dark btn-block btn-lg">Fragen mit übernehmen</button>
        </form>
        </div>
      </div>
    </div>
  </div>
  </div>


@endsection
