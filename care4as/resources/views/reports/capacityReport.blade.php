@extends('general_layout')

@section('content')
<div class="container bg-light">
  <div class="row">
    <div class="col">
      <form class="" action="{{route('reports.capacitysuite.post')}}" method="post">
        @csrf
        <div class="form-row">
          <h5>Für welche Abteilung soll der Capacity Suite Report erstellt werden</h5>
        </div>
        <div class="form-row">
          <div class="form-col">
            <label for="datefrom">Von:</label>
             <input type="date" id="start_date" name="start_date" class="form-control" placeholder="" value="{{request('start_date')}}">
           </div>
           <div class="form-col">
             <label for="dateTo">Bis:</label>
             <input type="date" id="end_date" name="end_date" class="form-control" placeholder="" value="{{request('end_date')}}">
           </div>
        </div>
        <div class="form-row">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="department" id="inlineRadio1" value="Mobile">
            <label class="form-check-label" for="inlineRadio1">Mobile</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="department" id="inlineRadio2" value="DSL">
            <label class="form-check-label" for="inlineRadio2">DSL</label>
          </div>
        </div>
        <div class="form-row">
          <button type="submit" name="button" class="btn-outline-success">Erstellen</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
