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
    text-align: center;
    margin: 0;
    border: 0;
    color: #746e58;
    white-space: nowrap;

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
                <select multiple class="form-control" name="employees[]" id="exampleFormControlSelect2" style="height: 150px; overflow:scroll;">
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

      <div class="auswahl">
        <div class="subauswahl aktiv" id="allData">
          Alle Daten
        </div>
        <div class="subauswahl" id="teamleiterview" >
          Teamleiterdaten
        </div>
        <div class="subauswahl"  id="crview" >
          CR Daten
        </div>
        <div class="subauswahl"  id="timesview">
          Zeit Daten
        </div>
        <div class="subauswahl" id="revenueview" >
          Umsatz/SAS/Optin
        </div>
      </div>
      <table class="table table-hover table-striped table-bordered" id="tableoverview">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>AHT</th>
            <th>h bezahlt </th>
            <th>h anwesend</th>
            <th>h produktiv</th>
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
            <th>SaS</th>
            <th>OptIn</th>
            <th>Saves(Gevo)</th>
            <th>Upgrades</th>
            <th>Sidegrades</th>
            <th>Downgrades</th>
            <th>Umsatz</th>
            <th>Umsatz/h bez</th>
            <th>Umsatz/h prod</th>
            <th>Kr h</th>
            <th>KQ</th>
            <th>Optionen</th>
          </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td class="bg-dark text-white" style="width: auto; ">{{$user->id}}</td>
            <td class="bg-dark text-white" style="text-align: left;">{{$user->surname}} {{$user->lastname}}</td>
            <!-- <td>{{$user->name}}</td> -->
            <td>
              {{$user->salesdata['aht']}}
            </td>
            <td>{{$user->salesdata['workedHours']}}</td>
            <td>{{$user->salesdata['payedtime11']}}</td>
            <td>{{$user->salesdata['productive']}}</td>
            @if($user->salesdata['workedHours'] != 0)
              <td data-order="{{round($user->salesdata['productive']*100/$user->salesdata['workedHours'],2)}}">{{round($user->salesdata['productive']*100/$user->salesdata['workedHours'],2)}}%</td>
            @else
              <td data-order="0">0%</td>
            @endif
            @if($user->salesdata['payedtime11'] != 0)
              <td data-order="{{round($user->salesdata['productive']*100/$user->salesdata['payedtime11'],2)}}">{{round($user->salesdata['productive']*100/$user->salesdata['payedtime11']),2}}%</td>
            @else
              <td data-order="0">0%</td>
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
            <td data-order="{{$user->salesdata['RLZ24Qouta']}}">{{$user->salesdata['RLZ24Qouta']}}%</td>
            <td>50</td>
            <td data-order="{{$user->salesdata['GeVo-Cr']}}"> {{$user->salesdata['GeVo-Cr']}}%</td>
            <td data-order="{{$user->salesdata['sscQuota']}}">{{$user->salesdata['sscQuota']}}%</td>
            <td data-order="{{$user->salesdata['bscQuota']}}">{{$user->salesdata['bscQuota']}}%</td>
            <td data-order="{{$user->salesdata['portalQuota']}}">{{$user->salesdata['portalQuota']}}%</td>
            <td>{{$user->sasquota}}</td>
            <td>{{$user->optinQuota}}%</td>
            <td>{{$user->gevo->where('change_cluster','Upgrade')->count() + $user->gevo->where('change_cluster','Sidegrade')->count() +$user->gevo->where('change_cluster','Downgrade')->count()}}</td>
            <td>{{$user->gevo->where('change_cluster','Upgrade')->count()}}</td>
            <td>{{$user->gevo->where('change_cluster','Sidegrade')->count()}}</td>
            <td>{{$user->gevo->where('change_cluster','Downgrade')->count()}}</td>
            <td data-order="{{$user->salesdata['orders'] * $pricepersave}}">{{$user->salesdata['orders'] * $pricepersave}}€</td>
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
            <td>{{$user->salesdata['sickhours']}}</td>
            <td data-order="{{$user->salesdata['sicknessquota']}}">{{$user->salesdata['sicknessquota']}}%</td>
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
          <td id="sas">22</td>
          <td id="optin">23</td>
          <td id="gevo">24</td>
          <td id="upgrade">25</td>
          <td id="downgrade">26</td>
          <td id="sidegrade">27</td>
          <td id="revenue">28</td>
          <td id="revenuePerHourPayedAVG">29</td>
          <td id="revenuePerHourProductiveAVG">30</td>
          <td id="sick hours">31</td>
          <td id="sicknessquotaAVG">32</td>
          <td>total</td>
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
<script src='https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function(){
    let table = $('#tableoverview').DataTable({
      "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation

            var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?  i : 0;
            };
            if (data['var']==1)
            total = api.column().data().reduce( function (a, b) {
            return intVal(a) + intVal(b);
            },0 );

            function getQuota(column)
            {
              let productiveQuota = api.column(column).nodes().toArray().map(function(node) {
                return $(node).attr('data-order');
              });
              let counter = 0;
              let sumPQ = productiveQuota.reduce(function (sum, currentValue) {
                if(currentValue != 0)
                {
                  counter = counter + 1
                  return  (1*parseFloat(sum) + 1*parseFloat(currentValue))
                }
                else {
                  return 1*parseFloat(sum)
                }
              }, 0)

              let Quota = sumPQ/counter
              return Quota
            }

            $(api.column( 2 ).footer() ).html('<b>'+Math.round(api.column(2).data().average()*100)/100 +'s</b>');
            $(api.column( 3 ).footer() ).html('<b>'+Math.round(api.column(3).data().sum()) +'h</b>');
            $(api.column( 4 ).footer() ).html('<b>'+Math.round(api.column(4).data().sum()) +'h</b>')
            $(api.column( 5 ).footer() ).html('<b>'+Math.round(api.column(5).data().sum()) +'h</b>')
            $(api.column( 6 ).footer() ).html('<b>'+getQuota(6).toFixed(2)+'%</b>')
            $(api.column( 7 ).footer() ).html('<b>'+getQuota(7).toFixed(2)+'%</b>')
            //savescolumn
            $(api.column( 8 ).footer() ).html('<b>'+Math.round(api.column(8).data().sum()) +'</b>')
            $(api.column( 9 ).footer() ).html('<b>'+Math.round(api.column(9).data().sum()) +'</b>')
            $(api.column( 10 ).footer() ).html('<b>'+Math.round(api.column(10).data().average()) +'</b>')
            $(api.column( 11 ).footer() ).html('<b>'+Math.round(api.column(11).data().sum()) +'</b>')
            $(api.column( 12 ).footer() ).html('<b>'+Math.round(api.column(12).data().sum()) +'</b>')
            $(api.column( 13 ).footer() ).html('<b>'+Math.round(api.column(13).data().sum()) +'</b>')
            $(api.column( 14 ).footer() ).html('<b>'+Math.round(api.column(14).data().sum()) +'</b>')
            $(api.column( 15 ).footer() ).html('<b>'+(Math.round(api.column(15).data().average())*100)/100 +'/h</b>')
            $(api.column( 16 ).footer() ).html('<b>'+getQuota(16).toFixed(2)+'%</b>')
            $(api.column( 17 ).footer() ).html('<b>'+Math.round(api.column(17).data().average()) +'%</b>')
            $(api.column( 18 ).footer() ).html('<b>'+getQuota(18).toFixed(2)+'%</b>')
            $(api.column( 19 ).footer() ).html('<b>'+getQuota(19).toFixed(2)+'%</b>')
            $(api.column( 20 ).footer() ).html('<b>'+getQuota(20).toFixed(2)+'%</b>')
            $(api.column( 21 ).footer() ).html('<b>'+getQuota(21).toFixed(2)+'%</b>')
            $(api.column( 22 ).footer() ).html('<b>'+getQuota(22).toFixed(2)+'%</b>')
            $(api.column( 23 ).footer() ).html('<b>'+Math.round(api.column(23).data().sum()) +'€</b>')
            $(api.column( 24 ).footer() ).html('<b>'+Math.round(api.column(24).data().average()) +'€</b>')
            $(api.column( 25 ).footer() ).html('<b>'+Math.round(api.column(25).data().average()) +'€</b>')
            $(api.column( 26 ).footer() ).html('<b>'+Math.round(api.column(26).data().average()) +'h</b>')
            $(api.column( 27 ).footer() ).html('<b>'+Math.round(api.column(27).data().sum()) +'</b>')
            $(api.column( 28 ).footer() ).html('<b>'+Math.round(api.column(28).data().sum()) +'</b>')
            $(api.column( 29 ).footer() ).html('<b>'+getQuota(29).toFixed(2)+'%</b>')
            $(api.column( 30 ).footer() ).html('<b> Total</b>')
          },
          select: true,
          dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100],
              ['10', '25', '50 ', '100']
          ],
          buttons: [

                  { extend: 'csv', text: '<i class="fas fa-file-csv fa-2x"></i>' },
                  { extend: 'excel', text: '<i class="fas fa-file-excel fa-2x"></i>' },
                  // 'excel',

              ],
      rowReorder: true,
      colReorder: true,
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

      "columnDefs": [
            { "width": "60px", "targets": "_all" },

          ],
        });

        if (document.querySelector('.subauswahl')) {
          document.querySelectorAll('.subauswahl').forEach((elem) => {
            elem.addEventListener("click", function(event) {

              $('.subauswahl').each(function(){
                  this.className=''
                  this.className='subauswahl'
              });
              event.target.className = 'subauswahl aktiv';
              switch(event.target.id) {
                case 'allData':
                    table.colReorder.reset();
                    table.columns().visible( false );
                    table.columns().visible( true );
                    // table.draw()

                  break;
                case 'teamleiterview':
                  // table.colReorder.reset();
                  table.columns().visible( false );

                  table.columns([0,1,2,3,4,31,32,7,18,19,22,23,28,33]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order( [0,1,2,3,4,31,32,7,18,19,22,23,28,33]);
                  // table.colReorder.order( [0,1,3,4,31,32,5,7,9,10,8,17,18,23,24,25,27],true);
                  break;
                case 'crview':
                  table.colReorder.reset();
                  table.columns().visible( false );
                  table.columns([0,1,8,9,11,12,13,14,17,18,19,20,21,22,30,33]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order( [0,1,8,9,11,12,13,14,17,18,19,20,21,22,30,33]);
                  // table.columns.adjust().draw();
                break;
                case 'timesview':
                  table.colReorder.reset();
                  table.columns().visible( false );
                  table.columns([0,1,2,3,4,5,6,7,10,29,30,33]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order( [0,1,2,3,4,5,6,7,10,29,30,33]);
                  // table.columns.adjust().draw();
                break;
                case 'revenueview':
                  table.colReorder.reset();
                  table.columns().visible( false );
                  table.columns([0,1,22,23,24,25,26,27,28,29,30,33]).visible( true );
                  $('.DTFC_LeftBodyWrapper').hide()
                  $('.DTFC_RightWrapper').hide()
                  $('#tableoverview').css('margin','0px');
                  table.colReorder.order( [0,1,28,29,30,27,26,25,24,22,23,33]);
                  // table.columns.adjust().draw();
                break;
              }

              // var item = event.target.id;

            });
          });
        }


      });
</script>
@endsection
