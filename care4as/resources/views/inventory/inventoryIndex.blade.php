@extends('general_layout')

@section('additional_css')
<style media="screen">

</style>
@endsection

@section('content')
<div class="container-fluid bg-cool text-white center_items">
  <div class="col-md-12">
    <div class="row">
      <h3>Hardware Liste</h3>
    </div>
      <table class="table table-borderless w-100 text-white">
        <tr class="unit-translucent">
          <th>id</th>
          <th>Art</th>
          <th>Ort</th>
          <th>Name</th>
          <th>Kommentar</th>
          <th>Beschreibung</th>
          <th>erfasst_am</th>
        </tr>
        @foreach($hardware as $item)
        <tr class="unit-translucent">
          <td>{{$item->id}}</td>
          <td>@if($item->type_id == 1) PC @elseif($item->type_id == 2) Monitor @endif</td>
          <td>{{$item->place}}</td>
          <td>{{$item->name}}</td>
          <td>{{$item->comment}}</td>
          <td>{{$item->description}}</td>
          <td>{{$item->created_at}}</td>
        @endforeach
        </tr>
      </table>
    </div>
  </div>

@endsection

@section('additional_js')
<script type="text/javascript">
$('#devicetype').on('change', function() {

  let devicetype = this.value

  console.log(devicetype)

  switch(devicetype) {
    case '1':
      $('#pcmenu').css('display','block')
      $('#monitormenu').css('display','none')
      // console.log('test')
    break;
    case '2':
      $('#monitormenu').css('display','block')
      $('#pcmenu').css('display','none')
      // console.log('test')
    }
  })
</script>
@endsection
