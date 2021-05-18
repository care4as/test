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
.bordered
{
  border: 4px solid black;
  border-bottom: 4px solid black !important;
  border-top: 0px solid black !important;
  border-collapse: collapse;
}

</style>
@endsection

@section('content')

<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">

<div class="row">
  <div class="nav-tabs-navigation">
    <div class="nav-tabs-wrapper">
      <ul class="nav nav-tabs" data-tabs="tabs">
          <li class="nav-item">
              <a class="nav-link active" href="#settings" data-toggle="tab">Einstellungen</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#rpi" data-toggle="tab">laufende Prozesse</a>
          </li>
          <!-- <li class="nav-item">
              <a class="nav-link" href="#history" data-toggle="tab">Weitere Funktion</a>
          </li> -->
      </ul>
    </div>
  </div>
</div>
  <div class="tab-content">
      <div id="settings" class="tab-pane fade in show active">
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
          <tr class="" style="">
            <td>Automatische Zwischenstandsmail Mobile</td>
            <td>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(DB::table('jobs')->where('queue','MailMobile')->exists()) checked @else unchecked @endif>
                <label class="custom-control-label" for="customSwitch1">Aktiv</label>
              </div>
            </td>
            <td>
              <p>Eine automatisierte Mail der Zwischenstände (aktuell: alle 2 Stunden an folgende Adressen:@if(DB::table('email_providers')->where('name','intermediateMailMobile')->first()) @foreach(DB::table('email_providers')->where('name','intermediateMailMobile')->first('adresses')  as $adress) {{$adress}} @endforeach) @endif</p></td>
            </td>
            <td rowspan="1" class="">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailProvidersModal">
              Verteiler
            </button>
            </td>
          </tr>
          <tr class="" style="">
            <td>Automatische Zwischenstandsmail DSL</td>
            <td>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch11" @if(DB::table('jobs')->where('queue','MailDSL')->exists()) checked @else unchecked @endif>
                <label class="custom-control-label" for="customSwitch11">Aktiv</label>
              </div>
            </td>
            <td>
              <p>Eine automatisierte Mail der Zwischenstände (aktuell: alle 2 Stunden an folgende Adressen:@if(DB::table('email_providers')->where('name','intermediateMailMobile')->first()) @foreach(DB::table('email_providers')->where('name','intermediateMailMobile')->first('adresses')  as $adress) {{$adress}} @endforeach) @endif</p></td>
            </td>
            <td rowspan="1" class="">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailProvidersModal">
              Verteiler
            </button>
            </td>
          </tr>
          <tr class="">
            <td class="">Zwischenstandsmail Mobile versenden</td>
            <td class="">
              <a class="btn btn-primary btn-sm" href="{{route('config.sendIntermediateMail',['isMobile' => true])}}" role="button">Go</a>
            </td>
            <td>
              Eine einmalige automatisierte Mail der Zwischenstände an @if(DB::table('email_providers')->where('name','intermediateMailMobile')->first()) @foreach(DB::table('email_providers')->where('name','intermediateMailMobile')->first('adresses')  as $adress) {{$adress}} @endforeach @endif
            </td>
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailProvidersModal">
            Verteiler
          </button></td>
          </tr>
          <tr class="">
            <td class="">Zwischenstandsmail DSL versenden</td>
            <td class="">
              <a class="btn btn-primary btn-sm" href="{{route('config.sendIntermediateMail',['isMobile' => false])}}" role="button">Go</a>
            </td>
            <td>
              Eine einmalige automatisierte Mail der Zwischenstände an @if(DB::table('email_providers')->where('name','intermediateMailDSL')->first()) @foreach(DB::table('email_providers')->where('name','intermediateMailDSL')->first('adresses')  as $adress) {{$adress}} @endforeach @endif
            </td>
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailProvidersModal">
            Verteiler
          </button></td>
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
      <div id="rpi" class="tab-pane fade in active">
        <div class="row justify-content-center" id="mainrow" style="table-layout: fixed">
      <div class="col-12" id="maincol">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Prozess</th>
              <th>Wird fällig zu</th>
              <th>Status/Optionen</th>
              <th>Optionen</th>
            </tr>
          </thead>
          <tbody>
            @foreach($processes as $process)
              <tr>
                @if($process->queue == 'intermediate')
                  <td>Zwischenstand laden</td>

                @elseif($process->queue == 'MailMobile')
                  <td>Zwischenstandsmail Mobile versenden</td>
                @elseif($process->queue == 'MailDSL')
                  <td>Zwischenstandsmail DSL versenden</td>
                @endif
                <td> {{$process->duedate}}</td>
                <td><a href="{{$process->id}}" class="btn btn-danger rounded-circle">X</a></td>

              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="emailProvidersModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adde oder lösche Mailadressen aus dem Verteiler für die Zwischenstandsmail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Bitte füge die Adressen in folgendem Schema hinzu um den reibungslosen Ablauf sicher zu stellen: max.mustermann@testmail.de;testuser@abc.de</p>
        <p id='proivdername'>
          <form class="form-control" action="{{route('config.updateEmailprovider')}}" method="post">
            @csrf
             <label for="exampleFormControlTextarea1" class="text-center">Emailadressen Mobile</label>
            <textarea type="text" name="emails" class="form-control"> @if(DB::table('email_providers')->where('name','intermediateMailMobile')->first()) @foreach( $adresses = json_decode( DB::table('email_providers')->where('name','intermediateMailMobile')->first('adresses')->adresses) as $adress){{$adress}}@if($adress != $adresses[count($adresses)-1]);@else @endif @endforeach @endif </textarea>
            <input type="hidden" name="providername" value="intermediateMailMobile">
            <button type="submit" name="button" class="btn btn-primary btn-sm  mt-2">Ändern</button>
          </form></p>
          <form class="form-control" action="{{route('config.updateEmailprovider')}}" method="post">
            @csrf
             <label for="exampleFormControlTextarea1">Emailverteiler DSL</label>
            <textarea type="text" name="emails" class="form-control"> @if(DB::table('email_providers')->where('name','intermediateMailDSL')->first()) @foreach( $adresses = json_decode( DB::table('email_providers')->where('name','intermediateMailDSL')->first('adresses')->adresses) as $adress){{$adress}}@if($adress != $adresses[count($adresses)-1]);@else @endif @endforeach @endif </textarea>
            <input type="hidden" name="providername" value="intermediateMailDSL">
            <button type="submit" name="button" class="btn btn-primary btn-sm  mt-2">Ändern</button>
          </form></p>
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
    // console.log('http://'+host+'/care4as/care4as/public/config/activateIntervallMailMobile')
    // axios.get('http://'+host+'/config/activateIntervallMailMobile')
    axios.get('http://'+host+'/care4as/care4as/public/config/activateIntervallMailMobile')
    .then(response => {
      console.log(response.data)
      alert('die Intervallmail Mobile wird automatisch versendet')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })
  }
  else {

    var host = window.location.host;

    // axios.get('http://'+host+'/config/deactivateIntervallMail')
    axios.get('http://'+host+'/care4as/care4as/public/config/deactivateIntervallMailMobile')

    .then(response => {
      alert('automatische Email deaktiviert')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })

  }
})
$('#customSwitch11').click(function(){

  if(this.checked == true)
  {
    var host = window.location.host;
    // console.log('http://'+host+'/care4as/care4as/public/config/activateIntervallMailMobile')
    // axios.get('http://'+host+'/config/activateIntervallMailMobile')
    axios.get('http://'+host+'/care4as/care4as/public/config/activateIntervallMailDSL')
    .then(response => {
      console.log(response.data)
      alert('die Intervallmail DSL wird automatisch versendet')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })
  }
  else {

    var host = window.location.host;

    // axios.get('http://'+host+'/config/deactivateIntervallMail')
    axios.get('http://'+host+'/care4as/care4as/public/config/deactivateIntervallMailDSL')

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

    // axios.get('http://'+host+'/config/activateAutomaticIntermediate')
    axios.get('http://'+host+'/care4as/care4as/public/config/activateAutomaticIntermediate')
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
