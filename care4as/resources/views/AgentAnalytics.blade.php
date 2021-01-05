@extends('general_layout')

@section('content')
<div class="container-fluid mt-5" style="border-radius: 15px;width: 75vw;">
  <div class="row">
    <div class="col d-flex justify-content-start">
      @if(App\User::where('id', '<', $user->id)->max('id'))
        <a href="{{route('user.stats', ['id' => App\User::where('id', '<', $user->id)->max('id') ])}}" class="btn btn-rounded btn-primary btn-outline">vorheriger Agent</a>
      @else
        <a href="" class="btn btn-rounded btn-primary btn-outline" disabled>vorheriger Agent</a>
      @endif
    </div>
    <div class="col d-flex justify-content-end">
      @if(App\User::where('id', '>', $user->id)->min('id'))
        <a href="{{route('user.stats', ['id' => App\User::where('id', '>', $user->id)->min('id') ])}}" class="btn btn-rounded btn-primary btn-outline">nächster Agent</a>
      @else
        <a href="" class="btn btn-rounded btn-primary btn-outline" disabled>nächster Agent</a>
      @endif
    </div>
  </div>
  <div class="row bg-light" id="mainrow"  style="border-radius: 35px;">
    <div class="col p-0" id="maincol">
      <div class="row m-0">
        <div class="col">
          <h4 class="text-center">{{$user->name}}</h4>
          <div class="row m-1 p-3 justify-content-center" style="background-color: rgba(0,0,0, 0.1);">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAeh7PE8nk_9Ya4K06e8OkFWBAeqHOfamUuKOdOVDN&s" alt="" style="width: 160px; border-radius: 45%; border: 2px solid black; opacity: 1;">
          </div>
        </div>
        <div class="col">
        <h4 class="text-left">Daten</h4>
          <div class="row p-3 justify-content-left">
            <form class="" action="{{route('user.update', ['id' => $user->id])}}" method="post">
              @csrf
              <table class="table table-bordered w-50" style="">
                <tr>
                  <th>Vorname</th>
                  <td><input type="text" name="surname" value="{{$user->surname}}"></td>
                </tr>
                <tr>
                  <th>Nachname</th>
                  <td><input type="text" name="lastname" value="{{$user->lastname}}"></td>
                </tr>
                <tr>
                  <th>PersonID</th>
                  <td><input type="text" name="person_id" value="{{$user->person_id}}"></td>
                </tr>
                <tr>
                  <th>tägliche Arbeitszeit</th>
                  <td><input type="text" name="dailyhours" value="{{$user->dailyhours}}"></td>
                </tr>
              </table>
              <button type="submit" class="btn btn-rounded btn-primary rounded-pill"name="button">Daten ändern</button>
            </form>

          </div>
        </div>
      </div>
      <hr>
      <div class="row m-0 w-100">
        <form class="mt-2 w-100" action="{{route('user.stats',['id' => $user->id])}}" method="get">
        <div class="col p-0">
          <div class="row m-2 justify-content-center">
            <div class="col-sm-3">
              <label for="datefrom">Von:</label>
               <input type="date" id="start_date" name="start_date" class="form-control" placeholder="">
             </div>
             <div class="col-sm-3">
               <label for="dateTo">Bis:</label>
               <input type="date" id="end_date" name="end_date" class="form-control" placeholder="">
             </div>
          </div>

          <div class="row m-2 justify-content-center">
            <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
          </div>
        </div>
        </form>
      </div>
      <hr>
      <div class="row justify-content-center">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#scorecard" data-toggle="tab">Scorecard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#monthlyStats" data-toggle="tab">Monatsstatistiken</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#dailyStats" data-toggle="tab">Tagesstatistiken</a>
                    </li>
                </ul>
            </div>
        </div>
      </div>
      <div class="row m-0">
        <div class="tab-content w-100" id="myTabContent">
          <div class="tab-pane fade show active" id="scorecard" role="tabpanel" aria-labelledby="home-tab">
            <div class="container mt-4 bg-white">
              <div class="row">
                <!-- Table Scorecard Variante 1 -->
                <!-- <table class="table table-hover">
                  <tr>
                    <th>SSC</th>
                    <th>BSC</th>
                    <th>Poratle</th>
                    <th>RLZ Quote</th>
                    <th>AHT</th>
                    <th>KQ</th>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                  </tr>
                </table> -->
                <!-- Table Scorecard Variante 2 -->
                <table class="table table-hover">
                  <tr>
                    <th>#</th>
                    <th>Calls</th>
                    <th>Abschlüsse</th>
                    <th>Quote</th>
                  </tr>
                  <tr>
                    <th>SSC</th>
                    <td>{{$salesdata['sscCalls']}}</td>
                    <td>{{$salesdata['sscOrders']}}</td>
                    @if($salesdata['sscCalls'] != 0)
                      <td class="@if(($salesdata['sscOrders']/$salesdata['sscCalls'])*100 < 48) tooLow @endif">{{round(($salesdata['sscOrders']/$salesdata['sscCalls'])*100,2)}}</td>
                    @else
                      <td>keine Werte</td>
                    @endif
                  </tr>
                  <tr>
                    <th>BSC</th>
                    <td>{{$salesdata['bscCalls']}}</td>
                    <td>{{$salesdata['bscOrders']}}</td>
                    @if($salesdata['bscCalls'] != 0)
                      <td class="@if(($salesdata['bscOrders']/$salesdata['bscCalls'])*100 < 20) tooLow @endif">{{round(($salesdata['bscOrders']/$salesdata['bscCalls'])*100,2)}}</td>
                    @else
                      <td>keine Werte</td>
                    @endif
                  </tr>
                  <tr>

                    <th>Portale</th>
                    <td>{{$salesdata['portalCalls']}}</td>
                    <td>{{$salesdata['portalOrders']}}</td>
                    @if($salesdata['portalCalls'] != 0)
                    <td class="@if(($salesdata['portalOrders']/$salesdata['portalCalls'])*100 < 70) tooLow @endif">{{round(($salesdata['portalOrders']/$salesdata['portalCalls'])*100,2)}}</td>
                  </tr>
                    @else
                      <td>keine Werte</td>
                    @endif
                  <tr>
                    <th>RLZ</th>
                    <td><b>RLZ + 24:</b> {{$sumrlz24}}</td>
                    <td><b>neue MVLZ:</b> {{$sumNMlz}}</td>
                    @if($sumrlz24 + $sumNMlz != 0)
                      <td class="@if($sumrlz24 / ($sumrlz24 + $sumNMlz)*100 < 70) tooLow @endif">{{round((($sumrlz24 / ($sumrlz24 + $sumNMlz))*100),2)}}</td>
                    @else
                      <td>keine Angaben</td>
                    @endif
                  </tr>
                  <tr>
                    <th>AHT</th>
                    <td>5</td>
                  </tr>
                  <tr>
                    <th>KQ</th>
                    <td>5</td>
                  </tr>
              </table>

                <!-- <div class="col d-block align-items-center">
                  <div class="row w-100 justify-content-center">
                    <div class="d-flex w-100 justify-content-center">
                      <h4>Daten</h4>
                    </div>
                    <div class="d-flex w-100 justify-content-center">
                      @if($user->person_id)
                      <table class="table table-hover w-50">
                        <tr>
                          <th>Calls</th>
                          <th>Abschlüsse</th>
                          <th>RLZ +24</th>
                          <th>24 Monate</th>
                          <th>Anteil RLZ+24</th>
                        </tr>
                        <tr>
                          <td>{{$sumcalls}}</td>
                          <td>{{$sumorders}}</td>
                          <td>{{$sumrlz24 }}</td>
                          <td>{{$sumNMlz}}</td>
                          @php

                          if(($sumrlz24 + $sumNMlz) != 0)
                          {
                            $RLZQoute =  ($sumrlz24 / ($sumrlz24 + $sumNMlz))*100;
                          }
                          else
                          {
                            $RLZQoute = 0;
                          }  @endphp
                          <td style="@if($RLZQoute < 70) background-color: red; color: white;@endif">@if($sumrlz24 + $sumNMlz == 0) 0 @else {{round($RLZQoute,2)}} @endif</td>
                        </tr>
                      </table>
                      @endif
                    </div>
                  </div>
                  <hr width="40%" size="5" align="center" >
                    <div class="row m-0 w-100">
                      <form class="mt-2 w-100" action="{{route('user.stats',['id' => $user->id])}}" method="get">
                      <div class="col p-0">
                        <div class="row m-2 justify-content-center">
                          <div class="col-sm-3">
                            <label for="datefrom">Von:</label>
                             <input type="date" id="start_date" name="start_date" class="form-control" placeholder="">
                           </div>
                           <div class="col-sm-3">
                             <label for="dateTo">Bis:</label>
                             <input type="date" id="end_date" name="end_date" class="form-control" placeholder="">
                           </div>
                        </div>

                        <div class="row m-2 justify-content-center">
                          <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
                        </div>
                      </div>
                      </form>
                    </div>

                </div> -->
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="monthlyStats" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container mt-4 bg-white">
              <div class="row">
                <table class="table table-hover">
                  <tr>
                    <th>#</th>
                    <th>SSC</th>
                    <th>BSC</th>
                    <th>Portale</th>
                    <th>AHT</th>
                    <th>KQ</th>
                  </tr>
                  @php
                    $counter = 1;
                  @endphp
                  @foreach($monthlyReports as $report)
                  <tr>
                    <th>
                      {{date("F", mktime(0, 0, 0, $counter, 10))}}
                    </th>
                    @if($report->first())
                    <td>@if($report->sum('calls_smallscreen')!=0){{round(($report->sum('orders_smallscreen')/$report->sum('calls_smallscreen'))*100,2)}} @else  keine SSC Calls @endif</td>
                    <td>@if($report->sum('calls_bigscreen')!=0){{round(($report->sum('orders_bigscreen')/$report->sum('calls_bigscreen'))*100,2)}} @else  keine BSC Calls @endif</td>
                    <td>@if($report->sum('calls_portale')!=0){{round(($report->sum('orders_portale')/$report->sum('calls_portale'))*100,2)}} @else keine Portal Calls @endif</td>
                    <td>test</td>
                    <td>test</td>
                    @else
                    <td>keine Werte</td>
                    @endif
                  </tr>
                  @php
                    $counter = $counter+1;
                  @endphp
                  @endforeach

                </table>
              </div>
            </div>
          </div>
          <!-- Tagesübersicht -->
          <div class="tab-pane fade" id="dailyStats" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row">
              <div class="col">
                <h2 class="text-center">Statistiken laut Retention Details</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-12 d-flex justify-content-center mt-3">
                {{$reports->appends(Request::except('page'))->links()}}
              </div>
              <div class="col">
                <div class="d-flex p-3 w-100 justify-content-center">
                  @if($user->person_id)
                  <table class="table table-bordered w-50" style="width:auto;">
                    <tr>
                      <th>Datum</th>
                      <th>Calls</th>
                      <th>Calls/hour</th>
                      <th>Abschlüsse</th>
                      <th>GeVo-CR</th>
                      <th>SSC Calls/<b>Abschlüsse</b></th>
                      <th>BSC Calls/<b>Abschlüsse</b></th>
                      <th>Portale Calls/<b>Abschlüsse</b></th>
                      <th>SSC CR</th>
                      <th>BSC CR</th>
                      <th>Portale CR</th>
                      <th>Opt-In</th>
                      <!-- <th>vergebenes Guthaben</th> -->
                      <th>24 Monate</th>
                      <th>RLZ+24</th>
                    </tr>
                    @foreach($reports as $report)
                    <tr>
                      <td>{{$report->call_date}}</td>
                      <td>{{$report->calls}}</td>
                      @if($user->dailyhours)
                        <td @if($report->calls/$user->dailyhours < 4) class=" tooLow" @endif> {{round($report->calls/$user->dailyhours,2)}}</td>
                      @else
                        <td>keine Arbeitszeit eingetragen</td>
                      @endif
                      <td>{{$report->orders}}</td>
                      @php $CR = (($report->orders) / $report->calls)*100;
                        if($report->calls_smallscreen == 0)
                        {
                          $sscCR = 0;
                        }
                        else
                        {
                           $sscCR = (($report->orders_smallscreen) / $report->calls_smallscreen)*100;
                        }
                        if($report->calls_bigscreen == 0)
                        {

                          $bscCR = 0;
                        }
                        else
                        {
                          $bscCR = (($report->orders_bigscreen) / $report->calls_bigscreen)*100;
                        }
                        if($report->calls_portale == 0)
                        {
                           $portalCR = 0;
                        }
                        else
                        {
                          $portalCR = (($report->orders_portale) / $report->calls_portale)*100;
                        }
                      @endphp
                      <td @if($CR < 40) class="tooLow" @endif> {{round($CR,2)}}</td>

                      <td>{{$report->calls_smallscreen}}/ <b>{{$report->orders_smallscreen}}</b> </td>
                      <td>{{$report->calls_bigscreen}}/<b>{{$report->orders_bigscreen}}</b></td>
                      <td>{{$report->calls_portale}}/<b>{{$report->orders_portale}}</b></td>
                      <td @if($sscCR < 46 && $report->calls_smallscreen != 0) class="tooLow" @elseif($report->calls_smallscreen == 0) class="stillOK"  @endif> {{round($sscCR,2)}}</td>
                      <td @if($bscCR < 17 && $report->calls_bigscreen != 0) class="tooLow" @elseif($report->calls_bigscreen == 0) class="stillOK" @endif> {{round($bscCR,2)}}</td>
                      <td @if($portalCR < 60 && $report->calls_portale != 0) class="tooLow" @elseif($report->calls_portale == 0) class="stillOK" @endif> {{round($portalCR,2)}}</td>
                      <td>noch keine Datenquelle</td>
                      <!-- <td>{{$report->Rabatt_Guthaben_Brutto_Mobile}}</td> -->
                      <td>{{$report->mvlzNeu}}</td>
                      <td>{{$report->rlzPlus}}</td>
                    </tr>
                    @endforeach
                  </table>
                  @endif
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>




    </div>
  </div>
</div>
@endsection
