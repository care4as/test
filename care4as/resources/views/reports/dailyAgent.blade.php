@extends('general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />

  <style media="screen">
  #debugroute
  {
    display: none;
  }
  .shiningeffect
  {
    animation: shine 4s ease-in-out infinite;
    animation-fill-mode: none;
    animation-fill-mode: forwards;
    content: "";
    position: absolute;
    top: -200%;
    left: -150%;
    width: 60%;
    height: 60%;
    opacity: 0;
    -webkit-transform: rotate(-40deg);
    -moz-transform: rotate(-40deg);
    -ms-transform: rotate(-40deg);
    -o-transform: rotate(-40deg);
    transform: rotate(-40deg);
  }
  @-webkit-keyframes shine {
	0% {
		opacity: 0.8;
		top: -50%;
		left: -50%;
		transition-property: left, top, opacity;
		transition-duration: 0.7s, 0.7s, 0.15s;
		transition-timing-function: ease;
	}

	100% {
		opacity: 0.0;
		top: 80%;
		left: 80%;
		transition-property: left, top, opacity;
	}
}

@-moz-keyframes shine {
	0% {
		opacity: 0.8;
		top: -50%;
		left: -50%;
		transition-property: left, top, opacity;
		transition-duration: 0.7s, 0.7s, 0.15s;
		transition-timing-function: ease;
	}

	100% {
		opacity: 0.0;
		top: 80%;
		left: 80%;
		transition-property: left, top, opacity;
	}
}

@-ms-keyframes shine {
	0% {
		opacity: 0.8;
		top: -50%;
		left: -50%;
		transition-property: left, top, opacity;
		transition-duration: 0.7s, 0.7s, 0.15s;
		transition-timing-function: ease;
	}

	100% {
		opacity: 0.0;
		top: 80%;
		left: 80%;
		transition-property: left, top, opacity;
	}
}

@-o-keyframes shine {
	0% {
		opacity: 0.8;
		top: -50%;
		left: -50%;
		transition-property: left, top, opacity;
		transition-duration: 0.7s, 0.7s, 0.15s;
		transition-timing-function: ease;
	}

	100% {
		opacity: 0.0;
		top: 80%;
		left: 80%;
		transition-property: left, top, opacity;
	}
}

@keyframes shine {
	0% {
		opacity: 0.8;
		top: -50%;
		left: -50%;
		transition-property: left, top, opacity;
		transition-duration: 0.5s, 0.7s, 0.15s;
		transition-timing-function: ease;
	}

	100% {
		opacity: 0.0;
		top: 80%;
		left: 80%;
		transition-property: left, top, opacity;
	}
}
</style>
@endsection

@section('content')
<div class="container p-0 text-center unit-translucent mt-4" style="position:relative;">
  <div class="loaderDiv" id="loaderDiv">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
  </div>
  <div class="row center_items">
    <h2>Daily Agent Import </h2>
  </div>
  <div class="row center_items">
    <div id="accordion">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Anleitung (klick mich)
            </button>
          </h5>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
            <p>
            <b>Ziehe die Datei in die Dropzone (türkiser Bereich) und lege die DailyAgent Datei ab. <br>Sollte die Datei aus dem Download der 1&1 stammen, bitte achte darauf, dass sie exakt "dailyagent" oder "Daily_Agent" heißt. Benenne Sie ggf. um.
            Bitte achte in jedem Fall darauf, dass du die richtige Zeile, in dem die Werte Zeilen im Excel Sheet anfangen, angibst.</b><br>
            <hr>
            Sollte die Datei aus den Agentenreporten ("Z:\WFM\1und1\Agentenreporte") kommen bitte achte darauf, dass die Datei
            nicht exakt "dailyagent" benannt wird. Dadurch wird sie in der Verarbeitung zugewiesen und unterscheidet den Prozess.<br>
            </p>
          </div>
        </div>
      </div>
  </div>
  <div class="row shadow m-2 mt-2">
    <div class="col-3">
      <span>
      Aktueller Datenstand:
      </span>
    </div>
    <div class="col-7 text-left">
      <span>
      @if(!App\DailyAgent::min('date'))
        keine Daten eingegeben
      @else
        {{Carbon\Carbon::parse(App\DailyAgent::min('date'))->format('d.m.Y H:i:s')}}</u> - <u>{{Carbon\Carbon::parse(App\DailyAgent::max('date'))->format('d.m.Y H:i:s')}}</u>
      @endif
      </span>
    </div>
    <div class="col-2">
      <a href="{{route('excel.dailyAgent.import')}}"><button type="button" class="btn btn-success btn-sm border-round" name="button">Zum Upload</button></a>
    </div>
  </div>
  <div class="row m-2 mt-2 shadow" id="app">
    <div class="col text-center p-2">
      <form action="{{route('excel.dailyAgent.upload')}}" class="dropzone" id="exceldropzone" enctype="multipart/form-data">
        @csrf
        <div class="form-row dropzone-previews dz-default dz-message unit-translucent" id="previewContainer">
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
        <div class="form-row mt-3 m-0 center_items" >
          <div class="col-12 p-0" style="position:relative; overflow:hidden; height: auto; margin: 0px;">
            <div class="shiningeffect" style="position: absolute; background-color: rgba(255,255,255,0.3); width: 50%;">

            </div>
            <button type="button " id="dropZoneSubmitter" class="btn btn-sm btn-block m-0 " name="button">Absenden</button>
          </div>
          </div>

      </form>
    </div>
  </div>
  <div class="row justify-content-center" id="debugroute">
    @if(Auth()->user()->role == "superadmin")
    <div class="col-12">
      <h5> Daily Agent Datei aus dem Reporting der 1&1</h5>
    </div>
    <div class="col-12">
      <form class="" action="{{route('excel.upload.debug')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row m-1 justify-content-center">
          <input type="file" name="file" value="">
        </div>
        <div class="form-row m-2 justify-content-center">
          <label for="sheet">Welches Sheet?</label> </br>
          <input class="form-control w-25" type="number" id="sheet" name="sheet" value="1">
        </div>
        <div class="form-row m-2 justify-content-center">
          <label for="sheet">Ab welcher Zeile?</label></br>
          <input class="form-control w-25" type="number" name="fromRow" value="2">
        </div>
        <div class="form-row m-1 ">

          <button type="submit" class="btn btn-rounded btn-block " name="button">Test</button>
        </div>
      </form>
    </div>
    @endif
</div>


@endsection

@section('additional_modal')

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
  timeout: 1200000,
  parallelUploads: 10,

  init: function () {

      var myDropzone = this;
      // Update selector to match your button
      document.querySelector("#dropZoneSubmitter").addEventListener("click", function(e) {
        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
          alert('keine Datei abgelegt')
           throw new Error('keine Datei abgelegt');
       }
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
        // console.log(response)
        this.removeFile(file)
        $('#failContent').html('Die Datei wurde hochgeladen')
        $('#successModal').modal('show')
        $('#loaderDiv').css('display','none');
      });
      this.on("complete", function(file) {
        // this.removeAllFiles()
      });
    }
};


</script>

<script type="text/javascript">

$( document ).ready(function() {
  console.log('test')
});
$(function(){

  document.addEventListener('keydown', function(event) {
  if (event.ctrlKey && event.key === 'g') {
    $('#debugroute').toggle()
  }
})})
</script>
@endsection
