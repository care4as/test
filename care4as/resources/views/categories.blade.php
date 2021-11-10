
@extends('general_layout')

@section('content')

<div class="container-fluid mt-4" style="width: 75vw;">
  <div class="row ">
    <form class="mt-2 w-100" action="{{route('report.joyce')}}" method="get">
      @csrf
      <div class="row m-0">
        <div class="col p-0">
          <div class="row m-2 justify-content-center">
            <div class="col-sm-3">
              <label for="datefrom">Von:</label>
               <input type="date" id="startdate" name="startdate" class="form-control" placeholder="">
             </div>
             <div class="col-sm-3">
               <label for="dateTo">Bis:</label>
               <input type="date" id="enddate" name="enddate" class="form-control" placeholder="">
             </div>
          </div>
        </div>
      </div>
      <div class="row ">
        <div class="col-6 center_items">
          <button type="submit" class="btn-primary border border-white" name="button" value="1">Filtern</button>
        </div>
        <div class="col-6 center_items">
          <button type="submit" class="btn-primary border border-white" name="button2" value="1">Als Excel</button>
        </div>

      </div>
    </form>
  </div>
  <div class="row ">
    <div class="col text-center center_items" style="border-radius: 15px;">

      <table>
        <tr>
          <td colspan="3 ">  <h3 class="text-dark">{{$timespan[0]}}</h3></td>
        </tr>
        <tr>
          <th class="text-dark">Kategorie</th>
        </tr>
      <tr>
        <td class="" style="vertical-align: top;">
          <h3 class="">Highperformer</h3>
          <table class="max-table" id="xxx" style="width: 100%;">
            <tr>
              <th>PID</th>
              <th>Name</th>
              <th>SSC Quote</th>
            </tr>
              @foreach($highperformers as $performer)
              <tr>
                <td>{{($performer->{'1u1_person_id'})}}</td>
                <td>{{$performer->name}}</td>
                <td>{{$performer->quota}}</td>

              </tr>
              @endforeach
          </table>

        </td>
        <td style="vertical-align: top;">
          <h3 class="">Midperformer</h3>
          <table class="max-table" id="xxx" style="width: 100%;">
            <tr>
              <th>PID</th>
              <th>Name</th>
              <th>SSC Quote</th>
            </tr>
              @foreach($midperformers as $performer)
              <tr>
                <td>{{($performer->{'1u1_person_id'})}}</td>
                <td>{{$performer->name}}</td>
                <td>{{$performer->quota}}</td>

              </tr>
              @endforeach
          </table>
        </td>
        <td style="vertical-align: top;">
          <h3 class="">Lowperformer</h3>
          <table class="max-table" id="xxx" style="width: 100%;">
            <tr>
              <th>PID</th>
              <th>Name</th>
              <th>SSC Quote</th>
            </tr>
              @foreach($lowperformers as $performer)
              <tr>
                <td>{{($performer->{'1u1_person_id'})}}</td>
                <td>{{$performer->name}}</td>
                <td>{{$performer->quota}}</td>
              </tr>
              @endforeach
          </table>
        </td>
      </tr>
    </tr>
    </table>
    </div>
  </div>
</div>
<div class="container-fluid mt-4" style="width: 75vw; border-radius: 25px;">
  <table class="max-table" id="xxx" style="width: 100%;">
    @foreach($dataarray as $key => $data)
    <tr class="">
      <td>{{$key}}</td>
      <td>insgesamt: {{count($data['date'])}}</td>
      <td>
        <table class="table table-borderless">
          @foreach($data['date'] as $date)
          <tr>
            <td>{{$date}}</td>
          </tr>
          @endforeach
        </table>

      </td>

    </tr>
    @endforeach
  </table>
</div>
@endsection
