@extends('general_layout')
@section('pagetitle')
    Reporte: Import
@endsection
@section('content')

@section('additional_css')
<link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
<style media="screen">
  .loadingerDA, .loadingerAB, .loadingerRD
  {
    animation: blink 2s infinite;
  }
  @keyframes blink {
  from {color: black;}
  to {color: white;}
  }
</style>
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="max-main-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="max-panel bg-none">
                        <div class="max-panel-title">Reporte importieren</div>
                        <div class="max-panel-content">
                            <table class="table" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">Report Test</th>
                                        <th>Daten von</th>
                                        <th>Daten bis</th>
                                        <th>Import</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="loadingerAB">
                                        <td style="text-align: left; font-weight: 600;">1u1 Availbench</td>
                                        <td id="" >Daten werden geladen</td>
                                        <td id=""></td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#availbenchModal">Importieren</button></td>
                                    </tr>
                                    <tr id="avData" style="display:none;">
                                        <td style="text-align: left; font-weight: 600;">1u1 Availbench</td>
                                        <td id="availbenchStart">xxx</td>
                                        <td id="availbenchEnd">xxx</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#availbenchModal">Importieren</button></td>
                                    </tr>
                                    <tr class="loadingerDA">
                                        <td style="text-align: left; font-weight: 600;">1u1 Daily Agent</td>
                                        <td id="" >Daten werden geladen</td>
                                        <td id=""></td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dailyAgentModal">Importieren</button></td>
                                    </tr>
                                    <tr id="dailyagentData" style="display:none;">
                                        <td style="text-align: left; font-weight: 600;">1u1 Daily Agent</td>
                                        <td id="dailyAgentStart">1</td>
                                        <td id="dailyAgentEnd">1</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dailyAgentModal">Importieren</button></td>
                                    </tr>
                                    <tr class="loadingerOptin">
                                        <td style="text-align: left; font-weight: 600;">1u1 OptIn</td>
                                        <td id="">Daten werden geladen</td>
                                        <td id=""></td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#optinModal">Importieren</button></td>
                                    </tr>
                                    <tr id="OptinDataStatus" style="display:none;">
                                        <td style="text-align: left; font-weight: 600;">1u1 OptIn</td>
                                        <td id="optinStart">1</td>
                                        <td id="optinEnd">1</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#optinModal">Importieren</button></td>
                                    </tr>
                                    <tr class="loadingerRD" >
                                        <td style="text-align: left; font-weight: 600;">1u1 Retention Details</td>
                                        <td id="">Daten werden geladen</td>
                                        <td id=""></td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#retDetailsModal">Importieren</button></td>
                                    </tr>
                                    <tr id="RDDataStatus" style="display:none;">
                                        <td style="text-align: left; font-weight: 600;">1u1 Retention Details</td>
                                        <td id="retDetailsStart">xxx</td>
                                        <td id="retDetailsEnd">xxx</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#retDetailsModal">Importieren</button></td>
                                    </tr>
                                    <tr class="loadingerSAS">
                                        <td style="text-align: left; font-weight: 600;">1u1 SaS</td>
                                        <td id="">Daten werden geladen</td>
                                        <td id=""></td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#retDetailsModal">Importieren</button></td>
                                    </tr>
                                    <tr id="SASDataStatus" style="display:none;">
                                        <td style="text-align: left; font-weight: 600;">1u1 SaS</td>
                                        <td id="sasStart">sas</td>
                                        <td id="sasEnd">sas</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sasModal">Importieren</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('additional_modal')
<!-- Availbench -->
<div class="modal fade" id="availbenchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Availbench</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width: 100%; font-size: 16px; font-weight: 600;">
                     Datei auswählen
                    </div>
                    <form action="{{route('availbench.upload')}}" class="dropzone" id="availbenchDropzone" enctype="multipart/form-data">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="availbenchContainer" style="min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                            <button type="button" id="availbenchDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- Daily Agent -->
