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
         <h5 class="text-center w-100"><u>Report Tagesbasis <span id="reportname">Sales</span></u>  </h5>
       </div>
       <div class="row m-0 mt-2 w-100 h-100 justify-content-center align-items-center">
         Von/bis:
         <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
             <i class="fa fa-calendar"></i>&nbsp;
             <span></span> <i class="fa fa-caret-down"></i>
         </div>
       </div>
       <div class="row m-0 mt-2 justify-content-center bg-white align-items-center">
         <div class="col p-2" >
            <canvas id="RDChart" width="" height=""style="height: 60vh; max-width: 90%;"></canvas>
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

          </div>
        </div>
      </div>
      <hr>
      <hr>
      <div class="row justify-content-center">
        <button type="button" name="button" id="dropdwnbtnRD" onclick="showReportDiv()">SalesPerformance</button>
        <button type="button" name="button">AHT</button>
        <button type="button" name="button">Umsatzperformance</button>
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
  $('#reportdiv').toggle()
}
function closeReportDiv(){
  $('#reportdiv').toggle()
}
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();
    var host = window.location.host;
    var userid = {!! json_encode($user->id) !!};


    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        // console.log(start.format('YY-MM-DD') + '/' +end.format('YY-MM-DD') )
        let params = new URLSearchParams();

        params.append("start", start);
        params.append("end" , end);
        params.append("userid" , userid);

        // let params = {
        //   start: start,
        //   end: end,
        //   userid: userid
        // }
        axios.get('http://'+host+'/user/salesdataDates',
        // axios.get('http://'+host+'/care4as/care4as/public/user/salesdataDates',
        {
          params: {
            start: start.format('Y-MM-DD'),
            end: end.format('Y-MM-DD'),
            userid: userid
          }
          })
        .then(response => {

          let chartData = response.data

          var ctx = document.getElementById('RDChart').getContext('2d')
            const myChart = new Chart(ctx, {
            type: 'bar',

            data: {
                datasets: [{
                 type: 'line',
                 label: 'CR',
                 data: chartData[1],
                 fill: false,
                 backgroundColor: 'rgba(41, 241, 195, 1)',
                 borderColor: 'rgba(41, 241, 195, 1)',
                 borderWidth: 1
             },
             {
                label: 'durschnittliche CR',
                type: 'line',
                label: 'CR durschn.',
                data: chartData[2],
                fill: false,
                backgroundColor: 'rgba(255, 99, 132)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
          },
             {
                label: 'durschnittliche SSC-CR',
                type: 'line',
                label: 'SSC-CR durschn.',
                data: chartData[3],
                fill: false,
                backgroundColor: 'rgba(0, 155, 119)',
                borderColor: 'rgba(0, 155, 119, 1)',
                borderWidth: 1
          },
             {
                label: 'SSC-CR',
                type: 'line',
                label: 'SSC-CR',
                data: chartData[4],
                fill: false,
                backgroundColor: 'rgba(136, 176, 75)',
                borderColor: 'rgba(136, 176, 75, 1)',
                borderWidth: 1
          }
        ],
          labels:chartData[0],
           },
           options: {
               scales: {
                 yAxes: [{
                   id: 'A',
                   type:'linear',
                   position: 'left',
                   ticks: {
                     beginAtZero: true,
                     min: 0,
                     max: 100,
                 }
               },
               {
                 id: 'B',
                 type:'linear',
                 position: 'right',
                 ticks: {
                   max: 10,
                   min: 0,
                 }
               }]}
             }});
          })
        .catch(function (err) {

          console.log(err.response);
          $('#failContent').html('Fehler: '+ err.response.data.message)
          $('#failFile').html('Datei: '+ err.response.data.file)
          $('#failLine').html('Line: '+ err.response.data.line)
          $('#failModal').modal('show')
          // $('#loaderDiv').css('display','none');
        })
    }


    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

});

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
</script>
@endsection
