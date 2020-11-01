@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row bg-light align-items-center"  style="border-radius: 15px;">
    <div class="col m-3">
      <form action="{{route('survey.create.post')}}" method="post">
        @csrf
        <table class="table table-striped table-bordered">
        <tr>
          <th>Frage übernehmen?</th>
          <th>Frage</th>
        </tr>
          @foreach($questions as $question)
          <tr>
            <td style="width: 10%;">
              <input class="" name="questions[]" type="checkbox" value="{{$question->id}}">
            </td>
            <td>{{$question->question}}</td>
          </tr>
          @endforeach
        </table>
        <button type="submit" class="btn btn-success btn-block btn-lg">Create Survey</button>
      </form>

    </div>
  </div>
</div>
@endsection
