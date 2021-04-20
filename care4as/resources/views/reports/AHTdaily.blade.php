@extends('..general_layout')

@section('additional_css')
  <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

  <div class="container bg-light">
    <div class="row bg-white shadow  m-1 mt-4" id="filtermenu">
      <div class="col-12 d-flex justify-content-center align-self-center">
        <h5>Filtermenü</h5>
      </div>
      <div class="col-12">
        <form class="mt-2 w-100" action="{{route('reports.AHTdaily')}}" method="get">
          <div class="row m-0 justify-content-center">
            <div class="col-12 p-0">
              <div class="row m-2 justify-content-start">
                <div class="col-sm-3">
                  <label for="datefrom">Von:</label>
                   <input type="date" id="start_date" name="start_date" class="form-control" placeholder="" value="{{request('start_date')}}">
                 </div>
                 <div class="col-sm-3">
                   <label for="dateTo">Bis:</label>
                   <input type="date" id="end_date" name="end_date" class="form-control" placeholder="" value="{{request('end_date')}}">
                 </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-12 p-0">
        <div class="row m-2 justify-content-center">
          <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
        </div>
      </div>
      </form>
    </div>
    <div class="row bg-white rounded">
      <div class="col">
        <table class="table table-striped table-hover">
          <tr>
            <th>Tag</th>
            <th>AHT</th>
          </tr>
          @foreach($finalValues as $key => $value)
          <tr>
            <td>{{$key}}</td>
            <td>{{round(($value[0] / $value[1]),0)}}</td>

          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
@endsection
