@extends('general_layout')
@section('pagetitle')
    Mobile Tracking
@endsection
@section('content')
@section('additional_css')

@php
function roundUp($calls,$quotient)
{
  if($calls == 0)
  {
    $quota = 0;
  }
  else
  {
    $quota = round($quotient*100/$calls, 2);
  }

  return $quota;
}
@endphp
<style>
    .tracking_title{
        border-bottom: 1px solid gray;
        text-align: center;
        font-size: 1.3rem;
    }

    .tracking-table{
        width: 100%;
        white-space: nowrap;
        border: 2px solid grey;
    }

    .tracking-table th, td{
        border: 1px solid grey;
        padding: 0 5px;
    }

    .tracking-table th{
        text-align: center;
    }
    .tracking_container{
        padding: 10px;
    }

    .tracking_description{
        font-size: 0.8em;
        text-align: center;
    }

    .tracking_title{
        border-bottom: 1px solid gray;
        text-align: center;
        padding: 10px 0;
        font-size: 1.3rem;
    }

    .tracking-table{
        white-space: nowrap;
        width:100%;
    }

    .tracking-table th, td{
        border: 1px solid black;
        padding: 0 5px;
    }

    .tracking-table th{
        text-align: center;
    }

    .btn-check {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
    }

    .btn-outline-primary:hover{
        color: white;
        background-color: #f96332;;
    }

    .btn-check:checked + label{
    color: white;
    background-color: #f96332;;
    border: 1px solid #f96332;
    }

    .first-btn-group-element{
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
    }

    .last-btn-group-element{
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }

    .btn-group > .btn:not(:first-child){
        margin-left: -2px;
    }

    .btn{
        padding: 5px 10px !important;
        margin-top: 0;
        margin-bottom: 0;
        min-width: 75px;
    }

    .btn-group-container{
        display: flex;
        justify-content: center;
    }

    .btn-tracking-change{
        min-width: 50px;
    }

    .form-control[disabled]{
        cursor: default;
    }

    .tr {
        background-color:  black !important;
    }
</style>
@endsection

