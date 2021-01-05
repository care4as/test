@extends('..general_layout')

@section('additional_css')
<style media="screen">

</style>
@endsection

@section('content')
<div class="container  text-center bg-light">
  <h2>Reporting</h2>
  <div class="row" id="app">
    <div class="col text-center bg-light">
      <table class="table table-hover">
        <tr>
          <th>#</th>
          <th>Datum</th>
          <th>Vertragsnummer</th>
          <th>Save Agent</th>
          <th>von</th>
        </tr>
        @foreach($data as $row)
        <tr>
          <td>{{$row->id}}</td>
          <td>{{$row->date}}</td>
          <td>{{$row->contractnumber}}</td>
          <td>{{$row->SaveAgent}}</td>
          <td>{{$row->edited_by}}</td>
        </tr>
        @endforeach
      </table>
    </div>

  </div>
</div>

@endsection

@section('additional_js')
<script type="text/javascript">

</script>
@endsection
