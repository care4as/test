@extends('general_layout')

@section('additional_css')
<style media="screen">
.max-table
{
  text-align: center;
}
</style>
@endsection

@section('content')
<div  class="container p-2" id="app">

<ships :admin="1" :user="{{Auth()->id()}}"> </ships>
</div>

@endsection
