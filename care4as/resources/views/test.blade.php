@extends('general_layout')

@section('additional_css')
<style media="screen">
  .testimg
  {
    border-radius: 25px;
    object-fit: cover;
    height: 310px;
    width: 100%;
    object-position: -30px -40px;
  }
  .colsh
  {
    height: 11em;
  }
</style>
@endsection
@section('content')
<div class="container-fluid mt-4 text-white" style="background-image: linear-gradient( 135deg, #52E5E7 10%, #130CB7 100%);">
  <div class="wrapper" style="height: auto;">
  <div class="row m-1 justify-content-center">
    <div class="col-sm-4 m-1 unit-translucent">
      <div class="row center_items">
        <h3>Andreas Robrahn</h3>
      </div>
      <div class="row" id="mainimg">
        <div class="col-12 p-2">
          <div class="d-flex">
            <img src="{{asset('images/flensburg.jpg')}}" alt="Bewerbungsbild Andreas Robrahn">
          </div>
        </div>
      </div>
      <div class="row" id="sliderimg">
        <div class="col p-2">
          <img src="{{asset('images/flensburg.jpg')}}" alt="zusätzliches Bild1">
        </div>
        <div class="col p-2">
          <img src="{{asset('images/flensburg.jpg')}}" alt="zusätzliches Bild2">
        </div>
        <div class="col p-2">
          <img src="{{asset('images/flensburg.jpg')}}" alt="zusätzliches Bild3">
        </div>
      </div>
      <div class="row">
        <table class="table table-borderless text-white">
          <tr>
            <th><h3>Allg. Informationen</h3></th>
          </tr>
          <tr>
            <td>Staatsangehörigkeit:</td>
            <td>deutsch</td>
          </tr>
          <tr>
            <td>Schulbildung:</td>
            <td>Abitur (2.5)</td>
          </tr>
          <tr>
            <td>Familienstand:</td>
            <td>ledig</td>
          </tr>
          <tr>
            <td>Email:</td>
            <td style="word-break: break-word;">andimensional@gmail.com</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-sm-7 m-1 unit-translucent">
      <div class="row center_items">
        <h3>Historie Arbeitgeber</h3>
      </div>
      <div class="row">
          <div id="accordion" class="accordion">
            <div class="row m-2 overflow-auto border-border">
              <div class="row m-2 w-100">
                <div class="card text-white bg-dark mb-3 w-100 unit-translucent" style="transform: rotateX(12deg);">
                  <div class="card-header">
                    <p class="text-left"><h4>Perry &amp; Knorr | Compliance, Versatel <span class="badge badge-secondary" style="float: right;"> 2010 - 2011</span></h4></p>
                    <p><button type="button" data-toggle="collapse" data-target="#collapse0" aria-expanded="true" aria-controls="collapseOne" class="btn btn-dark btn-lg btn-sm">Mehr Infos <i aria-hidden="true" class="fas fa-angle-double-down"></i></button></p>
                  </div>
                   <div id="collapse0" aria-labelledby="headingOne" data-parent="#accordion" class="collapse">
                      <div class="card-body">
                        <h5 class="card-title">Aufgabenbereich</h5>
                        <p class="card-text">Bearbeiten, Beurteilen und Lösen von Kundenbeschwerden für einen großen Telekomanbieter</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="row justify-content-center m-1">
          <div class="col-11 m-1 unit-translucent">
            <div class="row">
              <h3>Hobbys</h3>
            </div>
            <div class="row center_items">
              <div class="col-3 m-1 p-1 colsh overflow-hidden" style="position:relative;">
                <img class="testimg" src="http://www.stylez4anacondas.org/images/Kampfsport2.jpg" alt="">
              </div>
              <div class="col-3 m-1 p-1 colsh overflow-hidden" style="position:relative;">
                <img class="testimg" src="http://www.stylez4anacondas.org/images/Fu%C3%9Fball2.jpg" alt="">
              </div>
              <div class="col-3 m-1 p-1 colsh overflow-hidden" style="position:relative;">
                <img class="testimg" src="http://www.stylez4anacondas.org/images/Kampfsport2.jpg" alt="">
              </div>
              <div class="col-3 m-1 p-1 colsh overflow-hidden" style="position:relative;">
                <img class="testimg" src="http://www.stylez4anacondas.org/images/Kampfsport2.jpg" alt="">
              </div>
              <div class="col-3 m-1 p-1 colsh overflow-hidden" style="position:relative;">
                <img class="testimg" src="http://www.stylez4anacondas.org/images/Kampfsport2.jpg" alt="">
              </div>
              <div class="col-3 m-1 p-1 colsh overflow-hidden" style="position:relative;">
                <img class="testimg" src="http://www.stylez4anacondas.org/images/Kampfsport2.jpg" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
