@extends('general_layout')

@section('additioonal_css')
<style>
    .header{
        position:sticky;
        top: 0 ;
    }
</style>
@endsection

@section('content')
<div class="container-fluid" style="height: 200em;width: 75vw;">
  <div class="row ">
    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
      <div class="card card-nav-tabs card-plain">
      <div class="card-header card-header-danger">
          <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
          <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                  <ul class="nav nav-tabs" data-tabs="tabs">
                      <li class="nav-item">
                          <a class="nav-link active" href="#home" data-toggle="tab">Cancelliste</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#doku" data-toggle="tab">Dokuliste</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#history" data-toggle="tab">History</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <div class="row m-2 text-dark justify-content-center" style="border-radius: 15px;">
        <div class="col-sm-6 p-0 d-flex justify-content-center">
          <div class="chart-container p-1 d-flex justify-content-center" style="position: relative; width: 100%; height: 100%;">
            <canvas id="myChart"></canvas>
          </div>
        </div>
        <div class="col-sm-6 p-0">
          <div class="row text-dark justify-content-center">
            <h4>Cancels filtern</h4>
            <form class="mt-2 w-100" action="{{route('filter.cancels.post')}}" method="get">
              @csrf
              <div class="row m-0">
                <div class="col p-0">
                  <div class="row m-2 justify-content-center">
                    <div class="col-sm-3">
                      <label for="datefrom">Von:</label>
                       <input type="date" id="datefrom" name="from" class="form-control" placeholder="">
                     </div>
                     <div class="col-sm-3">
                       <label for="dateTo">Bis:</label>
                       <input type="date" id="dateTo" name="to" class="form-control" placeholder="">
                     </div>
                  </div>
                  <div class="row m-2 justify-content-center">
                    <div class="col-sm-3">
                      <label for="category">Kategorie:</label>
                       <input type="text" id="category" name="category" class="form-control" placeholder="">
                     </div>
                     <div class="col-sm-3">
                       <label for="dateTo">Username</label>
                       <input type="text" id="user" name="username" class="form-control" placeholder="">
                     </div>
                  </div>
                  <div class="row m-2 justify-content-center">
                    <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
                  </div>
                </div>
              </div>
            </form>

            <hr>
          </div>
        </div>

          {{-- @if($categories2)
            @foreach($categories2 as $key=>$count)
              <div class="col-3 ">
                {{$key}} : {{$count}}</br>
              </div>
            @endforeach
          @endif --}}
      </div>
      <hr>


      <div class="card-body" style="overflow: visible; height: auto;">
          <div class="tab-content text-center">
              <div class="tab-pane active" id="home">
                {{$cancels->appends(Request::except('page'))->links()}}
                <div class="table-responsive">
                  <table class="table table-striped" style="overflow: scroll; height: auto;">
                  <thead>
                    <tr class="header bg-light" style="position:sticky;top: 0% ; z-index: 2;">
                    <th >Kundenummer</th>
                      <th>Kategorie</th>
                      <th>Angebot</th>
                      <th>Bemerkung</th>
                      <th>erstellt am</th>
                      <th>Kundenberater</th>
                      <th>Optionen</th>
                    <tr>
                  </thead>
                  <tbody >
                    @foreach($cancels as $cancel)
                      <tr style="height: 75px;">
                        <td>{{$cancel->Customer}}</td>
                        <td>{{$cancel->Category}}</td>
                        <td>{{$cancel->Offer}}</td>
                        <td style="max-width: 200px;"><div class="p-1" style="max-height: 75px;overflow-y:scroll;">
                          {{$cancel->Notice}}
                        </div></td>
                        <td>{{$cancel->created_at}}</td>
                        @if($cancel->user)
                          <td>{{$cancel->user->name}}</td>
                        @else
                          <td>user gelöscht</td>
                        @endif
                        <td>
                          <a href="{{route('cancels.delete', ['id' => $cancel->id])}}">
                          <button class="btn btn-danger btn-fab btn-icon btn-round">
                              <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                          </a>
                          <a href="{{route('cancels.change.status', ['id' => $cancel->id, 'status' => 1])}}">
                          <button class="btn btn-success btn-fab btn-icon btn-round">
                              <i class="now-ui-icons ui-1_check"></i>
                          </button>
                          </a>
                          <a href="{{route('cancels.change.status', ['id' => $cancel->id, 'status' => 2])}}">
                          <button class="btn btn-primary btn-fab btn-icon btn-round">
                              <i class="now-ui-icons tech_mobile"></i>
                          </button>
                          </a>
                        </td>
                      <tr>
                    @endforeach
                  </tbody>
              </table>
                </div>

              </div>
              <div class="tab-pane" id="doku">
                <table class="table table-striped">
                <thead>
                  <tr>
                  <th class="header" scope="col">Case_ID</th>
                    <th>Angebot</th>
                    <th>Bemerkung</th>
                    <th>erstellt am</th>
                    <th>Kundenberater</th>
                    <th>Optionen</th>
                  <tr>
                </thead>
                <tbody>
                  @foreach($dokus as $doku)
                    <tr>

                      <td>{{$doku->Case_id}}</td>
                      <td>{{$doku->Offer}}</td>
                      <td style="max-width: 100px; max-height:50px; overflow:scroll;">{{$doku->Notice}}</td>
                      <td>{{$doku->created_at}}</td>
                      <td>Max Mustermann</td>
                      <td>
                        <a href="{{route('cancels.delete', ['id' => $doku->id])}}">
                        <button class="btn btn-danger btn-fab btn-icon btn-round">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                        </a>
                        </a>
                        <a href="{{route('cancels.change.status', ['id' => $doku->id, 'status' => 2])}}">
                        <button class="btn btn-primary btn-fab btn-icon btn-round">
                            <i class="now-ui-icons tech_mobile"></i>
                        </button>
                        </a>
                      </td>
                    <tr>
                  @endforeach
                </tbody>
            </table>
              </div>
              <div class="tab-pane" id="history">
                  <p> I think that&#x2019;s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus. I think that&#x2019;s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at.</p>
              </div>
          </div>
      </div>
    </div>

    </div>

  </div>
</div>

@endsection
@section('additional_js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
let chartData = {!! $categories2!!}
let labelArray= [];
let valueArray= [];

Object.keys(chartData).forEach(function(key) {
    var value = key;
    labelArray.push(value)
    valueArray.push(chartData[key])
    // ...
});

var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels:labelArray,
        datasets: [{
            data: valueArray,
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(60, 179, 113, 1)',
                'rgba(0, 0, 255, 1)',
                'rgba(238, 130, 238, 1)',
                'rgba(106, 90, 205, 1)',
                'rgba(255, 165, 0, 1)',
                'rgba(248, 188, 138, 1)',
                'rgba(157, 135, 138, 1)',
                'rgba(60, 141, 247, 1)',
                'rgba(32, 81, 126, 1)',
                'rgba(103, 163, 55, 1)',
                'rgba(255, 255, 55, 1)',
            ],
        }]
    },
    options: {

        legend: {
            display: true,
            position: 'right',
        },
    }
});
</script>
@endsection
