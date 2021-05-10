@extends('general_layout')

@section('additional_css')
<style media="screen">

  .table-striped>tbody>tr:hover {
    transition: none;
    font-size: 1em;
    opacity: 1;
  }
th{
  width: 10em;
  text-align: center;
}
td{
  width: 10em;
  text-align: center;
}
</style>
@endsection

@section('content')

<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">

  <div class="row justify-content-center" id="mainrow" style="table-layout: fixed">
    <div class="col-12" id="maincol">
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th>Prozess</th>
            <th>Status/Optionen</th>
            <th>Beschreibung</th>
            <th>Optionen</th>
          </tr>
        </thead>
        <tr class="">
          <td>Automatische Zwischenstandsmail</td>
          <td>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(DB::table('jobs')->where('queue','default')->exists()) checked @else unchecked @endif>
              <label class="custom-control-label" for="customSwitch1">Aktiv</label>
            </div>
          </td>
          <td>
            <p>Eine automatisierte Mail der Zwischenstände (aktuell: alle 2 Stunden an folgende Adressen:@if(DB::table('email_providers')->where('name','intermediateMail')->first()) @foreach(DB::table('email_providers')->where('name','intermediateMail')->first('adresses')  as $adress) {{$adress}} @endforeach) @endif</p></td>
          </td>
          <td rowspan="2">
            <h5>Emailadressen ändern</h5>
            <form class="form-control" action="{{route('config.updateEmailprovider')}}" method="post">
              @csrf
               <label for="exampleFormControlTextarea1">Emailadressen</label>
              <textarea type="text" name="emails" class="form-control"> @if(DB::table('email_providers')->where('name','intermediateMail')->first()) @foreach( $adresses = json_decode( DB::table('email_providers')->where('name','intermediateMail')->first('adresses')->adresses) as $adress){{$adress}}@if($adress != $adresses[count($adresses)-1]); @else @endif @endforeach @endif </textarea>
              <button type="submit" name="button" class="btn btn-primary btn-sm  mt-2">Ändern</button>
            </form>

          </td>
        </tr>
        <tr>
          <td>Zwischenstandsmail versenden</td>
          <td>
            <a class="btn btn-primary btn-sm" href="{{route('config.sendIntermediateMail')}}" role="button">Go</a>
          </td>
          <td>
            Eine einmalige automatisierte Mail der Zwischenstände an @if(DB::table('email_providers')->where('name','intermediateMail')->first()) @foreach(DB::table('email_providers')->where('name','intermediateMail')->first('adresses')  as $adress) {{$adress}} @endforeach @endif
          </td>
        </tr>
        <tr>
          <td>Zwischenstand laden</td>
          <td>
            <a class="btn btn-primary btn-sm" href="{{route('reports.intermediate.sync')}}" role="button">Go</a>
          </td>
          <td>Durch druck des Buttons wird manuell ein Zwischenstand der Zahlen aus dem KDW Tool in die Care4as Datenbank geladen. !!!Wichtig!!! Eine manueller Zwischenbericht ist fehleranfälliger und sollte automatisch erfolgen</td>
        </tr>
        <tr>
          <td>Zwischenstand automatisch laden</td>
          <td>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch2" @if(DB::table('jobs')->where('queue','intermediate')->exists()) checked @else unchecked @endif>
              <label class="custom-control-label" for="customSwitch2">Aktiv</label>
            </div>
          </td>
          <td>Alle 30 Minuten wird nun ein Zwischenstand des KDW Tools gezogen</td>
        </tr>
      </table>
    </div>
  </div>
</div>

<div class="modal" id="emailProvidersModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Füge oder lösche Emails aus dem Verteiler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id='proivdername'></p>
      </div>

    </div>
  </div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript">

$('#customSwitch1').click(function(){

  if(this.checked == true)
  {

    var host = window.location.host;

    // console.log('http://'+host+'/care4as/care4as/public/config/activateIntervallMail')

    axios.get('http://'host+'/config/activateIntervallMail')
    // axios.get('http://'+host+'/care4as/care4as/public/config/activateIntervallMail')
    .then(response => {
      console.log(response.data)
      alert('die Intervallmail wird automatisch versendet')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })
  }
  else {

    var host = window.location.host;

    // axios.get('http://'+host+'/config/deactivateIntervallMail')
    axios.get('http://'+host+'/care4as/care4as/public/config/deactivateIntervallMail')

    .then(response => {
      alert('automatische Email deaktiviert')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })

  }
})

$('#customSwitch2').click(function(){

  if(this.checked == true)
  {

    var host = window.location.host;

    // console.log('http://'+host+'/care4as/care4as/public/config/activateAutomaticIntermediate')

    axios.get('http://'+host+'/config/activateAutomaticIntermediate')
    // axios.get('http://'+host+'/care4as/care4as/public/config/activateAutomaticIntermediate')
    .then(response => {
      alert('Zwischenstand wird nun automatisch geladen')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })
  }
  else {

    var host = window.location.host;

    axios.get('http://'+host+'/config/deactivateAutomaticIntermediate')
    // axios.get('http://'+host+'/care4as/care4as/pu7blic/config/deactivateAutomaticIntermediate')

    .then(response => {
      alert('automatische Zwischenstände deaktiviert')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })

  }

})
</script>
@endsection
