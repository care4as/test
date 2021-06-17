@extends('general_layout')

@section('additional_css')
<link rel="stylesheet" type="text/css" href="{{asset('slick/slick/slick.css')}}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">

<style>
    .header{
        position:sticky;
        top: 0 ;
    }
    .col
    {
      padding: 0px;
    }
    .row
    {
      margin-right: 0px !important;
      margin-left: 0px !important;
    }
    .col-designed
    {
      position: relative;
      width: 100%;
      flex: 0 0 30%;
      max-width:30%;
    }
    .bg-care4as-light
    {
      background-color: rgba(255,127,80, 0.2);
      opacity: 1;
    }
    .accordion
    {
      width: 100%;
    }
    #axes-example-7 {
  height: 200px;
  max-width: 300px;
  margin: 0 auto;
}
#chart1.line {
  height: 350px;
  width: 75%;
  margin: 0 auto;
}
.chart
{
  height: 350px;
  max-width: 100%;
  margin: 0 auto;

}

</style>
@endsection

@section('content')

<div class="container-fluid m-1" id="app">
  <div class="row">
    <div class="col">
      <div class="row">
          <ptable> </ptable>
          </div>
        </div>
      </div>
      <div class="row bg-white shadow m-1" id="filtermenu">
        <div class="w-100" id="accordion">
          <div class="col-12 d-flex justify-content-center align-self-center">
            <h5><a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="cursor:pointer;">
              Filtermenü
              <span class="material-icons">
                expand_more
                </span>
            </a></h5>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="col-12">
              <form class="mt-2 w-100" action="{{route('dashboard.admin')}}" method="get">
                <div class="row m-0 justify-content-center">
                  <div class="col-6 p-0" style="">
                    <div class="row m-2 justify-content-center">
                      <div class="col-4 ml-1 p-0">
                        <label for="department">Abteilung:</label>
                        <select class="form-control" name="department" id="department" style="width:218px;">
                          <option value="" selected disabled>Wähle die Abteilung</option>
                          <option value="1&1 DSL Retention">1&1 DSL Retention</option>
                          <option value="1&1 Mobile Retention" >1&1 Mobile Retention</option>
                        </select>
                      </div>
                      <div class="col-4 p-0 mr-2">
                        <label for="department">Welche MA:</label>
                        <select multiple class="form-control" name="employees[]" id="employees" style="height: 150px; overflow:scroll;">
                        </select>
                      </div>
                    </div>
                    <div class="row m-2 justify-content-center">
                      <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        </form>
      </div>
      </div>
        <div class="row bg-light p-2 justify-content-center w-100">
          <div class="w-100" id="accordion1">
            <div class="col-12">
              <h5><a data-toggle="collapse" data-target="#collapseUserDash" aria-expanded="true" aria-controls="collapseUserDash" style="cursor:pointer;">
                Userdashboard
                <span class="material-icons">
                  expand_more
                  </span>
              </a></h5>
            </div>
            <div id="collapseUserDash" class="collapse show" aria-labelledby="headingtwo" data-parent="#accordion1">
            <div class="col-12">
              <div class="row">
                @foreach($users as $user)
                  <div class="col-designed m-3 p-1 border bg-white rounded shadow">
                    <h5>{{$user->wholeName()}}</h5>
                    <!-- <trackchart :userid="{{$user->id}}"> </trackchart> -->
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
  <div class="row bg-care4as p-2 justify-content-center w-100 bg-light mt-3" style="font-size: 1.5em; font-weight: 700;">
    <div class="w-100" id="accordion2">
      <div class="col-12" >
        <h5>
          <a data-toggle="collapse" data-target="#collapseTeamDash" aria-expanded="true" aria-controls="collapseTeamDash" style="cursor:pointer;">
          <span style="">Teamübersicht</span>
          <span class="material-icons">
            expand_more
            </span>
        </a></h5>
      </div>
      <div id="collapseTeamDash" class="collapse show" aria-labelledby="headingtwo" data-parent="#accordion2">
      <div class="col-12">
        <div class="row">
          <p>Verlauf der letzten 5 Tage</p>
        </div>
        <div class="row justify-content-center repeater" >
          @for($i = 1; $i<=5; $i++)
            <div class="col-designed-carousel m-2" style="height: 500px; opacity: 0.4;">
            <span style="font-size: 1.3em;"></span>Verlauf Teamquote {{Carbon\Carbon::today()->subdays($i)->Format('d.m.Y')}}
            <div class="d-flex mt-4">
              <table id="" class="charts-css column show-labels show-primary-axis chart" style="font-size: 0.5em; font-weight: 200;">
                <caption> Axes Example #5 </caption>
                <thead>
                  <tr>
                    <th scope="col"> Year </th>
                    <th scope="col"> Progress </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($quotas[Carbon\Carbon::today()->subdays($i)->Format('Y-m-d')] as $key => $data)
                    <tr><th scope="row"> {{$key}} </th> <td style="--size:{{$data['cr']}};--color: blue; color:white;">{{$data['cr']*100}}%</td></tr>
                  @endforeach
                </tbody>
              </table>
              </div>
            </div>
          @endfor
        </div>
        <div class="row justify-content-center">
          <button type="button" name="button" id="nextButton" class="btn-primary">Vorheriger Tag</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="failModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-danger text-white" >
      <div class="modal-body">
        <h5>&#128577;&#128580;&#128560; Fehler aufgetreten &#128577;&#128580;&#128560;</h5>
        <p id="failFile"></p>
        <p id="failLine"></p>
        <p id="failContent"></p>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript" src="{{asset('slick/slick/slick.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.repeater').slick({
    fade: true,
    prevArrow: false,
    nextArrow: $('#nextButton')
  });
});

  $('#department').change(function() {
    $('#employees').empty()
    let dep = this.value
    // console.log(dep)
    var host = window.location.host;
    // axios.get('http://'+host+'/user/getUsersByDep/'+ dep)
    axios.get('http://'+host+'/user/getUsersByDep/'+ dep)
    // axios.get('http://'+host+'/care4as/care4as/public/user/getUsersByDep/'+ dep)
    .then(response => {
      // console.log(response)
      let users = response.data

      users.forEach(function(user){
        let option = document.createElement("option");
        let name = user.surname + ' ' + user.lastname;

        option.value = user.id;
        option.innerHTML = name;

        $('#employees').append(option);
        // console.log(option)
        })
      })
    .catch(function (err) {

      $('#failContent').html('Fehler: '+ err.response.data.message)
      $('#failFile').html('Datei: '+ err.response.data.file)
      $('#failLine').html('Line: '+ err.response.data.line)
      $('#failModal').modal('show')
      console.log(err.response);
    })
  })
</script>
@endsection
