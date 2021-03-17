@extends('general_layout')

@section('additional_css')

@endsection

@section('content')
<div class="container  text-center bg-light">
  <div class="row " id="app">
    <div class="col-12">
      <h5>Top/Worst Report gemäß den  Retention Details</h5>
    </div>

    <div class="col mt-3 text-center  d-flex justify-content-center ">
        <form class="w-75" action="{{route('report.bestworst')}}" method="post">
          @csrf
          <div class="row bg-white m-2 shadow rounded-top">
            <div class="col-6 p-1">
              <label for="best">Wieviele der besten Agents?</label>
              <input type="text" class="form-control" id="best" name="best" value="1">
            </div>
            <div class="col-6 p-1">
              <label for="best">Wieviele der schlechtesten Agents?</label>
              <input type="text" class="form-control" id="best" name="worst" value="1">
            </div>
          </div>
          <hr>
          <div class="row bg-white m-2 shadow rounded-top">
            <div class="col-6 p-1">
              <label for="from">Von?</label>
              <input type="date" class="form-control" id="from" name="from" min="{{Carbon\Carbon::parse(App\RetentionDetail::min('call_date'))->format('Y-m-d')}}" max="{{Carbon\Carbon::parse(App\RetentionDetail::max('call_date'))->format('Y-m-d')}}">
            </div>
            <div class="col-6 p-1">
              <label for="to">Bis?</label>
              <input type="date" class="form-control" id="to" name="to" min="{{Carbon\Carbon::parse(App\RetentionDetail::min('call_date'))->format('Y-m-d')}}" max="{{Carbon\Carbon::parse(App\RetentionDetail::max('call_date'))->format('Y-m-d')}}">
            </div>
          </div>
          <hr>
          <div class="row bg-white m-2 justify-content-center shadow rounded">
            <div class="col-12 d-flex justify-content-center">
              <h5>Emaileinstellungen</h5>
            </div>
            <div class="col mt-2 p-1">
              <div class="row m-2 justify-content-center">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="asEmail" id="emailSwitch">
                  <label class="custom-control-label" for="emailSwitch">Als Email?</label>
                </div>
              </div>
              <hr class="shadow">
              <div class="row justify-content-center m-2">
                <label for="mailinglist">Emailverteiler</label>
                <input type="text" id="mailinglist" class="form-control" name="mailinglist" value="andreas.robrahn@care4as.de" disabled>
              </div>
            </div>
          </div>
          <div class="row bg-white shadow border rounded m-2">
            <div class="col-12">
              <h5>weitere Einstellungen</h5>
            </div>
            <div class="col-12">
              <div class="row m-2 justify-content-start">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="mobile" id="mobileSwitch">
                  <label class="custom-control-label" for="mobileSwitch">Mobile</label>
                </div>
              </div>
              <div class="row m-2 justify-content-start">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="dsl" id="dslSwitch">
                  <label class="custom-control-label" for="dslSwitch">DSL</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <label for="department">Ausgenommen werden folgende Mitarbeiter:</label>
                <select multiple class="form-control" name="employees[]" id="exampleFormControlSelect2" style="height: 150px; overflow:scroll;">
                  @foreach($users1 = App\User::where('role','agent')->orderBy('lastname')->get() as $user)
                    <option value="{{$user->id}}">{{$user->surname}} {{$user->lastname}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="row m-2">
            <button type="submit" class="btn btn-success btn-block rounded" name="button">Absenden</button>
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
  $('#emailSwitch').change(function(){
    if(this.checked) {

      $('#mailinglist').prop('disabled', false);
    }
    else {
      $('#mailinglist').prop('disabled', true);
    }

  })
});

</script>
@endsection
