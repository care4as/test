@extends('general_layout')

@section('additional_css')
<link rel="stylesheet" type="text/css" href="{{asset('slick/slick/slick.css')}}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
<script src="{{asset('js/app.js?v='.time())}}" ></script>
<style>
td,tr,table
{
  border-radius: 15px;
  border-collapse: separate;
  width: auto;
}
.table-striped>tbody>tr:nth-child(even) {
    background-color: #ddf8e8;
}
.department{
  cursor: pointer;
}
.department:hover{
  opacity: 0.5;
}

#dailyQuota
{
  color:white !important;
}
.f1{
  font-size: 1.7em;
}
.f2{
  font-size: 1.3em;
}
.rotated
{
  transform: rotateY(30deg);
  box-shadow: 1rem 1rem rgba(0,0,0,.15) !important;
  border-radius: 25px;
}
.rotated:hover{
  animation: rotateback 5s;
}
.derotate:hover{
  animation: rotateback 5s;
}
@keyframes rotateback {
50% {transform: rotateY(0deg);}
}
.borders-roundedlight
{
  border-radius: 15px;
}
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
/* #chart1.line {
  height: 350px;
  width: 75%;
  margin: 0 auto;
}
.chart
{
  height: 350px;
  max-width: 100%;
  margin: 0 auto;

} */

.nav-tabs{
  border: none;
}

.nav-item{
  margin: 15px !important;
}

.nav-link{
  border: 1px solid transparent;
  border-radius: 5px;
  font-family: 'Radio Canada', sans-serif;
  font-size: 1.4rem;
  color: #495057;
}

.nav-link:hover{
 border: 1px solid transparent;;
 box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
 color: black !important;
 background-color: white;
}

.nav-link.active {
 border: 1px solid transparent;
 box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
 font-weight: bold;
 color: black !important;
}

/* @import url('https://fonts.googleapis.com/css2?family=Radio+Canada:wght@300;400;500;600;700&display=swap'); */
</style>
@endsection

@section('content')

