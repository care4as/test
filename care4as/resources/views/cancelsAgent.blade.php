@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row ">

    <div class="col text-center bg-light" style="border-radius: 15px;">
      <h2>Cancelgründe Vorversion</h2>
      <form class="w-50  text-dark p-4" action="{{route('cancels.save')}}" method="post" style="margin-left: 25%;">

        @csrf
        <div class="form-group text-dark">
          <label for="case">Kundennummer</label>
          <input type="text" class="form-control" name="case" id="case" aria-describedby="case" Placeholder="z.B. 90191910">
        </div>
        <div class="form-group">
          <label for="offer">Angebot</label>
          <input type="text" class="form-control" id="Offer" name="Offer" aria-describedby="offer" Placeholder="z.B. ANF zu xx,xx€">
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Kategorie</label>
             <select class="form-control" name="Category" id="exampleFormControlSelect1">
               <option>Fehlrouting</option>
               <option>Negativflag</option>
               <option>Angebot zu teuer</option>
               <option>zuwenig DV</option>
               <option>lange Laufzeiten</option>
               <option>DSL Kunde</option>
               <option>oVL Kunde</option>
               <option>Authentifizierung nicht möglich</option>
               <option>HAG zu hoch</option>
               <option>unzufrieden mit der 1&1</option>
               <option>sonstige </option>
               <option>keine Netzabdeckung</option>
             </select>
           </div>
        <div class="form-group">
          <label for="cause">Cancelgrund</label>
          <textarea class="form-control" name="Cause" id="cause" rows="3" Placeholder="bitte hier eingeben..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="button1">Daten absenden</button>
        </form>
    </div>

  </div>
</div>

@endsection
@section('additional_js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script type="text/javascript">
  let element = document.getElementById('exampleFormControlSelect1');

  element.addEventListener("change", function(){
    if(element.value == "sonstige") {
      // console.log($('#button1').disabled)
      document.getElementById("button1").disabled = true;
      alert('gib bitte eine Beschreibung im Textfeld ein')
      let textarea = document.getElementById("cause");
      textarea.addEventListener("input", function(){
        document.getElementById("button1").disabled = false;
      }, false);
    }
    else {
      {
        document.getElementById("button1").disabled = false;
      }
    }
  }, false);

</script>

@endsection
