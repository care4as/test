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
        <div class="form-row m-1">
          <div class="form-col">
            <label for="datefrom">Von:</label>
             <input type="date" id="start_date" name="start_date" class="form-control" placeholder="" value="">
           </div>
           <div class="form-col">
             <label for="dateTo">Bis:</label>
             <input type="date" id="end_date" name="end_date" class="form-control" placeholder="" value="">
           </div>
        </div>
        <div class="form-row m-1">
          <div class="form-check form-check-inline">
            <label class="form-check-label p-0" for="inlineRadio1">Mobile</label>
            <input class="form-check-input ml-2" type="radio" name="department" id="inlineRadio1" value="Mobile">
          </div>
          <div class="form-check form-check-inline">
            <label class="form-check-label p-0" for="inlineRadio2">DSL</label>
            <input class="form-check-input ml-2" type="radio" name="department" id="inlineRadio2" value="DSL">
          </div>
        </div>
          <div class="form-row m-1  w-25">
            <label for="sickQ">Krankenquote</label>
            <div class="input-group">

              <input type="text" class="form-control" name="sickQ" value="8" id="sickQ">
              <div class="input-group-append">
                <span class="input-group-text">%</span>
              </div>
            </div>
          </div>
          <div class="form-row m-1 w-25">
            <label for="vacQ">Urlaubsquote</label>
            <div class="input-group">
              <input type="text"  class="form-control" name="vacQ" value="8"  id="vacQ">
              <div class="input-group-append">
                <span class="input-group-text">%</span>
              </div>
            </div>
          </div>

          <div class="form-row m-1 w-25">
            <label for="trainQ">Trainingquote</label>
            <div class="input-group">
              <input type="text" class="form-control"  name="trainQ" value="2" id="trainQ">
              <div class="input-group-append">
                <span class="input-group-text">%</span>
              </div>
            </div>
          </div>
          <div class="form-row m-1 w-25">
            <label for="meetQ">Meetingquote</label>
            <div class="input-group">
              <input type="text"  class="form-control" name="meetQ" value="1" id="meetQ">
              <div class="input-group-append">
                <span class="input-group-text">%</span>
              </div>
            </div>
          </div>
          <div class="form-row m-1 w-25">
            <label for="oAQ">Other Absence</label>
            <div class="input-group">
              <input type="text"  class="form-control" name="oAQ" value="25" id="oAQ">
              <div class="input-group-append">
                <span class="input-group-text">%</span>
              </div>
            </div>

          </div>

        <div class="form-row mt-2">
          <button type="submit" name="button" class="btn-outline-success p-0">Erstellen</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@section('additional_js')

<script type="text/javascript">
$('#start_date').on('input', function(){
  let day = new Date(this.value)

  let plusoneeighty = new Date(day.setDate(day.getDate() + 184))

let dayF = ('0' + plusoneeighty.getDate()).slice(-2)

var month = ("0" + (plusoneeighty.getMonth() + 1)).slice(-2)
//
var targetdate = plusoneeighty.getFullYear()+"-"+(month)+"-"+(dayF)

  // console.log(month)

  $('#end_date').val(targetdate)
})
</script>
@endsection
