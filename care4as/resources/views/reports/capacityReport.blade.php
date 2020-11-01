@extends('..general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container  text-center bg-light">
  <h2>Capacity-Suit Report einpflegen</h2>
  <div class="row" id="app">
    <div class="col text-center bg-light">
      <!-- <form action="/file-upload" class="dropzone" id="exceldropzone">
        <!-- <div class="dz-message text-dark" data-dz-message><span>Bitte Dateien einfügen</span></div>
      </form> -->

      <form class="" action="{{route('reports.capacitysuitreport.upload')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" value="" >
        <button type="submit" name="button">Absenden</button>
      </form>

    </div>

  </div>
</div>
<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->

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
  autoProcessQueue: false,
};
</script>

<script type="text/javascript">

$( document ).ready(function() {

  console.log('test')


});
@endsection
