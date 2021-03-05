@extends('general_layout')

@section('additional_css')
<style media="screen">
  table td{
    border: 1px solid black;
  }
  textarea.form-control
  {
    max-height: 500px;
  }
</style>
@endsection
@section('content')
<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">
  <form class="" action="{{route('eobmail.send')}}" method="post" id="eobmailform">
    @csrf
    <div class="row align-items-center">
      <div class="col">
        <label for="title">An:</label>
        <input type="" name="emails" value="andreas.robrahn@care4as.de" placeholder="" class="form-control w-50" id="title" aria-describedby="title">
      </div>

    </div>
    <div class="row align-items-center">
      <div class="col">
        <label for="title">Serivecelevel:</label>
        <input type="text" name="servicelevel" value="" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
      </div>
      <div class="col">
        <label for="title">Gevo CR:</label>
        <input type="text" name="gevocr" value="" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col">
        <label for="title">Erreichbarkeit:</label>
        <input type="text" name="erreichbarkeit" value="" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
      </div>
      <div class="col">
        <label for="title">SSC CR:</label>
        <input type="text" name="ssccr" value="" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col">
        <label for="title">Abnahme:</label>
        <input type="text" name="abnahme" value="" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
      </div>
      <div class="col">
        <label for="title">IV Erfüllung:</label>
        <input type="text" name="iverfüllung" value="" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
      </div>
    </div>

    <div class="row mt-3">
      <div class="col">
        <h5>Kommentar:</h5>
      </div>
    </div>
    <div class="row">
      <div class="col"  style="height: 200px; ">
        <textarea name="comment" class="form-control" rows="10" cols="200" style="">@if(isset($eobmail))@foreach($eobmail->notes as $note)- {{($note->note) }}&#010;@endforeach @endif</textarea>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <h5>Cancelgründe:</h5>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <textarea name="cancels" class="form-control" rows="8" cols="200">

        </textarea>
      </div>
    </div>
    <div class="row">
      <div class="col">
         <button type="button" id="confirmButton" class="btn btn-block btn-lg btn-primary">Mail Absenden</button>
      </div>
      <div class="col">
         <button type="button" data-toggle="modal" data-target="#commentModal" class="btn btn-block btn-lg btn-primary">Kommentar hinzufügen/entfernen</button>
      </div>
    </div>
  </form>
</div>
<div class="modal fade" id="commentModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
      @if(isset($eobmail))
        <form class="" action="{{route('eobmail.note.store', ['id' => $eobmail->id])}}" method="post">
      @else
        <form class="" action="{{route('eobmail.note.store')}}" method="post">
      @endif
          @csrf
          <div class="row mt-3">
            <div class="col">
              <h5>Kommentare:</h5>
                <table class="table table-responsive table-striped table-hover">
                  <tbody class="">
                    @if(isset($eobmail))
                      @foreach($eobmail->notes as $note)
                      <tr >
                        <td>{{$note->note}}</td>
                        <td><a href="{{route('note.delete', ['id' => $note->id])}}"><i class="far fa-trash-alt"></i></a> </td>
                      </tr>
                      @endforeach
                    @endif
                  </tbody>

                </table>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col">
              <h5>Kommentar:</h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <textarea name="note" class="form-control" rows="8" cols="200"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <button type="submit" name="buttonComment" value="1" class="btn btn-secondary btn-block">Kommentar hinzufügen</button>
            </div>
          </div>
        </form>
    </div>
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
  $("#confirmButton").click(function(){
  if(confirm ("Willst du die Mail wirklich absenden?"))
      $("#eobmailform")[0].submit();
  });
    // Javascript method's body can be found in assets/js/demos.js
    // demo.initDashboardPageCharts();

  });
</script>
@endsection
