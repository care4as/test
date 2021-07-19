@extends('general_layout')

@section('content')
<div class="container bg-white" style="width: 75vw; font-size: 0.9em;">
  <h2>Provisionsschätzer</h2>
  <p><small>die Zahlen sind lediglich geschätzt und können von den finalen Zahlen abweichen</small> </p>

  <table class="table table-striped">
    <tr>
      <td>Upgrades</td>

      <td>100</td>
      <td><input type="text" name="" value=""> </td>
    </tr>
    <tr>
      <td>Sidegrades</td>

      <td>50</td>
      <td><input type="text" name="" value=""> </td>
    </tr>
    <tr>
      <td>Downgrades</td>

      <td>25</td>
      <td><input type="text" name="" value=""> </td>
    </tr>
    <tr>
      <td>Calls</td>
      <td>25</td>
      <td><input type="text" name="" value=""> </td>
    </tr>
  </table>
  <h2 class="text-center">Meine Saves</h2>

  <table class="table table-striped" id="retentiontable">
    <thead>
      <tr>
        <th>Datum</th>
        <th>Calls</th>
        <th>SSC Calls</th>
        <th>BSC Calls</th>
        <th>Portal Calls</th>
        <th>Saves</th>
        <th>SSC Saves</th>
        <th>BSC Saves</th>
        <th>Portal Saves</th>
      </tr>
    </thead>
    <tbody>
      @foreach($retentionDetails as $save)
      <tr>
        <td data-sort="{{$save->call_date}}">{{$save->call_date->format('d.m.Y')}}</td>
        <td>{{$save->calls}}</td>
        <td>{{$save->calls_smallscreen}}</td>
        <td>{{$save->calls_bigscreen}}</td>
        <td>{{$save->calls_portale}}</td>
        <td>{{$save->orders}}</td>
        <td>{{$save->orders_smallscreen}}</td>
        <td>{{$save->orders_bigscreen}}</td>
        <td>{{$save->orders_portale}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div>
<div class="container-fluid mt-4" style="width: 75vw; font-size: 0.9em;">
  <div class="row bg-light align-items-center"  style="border-radius: 15px;">
    <div class="col">
        <div class="row">
          <span style="font-size: 20px; margin-top: 9px">  Calls:</span>
            <a class="btn btn-primary btn-fab btn-icon btn-round m-1" href="{{route('user.trackEvent', ['action' => 'add', 'division' => 'call', 'type' => 0, 'operator' => 0])}}">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </a>
               <button class="btn btn-primary btn-outline-primary m-1">@if($user->TrackingToday){{$user->TrackingToday->sum('calls')}} @else 0 @endif</button>
            <a class="btn btn-primary btn-fab btn-icon btn-round m-1" href="{{route('user.trackEvent', ['action' => 'sub', 'division' => 'call', 'type' => 0, 'operator' => 0])}}">
              <!-- -->
                <i class="now-ui-icons ui-1_simple-delete text-white"></i>
              </a>
        </div>
      </div>
      <div class="col">
        Calls +-
      </div>
      <div class="col">
        Calls +-
      </div>
      <div class="col">
        Calls +-
      </div>
      <div class="col">
        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#redirectModal">Rückruf weiterleiten</button>
      </div>
      <div class="col">
        <button class="btn btn-primary float-right" data-container="body" data-toggle="popover" data-placement="top" data-content='

        <div class="row border border-bottom m-0">
          <p class="">1und1 CR:@if($user->TrackingToday->sum('calls') == 0) 0 @else {{round( ($user->TrackingToday->sum('save') / $user->TrackingToday->sum('calls') * 100))}} @endif %</p>
        </div>
        <div class="row border border-bottom m-0">
          <p class="">Gesamt CR: 50%</p>
        </div>
        <div class="row border border-bottom m-0">
          <p class="">Monat CR: 50%</p>
        </div>
        '
        data-html="true">
        CR einblenden</button>
      </div>
  </div>
  <div class="row text-dark">
    <div class="col text-center bg-light mr-1 mt-1 align-items-center" style="border-radius: 15px;">
      <h5 class="m-1"> Retention</h5>
      <div class="row">
        <div class="col-1 ml-1">
          <div class="row" style="height: 23.5px;">
          </div>
          <div class="row align-items-center rowdashboardsize p-1">
            <div class="col p-0">
              SSC
            </div>
          </div>
          <div class="row align-items-center rowdashboardsize">
            <div class="col p-0">
              BSC
            </div>
          </div>
          <div class="row align-items-center rowdashboardsize">
            <div class="col p-0">
              Portal
            </div>
          </div>
        </div>
        <div class="col">
          <div class="row justify-content-center">
            <div class="col">
              Save
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Retention', 'type' => 'SSC','operator' => 1])}}">
                <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
              <!-- <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </button> -->
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Retention')->sum('save')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Retention', 'type' => 'SSC', 'operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Retention', 'type' => 'BSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
                @if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Retention')->sum('save')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Retention', 'type' => 'BSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">

            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Retention', 'type' => 'Portal', 'operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Retention')->sum('save')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Retention', 'type' => 'Portal','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col ml-1 border-left">
          <div class="row justify-content-center">
            Cancel
          </div>
          <div class="row align-items-center">

            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" data-toggle="modal" data-target="#exampleModal" data-division="Retention" data-type="SSC">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
                  @if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Retention')->sum('cancel')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Retention', 'type' => 'SSC', 'operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm"  data-toggle="modal" data-target="#exampleModal" data-division="Retention" data-type="BSC">
                <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Retention')->sum('cancel')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Retention', 'type' => 'BSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm"  data-toggle="modal" data-target="#exampleModal" data-division="Retention" data-type="Portal">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Retention')->sum('cancel')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Retention', 'type' => 'Portal','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col ml-1 border-left">
          <div class="row justify-content-center">
            Service
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Retention', 'type' => 'SSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Retention')->sum('service')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Retention', 'type' => 'SSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Retention', 'type' => 'BSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Retention')->sum('service')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Retention', 'type' => 'BSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Retention', 'type' => 'Portal','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Retention')->sum('service')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Retention', 'type' => 'Portal','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col text-center bg-light mt-1" style="border-radius: 15px;">
      <h5 class="m-1">Prevention</h5>
      <div class="row">
        <div class="col">
          <div class="row justify-content-center">
            <div class="col-1 p-0">
            </div>
            <div class="col">
              Save
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-1 p-0 ml-1">
              SSC
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Prevention', 'type' => 'SSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Prevention')->sum('save')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Prevention', 'type' => 'SSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-1 p-0 ml-1">
              BSC
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Prevention', 'type' => 'BSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
                @if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Prevention')->sum('save')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Prevention', 'type' => 'BSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-1 p-0 ml-1">
              Portal
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Prevention', 'type' => 'Portal','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
                @if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Prevention')->sum('save')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'save', 'division' => 'Prevention', 'type' => 'Portal','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col ml-1 border-left">
          <div class="row justify-content-center">
            Cancel
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Prevention', 'type' => 'SSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Prevention')->sum('cancel')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Prevention', 'type' => 'SSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Prevention', 'type' => 'BSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Prevention')->sum('cancel')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Prevention', 'type' => 'BSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Prevention', 'type' => 'Portal','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Prevention')->sum('cancel')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'cancel', 'division' => 'Prevention', 'type' => 'Portal','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col ml-1 border-left">
          <div class="row justify-content-center">
            Service
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Prevention', 'type' => 'SSC','operator' =>1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','SSC')->where('division','Prevention')->sum('service')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Prevention', 'type' => 'SSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Prevention', 'type' => 'BSC','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','BSC')->where('division','Prevention')->sum('service')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Prevention', 'type' => 'BSC','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Prevention', 'type' => 'Portal','operator' => 1])}}">
                  <i class="now-ui-icons ui-1_simple-add"></i>
              </a>
            </div>
            <div class="col-1 p-0">
              @if($user->TrackingToday){{$user->TrackingToday->where('type','Portal')->where('division','Prevention')->sum('service')}} @else 0 @endif
            </div>
            <div class="col p-0">
              <a class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm" href="{{route('user.trackEvent', ['action' => 'service', 'division' => 'Prevention', 'type' => 'Portal','operator' => 0])}}">
                  <i class="now-ui-icons ui-1_simple-delete"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-2 text-center bg-light mt-1 ml-1" style="border-radius: 15px;">
      <h5 class="m-1">KüRü</h5>
        <div class="row justify-content-center text-white" style="height: 21px;">
        </div>
        <div class="row align-items-center">
          <div class="col-3 p-0">
            SSC
          </div>
          <div class="col p-0">
            <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
                <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          </div>
          <div class="col-1 p-0">
            0
          </div>
          <div class="col p-0">
            <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
                <i class="now-ui-icons ui-1_simple-delete"></i>
            </button>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-3 p-0">
            BSC
          </div>
          <div class="col p-0">
            <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
                <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          </div>
          <div class="col-1 p-0">
            0
          </div>
          <div class="col p-0">
            <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
                <i class="now-ui-icons ui-1_simple-delete"></i>
            </button>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-3 p-0">
            Portal
          </div>
          <div class="col p-0">
            <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
                <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          </div>
          <div class="col-1 p-0">
            0
          </div>
          <div class="col p-0">
            <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
                <i class="now-ui-icons ui-1_simple-delete"></i>
            </button>
          </div>
        </div>
    </div>

  </div>
  <div class="row mt-2 text-dark">
    <div class="col-2 text-center  bg-light  ml-1 mt-1" style="border-radius: 15px;">
      <h5 class="m-1">Neuverträge</h5>
      <div class="row justify-content-center">
        KüRü
      </div>
      <div class="row align-items-center">
        <div class="col-3 p-0">
          SSC
        </div>
        <div class="col p-0">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
              <i class="now-ui-icons ui-1_simple-add"></i>
          </button>
        </div>
        <div class="col-1 p-0">
          0
        </div>
        <div class="col p-0">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
              <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-3 p-0">
          BSC
        </div>
        <div class="col p-0">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
              <i class="now-ui-icons ui-1_simple-add"></i>
          </button>
        </div>
        <div class="col-1 p-0">
          0
        </div>
        <div class="col p-0">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
              <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
        </div>
    </div>
      <div class="row align-items-center">
        <div class="col-3 p-0">
          Portal
        </div>
        <div class="col p-0">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
              <i class="now-ui-icons ui-1_simple-add"></i>
          </button>
        </div>
        <div class="col-1 p-0">
          0
        </div>
        <div class="col p-0">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round btn-sm">
              <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
        </div>
    </div>
  </div>
    <div class="col text-center  bg-light m-1" style="border-radius: 15px;">
    <h5 class="m-1">BK Handling</h5>
    <div class="row d-flex justify-content-center mt-3">
        <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-add"></i>
          </button>
        <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
          Save
        </div>
        <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
          <i class="now-ui-icons ui-1_simple-delete"></i>
        </button>
    </div>
    <div class="row d-flex justify-content-center">
        <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-add"></i>
          </button>
        <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
          Cancel
        </div>
        <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
          <i class="now-ui-icons ui-1_simple-delete"></i>
        </button>
    </div>
    <div class="row d-flex justify-content-center">
        <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-add"></i>
          </button>
        <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
          Save
        </div>
        <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
          <i class="now-ui-icons ui-1_simple-delete"></i>
        </button>
    </div>
    </div>
    <div class="col text-center  bg-light m-1" style="border-radius: 15px;">
      <h5 class="m-1">RLZ + 24</h5>
      <div class="row d-flex justify-content-center mt-3">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
            Save
          </div>
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
      </div>
      <div class="row d-flex justify-content-center">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
            Cancel
          </div>
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
      </div>
      <div class="row d-flex justify-content-center">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
            Save
          </div>
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
      </div>
    </div>
  </div>
  <div class="row d-flex justify-content-center mt-3">
    <div class="col text-center  bg-light m-1">
      <div class="row d-flex justify-content-center">
        <a href="{{route('user.trackEvent', ['action' => '30', 'division' => 'CareCoin', 'type' => 'CareCoin','operator' => 1])}}">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
              Upgrade (30)
          </div>
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
      </div>
      <div class="row d-flex justify-content-center">
        <a href="{{route('user.trackEvent', ['action' => '25', 'division' => 'CareCoin', 'type' => 'CareCoin','operator' => 1])}}">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          </a>
          <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
                Sidegrade (25)
          </div>
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
      </div>
      <div class="row d-flex justify-content-center">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px;  border-style: solid;  border-color: orange;">
              Downgrade (15)
          </div>
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
      </div>
      <div class="row d-flex justify-content-center">
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
              <i class="now-ui-icons ui-1_simple-add"></i>
            </button>
          <div class="d-flex align-items-center border bordercolor m-1" style="  border-width: 9px; border-style: solid; border-color: orange;">
              KüRü (5)
          </div>
          <button class="btn btn-primary btn-fab btn-icon btn-outline-primary btn-round">
            <i class="now-ui-icons ui-1_simple-delete"></i>
          </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="">Cancelgrund</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col text-center text-white bg-light" style="border-radius: 15px;">
            <form class="w-50  text-dark p-4" action="{{route('cancels.save')}}" method="post" style="margin-left: 25%;">
              @csrf
              <input type="hidden" name="cancel" value="" id="type_division">
              <div class="form-group text-dark">
                <label for="case">Case ID</label>
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
    </div>
  </div>
