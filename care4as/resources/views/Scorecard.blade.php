@extends('general_layout')

@section('additional_css')
<style media="screen">

  .form-control
  {
    min-width: 150px;
  }

  #reportdiv
  {
    display: none;
    position: absolute;
    height: 50vh;
    width: 75%;
    top: 5vh;
    left: 12.5%;
    background-color: red;
    z-index: 100;
    animation-name: fadeInTotally;
    animation-iteration-count: 1;
    animation-timing-function: ease-in-out;
    animation-duration: 1s;
    animation-fill-mode:forwards;
  }
  .backdrop
  {
   display: none;
   position: fixed;
   top: 0;
   left: 0;
   height: 100%;
   width: 100%;
   background-color: black;
   background-size: cover;
   z-index: 20;
   animation-name: fadeIn;
   animation-iteration-count: 1;
   animation-timing-function: ease-in-out;
   animation-duration: 1s;
   animation-fill-mode:forwards;
  }
  @keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 0.7;
    }
  }
  @keyframes fadeInTotally {
    0% {
        opacity: 0;
        transform: translateY(-100px);
    }
    100% {
        opacity: 1;
    }
  }

</style>
@endsection

@section('content')
<div class="container-fluid mt-2" style="border-radius: 15px;width: 75vw;">
  <div class="" id="reportdiv">
    <div class="nav-tabs-navigation bg-light">
      <div class="nav-tabs-wrapper">
        <ul class="nav nav-tabs" data-tabs="tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#days" data-toggle="tab">täglich</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#weeks" data-toggle="tab">wöchentlich</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#monthly" data-toggle="tab">monatlich</a>
            </li>
        </ul>
      </div>
    </div>
  <div class="tab-content" id="myTabContent">
     <div class="tab-pane fade show active" id="days" role="tabpanel" aria-labelledby="home-tab">

       <div class="row bg-white m-0 mt-2">
         <h5 class="text-center w-100"><u>Report Tagesbasis <span id="reportname"></span></u>  </h5>
       </div>
       <div class="row m-0 mt-2 w-100 h-100 justify-content-center align-items-center">
         Von/bis:
         <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
             <i class="fa fa-calendar"></i>&nbsp;
             <span></span> <i class="fa fa-caret-down"></i>
         </div>
       </div>
       <div class="row m-0 mt-2 justify-content-center bg-white align-items-center">
         <div class="col p-2" id="chartcontainer" style="position:relative;height: 70vh; width: 75vw;">
            <canvas id="Chart" width="" height=""style="position: absolute; height: 85%; max-width: 90%;"></canvas>
            <div class="loaderDiv p-2" id="loaderDiv" style="height: 90%; width: 95%;">
              <div class="lds-spinner" style="top:50%; left: 50%; transform: translate(-50%,-50%);"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
         </div>
       </div>

     </div>
     <div class="tab-pane fade" id="weeks" role="tabpanel" aria-labelledby="week-tab">
       tralala
     </div>
  </div>
  <button type="button" class="btn btn-danger rounded-circle" onclick="closeReportDiv()">
      Schließen
    </button>