<div style="font-size: 1em">
    <!-- START MAIN-->
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="card card-nav-tabs card-plain">
                    <div class="card-header card-header-danger">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#overview" data-toggle="tab">Übersicht</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#history" data-toggle="tab">Historie</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content text-center">
                            <div class="tab-pane active" id="overview">
                                <div style="margin: 10px 2px 10px 10px; overflow: scroll;">
                                    <table class="tracking-table" id="AdminTrackingTable">
                                        <thead>
                                            <tr>
                                                <th rowspan="3" class="bg-dark text-white"style="border-right: 2px solid grey">Name</th>
                                                <th colspan="3" style="border-right: 2px solid grey">Gesamt</th>
                                                <th colspan="9" style="border-right: 2px solid grey">SSC</th>
                                                <th colspan="9" style="border-right: 2px solid grey">BSC</th>
                                                <th colspan="9" style="border-right: 2px solid grey">Portal</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">Calls</th>
                                                <th rowspan="2">Cancel</th>
                                                <th rowspan="2" style="border-right: 2px solid grey">Service</th>
                                                <th rowspan="2">Calls</th>
                                                <th colspan="4">Saves</th>
                                                <th colspan="2">Negativ</th>
                                                <th colspan="2" style="border-right: 2px solid grey">CR</th>
                                                <th rowspan="2">Calls</th>
                                                <th colspan="4">Saves</th>
                                                <th colspan="2">Negativ</th>
                                                <th colspan="2" style="border-right: 2px solid grey">CR</th>
                                                <th rowspan="2">Calls</th>
                                                <th colspan="4">Saves</th>
                                                <th colspan="2">Negativ</th>
                                                <th colspan="2" style="border-right: 2px solid grey">CR</th>
                                                <th>Sonstige</th>
                                                <th colspan="2">OptIn</th>
                                            </tr>
                                            <tr>
                                                <th>Σ GeVo Saves</th>
                                                <th>← Gebucht</th>
                                                <th>← Nacharbeit</th>
                                                <th>KüRü</th>
                                                <th>Cancel</th>
                                                <th>Service</th>
                                                <th>Gebucht</th>
                                                <th style="border-right: 2px solid grey">Gesamt</th>
                                                <th>Σ GeVo Saves</th>
                                                <th>← Gebucht</th>
                                                <th>← Nacharbeit</th>
                                                <th>KüRü</th>
                                                <th>Cancel</th>
                                                <th>Service</th>
                                                <th>Gebucht</th>
                                                <th style="border-right: 2px solid grey">Gesamt</th>
                                                <th>Σ GeVo Saves</th>
                                                <th>← Gebucht</th>
                                                <th>← Nacharbeit</th>
                                                <th>KüRü</th>
                                                <th>Cancel</th>
                                                <th>Service</th>
                                                <th>Gebucht</th>
                                                <th style="border-right: 2px solid grey">Gesamt</th>
                                                <th>Calls</th>
                                                <th>Anzahl</th>
                                                <th>Quote</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            @foreach($users as $user)
                                            <td class="bg-dark text-white"style="border-right: 2px solid grey">{{$user->name}}</td>
                                            <td>{{$calls = $user->TrackingCallsToday->sum('calls')}}</td>
                                            <td>{{$cancels = $user->TrackingToday->where('event_category','Cancel')->count()}}</td>
                                            <td style="border-right: 2px solid grey">{{$user->TrackingToday->where('event_category','Service')->count()}}</td>
                                            <td>{{$sscCalls=$user->TrackingCallsToday->where('category',1)->sum('calls')}}</td>
                                            <td>@php $sscSaves = $user->TrackingToday->where('product_category','SSC')->where('event_category','Save')@endphp {{ $sscSaves->count()}}</td>
                                            <td>{{$sscSaves_NBO = $sscSaves->where('backoffice',0)->count()}}</td>
                                            <td>{{$sscSaves_PBO = $sscSaves->where('backoffice',1)->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','SSC')->where('event_category','KüRü')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','SSC')->where('event_category','Cancel')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','SSC')->where('event_category','Service')->count()}}</td>
                                            <td>{{roundUp($sscCalls,$sscSaves_NBO)}}%</td>
                                            <td style="border-right: 2px solid grey">{{roundUp($sscCalls,$sscSaves->count())}}%</td>
                                            <td>{{$bscCalls = $user->TrackingCallsToday->where('category',2)->sum('calls')}}</td>
                                            <td>@php $bscSaves = $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')@endphp {{ $bscSaves->count()}}</td>
                                            <td>{{$bscSaves_NBO = $bscSaves->where('backoffice',0)->count()}}</td>
                                            <td>{{$bscSaves_PBO = $bscSaves->where('backoffice',1)->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','BSC')->where('event_category','KüRü')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','BSC')->where('event_category','Cancel')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','BSC')->where('event_category','Service')->count()}}</td>
                                            <td>{{roundUp($bscCalls,$bscSaves_NBO)}}%</td>
                                            <td style="border-right: 2px solid grey">{{roundUp($bscCalls,$bscSaves->count())}}</td>
                                            <td>{{$portalCalls = $user->TrackingCallsToday->where('category',3)->sum('calls')}}</td>
                                            <td>@php $portalSaves = $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')@endphp {{ $portalSaves->count()}}</td>
                                            <td>{{$portalSaves_NBO = $portalSaves->where('backoffice',0)->count()}}</td>
                                            <td>{{$portalSaves_PBO = $portalSaves->where('backoffice',1)->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','Portale')->where('event_category','KüRü')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','Portale')->where('event_category','Cancel')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','Portale')->where('event_category','Service')->count()}}</td>
                                            <td>{{roundUp($portalCalls,$portalSaves_NBO)}}%</td>
                                            <td style="border-right: 2px solid grey">{{roundUp($portalCalls,$portalSaves->count())}}</td>
                                            <td>{{$sonstige = $user->TrackingCallsToday->where('category',4)->sum('calls')}}</td>
                                            <td>{{$optins = $user->TrackingToday->where('optin',1)->count()}}</td>
                                            <td>{{roundUp($calls,$optins)}}%</td>
                                          </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="border-right: 2px solid grey" class="bg-dark text-white">Summe</td>
                                                <td>{{$allCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->sum('calls');
                                                    })
                                                  }}</td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('event_category','Cancel')->count();
                                                    })
                                                  }}
                                                  </td>
                                                <td style="border-right: 2px solid grey">
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('event_category','Service')->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$allSSCCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',1)->sum('calls');
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$allSSCSaves = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','Save')->count();
                                                    })
                                                  }}

                                                </td>
                                                <td>{{$allSSCSaves_NBO = $users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','SSC')->where('event_category','Save')->where('backoffice',0)->count();
                                                  })
                                                }}</td>
                                                <td>
                                                  {{$allSSCSaves_PBO = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','Save')->where('backoffice',1)->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','KüRü')->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>{{$users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','SSC')->where('event_category','Cancel')->count();
                                                  })
                                                }}</td>
                                                  <td>{{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','Service')->count();
                                                    })
                                                  }}
                                                  </td>
                                                <td>{{roundUp($allSSCCalls,$allSSCSaves_NBO)}}%</td>
                                                <td style="border-right: 2px solid grey">{{roundUp($allSSCCalls,$allSSCSaves)}}%</td>
                                                <td>
                                                  {{$allBSCCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',2)->sum('calls');
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$allBSCSaves = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')->count();
                                                    })
                                                  }}

                                                </td>
                                                <td>{{$allBSCSaves_NBO = $users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')->where('backoffice',0)->count();
                                                  })
                                                }}</td>
                                                <td>
                                                  {{$allBSCSaves_PBO = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')->where('backoffice',1)->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','KüRü')->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>{{$users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','BSC')->where('event_category','Cancel')->count();
                                                  })
                                                }}</td>
                                                  <td>{{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','Service')->count();
                                                    })
                                                  }}</td>
                                                <td>{{roundUp($allBSCCalls,$allBSCSaves_NBO)}}%</td>
                                                <td style="border-right: 2px solid grey">{{roundUp($allBSCCalls,$allBSCSaves)}}%</td>
                                                <td>
                                                  {{$allPortalCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',3)->sum('calls');
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$allPortalSaves = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')->count();
                                                    })
                                                  }}

                                                </td>
                                                <td>{{$allPortalSaves_NBO = $users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')->where('backoffice',0)->count();
                                                  })
                                                }}</td>
                                                <td>
                                                  {{$allPortalSaves_PBO = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')->where('backoffice',1)->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','KüRü')->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>{{$users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','Portale')->where('event_category','Cancel')->count();
                                                  })
                                                }}</td>
                                                  <td>{{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','Service')->count();
                                                    })
                                                  }}</td>
                                                <td>{{roundUp($allPortalCalls,$allPortalSaves_NBO)}}%</td>
                                                <td style="border-right: 2px solid grey">{{roundUp($allPortalCalls,$allPortalSaves)}}%</td>
                                                <td>
                                                  {{$allETCCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',4)->sum('calls');
                                                    })
                                                  }}
                                                </td>
                                                <td>
                                                  {{$allOptins = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('optin',1)->count();
                                                    })
                                                  }}
                                                </td>
                                                <td>{{roundUp($allCalls,$allOptins)}}%</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="history">
                                <div style="margin: 10px 2px 10px 10px; overflow: scroll;">
                                    <table class="tracking-table" id="history-table">
                                        <thead>
                                            <th>Erstellt</th>
                                            <th>Kundenberater</th>
                                            <th>Vertragsnummer</th>
                                            <th>Produktgruppe</th>
                                            <th>Bearbeitung</th>
                                            <th>Zieltarif</th>
                                            <th>OptIn</th>
                                            <th>RLZ+24</th>
                                            <th>Nacharbeit</th>
                                            <th>Optionen</th>
                                        </thead>
                                        <tbody>
                                          @foreach($history as $record)
                                          <tr>
                                            <td>{{$record->created_at}}</td>
                                            <td>{{$record->createdBy->name}}</td>
                                            <td>{{$record->contract_number}}</td>
                                            <td>{{$record->product_category}}</td>
                                            <td>{{$record->event_category}}</td>
                                            <td>{{$record->target_tariff}}</td>
                                            <td>@if($record->optin == 1) ja @else nein @endif</td>
                                            <td>@if($record->runtime == 1) ja @else nein @endif</td>
                                            <td>@if($record->backoffice == 1) ja @else nein @endif</td>
                                            <td><a onclick="loadModalWithData({{$record->id}})"><button type="button" class="EditButton" name="button"><i class="far fa-edit"></i></button>  </a><a href="{{route('tracking.delete.admin', ['id' => $record->id])}}"><button type="button" class="DeleteButton" name="button"><i class="far fa-trash-alt"></i></button> </a></td>
                                          </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN-->
