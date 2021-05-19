@extends('general_layout')

@section('additional_css')
<style media="screen">
.sidebartest
{
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: relative; /* Stay in place */
  z-index: 1; /* Stay on top */
  left: 0;
  background-color: #222831;
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 8px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
}

/* The sidebar links */
.sidebartest a {
padding: 8px 8px 8px 32px;
text-decoration: none;
font-size: 25px;
color: #dddddd;
display: block;
transition: 0.3s;
}

/* When you mouse over the navigation links, change their color */
.sidebartest a:hover
{
color: #f05454;
}

/* MENÜ-Button */
label.hamburg {
    display: block;
    background: #f05454; width: 10.5vmin;  height: 7vmin;
    position: relative;
}

.line {
  position: absolute;
  left:1.25vmin;
  height: 3px;
  width: 8vmin;
  background: #dddddd; border-radius: 2px;
  display: block;
  transition: 0.5s;
  transform-origin: center;
  }

  .line:nth-child(1) { top: 1vmin; }
  .line:nth-child(2) { top: 3vmin; }
  .line:nth-child(3) { top: 5vmin; }

  #hamburg:checked + .hamburg .line:nth-child(1){
  transform: translateY(1.98vmin) rotate(-45deg);
  }

  #hamburg:checked + .hamburg .line:nth-child(2){
  opacity:0;
  }

  #hamburg:checked + .hamburg .line:nth-child(3){
  transform: translateY(-1.98vmin) rotate(45deg);
}

  input#hamburg {display:none}
  .col_designed
  {
    width: 30%;
  }

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
    /* border: 1px solid #f1f1f1; */
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
  </div>

    <div class="d-flex" style="position: absolute;">
      <div id="mySidebar" class="sidebartest">
        <a href="">Startseite</a>
        <a href="">Mein Profil</a>
        <a href="">Einstellungen</a>
        <a href="">Person 3</a>
        <a href="">Person 4</a>
        <a href="">Person 5</a>
        <a href="">Person 6</a>
    </div>
  </div>
  <!-- <div class="container-fluid"> -->





@endsection

@section('additional_js')

<script>
  /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
  function openNav() {
      document.getElementById("mySidebar").style.width = "250px";
      document.getElementById("main").style.marginLeft = "250px";
  }

  /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
  function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.marginLeft = "0";
  }

  function showSidebar(){
      var selection = document.getElementById("hamburg");
      if (selection.checked) {
          openNav()
      }
      else {
          closeNav()
      }
  }

  </script>
@endsection
