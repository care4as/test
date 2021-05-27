@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row ">

    <div class="col text-center bg-light" style="border-radius: 15px;">
      <h2>Tracking Offline Vorversion</h2>
      <form class="w-50  text-dark p-4" action="{{route('offlineTracking.save')}}" method="post" style="margin-left: 25%;">
        @csrf
        <div class="form-group text-dark">
          <label for="case">Vertragsnummer</label>
          <input type="text" class="form-control" name="contract_number" id="case" aria-describedby="case" Placeholder="z.B. 90191910">
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">Kategorie</label>
             <select class="form-control" name="category" id="exampleFormControlSelect1">
               <option>GeVo</option>
               <option>KüRü</option>
               <option>Negativ/Cancel</option>
               <option>Nicht erreicht</option>
               <option>Nicht erreicht --> Retention Offline</option>

             </select>
           </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Zeitraum</label>
             <select class="form-control" name="timespan" id="exampleFormControlSelect1">
               <option>8 - 9</option>
               <option>9 - 10</option>
               <option>10 - 11 Uhr</option>
               <option>11 - 12 Uhr</option>
               <option>12 - 13 Uhr</option>
               <option>13 - 14 Uhr</option>
               <option>14 - 15 Uhr</option>
               <option>15 - 16 Uhr</option>
               <option>16 - 17 Uhr</option>
               <option>17 - 18 Uhr</option>
               <option>18 - 19 Uhr</option>
               <option>19 - 20 Uhr</option>

             </select>
           </div>
        <div class="form-group">
          <label for="cause">Grund</label>
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
