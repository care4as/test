@extends('general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container  text-center bg-light">
  <h2>Daily Agent Import</h2>
  <div class="row bg-white shadow m-2 mt-2">
    <div class="col-12">
      <h4 class="text-center">Aktueller Datenstand:</h4>
    </div>
    <div class="col-8">
      @if(!App\DailyAgent::min('date'))
        <h5>keine Daten eingegeben</h5>
      @else
        <h5>Daily Agent im Zeitraum vom <u>{{Carbon\Carbon::parse(App\DailyAgent::min('date'))->format('d.m.Y H:i:s')}}</u>  bis zum <u>{{Carbon\Carbon::parse(App\DailyAgent::max('date'))->format('d.m.Y H:i:s')}}</u> </h5>
      @endif
    </div>
    <div class="col-2">
      <a href="{{route('dailyagent.removeDuplicates')}}"><button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a>
    </div>
    <div class="col-2">
      <a href="{{route('excel.dailyAgent.import')}}"><button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a>
    </div>

  </div>
  <div class="row m-2 mt-2 bg-white shadow" id="app">
    <div class="col text-center bg-light p-2">
      <form action="{{route('excel.dailyAgent.upload.queue')}}" class="dropzone" id="exceldropzone" enctype="multipart/form-data">
        @csrf
        <div class="form-row dropzone-previews dz-default dz-message" id="previewContainer" style="width: 100%; height: 18vh; padding: 5px; border-radius: 25px; border: 2px solid black;">
          <p class=" w-100 text-center">Ziehe die Dateien hier rein oder klick mich!</p>
          </div>
          <div class="form-row">
            <div class="col">
              Sheet: <input class="form-control" type="text" name="sheet" />
            </div>
            <div class="col">
              Ab Zeile: <input class="form-control" type="text" name="fromRow" />
            </div>
          </div>
        <div class="form-row">
          <button type="submit" class="btn btn-sm btn-block" name="button">Absenden</button>
        </div>
      </form>

      <!-- <form class="" action="{{route('excel.dailyAgent.upload.queue')}}" method="post" enctype="multipart/form-data">
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

      </form> -->
    </div>
  </div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript">


Dropzone.options.exceldropzone = {


  previewsContainer: "#previewContainer",
  addRemoveLinks: true,
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 120, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  dictResponseError: false,
  timeout: 180000,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
     // Make sure that the form isn't actually being sent.
       e.preventDefault();
       e.stopPropagation();
       myDropzone.processQueue();
      });

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
