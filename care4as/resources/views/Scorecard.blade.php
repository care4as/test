@extends('general_layout')

@section('additional_css')
<style media="screen">

  .form-control
  {
    min-width: 150px;
  }

  #reportdiv
  {
    position: absolute;
    height: 75vh;
    width: 50%;
    top: 15vh;
    left: 25%;
    background-color: red;
    z-index: 100;
  }

</style>
@endsection

@section('content')
<div class="container-fluid mt-2" style="border-radius: 15px;width: 75vw;">
  <div class="" id="reportdiv">
      <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">täglich</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">wöchentlich</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">monatlich</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
     <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
       <div class="row bg-white m-0 mt-2">
         <h5 class="text-center w-100">Salesperformance Tagesbasis <span id="reportname"></span> </h5>
       </div>
       <div class="row m-0 w-100 justify-content-center">
         <p ><h5 class="w-100 text-center">  Von/bis</h5> </p>

         <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
             <i class="fa fa-calendar"></i>&nbsp;
             <span></span> <i class="fa fa-caret-down"></i>
         </div>
       </div>
       <div class="row m-0 mt-2 justify-content-center bg-white">
         <div class="col p-2">
            <canvas id="RDChart" width="300" height="300"></canvas>
         </div>
       </div>
       <div class="row">
         <button type="button" name="button">Close</button>
       </div>
     </div>

  </div>
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
          <button type="button" name="button" id="dropdwnbtnRD" onclick="dropDownRD()">SalesPerformance</button>
          <div id="dropdwnRD" class="dropdown-content">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
          </div>
        </div>

        <button type="button" name="button">AHT</button>
        <button type="button" name="button">Umsatzperformance</button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script>
var ctx = document.getElementById('RDChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script type="text/javascript">

$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();
    var host = window.location.host;
    var userid = {!! json_encode($user->id) !!};


    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        let params = new URLSearchParams();

        params.append("start", start);
        params.append("end" , end);
        params.append("userid" , userid);

        // let params = {
        //   start: start,
        //   end: end,
        //   userid: userid
        // }

        axios.get('http://'+host+'/care4as/care4as/public/user/salesdataDates',
        {
          params: {
            start: start,
            end: end,
            userid: userid
          }
          })
        .then(response => {
          // console.log(response)
          let data = response.data
          console.log(data)
          })
        .catch(function (err) {

          console.log(err.response);
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
