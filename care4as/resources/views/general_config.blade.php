@extends('general_layout')

@section('additional_css')
<style media="screen">

  .table-striped>tbody>tr:hover {
    transition: none;
    font-size: 1em;
    opacity: 1;
  }
</style>
@endsection

@section('content')

<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">

  <div class="row justify-content-center" id="mainrow">
    <div class="col-6" id="maincol">
      <table class="table table-striped table-hover">
        <tr>
          <th>Prozess</th>
          <th>Status/Optionen</th>
          <th>Beschreibung</th>
        </tr>
        <tr>
          <td>Automatische Zwischenstandsmail</td>
          <td>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(DB::table('jobs')->where('queue','intermediate')->exists()) checked @endif>
              <label class="custom-control-label" for="customSwitch1">Aktiv</label>
            </div>
          </td>
          <td>test</td>
        </tr>
      </table>
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
    console.log(host)

    axios.get(host+'/care4as/care4as/public/config/activateIntermediateMail')

    .then(response => {
      alert('Zwischenstandsmail aktiviert')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })
  }
  else {

    var host = window.location.host;
    axios.get(host+'/care4as/care4as/public/config/deactivateIntermediateMail')
    .then(response => {
      alert('Zwischenstandsmail deaktiviert')

      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
    })

  }

})
</script>
@endsection
