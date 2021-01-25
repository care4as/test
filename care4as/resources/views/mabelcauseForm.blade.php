@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row ">

    <div class="col text-center bg-light" style="border-radius: 15px;">
      <h2>Mabelgründe Vorversion</h2>
      <form class="w-50  text-dark p-4" action="{{route('mabelcause.save')}}" method="post" style="margin-left: 25%;">
        @csrf
        <div class="form-group text-dark">
          <label for="case">Vertragsnummer</label>
          <input type="text" class="form-control" name="contractnumber" id="case" aria-describedby="case" Placeholder="z.B. 90191910">
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">Für wen?</label>
           <select class="form-control" name="whogotit" id="exampleFormControlSelect1">
             @foreach($users as $user)
              <option value="{{$user->id}}">{{$user->surname}} {{$user->lastname}}</option>
            @endforeach
           </select>
         </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Produktgruppe</label>
           <select class="form-control" name="category" id="exampleFormControlSelect1" required>
              <option value="" disabled selected></option>
              <option value="SSC">SSC</option>
              <option value="BSC">BSC</option>
              <option value="Portal">Portal</option>
           </select>
         </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Schweregrad</label>
           <select class="form-control" name="productgroup" id="exampleFormControlSelect1" required>
              <option value="" disabled selected> </option>
              <option value="green">systemseitig benötigt</option>
              <option value="yellow">Anfang der Grauzone</option>
              <option value="red">Ende der Grauzone</option>
           </select>
         </div>
        <div class="form-group">
          <label for="cause">Mabelgrund</label>
          <textarea class="form-control" name="why" id="cause" rows="3" Placeholder="bitte hier eingeben..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="button1">Daten absenden</button>
        </form>
    </div>
  </div>
</div>

@endsection
@section('additional_js')

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

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

</script> -->

@endsection
