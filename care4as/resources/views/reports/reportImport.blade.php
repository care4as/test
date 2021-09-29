@extends('general_layout')
@section('pagetitle')
    Reporte: Import
@endsection
@section('content')

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
                                        <th style="text-align: left;">Report</th>
                                        <th>Daten von</th>
                                        <th>Daten bis</th>
                                        <th>Import</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: left;">1u1 Availbench</td>
                                        <td>xx.xx.xxxx</td>
                                        <td>xx.xx.xxxx</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">1u1 Daily Agent</td>
                                        <td>{{Carbon\Carbon::parse(App\DailyAgent::min('date'))->format('d.m.Y H:i:s')}}</td>
                                        <td>{{Carbon\Carbon::parse(App\DailyAgent::max('date'))->format('d.m.Y H:i:s')}}</td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dailyAgentModal">DA Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">1u1 OptIn Report</td>
                                        <td>{{Carbon\Carbon::parse(App\Optin::min('date'))->format('d.m.Y')}}</td>
                                        <td>{{Carbon\Carbon::parse(App\DailyAgent::max('date'))->format('d.m.Y')}}</td>
                                        <td><button type="button" class="btn btn-primary">Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">1u1 Retention Details</td>
                                        <td>{{Carbon\Carbon::parse(App\RetentionDetail::min('call_date'))->format('d.m.Y')}}</td>
                                        <td>{{Carbon\Carbon::parse(App\RetentionDetail::max('call_date'))->format('d.m.Y')}}</td>
                                        <td><button type="button" class="btn btn-primary">Importieren</button></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">KDW Stundenreport</td>
                                        <td>{{Carbon\Carbon::parse(App\Hoursreport::min('work_date'))->format('d.m.Y')}}</td>
                                        <td>{{Carbon\Carbon::parse(App\Hoursreport::max('work_date'))->format('d.m.Y')}}</td>
                                        <td><button type="button" class="btn btn-primary">Importieren</button></td>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Availbench</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px;">
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                    Datenstand
                </div>
                <div style="width: 100%; overflow-x: auto; margin-bottom: 20px;">
                    <table class="max-table" id="userListTable">
                        <thead>
                            <tr style="width: 100%">
                                <th>Von</th>
                                <th>Bis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">Datum1</td>
                                <td style="text-align: center">Datum2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                    Datei auswählen
                </div>
                <button type="button" class="btn btn-primary" style="margin-top: 0; margin-bottom: 20px;">Durchsuchen</button>
                <div style="width: 100%; font-size: 16px; font-weight: 600;">
                    Import konfigurieren
                </div>
                <div style="display: grid; grid-template-columns: auto 1fr;">
                    <div style="padding-right: 5px; align-self: center;">Blatt:</div>
                    <div><input type="text" class="form-control" placeholder="Wert..."></div>
                    <div style="padding-right: 5px; align-self: center;">Zeile:</div>
                    <div><input type="text" class="form-control" placeholder="Wert..."></div>
                </div>
            </div>
            <div class="modal-footer" style="font-size: 14px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dailyAgentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="z-index: 500000;">
        <div class="modal-content bg-cool">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Daily Agent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body unit-translucent" style="font-size: 14px;">
                  <div style="width: 100%; overflow-x: auto; margin-bottom: 20px;">
                    <table class="max-table" id="userListTable">
                        <thead>
                            <tr style="width: 100%">
                                <th>Von</th>
                                <th>Bis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">Datum1</td>
                                <td style="text-align: center">Datum2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row mt-2 " id="app">
                  <div class="col text-center p-2">
                    <form action="{{route('excel.dailyAgent.upload')}}" class="dropzone" id="exceldropzone" enctype="multipart/form-data">
                      @csrf
                      <div class="form-row dropzone-previews dz-default dz-message" id="previewContainer">
                        <p class=" w-100 text-center">Ziehe die Dateien hier rein oder klick mich!</p>
                        </div>
                        <div class="form-row mt-4">
                          <div class="col ">
                            Blatt: <input class="form-control text-dark" type="text" name="sheet" value="1"/>
                          </div>
                          <div class="col">
                            Ab Zeile: <input class="form-control text-dark" type="text" name="fromRow" value="2"/>
                          </div>
                        </div>
                      <div class="form-row mt-3 m-0 center_items" >
                        <div class="col-12 p-0" style="position:relative; overflow:hidden; height: auto; margin: 0px;">
                          <div class="shiningeffect" style="position: absolute; background-color: rgba(255,255,255,0.3); width: 50%;">
                          </div>
                          <button type="button " id="dropZoneSubmitter" class="btn btn-primary btn-sm btn-block m-0 " name="button">Absenden</button>
                        </div>
                        </div>
                    </form>
                  </div>
                </div>
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
