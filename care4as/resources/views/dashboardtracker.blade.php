@extends('general_layout')

@section('additional_css')
<style>
    .header{
        position:sticky;
        top: 0 ;
    }
    .col
    {
      padding: 0px;
    }
    .row
    {
      margin-right: 0px !important;
      margin-left: 0px !important;
    }
    .col-designed
    {
      position: relative;
      width: 100%;
      flex: 0 0 45%;
      max-width: 45%;
    }
    .bg-care4as-light
    {
      background-color: rgba(255,127,80, 0.2);
      opacity: 1;
    }
</style>
@endsection

@section('content')

<div class="container-fluid m-1" id="app">

  <div class="row bg-care4as-light p-2 justify-content-center">
      @foreach($users as $user)
      <div class="col-designed m-3 p-1 border bg-white rounded shadow">
        <h5>{{$user->wholeName()}}</h5>
      <trackchart :userid="{{$user->id}}"> </trackchart>
      </div>
  @endforeach
  </div>
</div>

@endsection
