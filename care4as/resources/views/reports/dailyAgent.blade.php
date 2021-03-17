@extends('general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container  text-center bg-light">
  <h2>Daily Agent Import</h2>
  <div class="row" id="app">
    <div class="col text-center bg-light">
      <!-- <form action="{{route('excel.dailyAgent.upload.queue')}}" class="dropzone" id="exceldropzone" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="sheet" value="3">
        <input type="hidden" name="fromRow" value="2">
         <div class="dz-message text-dark" data-dz-message><span>Bitte Dateien einfügen</span></div>
      </form> -->
      <form class="" action="{{route('excel.dailyAgent.upload.queue')}}" method="post" enctype="multipart/form-data">
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
  maxFilesize: 80, // MB
  chunking:true,
  dictRemoveFile: 'entfernen',
  autoProcessQueue: true,
  dictResponseError: true,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button

      this.on('error', function (file, xhr, formData) {
          // Append all form inputs to the formData Dropzone will POST
          // console.log(xhr.message)
          alert(xhr.message);
      });

    }
};
</script>

<script type="text/javascript">

$( document ).ready(function() {

  console.log('test')


});

</script>
@endsection
