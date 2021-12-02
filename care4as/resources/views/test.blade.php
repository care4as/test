@extends('general_layout')

@section('additional_css')

<style media="screen">

</style>

@endsection
@section('content')
<div class="container-fluid p-2 f2" id="app">
  <div class="row" style="">
    @for($i=1; $i <= 1; $i++)
    <div class="col-12 m-2">
      @include('templates.Agentcard')
    </div>

    @endfor
  </div>

</div>
@endsection

@section('additional_js')
<script type="text/javascript">

const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
  type: 'bar',

  data: {
      datasets: [{
       type: 'line',
       label: 'CR',
       data: [1,2,3,4,5,6,7,8,9,10],
       fill: false,
       backgroundColor: 'rgba(41, 241, 195, 1)',
       borderColor: 'rgba(41, 241, 195, 1)',
       borderWidth: 1
   },
   {
      label: 'Calls',
      type: 'bar',
      yAxisID: 'B',
      data: [1,2,3,4,5,6,7,8,9,10],
      backgroundColor: 'rgba(255, 99, 132)',
      borderWidth: 1
}],
labels:[1,2,3,4,5,6,7,8,9,10],
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
   }
});
</script>
@endsection