</div>
@endsection

@section('additional_modal')
<div class="modal" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="" style="font-size: 1.45em;">Bearbeiten des Eintrags</h5>
                <button type="button" onclick="ModalClose()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                <div class="modal-body" style="font-size: 14px;">
                    <div class="row">
                      <form class="w-100" action="{{route('mobile.tracking.agents.update')}}" method="post">
                        @csrf
                          <div class="max-main-container">
                              <div class="tracking_title">
                                  Saves
                              </div>
                              <input type="hidden" name="trackid" id="trackid" value="">
                              <div class="tracking_container">
                                  <div class="tracking_description">Vertragsnummer</div>
                                  <input type="text" class="form-control" name="contract_number" id="contract_number" style="max-width: 300px; margin: 0 auto;" onchange="tracking_input()">
                              </div>
                              <div class="tracking_container">
                                  <div class="tracking_description">Produktgruppe</div>
                                  <div class="btn-group-container">
                                      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                          <input type="radio" class="btn-check" name="product_category" value="SSC" id="product_category1" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary first-btn-group-element" for="product_category1">SSC</label>
                                          <input type="radio" class="btn-check" name="product_category" value="BSC" id="product_category2" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary" for="product_category2">BSC</label>

                                          <input type="radio" class="btn-check" name="product_category" value="Portale" id="product_category3" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary last-btn-group-element" for="product_category3">Portal</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="tracking_container">
                                  <div class="tracking_description">Bearbeitung</div>
                                  <div class="btn-group-container">
                                      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                          <input type="radio" class="btn-check" name="event_category" value="Save" id="event_category1" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary first-btn-group-element" for="event_category1">Save</label>

                                          <input type="radio" class="btn-check" name="event_category" value="Cancel" id="event_category2" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary" for="event_category2">Cancel</label>

                                          <input type="radio" class="btn-check" name="event_category" value="Service" id="event_category3" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary" for="event_category3">Service</label>

                                          <input type="radio" class="btn-check" name="event_category" value="KüRü" id="event_category4" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary" for="event_category4">KüRü</label>
                                          <input type="radio" class="btn-check" name="event_category" value="NaBu" id="event_category5" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary last-btn-group-element" for="event_category5">NaBu</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="tracking_container">
                                  <div class="tracking_description">Zieltarif</div>
                                  <input type="text" class="form-control" id="target_tariff" name="target_tariff" style="max-width: 600px; margin: 0 auto;" onchange="tracking_input()" disabled>
                              </div>
                              <div class="tracking_container">
                                  <div class="tracking_description">OptIn gesetzt</div>
                                  <div class="btn-group-container">
                                      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                          <input type="radio" class="btn-check" name="optin" value="1" id="optin1" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary first-btn-group-element" for="optin1">Ja</label>

                                          <input type="radio" class="btn-check" name="optin" value="0" id="optin2" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary last-btn-group-element" for="optin2">Nein</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="tracking_container">
                                  <div class="tracking_description">Restlaufzeit+24</div>
                                  <div class="btn-group-container">
                                      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                          <input type="radio" class="btn-check" name="runtime" value="1" id="runtime1" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary first-btn-group-element" for="runtime1">Ja</label>

                                          <input type="radio" class="btn-check" name="runtime" value="0" id="runtime2" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary last-btn-group-element" for="runtime2">Nein</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="tracking_container">
                                  <div class="tracking_description">An Nacharbeit</div>
                                  <div class="btn-group-container">
                                      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                          <input type="radio" class="btn-check" name="backoffice" value="1" id="backoffice1" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary first-btn-group-element" for="backoffice1">Ja</label>

                                          <input type="radio" class="btn-check" name="backoffice" value="0" id="backoffice2" autocomplete="off" onchange="tracking_input()">
                                          <label class="btn btn-outline-primary last-btn-group-element" for="backoffice2">Nein</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="tracking_container" style="display: flex;">
                                  <input type="submit" value="Speichern" class="btn btn-primary" style="margin: 0 auto; min-width: 150px;" id="submit_tracking">
                              </div>
                          </div>
                      </div>

                      </form>
                    </div>
                </div>
              </div>
            </div>
            @endsection