<div class="modal fade" id="dailyAgentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Daily Agent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width: 100%; font-size: 16px; font-weight: 600;">
                     Datei auswählen
                    </div>
                    <form action="{{route('excel.dailyAgent.upload')}}" class="dropzone" id="dailyAgentDropzone" enctype="multipart/form-data">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="dailyAgentContainer" style="min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="1"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                            <button type="button" id="dailyAgentDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- OptIn -->
<div class="modal fade" id="optinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">OptIn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width: 100%; font-size: 16px; font-weight: 600;">
                     Datei auswählen
                    </div>
                    <form action="{{route('reports.OptIn.upload')}}" class="dropzone" id="optinDropzone" enctype="multipart/form-data">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="optinContainer" style="min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="1"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                            <button type="button" id="optinDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- Retention Details -->
<div class="modal fade" id="retDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Retention Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width: 100%; font-size: 16px; font-weight: 600;">
                     Datei auswählen
                    </div>
                    <form action="{{route('excel.test')}}" class="dropzone" id="retDetailsDropzone" enctype="multipart/form-data">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="retDetailsContainer" style="min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="1"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                            <button type="button" id="retDetailsDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- SaS -->
<div class="modal fade" id="sasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">SaS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="app">
                <div class="modal-body" style="font-size: 14px;">
                    <div style="width: 100%; font-size: 16px; font-weight: 600;">
                     Datei auswählen
                    </div>
                    <form action="{{route('reports.SAS.upload')}}" class="dropzone" id="sasDropzone" enctype="multipart/form-data">
                    @csrf
                        <div class="form-row dropzone-previews dz-default dz-message" id="sasContainer" style="min-height: 100px; width: auto; border: 1px solid black; box-shadow: none; background-color: #E3E3E3; border-radius: 5px;">
                            <p class="w-100 text-center" style="margin-bottom: 0;">Ziehe Dateien in dieses Fenster oder klicke darauf.</p>
                        </div>
                        <div style="width: 100%; font-size: 16px; font-weight: 600; margin-top: 20px;">
                            Import konfigurieren
                        </div>
                        <div style="display: grid; grid-template-columns: auto 1fr; grid-gap: 5px;">
                            <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                            <div><input type="text" class="form-control" name="sheet" placeholder="Wert..." style="color: black;" value="2"></div>
                            <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                            <div><input type="text" class="form-control" name="fromRow" placeholder="Wert..." style="color: black;" value="2"></div>
                        </div>
                </div>
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                            <button type="button" id="sasDropZoneSubmitter" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript">

Dropzone.options.availbenchDropzone = {
  previewsContainer: "#availbenchContainer",
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
      document.querySelector("#availbenchDropZoneSubmitter").addEventListener("click", function(e) {
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


Dropzone.options.dailyAgentDropzone = {
  previewsContainer: "#dailyAgentContainer",
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
      document.querySelector("#dailyAgentDropZoneSubmitter").addEventListener("click", function(e) {
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

Dropzone.options.optinDropzone = {
  previewsContainer: "#optinContainer",
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
      document.querySelector("#optinDropZoneSubmitter").addEventListener("click", function(e) {
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

Dropzone.options.retDetailsDropzone = {
  previewsContainer: "#retDetailsContainer",
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
      document.querySelector("#retDetailsDropZoneSubmitter").addEventListener("click", function(e) {
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

Dropzone.options.sasDropzone = {
  previewsContainer: "#sasContainer",
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
      document.querySelector("#sasDropZoneSubmitter").addEventListener("click", function(e) {
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
      });
    }
};

</script>

<script type="text/javascript">

$( document ).ready(function() {
  loadData('dailyAgentDataStatus','#dailyagentData','.loadingerDA')

  loadData('SASStatus','#SASDataStatus','.loadingerSAS')
  //
  loadData('OptinStatus','#OptinDataStatus','.loadingerOptin')
  //
  loadData('RDDataStatus','#RDDataStatus', '.loadingerRD')

});
$(function(){

  document.addEventListener('keydown', function(event) {
  if (event.ctrlKey && event.key === 'g') {
    $('#debugroute').toggle()
  }
})})
</script>

@endsection