</div>
<div class="modal fade" id="redirectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="">Weiterleitung</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col text-center text-white bg-light" style="border-radius: 15px;">
            <form class="w-50  text-dark p-4" action="{{route('callback.save')}}" method="post" style="margin-left: 25%;">
              @csrf
              <div class="form-group text-dark">
                <label for="customer">Kundennummmer</label>
                <input type="text" class="form-control" name="customer" id="customer" aria-describedby="case" Placeholder="z.B. 2473231">
              </div>
              <div class="form-group">
                <label for="time">Rückruf zu</label>
                <input type="text" class="form-control" id="time" name="time" aria-describedby="offer" Placeholder="z.B. von 14 -15 Uhr">
              </div>
              <div class="form-group">
                <label for="cause">Was wurde besprochen?</label>
                <textarea class="form-control" name="cause" id="cause" rows="3" Placeholder="bitte hier eingeben..."></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Weiterleiten</button>
              </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script>
  $(document).ready(function() {

    let table = $('#retentiontable').DataTable({
      ordering: true,
      "order": [[ 0, "desc" ]],
    })

    $(function () {
    $('[data-toggle="popover"]').popover()
  })
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
    // Javascript method's body can be found in assets/js/demos.js
    // demo.initDashboardPageCharts();
    $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {
    var data_division = '';
    var data_type = '';
    if (typeof $(this).data('division') !== 'undefined') {

      data_division = $(this).data('division');
      if(typeof $(this).data('type') !== 'undefined')
      {
        data_type = $(this).data('type')
      }
    }
    var data = data_division+'/'+data_type
    $('#type_division').val(data);
  })

  });
</script>
@endsection
