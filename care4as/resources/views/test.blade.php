@extends('general_layout')

@section('additional_css')
<style media="screen">


/* MENÜ-Button */

  .col_designed
  {
    width: 30%;
  }

  .col:hover
  {
    opacity: 0.5;
    background-color: hsl(0,100%,10%);
    cursor: pointer;
  }
  .flip-card {
    background-color: transparent;
    width: 100%;
    height: 100%;
    perspective: 1000px; /* Remove this if you don't want the 3D effect */
  }
  /* This container is needed to position the front and back side */
  .flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    /* text-align: center; */
    transition: transform 0.8s;
    transform-style: preserve-3d;
  }
  /* Do an horizontal flip when you move the mouse over the flip box container */
  .flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
  }
  /* Position the front and back side */
  .flip-card-front, .flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-backface-visibility: hidden; /* Safari */
    backface-visibility: hidden;
  }
  /* Style the front side (fallback if image is missing) */
  .flip-card-front {
    /* background-color: #bbb; */
    color: black;
  }
  /* Style the back side */
  .flip-card-back {
    background-color: dodgerblue;
    color: white;
    transform: rotateY(180deg);
  }
  @-webkit-keyframes image_blur {
    10% {
      /* -webkit-filter: blur(0px); */
      transform: skew(1deg) scale(1.1);

    }
    20% {
      /* -webkit-filter: blur(0.5px); */
      transform: skew(-1deg) scale(1.1);
      }
    30% {
      /* -webkit-filter: blur(0.5px); */
      transform: skew(1deg) scale(1.1);
      }
    40% {
      /* -webkit-filter: blur(0.5px); */
      transform: skew(-1deg) scale(1.1);
      }
    50% {
      /* -webkit-filter: blur(1px); */
      transform: skew(1deg) scale(1.05);;
      /* transform: scale(0.9); */
    }

    75% {
      /* -webkit-filter: blur(0.5px); */
      transform: skew(-1deg) scale(1.03);;
    }

    100% {
       /* -webkit-filter: blur(0px); */
      transform: skew(1deg) scale(1.1);;
    }
}
@keyframes grow
{
  FROM
  {
    transform: scale(0);
    opacity: 0.1;
    transform-origin: center;
  }
  to
  {
    transform: scale(5);
    opacity: 0.01;
    transform-origin: center;
  }
}
#bgimage {
  position: relative;
  object-fit: cover;
  height: 100%;
  width: 100%;
  -webkit-animation: image_blur 35s infinite;
  border: 4px solid white;
  border-radius: 15px;
   /* transition: all 5s ease; */
}
.borderrectangle
{
  height: 10px;
  width: 10px;
  border: 3px solid white;
}

.prevArrow:hover
{
  opacity: 0.4;
  animation: rotate 3s forwards;
  cursor: pointer;
}
.nextArrow:hover
{
  opacity: 0.4;
  animation: rotate 3s forwards;
  cursor: pointer;
}

@keyframes rotate
{
  FROM
  {
    transform: rotateY(1deg);
  }
  to
  {
    transform: rotateY(-45deg);
  }
}
</style>

@endsection

@section('content')

  <div class=""
    style="
    position: relative;
    height: 100%;
    padding: 15px;
    ">
    <div class="border-dark " style="
    position: relative;
    background: rgb(138,110,77);
    background: linear-gradient(90deg, rgba(138,110,77,1) 6%, rgba(134,105,70,1) 35%, rgba(70,53,33,1) 66%);
    width:100%;
    height:100%;
    border-radius: 15px;
    overflow: hidden;
    ">
    <div class=" d-flex p-2" style="position: relative;">

      <div class="borderrectangle" style="position: absolute; left: 0px; top: 0px;">

      </div>
      <div class="borderrectangle" style="position: absolute; right: 0px; top: 0px;">

      </div>
      <div class="borderrectangle" style="position: absolute; left: 0px; bottom: 0px;">

      </div>
      <div class="borderrectangle" style="position: absolute; right: 0px; bottom: 0px;">

      </div>
      <img src="http://neuenachbarschaft.de/wp-content/uploads/2017/08/WIESE-1024x683.jpg" alt="" id="bgimage">
    </div>
  </div>
  <div class="" style="
    display: flex;
    align-items: center;
    position: absolute;
    height: auto;
    width: 50%;
    left: 25%;
    top: 25%;
    border: 4px solid black;
    background: rgba(255,255,255,0.4);
    z-index: 100;
  ">
  <p style="
    color: rgba(0,0,0, 1);
    font-weight: 900;
    font-size: 1em;
    ">
    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
  </div>
  <div class="row" style="height: 50%;">
    <div class="col-1 d-flex align-items-center justify-content-center prevArrow"  style="background-color: black;">
      <i class='fas fa-angle-left ' style="font-size: 4em;"></i>
    </div>
    <div class="col-10">
      content
    </div>
    <div class="col-1  d-flex align-items-center justify-content-center nextArrow" style="background-color: black;">
      <i class='fas fa-angle-right 'style="font-size: 4em;"></i>
    </div>
  </div>
  </div>

  <!-- <div class="container-fluid"> -->

@endsection

@section('additional_js')


@endsection