</div>
  <div class="row">
    <div class="col d-flex justify-content-start">
      @if(App\User::where('id', '<', $user->id)->max('id'))
        <a href="{{route('user.stats', ['id' => App\User::where('id', '<', $user->id)->max('id') ])}}" class="btn btn-rounded btn-primary btn-outline">vorheriger Agent</a>
      @else
        <a href="" class="btn btn-rounded btn-primary btn-outline" disabled>vorheriger Agent</a>
      @endif
    </div>
    <div class="col d-flex justify-content-end">
      @if(App\User::where('id', '>', $user->id)->min('id'))
        <a href="{{route('user.stats', ['id' => App\User::where('id', '>', $user->id)->min('id') ])}}" class="btn btn-rounded btn-primary btn-outline">nächster Agent</a>
      @else
        <a href="" class="btn btn-rounded btn-primary btn-outline" disabled>nächster Agent</a>
      @endif
    </div>
  </div>
  <div class="row bg-light" id="mainrow"  style="border-radius: 35px;">
    <div class="col p-0" id="maincol">
      <div class="row m-0">
        <div class="col">
          <h4 class="text-center">{{$user->name}}</h4>
          <div class="row m-1 p-3 justify-content-center" style="background-color: rgba(0,0,0, 0.1);">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAeh7PE8nk_9Ya4K06e8OkFWBAeqHOfamUuKOdOVDN&s" alt="" style="width: 160px; border-radius: 45%; border: 2px solid black; opacity: 1;">
          </div>
        </div>
        <div class="col">
        <h4 class="text-left">Daten</h4>
          <div class="row p-3 justify-content-left">
            <table>
              <tr class="table">
                <td>Name</td>
                <td>Vorname</td>
                <td>Alter</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <hr>
      <hr>
      <div class="row justify-content-center">
        <form class="" action="{{route('user.update', ['id' => $user->id])}}" method="post">
            @csrf
            <table class="table table-bordered w-50">
              <tr>
                <td>
                  <table class="" style="">
                    <tr>
                      <th>Abteilung</th>
                      <td>
                        <select class="form-control" name="department" id="department" style="width:218px;">
                          <option value="" @if(!$user->department)  selected @endif disabled>Wähle die Abteilung</option>
                          <option value="1&1 DSL Retention" @if($user->department == '1&1 DSL Retention') selected @endif>1&1 DSL Retention</option>
                          <option value="1&1 Mobile Retention" @if($user->department == '1&1 Mobile Retention') selected @endif>1&1 Mobile Retention</option>
                          <option value="Telefonica" @if($user->department == 'Telefonica') selected @endif>Telefonica</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>Team</th>
                      <td>
                        <select class="form-control" name="team" id="Team" style="width:218px;">
                          <option value="" @if(!$user->team)  selected @endif disabled>Wähle dein Team</option>
                          <option value="Liesa" @if($user->team == 'Liesa') selected @endif>Liesa</option>
                          <option value="Jacha" @if($user->team == 'Jacha') selected @endif>XYZ</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>Vorname</th>
                      <td><input class="form-control" type="text" name="surname" value="{{$user->surname}}"></td>
                    </tr>
                    <tr>
                      <th>Nachname</th>
                      <td><input class="form-control" type="text" name="lastname" value="{{$user->lastname}}"></td>
                    </tr>
                    <tr>
                    @if(Auth()->user()->id == $user->id)
                      <tr>
                        <th>Email</th>
                        <td><input class="form-control" type="text" name="email" value="{{$user->email}}"></td>
                      </tr>
                    @endif

                    <tr>
                      <th>Rolle</th>
                      <td><select class="form-control" type="text" name="role">
                        @foreach($roles as $role)
                          @if($role->name == $user->role)
                            <option value="{{$role->name}}"selected>{{$role->name}}</option>
                          @else
                            <option value="{{$role->name}}">{{$role->name}}</option>
                          @endif
                        @endforeach
                      </select>
                      </td>
                    </tr>
                  </table>
                </td>
                <td>
                  @if(in_array('updateUser', Auth()->user()->getRights()))
                  <table class="" style="">
                    <tr>
                      <th>PersonID</th>
                      <td><input class="form-control" type="text" name="person_id" value="{{$user->person_id}}"></td>
                    </tr>
                    <tr>
                      <th>Agent ID</th>
                      <td><input class="form-control" type="text" name="agent_id" value="{{$user->agent_id}}"></td>
                    </tr>
                    <tr>
                      <th>tägliche Arbeitszeit</th>
                      <td><input class="form-control" type="text" name="dailyhours" value="{{$user->dailyhours}}"></td>
                    </tr>
                    <tr>
                      <th>KDW ID</th>
                      <td><input class="form-control" type="text" name="kdwid" value="{{$user->ds_id}}"></td>
                    </tr>
                    <tr>
                      <th>Tracking ID</th>
                      <td><input class="form-control" type="text" name="trackingid" value="{{$user->tracking_id}}"></td>
                    </tr>
                  </table>
                  @endif
                </td>
              </tr>
            </table>
            <button type="submit" class="btn btn-rounded btn-primary rounded-pill"name="button">Daten ändern</button>
          </form>
      </div>
      <div class="row justify-content-center">

        <button type="button" class="btn btn-primary rounded-circle" name="button" id="dropdwnbtnRD" onclick="showReportDiv('Sales')">
          <i class="fas fa-euro-sign"></i>
        </button>
        <button type="button" class="btn btn-primary rounded-circle" name="button" id="dropdwnbtnRD" onclick="showReportDiv('AHT')">
        <i class="far fa-clock"></i>
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('additional_js')
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">

function showReportDiv(tab) {

  let type = ''

  $('#reportdiv').toggle()
  $('#reportname').html(tab)
  $('.backdrop').toggle()

  if(tab == 'Sales')
  {
    type = 'sales'
  }
  else if(tab == 'AHT')
  {
    type = 'aht'
  }
  showChart(type, {!! json_encode($user->id) !!})
}
function closeReportDiv(){
  $('#reportdiv').toggle()
  $('.backdrop').toggle()
}
$( document ).ready(function() {

function dropDownRD() {
  let element = document.getElementById("dropdwnRD");
  let top = element.parentNode.getBoundingClientRect().top

  console.log(element.parentNode.getBoundingClientRect())
}

window.onclick = function(event) {
  if (!event.target.matches('.dropdwnbtnRD')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
});
</script>
@endsection
