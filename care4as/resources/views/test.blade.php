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
  .col-designed
  {
    width: 32%;
  }
  .col:hover
  {
    opacity: 0.5;
    background-color: hsl(0,100%,10%);
    cursor: pointer;
  }
</style>

@endsection

@section('content')
<div class="container-fluid bg-light"
  style="
  width: 75vw;
  height: 90vh;
  background-image:url('https://cdn.prod.www.spiegel.de/images/3f57c70a-0001-0004-0000-000000355905_w996_r1.77_fpx46.48_fpy50.jpg');
  background-size: 100% auto;
  background-position: center top;
  background-attachment: fixed;
  background-repeat: no-repeat;
  "
  >
  <nav>
    <div class="row justify-content-center align-items-center text-center" style="
    background: rgb(62,3,12);
    background: radial-gradient(circle, rgba(62,3,12,1) 62%, rgba(134,9,12,1) 88%, rgba(162,7,33,1) 98%);
    color: rgb(255,235,205);
    ">
      <div class="col">
        <input type="checkbox" id="hamburg" onclick="showSidebar()">
        <label for="hamburg" class="hamburg">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </label>
      </div>
      <div class="col ">
        Tracking
      </div>
      <div class="col">
        Nachrichten
      </div>
      <div class="col">
        <img src="https://i.stack.imgur.com/UCY3T.png" alt="">
      </div>
      <div class="col">
        Todos
      </div>
      <div class="col">
        Profil
      </div>
      <div class="col d-flex justify-content-end">
        <input type="checkbox" id="hamburg" onclick="showSidebar()">
        <label for="hamburg" class="hamburg">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </label>
      </div>
    </div>
  </nav>
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
  <div class="container-fluid">
    <div class="row justify-content-center mt-3">


    @for($i=0; $i <= 9; $i++ )
    <!-- <div class="col-3 m-3 p-1" style="background-color: rgba(250, 235, 215,1); color: 	rgb(128,128,128)">
      <div class="row m-0" id="bgimage">
        <div class="col p-0" style="position:relative">
          <img src="https://img.fotocommunity.com/herbstbaum-98afdef5-30d2-42cb-958d-a26be878075d.jpg?height=400" alt="">
          <div class="" style="position:absolute; bottom: 5px; left: 5px;">
            <img src="https://spd-mvp.de/uploads/spdLandesverbandMecklenburgVorpommern/Landtagswahl-2021/_1024xAUTO_crop_center-center_none/Manuela-Schwesig.jpg" alt="" style="border-radius:50%; height: 125px; width: 125px; object-fit: cover;">
          </div>
          <div class="d-flex justify-content-center" role="group" style="position:absolute; top: 5px; right: 5px; border-radius: 50px; height: 30px; width: 30px;">
            <button class="btn-white rounded-circle h-100 w-100 p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="material-icons">
                settings
              </i>
              </button>
              <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Chatten</a>
                <a class="dropdown-item" href="#">Als Freund hinzufügen</a>
                <a class="dropdown-item" href="#">Blockieren</a>
              </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col" >
          <p>Name, Alter</p>
          <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>

      </div>
      <div class="row">
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
      </div>
    </div> -->

    <!-- profilecard 2 -->

    <div class="col-designed m-1 p-1" style="background-color: rgba(250, 235, 215,1); color: 	rgb(128,128,128)">
      <div class="row bg m-2 border shadow-lg" style="background-color: rgba(250, 235, 215,0.7);">
        <div class="col-5 m-2 d-flex align-items-center">
          <img src="https://spd-mvp.de/uploads/spdLandesverbandMecklenburgVorpommern/Landtagswahl-2021/_1024xAUTO_crop_center-center_none/Manuela-Schwesig.jpg" class="img-fluid" alt="">
        </div>
        <div class="col-6 overflow-auto" >
          <div class="row">
            Manuela Schwesing, 43
          </div>
          <div class="row" style="height: 10vh;">
            <span style="font-size: 1em;">Motto:</span>
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
          </div>

        </div>

      </div>
    </div>
    @endfor
  </div>
  </div>
  </div>


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
