@extends('general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container text-center bg-light p-2">
  <h2>Reporting Stundenreport</h2>
  <div class="row m-2 mt-2 shadow bg-white">
    <div class="col-8">
      @if(!App\Hoursreport::min('date'))
        <h5>keine Daten eingegeben</h5>
      @else
        <h5>Stundenreport im Zeitraum vom <u>{{Carbon\Carbon::parse(App\Hoursreport::min('date'))->format('d.m.Y')}}</u>  bis zum <u>{{Carbon\Carbon::parse(App\Hoursreport::max('date'))->format('d.m.Y ')}}</u> </h5>
      @endif
    </div>
    <div class="col-2">
      <a href="{{route('hoursreport.removeDuplicates')}}"><button type="button" class="btn btn-sm border-round" name="button">Duplikate entfernen</button></a>
    </div>
    <div class="col-2">
      <a href="{{route('hoursreport.sync')}}"><button type="button" class="btn btn-sm btn-success border-round" name="button">Userdaten verknüpfen</button></a>
    </div>
  </div>
  <div class="row m-2 mt-2 shadow bg-white" id="app">
    <div class="col text-center mt-2">
      <!-- <form action="{{route('excel.dailyAgent.upload.queue')}}" class="dropzone" id="exceldropzone" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="sheet" value="3">
        <input type="hidden" name="fromRow" value="2">
         <div class="dz-message text-dark" data-dz-message><span>Bitte Dateien einfügen</span></div>
      </form> -->
      <form class="" action="{{route('reports.reportHours.post')}}" method="post" enctype="multipart/form-data">
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

<div class="container text-center bg-light p-2">
  <div class="row m-2 bg-white">
    <h5>Noch nicht zugewiesene Datensätze</h5>
  </div>
  <div class="row m-2 bg-white">
    <table class="table table-striped table-hover table-responsive" id="hourstable">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Name</th>
          <th>Eintrag löschen</th>
          <th style="font-size: 1em;">löschen nach Name</th>
          <th style="font-size: 1em;">synchronisieren</th>
        </tr>
      </thead>
      <tbody>
        @foreach($unsyncedHoursreports as $report)
          <tr>
            <td>{{$report->id}}</td>
            <td>{{$report->date}}</td>
            <td>{{$report->name}}</td>
            <td><a href="{{route('hoursreport.delete', ['id' => $report->id])}}">
              <span class="material-icons text-dark">
              delete_forever
              </span>
              </a>
            </td>
            <td ><a href="{{route('hoursreport.deleteByName', ['name' => $report->name])}}">
              <span class="material-icons">
                delete
              </span>
              </a>
            </td>
            <td><a href="{{route('hoursreport.syncByName', ['name' => $report->name])}}">
              <span class="material-icons">
              sync
              </span>
            </a>
          </td>
          </tr>
        @endforeach
      </tbody>

    </table>
  </div>
</div>
@endsection

@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>

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

  $('#hourstable').DataTable()


});

</script>
@endsection
