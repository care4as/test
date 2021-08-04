@extends('general_layout')

@section('additional_css')

@endsection

@section('content')
<div class="container-fluid bg-cool text-white center_items">
  <div class="col-md-12">
    <div class="row">
      <h3>Item {{$item->name}}</h3>
    </div>
    <div class="row">
      <form class="unit-translucent" action="inventory.item.update, ['id' => $item->id]" method="post">
        <table class="table table-borderless w-100 text-white">
          <tr>
            <th>Wert</th>
            <th>alter Wert</th>
            <th>neuer Wert</th>
          </tr>
          <tr class="">
            <th>id</th>   <td>{{$item->id}} </td> <td><input type="text" class="form-control" name="id" value="{{$item->id}}" disabled> </td>
          </tr>
          <tr>
            <th>name</th>
            <td>{{$item->name}} </td>
            <td><input type="text" name="name" class="form-control" value="{{$item->name}}"> </td>
          </tr>
          <tr>
            <th>Typ</th>
            <td>@if($item->type_id == 1) PC @elseif($item->type_id == 2) Monitor @endif</td>
            <td><input type="text" name="type" value="@if($item->type_id == 1) PC @elseif($item->type_id == 2) Monitor @endif">
          </tr>
          <tr>
            <th>Ort</th>
            <td>{{$item->place}} </td>
            <td><input type="text" name="" value="{{$item->place}}"> </td>
          </tr>
          <tr>
            <th>Beschreibung </th> <td>{{$item->description}} </td> <td><input type="text" name="" value="{{$item->description}}"></td>
          </tr>
          <tr>
            <th>Kommentar</th> <td>{{$item->comment}} </td> <td><input type="text" name="" value="{{$item->comment}}"></td>
          </tr>
          <tr>
            <td colspan="3"><button type="button" class="btn-block bg-cool" name="button">Ändern</button> </td>
          </tr>
        </table>
      </form>
      </div>
    </div>
  </div>
@endsection

@section('additional_js')
<script type="text/javascript">

</script>
@endsection
