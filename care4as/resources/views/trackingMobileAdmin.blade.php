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
                                    <table class="tracking-table">
                                        <thead>
                                            <tr>
                                                <th rowspan="3" style="border-right: 2px solid grey">Name</th>
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
                                            <td style="border-right: 2px solid grey">{{$user->name}}</td>
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
                                            <td>{{roundUp($sscCalls,$sscSaves_NBO)}}</td>
                                            <td style="border-right: 2px solid grey">{{roundUp($sscCalls,$sscSaves->count())}}</td>
                                            <td>{{$bscCalls = $user->TrackingCallsToday->where('category',2)->sum('calls')}}</td>
                                            <td>@php $bscSaves = $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')@endphp {{ $bscSaves->count()}}</td>
                                            <td>{{$bscSaves_NBO = $bscSaves->where('backoffice',0)->count()}}</td>
                                            <td>{{$bscSaves_PBO = $bscSaves->where('backoffice',1)->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','BSC')->where('event_category','KüRü')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','BSC')->where('event_category','Cancel')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','BSC')->where('event_category','Service')->count()}}</td>
                                            <td>{{roundUp($bscCalls,$bscSaves_NBO)}}</td>
                                            <td style="border-right: 2px solid grey">{{roundUp($bscCalls,$bscSaves->count())}}</td>
                                            <td>{{$portalCalls = $user->TrackingCallsToday->where('category',3)->sum('calls')}}</td>
                                            <td>@php $portalSaves = $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')@endphp {{ $portalSaves->count()}}</td>
                                            <td>{{$portalSaves_NBO = $portalSaves->where('backoffice',0)->count()}}</td>
                                            <td>{{$portalSaves_PBO = $portalSaves->where('backoffice',1)->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','Portale')->where('event_category','KüRü')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','Portale')->where('event_category','Cancel')->count()}}</td>
                                            <td>{{$user->TrackingToday->where('product_category','Portale')->where('event_category','Service')->count()}}</td>
                                            <td>{{roundUp($portalCalls,$portalSaves_NBO)}}</td>
                                            <td style="border-right: 2px solid grey">{{roundUp($portalCalls,$portalSaves->count())}}</td>
                                            <td>{{$sonstige = $user->TrackingCallsToday->where('category',4)->sum('calls')}}</td>
                                            <td>{{$optins = $user->TrackingToday->where('optin',1)->count()}}</td>
                                            <td>{{roundUp($calls,$optins)}}</td>
                                          </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="border-right: 2px solid grey">Summe</td>
                                                <td>{{$allCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->sum('calls');
                                                    })
                                                  }}</td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('event_category','Cancel')->count();
                                                    });}}
                                                  </td>
                                                <td style="border-right: 2px solid grey">
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('event_category','Service')->count();
                                                    })
                                                  ;}}
                                                </td>
                                                <td>
                                                  {{$allSSCCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',1)->sum('calls');
                                                    });}}
                                                </td>
                                                <td>
                                                  {{$allSSCSaves = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','Save')->count();
                                                    });}}

                                                </td>
                                                <td>{{$allSSCSaves_NBO = $users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','SSC')->where('event_category','Save')->where('backoffice',0)->count();
                                                  });}}</td>
                                                <td>
                                                  {{$allSSCSaves_PBO = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','Save')->where('backoffice',1)->count();
                                                    });}}
                                                </td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','KüRü')->count();
                                                    });}}
                                                </td>
                                                <td>{{$users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','SSC')->where('event_category','Cancel')->count();
                                                  });}}</td>
                                                  <td>{{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','SSC')->where('event_category','Service')->count();
                                                    });}}</td>
                                                <td>{{roundUp($allCalls,$allSSCSaves_NBO)}}%</td>
                                                <td style="border-right: 2px solid grey">{{roundUp($allCalls,$allSSCSaves)}}%</td>
                                                <td>
                                                  {{$allBSCCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',2)->sum('calls');
                                                    });}}
                                                </td>
                                                <td>
                                                  {{$allBSCSaves = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')->count();
                                                    });}}

                                                </td>
                                                <td>{{$allBSCSaves_NBO = $users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')->where('backoffice',0)->count();
                                                  });}}</td>
                                                <td>
                                                  {{$allBSCSaves_PBO = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','Save')->where('backoffice',1)->count();
                                                    });}}
                                                </td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','KüRü')->count();
                                                    });}}
                                                </td>
                                                <td>{{$users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','BSC')->where('event_category','Cancel')->count();
                                                  });}}</td>
                                                  <td>{{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','BSC')->where('event_category','Service')->count();
                                                    });}}</td>
                                                <td>{{roundUp($allCalls,$allBSCSaves_NBO)}}%</td>
                                                <td style="border-right: 2px solid grey">{{roundUp($allBSCCalls,$allSSCSaves)}}%</td>
                                                <td>
                                                  {{$allPortalCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',3)->sum('calls');
                                                    });}}
                                                </td>
                                                <td>
                                                  {{$allPortalSaves = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')->count();
                                                    });}}

                                                </td>
                                                <td>{{$allPortalSaves_NBO = $users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')->where('backoffice',0)->count();
                                                  });}}</td>
                                                <td>
                                                  {{$allPortalSaves_PBO = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','Save')->where('backoffice',1)->count();
                                                    });}}
                                                </td>
                                                <td>
                                                  {{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','KüRü')->count();
                                                    });}}
                                                </td>
                                                <td>{{$users->sum(function ($user) {
                                                    return $user->TrackingToday->where('product_category','Portale')->where('event_category','Cancel')->count();
                                                  });}}</td>
                                                  <td>{{$users->sum(function ($user) {
                                                      return $user->TrackingToday->where('product_category','Portale')->where('event_category','Service')->count();
                                                    });}}</td>
                                                <td>{{roundUp($allCalls,$allPortalSaves_NBO)}}%</td>
                                                <td style="border-right: 2px solid grey">{{roundUp($allPortalCalls,$allPortalSaves)}}%</td>
                                                <td>
                                                  {{$allETCCalls = $users->sum(function ($user) {
                                                      return $user->TrackingCallsToday->where('category',4)->sum('calls');
                                                    });}}
                                                </td>
                                                <td>
                                                  {{$allOptins = $users->sum(function ($user) {
                                                      return $user->TrackingToday->where('optin',1)->count();
                                                    });}}
                                                </td>
                                                <td>{{roundUp($allCalls,$allOptins)}}%</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="history">
                                <div style="margin: 10px 2px 10px 10px; overflow: scroll;">
                                    <table class="tracking-table">
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

@endsection
