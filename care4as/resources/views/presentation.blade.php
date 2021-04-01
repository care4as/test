@extends('general_layout')

@section('additional_css')

<style media="screen">

.table-striped>tbody>tr:nth-child(even) {
    background-color: #ddf8e8;
}
.table-striped>tbody>tr:nth-child(odd) {
    background-color: #fefdfa;
}

  th, td
  {
    font-size: 1.4em !important;
    text-align: left;
    margin: 0;
    border: 0;
    color: #746e58;
    /* overflow: hidden; */
    /* text-overflow: ellipsis; */
  }
  .table-hover tbody td:hover {
    background-color: black;
    color:white;
  }
  div .dataTables_scrollFoot{
     /* display: none; */
   }
  div .DTFC_RightFootWrapper
  {
    display: none;
  }
  div .DTFC_LeftFootWrapper
  {
    display: none;
  }
  .DTFC_LeftBodyLiner
  {
    overflow: hidden !important;;

  }

  .DTFC_RightBodyLiner
  {
    overflow: hidden !important;;
  }
  .DTFC_LeftBodyWrapper
  {
    overflow: hidden !important;

  }
  .DTFC_RightWrapper
  {
    right: 0px !important;
  }
  #footerdata
  {
    display: hidden;
  }

</style>

@endsection

@section('content')