@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script src='https://cdn.datatables.net/plug-ins/1.10.24/api/sum().js'></script>
<script src='https://cdn.datatables.net/plug-ins/1.10.24/api/average().js'></script>
<script src='https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js'></script>
<script src='https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


<script type="text/javascript">

let table = $('#AdminTrackingTable').DataTable({
  select: true,
  dom: 'Blfrtip',
  lengthMenu: [
      [-1, 3, 5, 10, 25, 50, 100],
      ["alle", 3, 5, 10, 25, 50, 100]
  ],
  buttons: [
          { extend: 'csv', text: '<i class="fas fa-file-csv fa-2x"></i>' },
          { extend: 'excel', text: '<i class="fas fa-file-excel fa-2x"></i>' },
          // 'excel',
      ],
    rowReorder: true,
    colReorder: true,
    scrollX: true,
    scrollCollapse: true,
    fixedColumns: {
      leftColumns: 1,
    }
    })
let table2 = $('#history-table').DataTable({
  select: true,
  dom: 'Blfrtip',
  lengthMenu: [
      [50, 100],
      [50, 100]
  ],
  order: [ 0, "desc" ],
  buttons: [
          { extend: 'csv', text: '<i class="fas fa-file-csv fa-2x"></i>' },
          { extend: 'excel', text: '<i class="fas fa-file-excel fa-2x"></i>' },
          // 'excel',
      ],
    // scrollX: true,

    // fixedColumns: {
    //   leftColumns: 2,
    // }
    })

