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
          <td><p>du erhälst an deine persönliche Emailadresse : {{Auth()->user()->email}} 1 Minute nach jedem Intervall eine Email zur aktuellen Performance und zum Vergleich im Vorintervall</p></td>

          </td>
        </tr>
        <tr>
          <td>Zwischenstandsmail versenden</td>
          <td>
            <a class="btn btn-primary btn-sm" href="{{route('config.sendIntermediateMail')}}" role="button">Go</a>
          </td>
          <td>test</td>
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

    // axios.get('/config/activateIntervallMail')
    axios.get('http://'+host+'/care4as/care4as/public/config/activateIntervallMail')
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

    console.log('http://'+host+'/care4as/care4as/public/config/activateAutomaticIntermediate')

    // axios.get('./activateIntermediateMail')
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

    // axios.get(host+'/deactivateIntermediateMail')
    axios.get('http://'+host+'/care4as/care4as/public/config/deactivateAutomaticIntermediate')

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
