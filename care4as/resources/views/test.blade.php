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

<div class="container bg-light">
  <table>
    <tr>
      <td>#</td>
      <td>Vertragsnummer</td>
      <td>Zeitraum</td>
      <td>Kategorie</td>
      <td>erstellt von</td>
      <td>Kommentar</td>
      <td>erstellt</td>
    </tr>
    @foreach($offlinetracks ?? '' as $tracking)
    <tr>
      <td>{{$tracking->id}}</td>
      <td>{{$tracking->contract_number}}</td>
      <td>{{$tracking->timespan}}</td>
      <td>{{$tracking->category}}</td>
      <td>{{$tracking->user->name}}</td>
      <td>{{$tracking->comment}}</td>
      <td>{{$tracking->created_at}}</td>
    </tr>
    @endforeach
  </table>
  <hr>

  @foreach($users as $user)
  <table class="table table-striped">

    <thead class="thead-dark">
      <tr>
        <td>Agent {{$user->wholeName()}}</td>
        <td>Gevo</td>
        <td>KüRü</td>
        <td>Negativ/Cancel</td>
        <td>Nicht erreicht</td>
        <td>Nicht erreicht --> Retention Offline</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>8 - 9</td>
        <td>{{$offlinetracks ?? ''->where('timespan','8 - 9')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','8 - 9')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','8 - 9')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','8 - 9')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','8 - 9')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>9 - 10</td>
        <td>{{$offlinetracks ?? ''->where('timespan','9 - 10')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','9 - 10')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','9 - 10')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','9 - 10')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','9 - 10')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>10 - 11</td>
        <td>{{$offlinetracks ?? ''->where('timespan','10 - 11')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','10 - 11')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','10 - 11')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','10 - 11')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','10 - 11')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>11 - 12</td>
        <td>{{$offlinetracks ?? ''->where('timespan','11 - 12')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','11 - 12')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','11 - 12')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','11 - 12')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','11 - 12')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>12 - 13</td>
        <td>{{$offlinetracks ?? ''->where('timespan','12 - 13')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','12 - 13')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','12 - 13')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','12 - 13')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','12 - 13')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>13 - 14</td>
        <td>{{$offlinetracks ?? ''->where('timespan','13 - 14')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','13 - 14')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','13 - 14')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','13 - 14')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','13 - 14')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>14 - 15</td>
        <td>{{$offlinetracks ?? ''->where('timespan','14 - 15')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','14 - 15')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','14 - 15')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','14 - 15')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','14 - 15')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>15 - 16</td>
        <td>{{$offlinetracks ?? ''->where('timespan','15 - 16')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','15 - 16')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','15 - 16')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','15 - 16')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','15 - 16')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>16 - 17</td>
        <td>{{$offlinetracks ?? ''->where('timespan','16 - 17')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','16 - 17')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','16 - 17')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','16 - 17')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','16 - 17')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>17 - 18</td>
        <td>{{$offlinetracks ?? ''->where('timespan','17 - 18')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','17 - 18')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','17 - 18')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','17 - 18')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','17 - 18')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>18 - 19</td>
        <td>{{$offlinetracks ?? ''->where('timespan','18 - 19')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','18 - 19')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','18 - 19')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','18 - 19')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','18 - 19')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>19 - 20</td>
        <td>{{$offlinetracks ?? ''->where('timespan','19 - 20')->where('category','GeVo')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','19 - 20')->where('category','KüRü')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','19 - 20')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','19 - 20')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$offlinetracks ?? ''->where('timespan','19 - 20')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>

    </tbody>
  </table>
  @endforeach
</div>



@endsection

@section('additional_js')


@endsection
