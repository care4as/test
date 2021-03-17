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
  <div class="row justify-content-center">
    <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <ul class="nav nav-tabs" data-tabs="tabs">
              <li class="nav-item">
                  <a class="nav-link active" href="#mobile" data-toggle="tab">Feierabendmail Mobile</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#dsl" data-toggle="tab">Feierabendmail DSL</a>
              </li>
          </ul>
        </div>
    </div>
  </div>
  <div class="row m-0">
    <div class="tab-content w-100" id="myTabContent">
      <div class="tab-pane fade show active" id="mobile" role="tabpanel" aria-labelledby="mobile-tab">
        <form class="" action="{{route('eobmail.kpi.store')}}" method="post" id="eobmailformmobile">
          @csrf
          <div class="row align-items-center">
            <input type="hidden" name="department" value="1">

          </div>
          <hr>
          <div class="row align-items-center mt-2">
            <div class="col">
              <label for="title">Serivecelevel:</label>
              <input type="text" name="servicelevel" value="{{$eobmail->servicelevel}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
            <div class="col">
              <label for="title">Gevo CR:</label>
              <input type="text" name="gevocr" value="{{$eobmail->gevocr}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col">
              <label for="title">Erreichbarkeit:</label>
              <input type="text" name="erreichbarkeit" value="{{$eobmail->erreichbarkeit}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
            <div class="col">
              <label for="title">SSC CR:</label>
              <input type="text" name="ssccr" value="{{$eobmail->ssccr}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col">
              <label for="title">Abnahme:</label>
              <input type="text" name="abnahme" value="{{$eobmail->abnahme}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
            <div class="col">
              <label for="title">IV Erfüllung:</label>
              <input type="text" name="iv_erfuellung" value="{{$eobmail->iv_erfuellung}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6">
              <label for="title">Krankenquote:</label>
              <input type="text" name="krankenquote" value="{{$eobmail->krankenquote}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
            <div class="col-6">

            </div>
          </div>
          <div class="row mt-3">
            <div class="col">
              <h5>Kommentar:</h5>
            </div>
          </div>
          <div class="row">
            <div class="col"  style="">
              <textarea name="comment" class="form-control" rows="10" cols="200" style="">@if(isset($eobmail))@foreach($eobmail->notes->where('department','mobile') as $note)- {{($note->note) }}&#010;@endforeach @endif</textarea>
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
               <button type="submit" id="confirmButton" class="btn btn-block btn-sm btn-primary">Werte Speichern </button>
            </div>
            <div class="col">
               <button type="button" data-toggle="modal" data-target="#commentModal" class="btn btn-block btn-sm btn-primary">Kommentar hinzufügen/entfernen</button>
            </div>
          </div>
        </form>
      </div>
      <div class="tab-pane" id="dsl" role="tabpanel" aria-labelledby="dsl-tab">
        <form class="" action="{{route('eobmail.kpi.store')}}" method="post" id="eobmailformdsl">
          <input type="hidden" name="department" value="2">
          @csrf
          <hr>
          <div class="row align-items-center mt-2">
            <div class="col">
              <label for="title">Serivecelevel:</label>
              <input type="text" name="servicelevel" value="{{$eobmaildsl->servicelevel}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
            <div class="col">
              <label for="title">Gevo CR:</label>
              <input type="text" name="gevocr" value="{{$eobmaildsl->gevocr}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col">
              <label for="title">Erreichbarkeit:</label>
              <input type="text" name="erreichbarkeit" value="{{$eobmaildsl->erreichbarkeit}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
            <div class="col">
              <label for="title">Abnahme:</label>
              <input type="text" name="abnahme" value="{{$eobmaildsl->abnahme}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col">
              <label for="title">IV Erfüllung:</label>
              <input type="text" name="iv_erfuellung" value="{{$eobmaildsl->iv_erfuellung}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
            <div class="col">
              <label for="title">Krankenquote:</label>
              <input type="text" name="krankenquote" value="{{$eobmaildsl->krankenquote}}" placeholder=""  class="form-control w-50" id="title" aria-describedby="title">
            </div>
          </div>
          <div class="row mt-3">
            <div class="col">
              <h5>Kommentar:</h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <textarea name="comment" class="form-control" rows="10" cols="200" style="">@if(isset($eobmaildsl))@foreach($eobmaildsl->notes as $note)- {{($note->note) }}&#010;@endforeach @endif</textarea>
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
               <button type="submit" id="confirmButtonDSL" class="btn btn-block btn-sm btn-primary">Werte speichern </button>
            </div>
            <div class="col">
               <button type="button" data-toggle="modal" data-target="#commentModal" class="btn btn-block btn-sm btn-primary">Kommentar hinzufügen/entfernen</button>
            </div>
          </div>
        </form>

      </div>
      <hr>
      <div class="row m-0">
        <form class="form-control" action="{{route('eobmail.send')}}" method="post">
          @csrf
          <div class="col-12 text-center">
            <h5>Feierabendmail für Abteilung:</h5>
          </div>
          <div class="col-12  mt-4 d-flex justify-content-center">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="department1" name="department" class="custom-control-input" value="dsl">
              <label class="custom-control-label" for="department1">DSL</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="department2" name="department" class="custom-control-input" value="mobile">
              <label class="custom-control-label" for="department2">Mobile</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="department3" name="department" class="custom-control-input" value="both" selected>
              <label class="custom-control-label" for="department3">Beides</label>
            </div>
          </div>
          <div class="col-12 mt-4" >
            <div class="" style="display:grid; justify-content: center;">
              <div class="" style="width:50vw; text-align: center;">
                <label class="" for="emails2send"><h5>An:</h5></label></br>
                <input type="text" name="emails2send" value="andreas.robrahn@care4as.de;maximilian.steinberg@care4as.de" placeholder="" class="form-control" id="emails2send" aria-describedby="title">
              </div>
            </div>
          </div>
          <hr>
          <div class="col p-0 mt-4">
            <button type="submit" class="btn btn-block btn-lg btn-primary">Mail absenden</button>
          </div>
        </form>
      </div>
    </div>
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
                <table class="table table-responsive table-striped table-hover text-white" style="max-height:80%; overflow: scroll;">
                  <thead class="thead-dark">
                    <th>Notiz</th>
                    <th>Abteilung</th>
                    <th>Typ</th>
                    <th>Optionen</th>
                  </thead>
                  <tbody class="">
                    @if(isset($eobmail))
                      @foreach($eobmail->notes as $note)
                      <tr  class="@if($note->department == 'mobile') bg-info @else bg-warning @endif">
                        <td>{{$note->note}}</td>
                        <td>@if($note->department == 'dsl')<i class="material-icons">router</i> @else <i class="material-icons">phone_android</i> @endif</td>
                        <td>{{$note->type}}</td>
                        <td class="text-center"><a href="{{route('note.delete', ['id' => $note->id])}}"><i class="far fa-trash-alt text-white"></i></a> </td>
                      </tr>
                      @endforeach
                      @foreach($eobmaildsl->notes as $note)
                      <tr  class="@if($note->department == 'mobile') bg-info @else bg-warning @endif">
                        <td>{{$note->note}}</td>
                        <td>@if($note->department == 'dsl')<i class="material-icons">router</i> @else <i class="material-icons">phone_android</i> @endif</td>
                        <td>{{$note->type}}</td>
                        <td class="text-center"><a href="{{route('note.delete', ['id' => $note->id])}}"><i class="far fa-trash-alt text-white"></i></a> </td>
                      </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col">
              <h5>Neuer Kommentar:</h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <textarea name="note" class="form-control" rows="8" cols="200"></textarea>
            </div>
          </div>
          <div class="row m-2">
            <div class="col-12">
              <h5>Abteilung</h5>
            </div>
            <div class="col-12">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="departmentComment1" name="departmentComment" class="custom-control-input" value="dsl">
                <label class="custom-control-label" for="departmentComment1">DSL</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="departmentComment2" name="departmentComment" class="custom-control-input" value="mobile">
                <label class="custom-control-label" for="departmentComment2">Mobile</label>
              </div>

            </div>
          </div>
          <div class="row m-2">
            <div class="col-12">
              <h5>Welche Art von Kommentar:</h5>
            </div>
            <div class="col-12">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="type1" name="type" class="custom-control-input" value="service">
                <label class="custom-control-label" for="type1">Service Performance</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="type2" name="type" class="custom-control-input" value="sales">
                <label class="custom-control-label" for="type2">Sales Performance</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="type3" name="type" class="custom-control-input" value="others">
                <label class="custom-control-label" for="type3">Sonstiges</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
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

    // Javascript method's body can be found in assets/js/demos.js
    // demo.initDashboardPageCharts();

  });
</script>
@endsection
