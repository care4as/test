@extends('general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />

  <style media="screen">
  .lds-spinner {
  color: official;
  align-self: center;
  position: relative;
  width: 250px;
  height: 250px;
  align-self: center;
  display: flex;
  justify-content: center;
}
.lds-spinner div {
  transform-origin: 40px 40px;
  animation: lds-spinner 1.2s linear infinite;
}
.lds-spinner div:after {
  content: " ";
  /* display: block; */
  position: absolute;
  top: -45px;
  left: 37px;
  width: 10px;
  height: 50px;
  border-radius: 20%;
  background: #fff;
}
.lds-spinner div:nth-child(1) {
  transform: rotate(0deg);
  animation-delay: -1.1s;
}
.lds-spinner div:nth-child(2) {
  transform: rotate(30deg);
  animation-delay: -1s;
}
.lds-spinner div:nth-child(3) {
  transform: rotate(60deg);
  animation-delay: -0.9s;
}
.lds-spinner div:nth-child(4) {
  transform: rotate(90deg);
  animation-delay: -0.8s;
}
.lds-spinner div:nth-child(5) {
  transform: rotate(120deg);
  animation-delay: -0.7s;
}
.lds-spinner div:nth-child(6) {
  transform: rotate(150deg);
  animation-delay: -0.6s;
}
.lds-spinner div:nth-child(7) {
  transform: rotate(180deg);
  animation-delay: -0.5s;
}
.lds-spinner div:nth-child(8) {
  transform: rotate(210deg);
  animation-delay: -0.4s;
}
.lds-spinner div:nth-child(9) {
  transform: rotate(240deg);
  animation-delay: -0.3s;
}
.lds-spinner div:nth-child(10) {
  transform: rotate(270deg);
  animation-delay: -0.2s;
}
.lds-spinner div:nth-child(11) {
  transform: rotate(300deg);
  animation-delay: -0.1s;
}
.lds-spinner div:nth-child(12) {
  transform: rotate(330deg);
  animation-delay: 0s;
}
@keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
  .loaderDiv
  {
    position: absolute;
    height: 100%;
    width: 100%;
    background-color:rgba(0,0,0,0.8);;
    z-index:100;
    display: none;
    justify-content: center;
  }
  .loader {
  /* display:none; */
  font-size: 2px;
  /* margin: 50px auto; */
  text-indent: -9999em;
  width: 250px;
  height: 250px;
  border-radius: 50%;
  margin: auto;
  align-self:   center;
  /* background: #ffffff; */
  /* background: -moz-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: -webkit-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: -o-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: -ms-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  /* background: linear-gradient(to right, #ffffff 10%, rgba(255, 255, 255, 0) 42%); */
  position: relative;
  -webkit-animation: load3 1.4s infinite linear;
  animation: load3 1.4s infinite linear;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.loader:before {
  width: 50%;
  height: 50%;
  background: #0dc5c1;
  border-radius: 100% 0 0 0;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
}
.loader:after {
  background: #ffffff;
  width: 75%;
  height: 75%;
  border-radius: 50%;
  content: '';
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
@-webkit-keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
  </style>
@endsection

@section('content')
<div class="container  text-center bg-light" style="position:relative;">
  <div class="loaderDiv" id="loaderDiv">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
  </div>
  <h2>Daily Agent Import </h2>
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
        <div class="form-row dropzone-previews dz-default dz-message" id="previewContainer"
        style="
        background: rgb(203,200,244);
        background: linear-gradient(90deg, rgba(203,200,244,1) 0%, rgba(159,231,208,1) 0%, rgba(223,249,241,1) 0%, rgba(178,238,233,0.8827731776304272) 100%);
        width: 100%;
        height: auto;
        min-height: 15vh;
        padding: 5px;
        border-radius: 25px;
        border: 2px solid black;
        box-shadow:10px 10px 5px grey;">
          <p class=" w-100 text-center">Ziehe die Dateien hier rein oder klick mich!</p>
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


    </div>
  </div>
  <div class="row">
    <form class="" action="{{route('excel.dailyAgent.upload.queue')}}" method="post" enctype="multipart/form-data">
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
      <div class="row">
        <button type="submit" class="btn btn-rounded btn-block" name="button">Test</button>
      </div>
    </form>
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
  dictDefaultMessage: 'test',
  dictFallbackMessage: 'Testmessage',
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 120, // MB
  // chunking:true,
  dictRemoveFile: 'entfernen',
  dictResponseError: null,
  autoProcessQueue: false,
  dictResponseError: false,
  timeout: 600000,

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

  console.log('test')


});

</script>
@endsection
