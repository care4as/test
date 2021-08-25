@extends('general_layout')

@section('additional_css')
<style media="screen">
    a{
      cursor: pointer;
    }
    textarea
     {
       max-height: none !important;
       height: 10em !important;
       border-radius: 15px;
     }
</style>
@endsection

@section('pagetitle')
  Hardwareindex
@endsection

@section('content')
<div class="container-fluid text-white center_items" style="margin-top: 50px;">
  <div class="col-md-10">
    <div class="row">
      <h4>Kapazitäten</h4>
    </div>
    <div class="row">
      <div class="col p-0 m-2">
      <table class="table table-borderless unit-translucent">
        <tr>
          <td>Flensburg OG</td>
          <td>einsatzbereite erfasste Rechner: {{DB::table('hardware_inventory')->where('type_id', 1)->where('place','Flensburg-Weiche OG')->count()}}</td>
        </tr>
        <tr>
          <td>Flensburg EG</td>
          <td>einsatzbereite erfasste Rechner: {{DB::table('hardware_inventory')->where('type_id', 1)->where('place','Flensburg-Weiche EG')->count()}}</td>
        </tr>
      </table>
      </div>
    </div>
    <div class="row">
      <h5>Hardware Liste</h5>
    </div>
    <form class="w-100" action="{{route('inventory.list')}}" method="get">
    <div class="row">
      <div class="col-md-4 p-0 m-2">
        <div class="unit-translucent p-2 ">
          <div class="">Geräteauswahl</div>
          <hr>
            <div class="">
                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                    <label for="inputState" style="margin: auto;">Art:</label>
                    <select id="inputState" class="form-control" name="device_type">
                      <option selected>Alle</option>
                      <option value="1">PC</option>
                      <option value="2">Monitor</option>
                      <option value="3">Drucker</option>
                      <option value="4">Telefone</option>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="col-md-4 p-0 m-2">
        <div class="unit-translucent p-2">
          <div class="">Ort</div>
          <hr>
            <div class="">
              <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                <label for="inputState" style="margin: auto;">Auswahl:</label>
                <select id="inputState" class="form-control" name="place">
                    <option selected>Alle</option>
                    @foreach(DB::table('hardware_inventory')->pluck('place')->unique() as $place)
                    <option value="{{$place}}">{{$place}}</option>
                    @endforeach
                </select>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-2 p-0 m-2 d-flex align-items-bottom">
        <button type="submit" class="unit-translucent" name="button">Absenden</button>
      </div>
    </div>
  </form>
    <div class="row">
      <div class="col p-0 m-2">
        <div class="table-responsive">
          <table class="table table-borderless w-100 text-white tablespacing" id="hwtable">
            <thead>
            <tr class="unit-translucent">
              <th>id</th>
              <th>Art</th>
              <th>Ort</th>
              <th>Name</th>
              <th>Kommentar</th>
              <th>Beschreibung</th>
              <th>erfasst_am</th>
              <th>Optionen</th>
            </tr>
            </thead>
            <tbody>
              @foreach($hardware as $item)
              <tr class="unit-translucent">
                <td>{{$item->id}}</td>
                <td>@if($item->type_id == 1) PC @elseif($item->type_id == 2) Monitor @endif</td>
                <td>{{$item->place}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->comment}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->created_at}}</td>
                <td><a onclick="showHWModal({{$item->id}})">HW anzeigen</a> <a href="{{route('inventory.item.delete',['id' => $item->id])}}">HW löschen</a> </td>
              @endforeach
              </tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('additional_modal')
