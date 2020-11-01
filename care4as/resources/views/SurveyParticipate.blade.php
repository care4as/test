
@extends('general_layout')

@section('content')

<div class="container-fluid" style="width: 75vw;">
  <div class="row ">
    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
      <!-- App\SurveyQuestion::where('user_id', Hash::check(Auth()->user()->id, 'user_id'))->exists() -->
      @if(null)
      {
        <h2 class="text-dark"> bereits teilgenommen</h2>
      }
      @else
      {
        @if($survey)
          <form class="" action="{{route('survey.user.post')}}" method="post">
            @csrf
            <table class="table table-hover table-bordered">
              <tr>
                <th>#</th>
                <th>Frage</th>
                <th><h4>&#128530;</h3> </th>
                <th><h4>&#128532;</h4> </th>
                <th><h4>&#128528;</h4></th>
                <th><h4>&#128578;</h4> </th>
                <th><h4> &#128522;</h4></th>
              </tr>
                @foreach($survey->Questions as $question)
                <tr>
                  <td style="width: 10%;">{{$question->id}}</td>
                  <td style="width: 20%;">{{$question->question->question}}</td>
                  @if($question->alreadyanswered != 1)
                    <td style="">
                      <input type="hidden" name="surveyid" value="{{$survey->id}}">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{$question->question->question}}1" name="{{$question->question->id}}" class="custom-control-input" value='1'>
                        <label class="custom-control-label" for="{{$question->question->question}}1"></label>
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{$question->question->question}}2" name="{{$question->question->id}}" class="custom-control-input" value='2'>
                        <label class="custom-control-label" for="{{$question->question->question}}2"></label>
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{$question->question->question}}3" name="{{$question->question->id}}" class="custom-control-input" value='3'>
                        <label class="custom-control-label" for="{{$question->question->question}}3"></label>
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{$question->question->question}}4" name="{{$question->question->id}}" class="custom-control-input" value='4'>
                        <label class="custom-control-label" for="{{$question->question->question}}4"></label>
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{$question->question->question}}5" name="{{$question->question->id}}" class="custom-control-input" value='5'>
                        <label class="custom-control-label" for="{{$question->question->question}}5"></label>
                      </div>
                    </td>
                    @else
                    <td colspan="5">bereits beantwortet</td>
                  @endif
                  </tr>
                @endforeach
            </table>
            <button type="submit" class="btn-block btn-success btn-lg">Eingabe absenden</button>
          </form>

          @else
          <span class="text-dark">keine aktive Mitarbeiterumfrage</span>

          @endif
        @endif
    </div>
  </div>
</div>

@endsection
