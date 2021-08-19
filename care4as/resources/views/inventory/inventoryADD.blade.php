@extends('general_layout')

@section('pagetitle')
  Hardware hinzufügen
@endsection

@section('additional_css')
<style media="screen">
  #pcmenu, #monitormenu
  {
    display: none;
  }
</style>
@endsection

@section('content')
<div class="container bg-cool text-white center_items">
  <div class="col-md-8">
    <div class="row">
      <h3>Hardware Item hinzufügen</h3>
    </div>
    <div class="row">
      <form class="w-100" action="{{route('inventory.add')}}" method="post">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputPassword4">Gerätetyp</label><br>
            <select class="form-control" class="unit-translucent text-white" name="devicetype" id="devicetype">
              <option value="" selected disabled>Wähle den Gerätetyp</option>
              <option value="1">PC</option>
              <option value="2">Monitor</option>
              <option value="3">Drucker</option>
              <option value="4">Webcam</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="place">Standort</label><br>
            <select class="form-control" class="unit-translucent text-white" name="place" id="place">
              <option value="" selected disabled>Standort</option>
              <option value="Flensburg-Weiche EG">Flensburg-Weiche EG</option>
              <option value="Flensburg-Weiche OG">Flensburg-Weiche OG</option>
              <option value="Gutenbergstr.">Gutenbergstr.</option>
              <option value="Homeoffice">Homeoffice</option>
            </select>
          </div>
        </div>
        <hr>
        <div class="container p-0" id="pcmenu">
          <div class="form-row ">
            <div class="form-group col-md-12">
              <h5>PC Zusatzinfo</h5>
            </div>
            <div class="form-group col-md-6">
              <label for="brand">Typ, Marke</label>
              <input type="text" name="brandpc" id="brandpc" value="" class="form-control">
            </div>

            <div class="form-group col-md-6">
              <label for="cpufamily">CPU Familie</label>
              <input type="text" name="cpufamily" id="cpufamily" value="" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label for="cpu">CPU</label>
              <input type="text" name="cpu" id="cpu" value="" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label for="speed">Geschwindigkeit</label>
              <input type="text" name="speed" id="speed" value="" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <div class="m-1">
                Display Connections
              </div>
              <div class="m-4">
                <input class="form-check-input" name="portspc[]" type="checkbox" value="vga" id="vga">
                <label class="form-check-label" for="vga">
                  VGA
                </label>
              </div>
              <div class="m-4">
                <input class="form-check-input" name="portspc[]" type="checkbox" value="dvi" id="dvi">
                <label class="form-check-label" for="dvi">
                  DVI
                </label>
              </div>
              <div class="m-4">
                <input class="form-check-input" name="portspc[]" type="checkbox" value="hdmi" id="hdmi">
                <label class="form-check-label" for="hdmi">
                  HDMI
                </label>
              </div>
              <div class="m-4">
                <input class="form-check-input" name="portspc[]" type="checkbox" value="displayport" id="displayport">
                <label class="form-check-label" for="displayport">
                  Display Port
                </label>
              </div>

            </div>

          </div>
        </div>
        <div class="container p-0" id="monitormenu">
          <div class="form-row" >
            <div class="form-group col-md-12">
              <h5>Monitor Zusatzinfo</h5>
            </div>
            <div class="form-group col-md-6">
              <label for="brand">Typ, Marke</label>
              <input type="text" name="brandmonitor" id="brandmonitor" value="" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label for="brand">Größe</label>
              <input type="text" name="size" id="size" value="" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <div class="m-1">
                Display Connections
              </div>
              <div class="m-4">
                <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="vga" id="vga">
                <label class="form-check-label" for="vga">
                  VGA
                </label>
              </div>
              <div class="m-4">
                <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="dvi" id="dvi">
                <label class="form-check-label" for="dvi">
                  DVI
                </label>
              </div>
              <div class="m-4">
                <input class="form-check-input" name="portsmonitor[]" type="checkbox" value="hdmi" id="hdmi">
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
          </div>
        </div>
        <hr>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="">Seriennummer</label>
            <input type="text" name="serialnumber" value="" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <label for="brand">Name, interne Bezeichnung</label>
            <input type="text" name="name" id="name" value="" class="form-control">
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="description">Beschreibung</label>
              <textarea name="description" id="description" class="form-control" rows="8" cols="200"></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="comment">Kommentar</label>
              <textarea name="comment" id="comment" class="form-control" rows="8" cols="200"></textarea>
            </div>
          </div>
          <div class="form-row w-100">
            <button type="submit" class="btn-lg btn-block btn-rounded btn-success" name="button">Absenden</button>
          </div>
        </form>
      </div>
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