@foreach($hardware as $item)
<div class="modal fade" id="HWModal{{$item->id}}" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg center_items" role="document">
    <div class="modal-content" >
      <div class="container-fluid bg-cool text-white center_items" >
        <div class="col-md-12">
          <div class="row">
            <h3 id="hardwarename">Einheit {{ $item->name}}</h3>
          </div>
          <div class="row center_items">
            <form class="unit-translucent w-100" action="{{route('inventory.item.update', ['id' =>  $item->id])}}" method="post">
              @csrf
              <table class="table table-borderless w-100 text-white">
                <tr>
                  <th>Wert</th>
                  <th>alter Wert</th>
                  <th>neuer Wert</th>
                </tr>
                <tr class="">
                  <th>id</th><td>{{ $item->id}} </td> <td><input type="text" class="form-control" name="id" value="{{ $item->id}}" disabled> </td>
                </tr>
                <tr>
                  <th>name</th>
                  <td>{{ $item->name}} </td>
                  <td><input type="text" name="name" class="form-control" value="{{ $item->name}}"> </td>
                </tr>
                <tr>
                  <th>Typ</th>
                  <td>@if( $item->type_id == 1) PC @elseif( $item->type_id == 2) Monitor @endif</td>
                  <td>
                    <select class="form-control" class="unit-translucent text-white" name="devicetype" id="devicetype">
                    <option value="" disabled>Wähle den Gerätetyp</option>
                    <option value="1" @if( $item->type_id == 1) selected @endif>PC</option>
                    <option value="2" @if( $item->type_id == 2) selected @endif>Monitor</option>
                    <option value="3" @if( $item->type_id == 3) selected @endif>Drucker</option>
                    <option value="4" @if( $item->type_id == 4) selected @endif>Webcam</option>
                  </select>
                </td>
                </tr>
                <tr>
                  <th>Ort</th>
                  <td>{{ $item->place}} </td>
                  <td>
                    <select class="form-control" class="unit-translucent text-white" name="place" id="place">
                      <option value="" selected disabled>Standort</option>
                      <option value="Flensburg-Weiche EG" @if( $item->place == "Flensburg-Weiche EG") selected @endif>Flensburg-Weiche EG</option>
                      <option value="Flensburg-Weiche OG"  @if( $item->place == "Flensburg-Weiche OG") selected @endif>Flensburg-Weiche OG</option>
                      <option value="Gutenbergstr." @if( $item->place == "Gutenbergstr") selected @endif>Gutenbergstr.</option>
                      <option value="Homeoffice" @if( $item->place == "Homeoffice") selected @endif>Homeoffice</option>
                    </select>
                   </td>
                </tr>
                @if( $item->type_id == 1)
                  <tr>
                    <th>Modell</th>
                    <td>{{ $item->devicePC->brand}}</td>
                    <td><input type="text" name="brand" class="form-control" value="{{ $item->devicePC->brand}}"> </td>
                  </tr>
                  <tr>
                    <th>CPU</th>
                    <td>{{ $item->devicePC->cpu}}</td>
                    <td><input type="text" name="cpu" class="form-control" value="{{ $item->devicePC->cpu}}"> </td>
                  </tr>
                  <tr>
                    <th>Anschlüsse Video</th>
                    <td>@foreach(json_decode( $item->devicePC->port) as $port) {{$port}} @endforeach</td>
                    <td>
                      <div class="form-check-inline">
                        <input class="form-check-input" name="portspc[]" type="checkbox" value="vga" id="vga" @if(in_array('vga',json_decode( $item->devicePC->port))) checked @endif>
                        <label class="form-check-label" for="vga">
                          VGA
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <input class="form-check-input" name="portspc[]" type="checkbox" value="dvi" id="dvi" @if(in_array('dvi',json_decode( $item->devicePC->port))) checked @endif>
                        <label class="form-check-label" for="dvi">
                          DVI
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <input class="form-check-input" name="portspc[]" type="checkbox" value="hdmi" id="hdmi" @if(in_array('hdmi',json_decode( $item->devicePC->port))) checked @endif>
                        <label class="form-check-label" for="hdmi">
                          HDMI
                        </label>
                      </div>
                      <div class=" form-check-inline">
                        <input class="form-check-input" name="portspc[]" type="checkbox" value="displayport" id="displayport" @if(in_array('displayport',json_decode( $item->devicePC->port))) checked @endif>
                        <label class="form-check-label" for="displayport">
                          Display Port
                        </label>
                      </div>

                    </td>
                  </tr>
                  <tr>
                    <th>Geschwindigkeit</th>
                    <td>{{$item->devicePC->speed}}</td>
                    <td><input type="text" name="speed" class="form-control" value="{{ $item->devicePC->speed}}"> </td>
                  </tr>
                  @elseif( $item->type_id == 2)
                  <tr>
                      <th>Modell</th>
                    <td>{{ $item->deviceMO->brand}}</td>
                    <td><input type="text" name="brand" class="form-control" value="{{ $item->deviceMO->brand}}"> </td>
                  </tr>
                  <tr>
                    @if(is_array(json_decode( $item->deviceMO->ports)))
                    <th>Anschlüsse Video</th>
                    <td>@foreach(json_decode( $item->deviceMO->ports) as $port) {{$port}} @endforeach</td>
                    <td>
                      <div class="form-check-inline">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="vga" id="vga" @if(in_array('vga',json_decode( $item->deviceMO->ports))) checked @endif>
                        <label class="form-check-label" for="vga">
                          VGA
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="dvi" id="dvi" @if(in_array('dvi',json_decode( $item->deviceMO->ports))) checked @endif>
                        <label class="form-check-label" for="dvi">
                          DVI
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="hdmi" id="hdmi" @if(in_array('hdmi',json_decode( $item->deviceMO->ports))) checked @endif>
                        <label class="form-check-label" for="hdmi">
                          HDMI
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="displayport" id="displayport" @if(in_array('displayport',json_decode( $item->deviceMO->ports))) checked @endif>
                        <label class="form-check-label" for="displayport">
                          Display Port
                        </label>
                      </div>

                    </td>
                    @else
                    <th>Videoanschlüsse</th>
                    <td>keine Angabe</td>
                    <td><div class="form-group col-md-6">
                      <div class="m-4">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="vga" id="vga">
                        <label class="form-check-label" for="vga">
                          VGA
                        </label>
                      </div>
                      <div class="m-4">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="dvi" id="dvi" >
                        <label class="form-check-label" for="dvi">
                          DVI
                        </label>
                      </div>
                      <div class="m-4">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="hdmi" id="hdmi" >
                        <label class="form-check-label" for="hdmi">
                          HDMI
                        </label>
                      </div>
                      <div class="m-4">
                        <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="displayport" id="displayport">
                        <label class="form-check-label" for="displayport">
                          Display Port
                        </label>
                      </div>

                    </div>
                    </td>
                    @endif
                  </tr>
                @endif
                <tr>
                  <th>Beschreibung </th> <td>{{ $item->description}} </td> <td><textarea class="form-control" rows="10" name="description">{{ $item->description}}</textarea></td>
                </tr>
                <tr>
                  <th>Kommentar</th> <td>{{ $item->comment}} </td> <td><input type="text" class="form-control" name="comment" value="{{ $item->comment}}"></td>
                </tr>
                <tr>
                  <td colspan="3"><button type="submit" class="btn-block bg-cool" name="button">Ändern</button> </td>
                </tr>
              </table>
            </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endforeach
@endsection

@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>

<script type="text/javascript">
let table = $('#hwtable').DataTable({
  dom: 'Blfrtip',
  buttons: [
          { extend: 'csv', text: '<i class="fas fa-file-csv fa-2x"></i>' },
          { extend: 'excel', text: '<i class="fas fa-file-excel fa-2x"></i>' },
          // 'excel',
      ]
})
$('#devicetype').on('change', function() {

  let devicetype = this.value

  // console.log(devicetype)

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
  function showHWModal(id){

    var host = window.location.host;

    // axios.get('http://'+host+'/care4as/care4as/public/inventory/item/show/' +id)
    // // axios.get('/inventory/item/show/' +id)
    // .then(response => {
    //
    //   console.log(response.data)
    //
    // })
    // .catch(function (err) {
    //   console.log('error HWdata')
    //   console.log(err);
    // })

    $('#HWModal'+id).modal({
      backdrop: true
    })
    $('#HWModal').modal('toggle')
    // $('.backdrop').modal('toggle')
  }
</script>
@endsection
