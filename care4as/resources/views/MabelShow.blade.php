@extends('general_layout')

@section('content')
<div class="container-fluid bg-light p-5" style="width: 75vw; border-radius: 15px;">
  <div class="row justify-content-center">
    <h5>Filtermenü</h5>
  </div>
  <div class="row justify-content-center">
    <div class="col-7">
      <form class="" action="{{route('mabelcause.index.filtered')}}" method="post">
        @csrf
        <div class="row m-2 justify-content-center">
          <div class="col-sm-3">
            <label for="datefrom">Von:</label>
             <input type="date" id="datefrom" name="from" class="form-control" placeholder="" value="{{\Carbon\Carbon::today()->toDateString()}}">
           </div>
           <div class="col-sm-3">
             <label for="dateTo">Bis:</label>
             <input type="date" id="dateTo" name="to" class="form-control" placeholder="" value="{{\Carbon\Carbon::today()->toDateString()}}">
           </div>
        </div>
        <div class="row m-2 justify-content-center">
          <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
            <ul class="nav nav-tabs" data-tabs="tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#mabelcauses" data-toggle="tab">Mabelgründe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#whogotit" data-toggle="tab">Gemabelt für</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#whodidit" data-toggle="tab">Mabler</a>
                </li>
            </ul>
        </div>
    </div>
  </div>
  <div class="tab-content w-100" id="myTabContent">
    <div class="tab-pane fade show active" id="mabelcauses" role="tabpanel" aria-labelledby="home-tab">
      <table class='table table-hover w-100'>
        <tr>
          <th>#</th>
          <th>gemabelt von</th>
          <th>gemabelt an</th>
          <th>aus folgendem Grund</th>
          <th>erstellt am</th>
          <th>Optionen</th>
        </tr>
          @foreach($mabelCs as $mabelC)
            <tr>
              <td>{{$mabelC->id}}</td>
              <td>{{$mabelC->DidIt->name}}</td>
              <td>{{$mabelC->GotIt->name}}</td>
              <td>{{$mabelC->WhyBro}}</td>
              <td>{{$mabelC->created_at}}</td>
              <td><a href="route()"> <i class="now-ui-icons ui-1_zoom-bold"></i></a></td>
            </tr>
          @endforeach
      </table>
    </div>
    <div class="tab-pane" id="whogotit" role="tabpanel" aria-labelledby="home-tab">
      <div class="row mt-4" id='firstLevelRow'>
        <div class="col-sm">
          <table class='table table-hover w-100'>
              @foreach($stats1 as $user => $count)
                <tr>
                  <th>{{$user}}:</th>
                  <th>{{$count}}</th>
                </tr>
              @endforeach
          </table>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="whodidit" role="tabpanel" aria-labelledby="home-tab">
      <div class="row mt-4">
        <div class="col-sm">
          <table class='table table-hover w-100'>
              @foreach($stats2 as $user => $count)
                <tr>
                  <th>{{$user}}:</th>
                  <th>{{$count}}</th>
                </tr>
              @endforeach
          </table>
        </div>
      </div>
    </div>
</div>

@endsection
@section('additional_js')
<script>
  $(document).ready(function() {
    $(function () {
    $('[data-toggle="popover"]').popover()
  })
    // Javascript method's body can be found in assets/js/demos.js
    // demo.initDashboardPageCharts();

  });
</script>
@endsection