function loadModalWithData(id) {

  var host = window.location.host;

  axios.get
    // ('http://'+host+'/care4as/care4as/public/mobile/tracking/json/'+id)
    ('http://'+host+'/mobile/tracking/json/'+id)
    .then(response => {
      if(response.data)
      {
        let data = response.data
        console.log('data received')
        console.log(data)

        $('#trackid').val(data.id)

        $('#contract_number').val(data.contract_number)

        var radios = $('input:radio[name=product_category]');

        radios.each(function () { $(this).prop('checked', false); });
        if(radios.is(':checked') === false) {
            radios.filter('[value='+data.product_category+']').prop('checked', true);
        }

        var radios2 = $('input:radio[name=event_category]');

        radios2.each(function () { $(this).prop('checked', false); });

        if(radios2.is(':checked') === false) {
            radios2.filter('[value='+data.event_category+']').prop('checked', true);
        }

        let input = $('#target_tariff')
        input.val(data.target_tariff).prop("disabled", false)

        var radios3 = $('input:radio[name=optin]');

        radios3.each(function () { $(this).prop('checked', false); });


        if(radios3.is(':checked') === false) {
            radios3.filter('[value='+data.optin+']').prop('checked', true);
        }

        var radios4 = $('input:radio[name=runtime]');

        radios4.each(function () { $(this).prop('checked', false); });


        if(radios4.is(':checked') === false) {
            radios4.filter('[value='+data.runtime+']').prop('checked', true);
        }

        var radios5 = $('input:radio[name=backoffice]');

        radios5.each(function () { $(this).prop('checked', false); });


        if(radios5.is(':checked') === false) {
            radios5.filter('[value='+data.backoffice+']').prop('checked', true);
        }
        $('#EditModal').toggle()
      }
      else {
        console.log('data not received received')
      }
    })
    .catch(function (err) {
      console.log('error TrackData')
      console.log(err.response);
    })


}
function ModalClose() {
  $('#EditModal').toggle()
}
</script>


@endsection