<div class="container-fluid bg-light m-1">
  <div class="row justify-content-center align-self-center m-1">
      <h4 >Präsentation des aktuellen Moduls: {{$modul ?? ''}}</h4>
  </div>

  <div class="row bg-white shadow  m-1 mt-4" id="filtermenu">
    <div class="col-12 d-flex justify-content-center align-self-center">
      <h5>Filtermenü</h5>
    </div>
    <div class="col-12">
      <form class="mt-2 w-100" action="{{route('presentation')}}" method="get">
        <div class="row m-0 justify-content-center">
          <div class="col-6 p-0" style="border-right: 2px solid black;">
            <div class="row m-2 justify-content-end">
              <div class="col-4 ml-1 p-0">
                <label for="department">Abteilung:</label>
                <select class="form-control" name="department" id="department" style="width:218px;">
                  <option value="" @if(!request('department')) selected @endif disabled>Wähle die Abteilung</option>
                  <option value="1&1 DSL Retention" @if(request('department') == '1&1 DSL Retention') selected @endif>1&1 DSL Retention</option>
                  <option value="1&1 Mobile Retention" @if(request('department') == '1&1 Mobile Retention') selected @endif>1&1 Mobile Retention</option>
                </select>
              </div>
              <div class="col-3 p-0 mr-2">
                <label for="department">Welche MA:</label>
                <select multiple class="form-control" name="employees[]" id="exampleFormControlSelect2" style="height: 50px; overflow:scroll;">
                  @if(request('department'))
                    @foreach($users1 = App\User::where('department',request('department'))->where('role','agent')->get() as $user)
                      <option value="{{$user->id}}">{{$user->surname}} {{$user->lastname}}</option>
                    @endforeach
                  @else
                    @foreach($users1 = App\User::where('role','agent')->where('department','1&1 Mobile Retention')->get() as $user)
                      <option value="{{$user->id}}">{{$user->surname}} {{$user->lastname}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
          <div class="col-6 p-0">
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
  <div class="row m-2 mt-4 bg-white shadow justify-content-center align-self-center" >
    <div class="col-12">
    <div class="col p-1">
      @php
        if(request('department') == '1&1 DSL Retention')
        {
          $pricepersave = 15;
        }
        else
        {
          $pricepersave = 15;
        }
      @endphp

      <table class="table table-hover table-striped table-bordered" id="tableoverview">
        <thead class="thead-dark">
          <tr>
            <th >#</th>
            <th >Name</th>
            <th>AHT</th>
            <th>KDW bez Zeit</th>
            <th>1&1 bez Zeit</th>
            <th>1&1 ProZ</th>
            <th>PQ</th>
            <th>1&1 PQ</th>
            <th>Saves</th>
            <th>Calls</th>
            <th>Calls/h</th>
            <th>SSC</th>
            <th>BSC</th>
            <th>Portal</th>
            <th>SSE</th>
            <th>Saves/h</th>
            <th>RLZ+24 %</th>
            <th>GO CR</th>
            <th>RET GeVo CR</th>
            <th>SSC CR</th>
            <th>BSC CR</th>
            <th>Portal CR</th>
            <th>KüRü CR</th>
            <th>Umsatz</th>
            <th>Umsatz/h bez</th>
            <th>Umsatz/h prod</th>
            <th>KQ</th>
            <th>Optionen</th>
          </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td class="bg-dark text-white" style="width: auto; ">{{$user->id}}</td>
            <td class="bg-dark text-white" style="width: 90px;word-break: normal;">{{$user->surname}} {{$user->lastname}}</td>
            <!-- <td>{{$user->name}}</td> -->
            <td>
              {{$user->salesdata['aht']}}
            </td>
            <td>{{$user->salesdata['workedHours']}}</td>
            <td>{{$user->salesdata['payedtime11']}}</td>
            <td>{{$user->salesdata['productive']}}</td>
            @if($user->salesdata['workedHours'] != 0)
              <td>{{round($user->salesdata['productive']*100/$user->salesdata['workedHours'],2)}}</td>
            @else
              <td>0</td>
            @endif
            @if($user->salesdata['payedtime11'] != 0)
              <td>{{round($user->salesdata['productive']*100/$user->salesdata['payedtime11']),2}}</td>
            @else
              <td>0</td>
            @endif
            @if($user->department == '1&1 DSL Retention')
              <td>{{$user->salesdata['orders']}}</td>
            @else
              <td>{{$sumSaves = $user->salesdata['sscOrders'] + $user->salesdata['bscOrders'] + $user->salesdata['portalOrders']}}</td>
            @endif
            <td>{{$user->salesdata['calls']}}</td>
            @if($user->salesdata['workedHours'] != 0)
              <td>{{round($user->salesdata['calls'] / $user->salesdata['workedHours'],2)}}</td>
              @else
              <td>0</td>
            @endif
            <td>{{$user->salesdata['sscOrders']}}</td>
            <td>{{$user->salesdata['bscOrders']}}</td>
            <td>{{$user->salesdata['portalOrders']}}</td>
              <td>{{$user->salesdata['ssesaves']}}</td>
            @if($user->salesdata['workedHours'] != 0)
              @if($user->department == '1&1 DSL Retention')
                <td>{{round($user->salesdata['ssesaves']/($user->salesdata['workedHours']),2)}}</td>
              @else
                <td>{{round($sumSaves/($user->salesdata['workedHours']),2)}}</td>
              @endif
            @else
              <td>0</td>
            @endif
            <td>{{$user->salesdata['RLZ24Qouta']}}</td>
            <td>50</td>
            <td> {{$user->salesdata['GeVo-Cr']}}</td>
            <td>{{$user->salesdata['sscQuota']}}</td>
            <td>{{$user->salesdata['bscQuota']}}</td>
            <td>{{$user->salesdata['portalQuota']}}</td>
            <td>50</td>
            <td>{{$user->salesdata['orders'] * $pricepersave}}</td>
            @if($user->salesdata['workedHours'] != 0)
              <td>{{round(($user->salesdata['orders'] * $pricepersave)/($user->salesdata['workedHours']),2)}}</td>
            @else
              <td>0</td>
            @endif
            @if($user->salesdata['productive'] != 0)
              <td>{{round(($user->salesdata['orders'] * $pricepersave) / $user->salesdata['productive'],2) }}</td>
            @else
                <td>0</td>
            @endif
            <td>{{$user->salesdata['sicknessquota']}}</td>
            <!-- <td>round($user->salesdata['sicknessquota'],2)%</td> -->
            <td class="bg-dark" style="text-align:center; font-size: 1.4em;">
              <a class="text-muted" href="{{route('user.stats', ['id' => $user->id])}}">
                <span class="material-icons text-white">preview</span>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="">
        <tr class="bg-dark text-white" id='footerdata'>
          <td>Total:</td>
          <td>1</td>
          <td id="aht">2</td>
          <td id="kdw">3</td>
          <td id="payed11avg">4</td>
          <td id="productive11avg">5</td>
          <td id="produktivequote">6</td>
          <td id="savessum">7</td>
          <td id="savessum">8</td>
          <td id="callssum">9</td>
          <td id="callsPerHourAVG">10</td>
          <td id="sscSum">11</td>
          <td id="bscSum">12</td>
          <td id="portalSum">13</td>
          <td id="sse">14</td>
          <td id="savesPerHourAVG">15</td>
          <td id="rlz">16</td>
          <td id="gocr">17</td>
          <td id="gevoCrAVG">18</td>
          <td id="sscCrAVG">19</td>
          <td id="bscCrAVG">20</td>
          <td id="portalCrAVG">21</td>
          <td id="kürücr">22</td>
          <td id="revenue">23</td>
          <td id="revenuePerHourPayedAVG">24</td>
          <td id="revenuePerHourProductiveAVG">25</td>
          <td id="sicknessquotaAVG">26</td>
          <td>25</td>
        </tr>
      </tfoot>
    </table>
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

<script type="text/javascript">
  $(document).ready(function(){
    let table = $('#tableoverview').DataTable({

      "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            $(api.column( 2 ).footer() ).html('<b>'+Math.round(api.column(2).data().average()*100)/100 +'s</b>');
            $(api.column( 3 ).footer() ).html('<b>'+Math.round(api.column(3).data().sum()) +'h</b>');
            $(api.column( 4 ).footer() ).html('<b>'+Math.round(api.column(4).data().sum()) +'h</b>')
            $(api.column( 5 ).footer() ).html('<b>'+Math.round(api.column(5).data().sum()) +'h</b>')
            $(api.column( 6 ).footer() ).html('<b>'+Math.round(api.column(6).data().average()) +'%</b>')
            $(api.column( 7 ).footer() ).html('<b>'+Math.round(api.column(7).data().average()) +'%</b>')
            $(api.column( 8 ).footer() ).html('<b>'+Math.round(api.column(8).data().sum()) +'</b>')
            $(api.column( 9 ).footer() ).html('<b>'+Math.round(api.column(9).data().sum()) +'</b>')
            $(api.column( 10 ).footer() ).html('<b>'+Math.round(api.column(10).data().average()) +'</b>')
            $(api.column( 11 ).footer() ).html('<b>'+Math.round(api.column(11).data().sum()) +'</b>')
            $(api.column( 12 ).footer() ).html('<b>'+Math.round(api.column(12).data().sum()) +'</b>')
            $(api.column( 13 ).footer() ).html('<b>'+Math.round(api.column(13).data().sum()) +'</b>')
            $(api.column( 14 ).footer() ).html('<b>'+Math.round(api.column(14).data().sum()) +'</b>')
            $(api.column( 15 ).footer() ).html('<b>'+(Math.round(api.column(15).data().average())*100)/100 +'/h</b>')
            $(api.column( 16 ).footer() ).html('<b>'+Math.round(api.column(16).data().average()) +'%</b>')
            $(api.column( 17 ).footer() ).html('<b>'+Math.round(api.column(17).data().average()) +'%</b>')
            $(api.column( 18 ).footer() ).html('<b>'+Math.round(api.column(18).data().average()) +'%</b>')
            $(api.column( 19 ).footer() ).html('<b>'+Math.round(api.column(19).data().average()) +'%</b>')
            $(api.column( 20 ).footer() ).html('<b>'+Math.round(api.column(20).data().average()) +'%</b>')
            $(api.column( 21 ).footer() ).html('<b>'+Math.round(api.column(21).data().average()) +'%</b>')
            $(api.column( 22 ).footer() ).html('<b>'+Math.round(api.column(22).data().average()) +'%</b>')
            $(api.column( 23 ).footer() ).html('<b>'+Math.round(api.column(23).data().sum()) +'€</b>')
            $(api.column( 24 ).footer() ).html('<b>'+Math.round(api.column(24).data().average()) +'€</b>')
            $(api.column( 25 ).footer() ).html('<b>'+Math.round(api.column(25).data().average()) +'€</b>')
            $(api.column( 26 ).footer() ).html('<b>'+Math.round(api.column(26).data().average()) +'%</b>')
            $(api.column( 27 ).footer() ).html('<b> total</b>')

          },
      scrollX: true,
      scrollY: "600px",
      scrollCollapse: true,
      fixedColumns:   {
            leftColumns: 2,
            rightColumns: 1,
        },
        fnInitComplete: function(){
           // $('#footerdata').style.display = 'hidden';
       },

      "columnDefs": [ {
            "targets": [6,7,16,17,18,19,26],
            "width": '65px',
            "render": function ( data, type, full, meta ) {
              if(isNaN(data))
              {
                return 0;
              }
              else {

                return data+'%';
              }}},
            {
            "targets": [21,22,23,24,25],
            "render": function ( data, type, full, meta ) {
              if(isNaN(data))
              {
                return 0;
              }
              else {
                return +data+'€';
              }
            }
          }],
        });
      });
</script>
@endsection
