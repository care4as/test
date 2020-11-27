@extends('general_layout')

@section('content')
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="row" style="background-color:rgba(114,227,242,1); border-bottom: 5px solid black;">
        <div class="col">
          <h5>titlevariabel</h5>
        </div>
        <div class="d-flex float-right align-self-center">
          <img src="" class="img-fluid p-3" alt="firmenlogo">
        </div>
      </div>
      <div class="row" style="background-color: rgba(72,72,72,1); border-bottom: 5px solid black;">
        <div class="col-12">
          <p>content</p>
        </div>
      </div>
      <div class="row bg-light">
        <div class="col text-dark">
          <p>footer</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
