@extends('general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container  text-center bg-light">
  <h2>Reporting</h2>
  <hr>
  <div class="row" id="app">
    <div class="col p-0">
      <div class="row">
        <div class="col">
          <p><h4> Buchungslisten </h4> </p>
          <p>Link: Z:\1und1 DSL RET IB\Agenten\NACHARBEITS-AV\DSL_MOB_Shared\01_Buchungsliste\ + Monatsordner</p>
        </div>

      </div>
      <div class="row">
        <div class="col text-center bg-light">
          <form action="{{route('excel.provision.upload')}}" method="post" class="dropzone" id="exceldropzone" enctype="multipart/form-data">
            @csrf
            <div class="dz-message text-dark" data-dz-message><span>Bitte Dateien einfügen</span></div>
          </form>

          <!-- <form class="" action="{{route('excel.provision.upload')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" value="">
            <button type="submit" class="btn-rounded btn-block btn-success"name="button">Absenden</button>
          </form> -->
        </div>
      </div>
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
  maxFilesize: 2, // MB

  dictRemoveFile: 'doch nicht',
  dictRemoveFile: 'entfernen',
  autoProcessQueue: true,
};
</script>

<script type="text/javascript">

$( document ).ready(function() {

  console.log('test')


});

</script>
@endsection
