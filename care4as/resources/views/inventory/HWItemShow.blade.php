@extends('general_layout')

@section('additional_css')

@endsection

@section('content')
<div class="container-fluid bg-cool text-white center_items">
  <div class="col-md-12">
    <div class="row">
      <h3>Item {{$item->name}}</h3>
    </div>
    <div class="row center_items">
      <form class="unit-translucent w-75" action="{{route('inventory.item.update', ['id' => $item->id])}}" method="post">
        @csrf
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
            <td>
              <select class="form-control" class="unit-translucent text-white" name="devicetype" id="devicetype">
              <option value="" disabled>Wähle den Gerätetyp</option>
              <option value="1" @if($item->type_id == 1) selected @endif>PC</option>
              <option value="2" @if($item->type_id == 2) selected @endif>Monitor</option>
              <option value="3" @if($item->type_id == 3) selected @endif>Drucker</option>
              <option value="4" @if($item->type_id == 4) selected @endif>Webcam</option>
            </select>
          </td>
          </tr>
          <tr>
            <th>Ort</th>
            <td>{{$item->place}} </td>
            <td>
              <select class="form-control" class="unit-translucent text-white" name="place" id="place">
                <option value="" selected disabled>Standort</option>
                <option value="Flensburg-Weiche EG" @if($item->place == "Flensburg-Weiche EG") selected @endif>Flensburg-Weiche EG</option>
                <option value="Flensburg-Weiche OG"  @if($item->place == "Flensburg-Weiche OG") selected @endif>Flensburg-Weiche OG</option>
                <option value="Gutenbergstr." @if($item->place == "Gutenbergstr") selected @endif>Gutenbergstr.</option>
                <option value="Homeoffice" @if($item->place == "Homeoffice") selected @endif>Homeoffice</option>
              </select>
             </td>
          </tr>
          @if($item->type_id == 1)
            <tr>
              <th>Modell</th>
              <td>{{$item->devicePC->brand}}</td>
              <td><input type="text" name="brand" class="form-control" value="{{$item->devicePC->brand}}"> </td>
            </tr>
            <tr>
              <th>CPU</th>
              <td>{{$item->devicePC->cpu}}</td>
              <td><input type="text" name="cpu" class="form-control" value="{{$item->devicePC->cpu}}"> </td>
            </tr>
            <tr>
              <th>Anschlüsse Video</th>
              <td>@foreach(json_decode($item->devicePC->port) as $port) {{$port}} @endforeach</td>
              <td><div class="form-group col-md-6">
                <div class="m-4">
                  <input class="form-check-input" name="portspc[]" type="checkbox" value="vga" id="vga" @if(in_array('vga',json_decode($item->devicePC->port))) checked @endif>
                  <label class="form-check-label" for="vga">
                    VGA
                  </label>
                </div>
                <div class="m-4">
                  <input class="form-check-input" name="portspc[]" type="checkbox" value="dvi" id="dvi" @if(in_array('dvi',json_decode($item->devicePC->port))) checked @endif>
                  <label class="form-check-label" for="dvi">
                    DVI
                  </label>
                </div>
                <div class="m-4">
                  <input class="form-check-input" name="portspc[]" type="checkbox" value="hdmi" id="hdmi" @if(in_array('hdmi',json_decode($item->devicePC->port))) checked @endif>
                  <label class="form-check-label" for="hdmi">
                    HDMI
                  </label>
                </div>
                <div class="m-4">
                  <input class="form-check-input" name="portspc[]" type="checkbox" value="displayport" id="displayport" @if(in_array('displayport',json_decode($item->devicePC->port))) checked @endif>
                  <label class="form-check-label" for="displayport">
                    Display Port
                  </label>
                </div>

              </div>
              </td>
            </tr>
            <tr>
              <th>Geschwindigkeit</th>
              <td>{{$item->devicePC->speed}}</td>
              <td><input type="text" name="speed" class="form-control" value="{{$item->devicePC->speed}}"> </td>
            </tr>
          @elseif($item->type_id == 2)
            <tr>
                <th>Modell</th>
              <td>{{$item->deviceMO->brand}}</td>
              <td><input type="text" name="brand" class="form-control" value="{{$item->deviceMO->brand}}"> </td>
            </tr>
            <tr>
              @if(is_array(json_decode($item->deviceMO->ports)))
              <th>Anschlüsse Video</th>
              <td>@foreach(json_decode($item->deviceMO->ports) as $port) {{$port}} @endforeach</td>
              <td><div class="form-group col-md-6">
                <div class="m-4">
                  <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="vga" id="vga" @if(in_array('vga',json_decode($item->deviceMO->ports))) checked @endif>
                  <label class="form-check-label" for="vga">
                    VGA
                  </label>
                </div>
                <div class="m-4">
                  <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="dvi" id="dvi" @if(in_array('dvi',json_decode($item->deviceMO->ports))) checked @endif>
                  <label class="form-check-label" for="dvi">
                    DVI
                  </label>
                </div>
                <div class="m-4">
                  <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="hdmi" id="hdmi" @if(in_array('hdmi',json_decode($item->deviceMO->ports))) checked @endif>
                  <label class="form-check-label" for="hdmi">
                    HDMI
                  </label>
                </div>
                <div class="m-4">
                  <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="displayport" id="displayport" @if(in_array('displayport',json_decode($item->deviceMO->ports))) checked @endif>
                  <label class="form-check-label" for="displayport">
                    Display Port
                  </label>
                </div>

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
            <th>Beschreibung </th> <td>{{$item->description}} </td> <td><input type="text" class="form-control" name="description" value="{{$item->description}}"></td>
          </tr>
          <tr>
            <th>Kommentar</th> <td>{{$item->comment}} </td> <td><input type="text" class="form-control" name="comment" value="{{$item->comment}}"></td>
          </tr>
          <tr>
            <td colspan="3"><button type="submit" class="btn-block bg-cool" name="button">Ändern</button> </td>
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
