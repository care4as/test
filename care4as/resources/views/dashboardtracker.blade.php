@extends('general_layout')

@section('additioonal_css')
<style>
    .header{
        position:sticky;
        top: 0 ;
    }
</style>
@endsection

@section('content')

<div class="container-fluid mt-4 bg-light m-1" id="app">

  <trackchart :userid="1"> </trackchart>
</div>

@endsection
