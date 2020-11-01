@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row bg-light align-items-center"  style="border-radius: 15px;">
    <div class="col">
      <form action="{{route('question.create.post')}}" method="post">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Frage</label>
            <input type="text" name="question" class="form-control" id="inputEmail4" placeholder="zB. wie glücklich bist du?">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Create Question</button>
      </form>

    </div>
  </div>
</div>
@endsection
