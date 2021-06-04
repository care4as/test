@extends('general_layout')

@section('additional_css')
<style media="screen">
body{
  font-family: 'Merienda One';
  font-size: 1.1em;
  overflow:initial !important
}

.mainColor
{
  background: RGB(221, 65, 36);
}
#stickynav
{
  color: white;
}
.table-striped>tbody>tr:nth-child(even) {
    background-color: #ddf8e8;
}

.table-striped>tbody>tr:nth-child(odd) {
    background-color: #fefdfa;
}
.table-striped>tbody>tr:hover {
  opacity: 0.5;
}

tr{
  /* text-align: center; */
}
</style>

@endsection

@section('content')

<div class="container bg-light">

  <div class="row sticky-top mainColor" id='stickynav'>
    <div class="col d-flex justify-content-center align-items-center">
      Aktuelles
    </div>
    <div class="col d-flex justify-content-center align-items-center">
      Über uns
    </div>
    <div class="col d-flex justify-content-center align-items-center">
      Training
    </div>
    <div class="col d-flex justify-content-center align-items-center">
      <img src="https://static.wixstatic.com/media/f48c3a_bd5d30ff99ab4ab29a8621d05c2e190c~mv2.jpg/v1/fill/w_110,h_110,al_c,q_80,usm_0.66_1.00_0.01/f48c3a_bd5d30ff99ab4ab29a8621d05c2e190c~mv2.webp" alt="" style="width:110px;height:110px;object-fit:cover;object-position:50% 50%">
    </div>
    <div class="col d-flex justify-content-center align-items-center">
      Sport
    </div>
    <div class="col d-flex justify-content-center align-items-center">
      Kontakt/Social Media
    </div>
    <div class="col d-flex justify-content-center align-items-center">
      Impressum
    </div>
  </div>
  <div class="row justify-content-center mt-3">
    <div class="col-8 p-0 ">
      <p><h3 class="text-center">🥋🤼 Team Yak 🤼🥋 <br> Brasilian Jiu Jitsu in Flensburg ! </h3> </p>
      <p class="mt-3">
        Seit dem 31.05.21 ist das Training in Gruppen wieder möglich. Bis auf weiteres setzten wir ein negatives Coronatestergbnis, das nicht älter als 48 Stunden ist, zur Teilnahme am Training voraus.
        Wir bitten um euer Verständnis!
      </p>
    </div>
  </div>
  <div class="row bg-dark text-white justify-content-center mt-3">
    <div class="col-8 p-0 ">
      <p><h3 class="text-center">Das ist Team Yak</h3> </p>
      <p class="" style="margin-top: 55px;">
        Wir sind das erste BJJ Team Flensburgs. Gegründet wurde das Team Yak 2015 vom Braungurt Eitan Bronschtein. Derzeit Unterrichtet er BJJ im Ninja Sportclub e.V. in Hamburg. Das Training in Flensburg wird von den Brüdern Andreas & Kristoffer Madsen geleitet. Beide tragen einen lila Gurt der ihnen von Eitan Bronschtain 2020 und 2019 übergeben wurde und bringen zusammen mehr als 10 Jahre Erfahrung auf die Matte. Das Team steht für ein offenes Klima, das jede an dem Sport Interessierte Person herzlich aufnimmt und ein Teil des Teams werden lässt.
      </p>
    </div>
  </div>
  <div class="row bg-white justify-content-center mt-3">
    <div class="col-8 p-0 ">
      <p><h3 class="text-center">Unsere Trainingszeiten</h3> </p>
      <table class="table table-striped" id="userdata">
      <thead class="mainColor text-white" style="opacity: 0.5;">
        <tr>
          <th class="">#</th>
          <th>Uhrzeit</th>
          <th>Trainingsinhalt</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Montag</td>
          <td>20.00 Uhr - 21.30 Uhr</td>
          <td>Grappling Fundamentals</td>
        </tr>
        <tr>
          <td>Dienstag</td>
          <td>16.15 Uhr - 17.45 Uhr</td>
          <td>BJJ Technik</td>
        </tr>
        <tr>
          <td>Donnerstag</td>
          <td>16.15 Uhr - 17.45 Uhr</td>
          <td>BJJ Technik</td>
        </tr>
        <tr>
          <td>Freitag</td>
          <td>18.00 Uhr - 19.30 Uhr</td>
          <td>Competition Class</td>
        </tr>
      </tbody>
  </table>
    </div>
  </div>

  </div>


@endsection

@section('additional_js')


</script>
@endsection
