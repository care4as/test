@extends('general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container  text-center bg-light">
  <h2>Retention Details Import</h2>
  <div class="row bg-white m-2 shadow">
    <div class="col-8">
      <h5>Retention Details vom <u>{{Carbon\Carbon::parse(App\RetentionDetail::min('call_date'))->format('d.m.Y')}}</u> bis zum <u>{{Carbon\Carbon::parse(App\RetentionDetail::max('call_date'))->format('d.m.Y')}}</u></h5>
    </div>
    <div class="col-2">
      <a href="{{route('retentiondetails.removeDuplicates')}}">  <button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a>
    </div>
    <div class="col-2">
      <a href="{{route('reports.report')}}">  <button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a>
    </div>
  </div>
  <div class="row bg-white m-2 mt-2 shadow" id="app">

    <div class="col text-center bg-light">
      <!-- <form action="/file-upload" class="dropzone" id="exceldropzone">
        <!-- <div class="dz-message text-dark" data-dz-message><span>Bitte Dateien einfügen</span></div>
      </form> -->

      <form class="" action="{{route('excel.test')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" value="">
        <div class="form-row mt-2 justify-content-center">
          <label for="sheet">Welches Sheet?</label> </br>
          <input class="form-control w-25" type="number" id="sheet" name="sheet" value="">
        </div>
        <div class="form-row mt-2 justify-content-center">
          <label for="sheet">Ab welcher Zeile?</label></br>
          <input class="form-control w-25" type="number" name="fromRow" value="">
        </div>

        <button type="submit" name="button">Absenden</button>
      </form>

    </div>

  </div>
</div>

@endsection

@section('additional_js')
<script type="text/javascript">

Dropzone.options.exceldropzone = {

  addRemoveLinks: true,
  dictDefaultMessage: "Ziehe die Dateien in die Dropzone oder klicke hier",
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 2, // MB

  dictRemoveFile: 'doch nicht',
  dictRemoveFile: 'entfernen',
  autoProcessQueue: false,
};
</script>

<script type="text/javascript">

$( document ).ready(function() {

  console.log('test')


});

</script>
@endsection
