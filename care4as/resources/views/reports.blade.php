@extends('general_layout')

@section('additional_css')

@endsection

@section('content')
<div class="container  text-center bg-light">
  <h2>Reporte versenden</h2>
  <div class="row" id="app">
    <div class="col text-center bg-light">
      <h5>Top/Worst Report nach Retention Details</h5>
        <form class="" action="index.html" method="post">
          @csrf
          <div class="row  mt-1">
            <div class="col-6">
              <label for="best">Wieviele der besten Agents?</label>
              <input type="text" class="form-control" id="best" name="best" value="1">
            </div>
            <div class="col-6">
              <label for="best">Wieviele der schlechtesten Agents?</label>
              <input type="text" class="form-control" id="best" name="worst" value="1">
            </div>
          </div>
          <div class="row  mt-1">
            <div class="col-6">
              <label for="from">Von?</label>
              <input type="date" class="form-control" id="from" name="from" value="{{Carbon\Carbon::parse(App\RetentionDetail::min('call_date'))->format('Y-m-d')}}">
            </div>
            <div class="col-6">
              <label for="to">Bis?</label>
              <input type="date" class="form-control" id="to" name="to" value="{{Carbon\Carbon::parse(App\RetentionDetail::max('call_date'))->format('Y-m-d')}}">
            </div>
          </div>
          <div class="row mt-2">
            <label for="mailinglist">Emailverteiler</label>
            <input type="text" id="mailinglist" class="form-control" name="mailinglist" value="andreas.robrahn@care4as.de">
          </div>
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
