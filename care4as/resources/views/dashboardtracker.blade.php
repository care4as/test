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

@import url('https://fonts.googleapis.com/css2?family=Radio+Canada:wght@300;400;500;600;700&display=swap');
</style>
@endsection

@section('content')

<div class="container-fluid " id="app">
  <div class="tab-content">
    <div id="currentTracking" class="tab-pane fade in show active">
      <div class="row m-4 borders-roundedlight">
        <div class="col">
          <div class="row">
            <ptable></ptable>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript">

$(document).ready(function(){
  Chart.defaults.global.defaultFontFamily = 'Radio Canada';
});

</script>
@endsection
