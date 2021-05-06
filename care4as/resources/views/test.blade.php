@extends('general_layout')



@section('additional_css')
<style media="screen">
  .col-designed
  {
    width: 32%;
  }
</style>

@endsection

@section('content')
<div class="container-fluid bg-light" style="width: 75vw;">
  <div class="row justify-content-center align-items-center text-center">
    <div class="col ">
      Suche
    </div>
    <div class="col">
      Nachrichten
    </div>
    <div class="col">
      <img src="https://i.stack.imgur.com/UCY3T.png" alt="">
    </div>
    <div class="col">
      Favoriten
    </div>
    <div class="col">
      Profilbesucher
    </div>
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
    <!-- <div class="col-designed m-1 p-1" style="background-color: rgba(250, 235, 215,1); color: 	rgb(128,128,128)">
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
    </div> -->
    @endfor
  </div>
</div>
@endsection
