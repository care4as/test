@extends('general_layout')

@section('additional_css')
<style media="screen">
  .dropzone{
    background: none !important;
    border: none !important;
  }
</style>
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container p-0 text-center unit-translucent mt-4" style="position:relative;">
  <div class="loaderDiv" id="loaderDiv">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
  </div>
  <h2>Retention Details Import</h2>
  <div class="row m-2 shadow">
    <div class="col-8">
      <h5>Retention Details vom <u>{{Carbon\Carbon::parse(App\RetentionDetail::min('call_date'))->format('d.m.Y')}}</u> bis zum <u>{{Carbon\Carbon::parse(App\RetentionDetail::max('call_date'))->format('d.m.Y')}}</u></h5>
    </div>
    <div class="col-2">
      <a href="{{route('reports.report')}}">  <button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a>
    </div>
  </div>
  <div class="row m-2 mt-2 shadow" id="app">

    <div class="col-12">
      <h5>Wähle die Datei</h5>
    </div>
    <div class="col text-center p-1">
      <form action="{{route('excel.test')}}" class="dropzone" id="exceldropzone" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row dropzone-previews dz-default dz-message unit-translucent" id="previewContainer">
          <p class="w-100 text-center">Ziehe die Dateien hier rein oder klick mich!</p>
          </div>
          <div class="form-row">
            <div class="col">
              Sheet: <input class="form-control" type="text" name="sheet" value="1"/>
            </div>
            <div class="col">
              Ab Zeile: <input class="form-control" type="text" name="fromRow" value="2"/>
            </div>
          </div>
          <div class="form-row">
          <button type="button" id="dropZoneSubmitter" class="btn btn-sm btn-block" name="button">Absenden</button>
        </div>
      </form>
      <!-- For Debuggin purposes -->
      @if(Auth()->user()->role == "superadmin")
      <form class="" action="{{route('excel.test')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" value="">
        <div class="form-row mt-2 justify-content-center">
          <label for="sheet">Welches Sheet?</label> </br>
          <input class="form-control w-25" type="number" id="sheet" name="sheet" value="1">
        </div>
        <div class="form-row mt-2 justify-content-center">
          <label for="sheet">Ab welcher Zeile?</label></br>
          <input class="form-control w-25" type="number" name="fromRow" value="2">
        </div>

        <button type="submit" name="button">Absenden</button>
      </form>
      @endif
    </div>
  </div>
</div>
<div class="modal fade" id="failModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-danger text-white" >
      <div class="modal-body">
        <h5>&#128577;&#128580;&#128560; Fehler aufgetreten &#128577;&#128580;&#128560;</h5>
        <p id="failFile"></p>
        <p id="failLine"></p>
        <p id="failContent"></p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('additional_modal')
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-success text-white" >
      <div class="modal-body">
        <h5>Triumph!</h5>
        <p>Die Datei wurde erfolgreich hochgeladen &#129321;&#129321;&#129321;</p>
      </div>

    </div>
  </div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript">

Dropzone.options.exceldropzone = {

  previewsContainer: "#previewContainer",
  addRemoveLinks: true,
  dictDefaultMessage: "Ziehe die Dateien in die Dropzone oder klicke hier",
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  dictRemoveFile: 'entfernen',
  autoProcessQueue: false,
  timeout: 1200000,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#dropZoneSubmitter").addEventListener("click", function(e) {
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
       $('#loaderDiv').css('display','flex');
      });

      this.on('error', function (file,errormessage, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          console.log(errormessage)
          $('#failContent').html('Fehler: '+ errormessage.message)
          $('#failFile').html('Datei: '+ errormessage.file)
          $('#failLine').html('Line: '+ errormessage.line)
          $('#failModal').modal('show')
          $('#loaderDiv').css('display','none');
      });
      this.on("success", function(file, response) {
        console.log(response)
        this.removeAllFiles()
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv').css('display','none');
      });
      this.on("complete", function(file) {
        this.removeAllFiles()
      });

    }
};
</script>

<script type="text/javascript">

$( document ).ready(function() {

});

</script>
@endsection
