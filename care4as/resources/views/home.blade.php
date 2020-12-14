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
</div>
@endsection
