@extends('general_layout')

@section('additional_css')
<style media="screen">
body
{

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

.col-designed
{
  width: 30%;
  height: 10em;
}
.col:hover
{
  opacity: 0.5;
  background-color: hsl(0,100%,10%);
  cursor: pointer;
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
    transform: rotateY(175deg);
  }
}
.flip-card {
  background-color: transparent;
  width: 95%;
  height: 90%;
  perspective: 1000px; /* Remove this if you don't want the 3D effect */
}

/* This container is needed to position the front and back side */
.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.8s;
  transform-style: preserve-3d;
  background-color: rgba(255, 255, 255, 0.8);
  margin-left: -10px;
  margin-top: -10px;
  -webkit-box-shadow: -1px 3px 8px 10px rgba(0,0,0,0.34);
  box-shadow: -1px 3px 8px 10px rgba(0,0,0,0.34);
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
  background-color: rgba(250, 235, 215,1); color:rgb(128,128,128);
    color: black;
    font-weight 500;
  transform: rotateY(180deg);
}
.bubble
    {
      position: absolute;
      display: grid;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      text-align: center;
      height: 150px;
      width: 150px;
      color: white;
      font-weight: 900;
      background: #00b4ff
      background: radial-gradient(ellipse at center,  rgba(255,255,255,0.5) 0%,rgba(255,255,255,1) 70%);

    }
</style>

@endsection

@section('content')

  <div class=""
    style="
    background: rgb(255,255,255);

    position: relative;
    height: 100%;
    padding: 15px;
    text-shadow: 1px 0px 1px #CCCCCC, 0px 1px 1px #EEEEEE, 2px 1px 1px #CCCCCC, 1px 2px 1px #EEEEEE, 3px 2px 1px #CCCCCC, 2px 3px 1px #EEEEEE, 4px 3px 1px #CCCCCC, 3px 4px 1px #EEEEEE, 5px 4px 1px #CCCCCC, 4px 5px 1px #EEEEEE, 6px 5px 1px #CCCCCC, 5px 6px 1px #EEEEEE, 7px 6px 1px #CCCCCC;
    ">
    <div class="container"
    style="
    background: rgb(0,0,0);
    /* background: rgb(244,238,238); */
    /* background: linear-gradient(90deg, rgba(244,238,238,0.1) 10%, rgba(240,231,220,0.1) 53%, rgba(251,240,225,0.1) 89%); */
    border-radius: 15px;
    position: relative;
    height: 100%;
    padding: 15px;
    text-shadow: 1px 0px 1px #CCCCCC, 0px 1px 1px #EEEEEE, 2px 1px 1px #CCCCCC, 1px 2px 1px #EEEEEE, 3px 2px 1px #CCCCCC, 2px 3px 1px #EEEEEE, 4px 3px 1px #CCCCCC, 3px 4px 1px #EEEEEE, 5px 4px 1px #CCCCCC, 4px 5px 1px #EEEEEE, 6px 5px 1px #CCCCCC, 5px 6px 1px #EEEEEE, 7px 6px 1px #CCCCCC;
    ">
      <p>"Die Firma TKA Software Systems will dir eine Webseite erstellen.
        Eine einfache Seite mit tollem Design oder eine kompliziertere Anwendung, zB. mit einer Datenbank. Wenn du eine gute Idee hast schreib uns oder ruf uns an und wir gucken was für dich die beste Lösung ist.
        Wir haben, wie die Seite vielleicht verraten lässt, ein lockeres Umfeld "</p>
    </div>
    <div class="bubble" style="top: 55%; left: 43%;">

    </div>
  <!-- <div class="row" style="">
    <div class="col-12 p-0">
      <div class="row m-2">
        @foreach($users as $user)
        <div class="col-designed m-3" style="position: relative; background-color: rgba(250, 235, 215,1); color:rgb(128,128,128); height: 190px; width: 25%;">
          <div class="d-flex" style="background-image: url('http://neuenachbarschaft.de/wp-content/uploads/2017/08/WIESE-1024x683.jpg'); position:absolute; height: 100%; width: 100%; font-size: 3em; display: flex; align-items: center; justify-content: center;">
            💘
          </div>
          <div class="flip-card">
            <div class="flip-card-inner" style="">
              <div class="flip-card-front">
                <div class="row h-100 m-0 align-items-center">
                  <div class="col-6">
                    <img src="https://spd-mvp.de/uploads/spdLandesverbandMecklenburgVorpommern/Landtagswahl-2021/_1024xAUTO_crop_center-center_none/Manuela-Schwesig.jpg" class="img-fluid shadow-lg" alt="" style="border: 5px solid white;">
                  </div>
                  <div class="col-6">
                    <div class="row">
                      <p>{{$user->wholeName()}}</p>
                    </div>
                    <div class="row">
                      <p><small>scroll auf die Karte für mehr Infos</small> </p>
                    </div>

                  </div>
                </div>

              </div>
              <div class="flip-card-back">
                <div class="row m-0">
                  <p>  OptinQuote: {{$user->optinQuota}}%</p>
                </div>
                <div class="row m-0">
                  <p>SAS Quote:{{$user->sasquota}}</p>
                </div>
              </div>
            </div>
          </div> -->
          <!-- <div class="flip-card" style="background-color: rgba(250, 235, 215,1); margin-top: -10px; margin-left: -10px; height: 100%; width: 100%;" >
            <div class="flipcard-inner p-0">
              <div class="flip-card-front" id="#front">
                <div class="row m-0">
                  <div class="col-6">
                    <img src="https://spd-mvp.de/uploads/spdLandesverbandMecklenburgVorpommern/Landtagswahl-2021/_1024xAUTO_crop_center-center_none/Manuela-Schwesig.jpg" class="img-fluid shadow-lg" alt="" style="border: 5px solid white;">
                  </div>
                  <div class="col-6">
                    <div class="row">
                      <p>{{$user->wholeName()}}</p>
                    </div>
                    <div class="row">
                      <p>  OptinQuote: {{$user->optinQuota}}%</p>
                    </div>
                    <div class="row">
                      <p>SAS Quote:{{$user->optinQuota}}</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flip-card-back" id="#back">
                <div class="row">
                  {{$user->optinQuota}}
                </div>
                <div class="row" style="height: 10vh;">
                  <span style="font-size: 1em;">Motto:</span>
                  <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                </div>
              </div>
          </div>
        </div> -->
      <!-- </div>
      @endforeach
      </div> -->

  </div>
  </div>
  </div>

    </div>

  </div>
  </div>

  <!-- <div class="container-fluid"> -->

@endsection

@section('additional_js')


@endsection