<div class="container-fluid " id="app">
  <div class="row center_items mt-4">
    <div class="nav-tabs-navigation ">
      <div class="nav-tabs-wrapper center_items bg-light" style="border-radius: 5px;">
        <ul class="nav nav-tabs" data-tabs="tabs">
            <li class="nav-item ">
                <a class="nav-link active" href="#currentTracking" data-toggle="tab">Tageswerte</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#agents" data-toggle="tab">Agents</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#history" data-toggle="tab">CR Verlauf</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#history" data-toggle="tab">Weitere Funktion</a>
            </li> -->
        </ul>
      </div>
    </div>
  </div>
  <div class="tab-content">
    <div id="currentTracking" class="tab-pane fade in show active">
      <div class="row m-4 borders-roundedlight">
        <div class="col">
          <div class="row">
              <ptableAlt></ptableAlt>
              </div>
            </div>
          </div>
        </div>
      <div id="agents" class="tab-pane fade in">
        <div class="bg-light d-flex" style="position: absolute; right: 5px; top: 50%; z-index:10;">
          <div class="bg-info position-relative center_items" style="min-height: 100%;">
            <button type="button" name="button" onclick="openFiltermenu()">
              <span class="material-icons">
                arrow_back
                </span>
              </div>
            </button>
          <div class="col-12 d-none">
            <form class="w-100" action="{{route('dashboard.admin')}}" method="get">
              <div class="row m-0 justify-content-center">
                <div class="col p-2">
                  <label for="department">Abteilung:</label>
                  <select class="form-control" name="department" id="department" style="width:218px;">
                    <option value="" selected disabled>Wähle die Abteilung</option>
                    <option value="1&1 DSL Retention">1&1 DSL Retention</option>
                    <option value="1&1 Mobile Retention" >1&1 Mobile Retention</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col p-0 mr-2">
                  <label for="department">Welche MA:</label>
                  <select multiple class="form-control" name="employees[]" id="employees" style="height: 150px; overflow:scroll;">
                  </select>
                </div>
              </div>
              <div class="row justify-content-center">
                    <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
              </div>
            </div>
          </div>
          <div class="row p-2 justify-content-center w-100 borders-roundedlight">
            <div class="col-12 center_items">
              <h5 class="goldentext">Userdash</h5>
            </div>
            <div id="collapseUserDash" class="collapse show" aria-labelledby="headingtwo" data-parent="#accordion1">
              <div class="col-12">
                <div class="row center_items">
                  @foreach($users as $user)
                    <div class="col-10 col-md-5 m-1 bg-dark shadow-white">
                      <h5 class="goldentext">{{$user->name}}
                          <a class="align-items-center" href="{{route('user.stats',['id' => $user->id])}}">
                            <span class="material-icons">
                            preview
                            </span>
                          </a>
                        </h5>
                      <trackchart :userid="{{$user->id}}"> </trackchart>
                    </div>
                  @endforeach
                </div>
            </div>
          </div>
        </div>
      </div>
      <div id="history" class="tab-pane fade in">
        <div class="row unit-translucent p-2 justify-content-center w-100 bg-light mt-3 borders-roundedlight" style="font-size: 1.5em; font-weight: 700;">
          <div class="w-100" id="accordion2">
            <div class="col-12" >
              <h5>
                <a data-toggle="collapse" data-target="#collapseTeamDash" aria-expanded="true" aria-controls="collapseTeamDash" style="cursor:pointer;">
                  <span style="">Teamübersicht 1&1 Retention Mobile</span>
                  <span class="material-icons">
                    expand_more
                    </span>
                  </a>
                </h5>
                </div>
              <div id="collapseTeamDash" class="collapse show" aria-labelledby="headingtwo" data-parent="#accordion2">
                <div class="col-12" style="height: 75vh;">
                  <div class="row justify-content-center h-25">
                    <p>Verlauf der letzten 5 Tage</p>
                  </div>
                  <div class="row h-50 repeater1">
                    @for($i = 1; $i<=5; $i++)
                    <div class="col-12" style="">
                      <span style="font-size: 1.3em;"></span>{{Carbon\Carbon::today()->subdays($i)->Format('d.m.Y')}}
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
                            <tr>
                              <th scope="row"> {{$key}} </th> <td style="--size:{{$data['cr']}};--color: blue; color:white;">{{$data['cr']*100}}%</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  @endfor
                </div>
                <div class="row  h-25 justify-content-center">
                <div class="col-6 center_items">
                  <button type="button" name="button" id="nextButton" class="btn-primary">Vorheriger Tag</button>
                </div>
                <div class="col-6 center_items">
                  <button type="button" name="button" id="prevButton" class="btn-primary">Nächster Tag</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row unit-translucent p-2 justify-content-center w-100 bg-light mt-3 borders-roundedlight" style="font-size: 1.5em; font-weight: 700;">
        <div class="w-100" id="accordion2">
          <div class="col-12" >
            <h5>
              <a data-toggle="collapse" data-target="#collapseTeamDash1" aria-expanded="true" aria-controls="collapseTeamDash" style="cursor:pointer;">
              <span style="">Teamübersicht 1&1 Retention DSL</span>
              <span class="material-icons">
                expand_more
                </span>
            </a></h5>
          </div>
          <div id="collapseTeamDash1" class="collapse show" aria-labelledby="headingtwo" data-parent="#accordion2">
          <div class="col-12">
            <div class="row">
              <p>Verlauf der letzten 5 Tage</p>
            </div>
            <div class="row justify-content-center repeater2" >
              @for($i = 1; $i<=5; $i++)
                <div class="col-designed-carousel m-2" style="height: 500px; opacity: 0.4;">
                <span style="font-size: 1.3em;"></span>{{Carbon\Carbon::today()->subdays($i)->Format('d.m.Y')}}
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
                      @foreach($quotasDSL[Carbon\Carbon::today()->subdays($i)->Format('Y-m-d')] as $key => $data)
                        <tr><th scope="row"> {{$key}} </th> <td style="--size:{{$data['cr']}};--color: blue; color:white;">{{$data['cr']*100}}%</td></tr>
                      @endforeach
                    </tbody>
                  </table>
                  </div>
                </div>
              @endfor
            </div>
            <div class="row justify-content-center">
              <div class="col-6 center_items">
                <button type="button" name="button" id="nextButton2" class="btn-primary">Vorheriger Tag</button>
              </div>
              <div class="col-6 center_items">
                <button type="button" name="button" id="prevButton2" class="btn-primary">Nächster Tag</button>
              </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('additional_modal')
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
@endsection
@section('additional_js')
<script src="/js/app.js"></script>
<script type="text/javascript" src="/js/app.js?v=2.4.1"></script>
<script type="text/javascript" src="{{asset('slick/slick/slick.min.js')}}"></script>
<script type="text/javascript">

$(document).ready(function(){
  Chart.defaults.global.defaultFontFamily = 'Radio Canada';
  $('.repeater1').slick({

    fade: true,
    prevArrow: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    nextArrow: $('#nextButton'),
    prevArrow: $('#prevButton')
  });
  $('.repeater2').slick({
    fade: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: false,
    nextArrow: $('#nextButton2'),
    prevArrow: $('#prevButton2')
  });
});

  $('#department').change(function() {

    $('#employees').empty()

    let dep = this.value
    // console.log(dep)
    var host = window.location.host;

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
