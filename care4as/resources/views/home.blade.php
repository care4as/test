@extends('general_layout')

@section('content')

<div class="container-fluid bg-light rounded">
  <div class="row bg-info" id="headline">
    <div class="col">
      <h2 class="text-center text-white">Andreas Robrahn</h2>
    </div>
  </div>
  <div class="row justify-content-center" id="img slider">
    <div class="col d-flex justify-content-center">
      <img src="img-fluid" alt="Bewerbungsfoto">
    </div>

    <div class="col d-flex justify-content-center">
      <img src="img-fluid" alt="Bewerbungsfoto">
    </div>

    <div class="col d-flex justify-content-center">
      <img src="img-fluid" alt="Bewerbungsfoto">
    </div>

    <div class="col d-flex justify-content-center">
      <img src="img-fluid" alt="Bewerbungsfoto">
    </div>

  </div>
  <div class="row mt-2 justify-content-center">
    <div class="col-6 text-dark rounded shadow-lg">
      <h3 class="text-center">Über mich:</h3>
      <p>Sehr geehrter Besucher*innen,<br>
      willkommen auf meiner eigens designten, entwickelten und gehosteten Seite. Ich gebe dir hier eine bessere Einsicht um deine Entscheidung leichter zu machen, und stelle dir auch weniger subtil die Frage "stellst du lieber jemanden ein der gelernt hat wie man eine Website programmiert oder jemanden der eine Webseite programmiert hat?".
      Auf den folgenden Seiten präsentiere ich dir ein paar meiner bereits erworbenen Fähigkeiten, einen ausführlicheren Lebenslauf und einige relevante Ansichten meinerseits über Arbeit ansich und Erwartungen die ich selbst an dein Unternehmen richte.</p>
    </div>
  </div>
  <div class="row mt-5">
    <img src="{{asset('images/flensburg.jpg')}}" class="img-fluid" alt="flensburg" style="width:100%; height: 300px; object-fit: cover;">
  </div>
  <div class="row mt-5 justify-content-center">
    <div class="col-sm-4 text-dark rounded shadow-lg m-1">
      <img src="https://media.istockphoto.com/photos/flensburg-in-germany-picture-id1264881211?b=1&k=6&m=1264881211&s=170667a&w=0&h=-ex_moiPWNOlLkWPqxfFsQUwXCvBqJ4W98kUfMCeflc=" alt="flensburgfoto">
    </div>
    <div class="col-sm-4 text-dark rounded shadow-lg m-1  d-flex align-items-center">
      <p>Ich wohne nun seit mittlerweile 14 Jahren im nördlichsten Norden Deutschlands. Anfangs aus beruflichen Gründen immigriert, habe ich die Stadt im Laufe der Jahre liebgewonnen. Die Nähe zur Ostsee, die offene Gesellschaft sind nur einige der </p>
    </div>
  </div>
  <div class="row mt-5 justify-content-center p-2">
    <div class="col-sm-4 text-dark rounded shadow-lg m-1 d-flex align-items-center">
        <p>Geboren und aufgewachsen bin ich am schönsten Flecken der Erde wenn man Natur mag. Wir haben sogar Nandus!</p>
    </div>
    <div class="col-sm-4 text-dark rounded shadow-lg m-1">
      <img src="https://cdn.pixabay.com/photo/2017/05/28/09/15/rape-blossom-2350448__340.jpg" alt="nordwestmecklenburg foto">
    </div>
  </div>
  <div class="row mt-5">
    <img src="{{asset('images/flensburg.jpg')}}" class="img-fluid" alt="flensburg" style="width:100%; height: 300px; object-fit: cover;">
  </div>
  <div class="row ">
    <div class="col">
      <div class="row justify-content-center">
        <h4 class="text-center">Produktkarten</h4>
      </div>
      <div class="row">
        <div class="col">
          <div class="bg-white shadow-lg" style="max-width: 250px; ">
            <div class="row-0">
              <div class="col p-2 d-flex justify-content-center">
                <img class="img-fluid shadow-sm" alt="ProduktBild" style="object-fit:scale-down; margin-top: -30px; width: 90%; border-radius: 15px;" src="data:image/jpeg;base64,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" >
              </div>
            </div>
            <div class="row m-0 justify-content-center">
              <div class="col p-0 ">
                <h5 class="text-center">Auto2</h5>
              </div>
            </div>
            <div class="row m-0">
              <div class="col p-0">
                <a class="" data-toggle="collapse" href="#description2" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <h5>Beschreibung</h5>
                </a>
                <div class="collapse" id="description2">
                  <div class="card card-body">
                     <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                  </div>
                </div>

              </div>
            </div>
            <div class="row m-0 mt-2">
              <div class="col-4 d-flex justify-content-center">
                <a href="#"><i class="far fa-id-card"></i></a>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <a href="#"><i class="fas fa-ad"></i></a>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <a href="#"><i class="far fa-id-card"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="bg-white shadow-lg" style="max-width: 250px; ">
            <div class="row-0">
              <div class="col p-2 d-flex justify-content-center">
                <img class="img-fluid shadow-sm" alt="ProduktBild" style="object-fit:scale-down; margin-top: -30px; width: 90%; height: 160px; border-radius: 15px;" src="https://lh3.googleusercontent.com/proxy/n-0cFcuX0Vur48BzgkMqUy4h8PSfIHBP8Z11Qji2dJhbZtBvQHc4ef_vplQofrDvtXm-nkl0QMXDESKpO-LWqixGMlwhjfWNuRvsj735HnEB1T1i1q2Wmlt_cobnhESjrUZHmVV2tFuTbt2Y" >
              </div>
            </div>
            <div class="row m-0 justify-content-center">
              <div class="col p-0 ">
                <h5 class="text-center">Auto1</h5>
              </div>
            </div>
            <div class="row m-0">
              <div class="col p-0">
                <a class="" data-toggle="collapse" href="#description1" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <h5>Beschreibung</h5>
                </a>
                <div class="collapse" id="description1">
                  <div class="card card-body">
                     <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                  </div>
                </div>

              </div>
            </div>
            <div class="row m-0 mt-2">
              <div class="col-4 bg-light d-flex justify-content-center border">
                <a href="#"><i class="far fa-id-card"></i></a>
              </div>
              <div class="col-4 bg-light d-flex justify-content-center border">
                <a href="#"><i class="fas fa-ad"></i></a>
              </div>
              <div class="col-4 bg-light d-flex justify-content-center border">
                <a href="#"><i class="far fa-id-card"></i></a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
