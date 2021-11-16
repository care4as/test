@extends('general_layout')
@section('pagetitle')
    Controlling: Projektmeldung
@endsection
@section('content')
@section('additional_css')
<style>
    table.dataTable {
        border-collapse: collapse;
    }
    .form-control{
        color:black;
    }
    table.dataTable tbody td, table.dataTable tfoot td, table.dataTable thead th {
        padding: 0px 15px;
    }
    .sorting_desc, .sorting_asc {
        background-blend-mode: luminosity;
    }
    .dataTables_wrapper .dataTables_length select{
        width: 60px;
        margin-left: 4px;
        margin-right: 4px;
    }
    label{
        display: flex;
        align-items: center;
    }
    .DTFC_LeftBodyLiner {
        overflow-x: hidden;
    }
    .hoverRow{
        background-color: #ddd !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        border: 1px solid transparent;
        background: transparent;
    }
    .page-item.active .page-link{
        background-color: #FA7A50;
        border-color: #FA7A50;
    }

</style>
@endsection

<div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('projectReport')}}" method="get()"> 
            @csrf
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Projekt</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                        <label for="inputState" style="margin: auto;">Auswahl:</label>
                                        <select id="inputState" class="form-control" style="color:black;" name="project">
                                            @if($defaultVariablesArray['project'] == '1u1_dsl_ret')
                                                <option selected value="1u1_dsl_ret">1u1 DSL Retention</option>
                                            @else
                                                <option value="1u1_dsl_ret">1u1 DSL Retention</option>
                                            @endif
                                            @if($defaultVariablesArray['project'] == '1u1_mobile_ret')
                                                <option selected value="1u1_mobile_ret">1u1 Mobile Retention</option>
                                            @else
                                                <option value="1u1_mobile_ret">1u1 Mobile Retention</option>
                                            @endif
                                            <!-- <option value="1u1_offline">1u1 Kündigungsadministration</option>
                                            <option value="telefonica_outbound">Telefonica Outbound</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Zeitraum</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <p style="margin: auto;">Von:</p>
                                        <input type="date" id="datefrom" name="startDate" class="form-control" placeholder="" style="color:black;" value="{{$defaultVariablesArray['startDate']}}">
                                        <p style="margin: auto;">Bis:</p>
                                        <input type="date" id="datefrom" name="endDate" class="form-control" placeholder="" style="color:black;" value="{{$defaultVariablesArray['endDate']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="display:flex; margin-top: 20px; margin-bottom: 20px;">
                            <button class="btn btn-primary" style="margin: auto;" type="submit">Bericht erzeugen</button>
                        </div>
                    </div>
                </div>
            </form>  
        </div>    
    </div>

<!-- START PROJECT: DSL -->
    @if($defaultVariablesArray['project'] == '1u1_dsl_ret')
    <div class="row">  
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="max-panel-title">
                    Projektmeldung 1u1 DSL Retention
                </div>
                <div class="max-panel-content">
                    <div style="width: 100%;">
                        <table class="max-table" id="dslMaTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Std. Bezahlt</th>
                                    <th>Std. Produktiv</th>
                                    <th>← in %</th>
                                    <th>Std. Pause</th>
                                    <th>← in %</th>
                                    <th>Std. Krank</th>
                                    <th>← in %</th>
                                    <th>Std. Speedretention</th>
                                    <th>∑ Calls</th>
                                    <th>← / Stunde</th>
                                    <th>AHT</th>
                                    <th>∑ GeVo Saves</th>
                                    <th>← CR</th>
                                    <th>∑ KüRü</th>
                                    <th>∑ bez. OptIn</th>
                                    <th>∑ OptIn</th>
                                    <th>← in %</th>
                                    <th>∑ Mögliche OptIn</th>
                                    <th>← in %</th>
                                    <th>∑ SaS</th>
                                    <th>← in ‰</th>
                                    <th>RLZ+24 Quote</th>
                                    <th>€ Speedretention</th>
                                    <th>€ Availbench</th>
                                    <th><abbr title="Call: {{number_format($defaultVariablesArray['optin_call'], 2, ',', '.')}}€&#010;Mail: {{number_format($defaultVariablesArray['optin_mail'], 2, ',', '.')}}€&#010;Print: {{number_format($defaultVariablesArray['optin_print'], 2, ',', '.')}}€&#010;SMS: {{number_format($defaultVariablesArray['optin_sms'], 2, ',', '.')}}€&#010;Verkehrsdaten: {{number_format($defaultVariablesArray['optin_traffic'], 2, ',', '.')}}€&#010;Nutzungsdaten: {{number_format($defaultVariablesArray['optin_usage'], 2, ',', '.')}}€">€ OptIn</abbr></th>
                                    <th><abbr title="GeVo: {{number_format($defaultVariablesArray['revenue_sale_dsl'], 2, ',', '.')}}€&#010;KüRü {{number_format($defaultVariablesArray['revenue_kuerue'], 2, ',', '.')}}€">€ Sales</abbr></th>
                                    <th>€ Gesamt</th>
                                    <th>€ / Std. bez.</th>
                                    <th>€ / Std. prod.</th>
                                    <th>€ MA Kosten</th>
                                    <th>€ Delta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataArray['employees'] as $key => $employee)
                                    <tr>
                                    <!--Name-->         <td style="text-align: left;">{{$employee['full_name']}}</td>
                                    <!--Std. bez.-->    <td>{{number_format($employee['work_hours'], 2,",",".")}}</td>
                                    <!--Std. prod.-->   <td>{{number_format($employee['productive_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($employee['productive_percentage'], 2,",",".")}}%</td>
                                    <!--Pause-->        <td>{{number_format($employee['break_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($employee['break_percentage'], 2,",",".")}}%</td>
                                    <!--Krank-->        <td>{{number_format($employee['sick_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($employee['sick_percentage'], 2,",",".")}}%</td>
                                    <!--Std. SR-->      <td>{{number_format($employee['hours_speedretention'], 2,",",".")}}</td>
                                    <!--Summe Calls-->  <td>{{$employee['dsl_calls']}}</td>
                                    <!--Pro Std.-->     <td>{{number_format($employee['calls_per_hour'], 2,",",".")}}</td>
                                    <!--AHT-->          <td>{{number_format($employee['aht'], 0,",","")}}</td>
                                    <!--GeVo Sales-->   <td>{{$employee['dsl_saves']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($employee['dsl_cr'], 2,",",".")}}%</td>
                                    <!--Kürü Sales-->   <td>{{$employee['dsl_kuerue']}}</td>
                                    <!--OptIn bez.-->   <td>{{$employee['optin_sum_payed']}}</td>
                                    <!--OptIn Summe-->  <td>{{$employee['optin_calls_new']}}</td>
                                    <!--in %-->         <td>{{number_format($employee['optin_percentage'], 2,",",".")}}%</td>
                                    <!--OptIn Möglich--><td>{{$employee['optin_calls_possible']}}</td>
                                    <!--in %-->         <td>{{number_format($employee['optin_possible_percentage'], 2,",",".")}}%</td>
                                    <!--SaS Summe-->    <td>{{$employee['sas_orders']}}</td>
                                    <!--in ‰-->         <td>{{number_format($employee['sas_promille'], 2,",",".")}}‰</td>
                                    <!--RLZ Quote-->    <td>{{number_format($employee['rlz_plus_percentage'], 2,",",".")}}%</td>
                                    <!--U. SR -->       <td style="text-align: right;">{{number_format($employee['revenue_speedretention'], 2,",","")}}€</td>
                                    <!--U. Availbench--><td style="text-align: right;">{{number_format($employee['revenue_availbench'], 2,",","")}}€</td>
                                    <!--U. OptIn -->    <td style="text-align: right;">{{number_format($employee['revenue_optin'], 2,",","")}}€</td>
                                    <!--U. Sales-->     <td style="text-align: right;">{{number_format($employee['revenue_sales'], 2,",","")}}€</td>
                                    <!--U. Gesamt-->    <td style="text-align: right;">{{number_format($employee['revenue_sum'], 2,",","")}}€</td>
                                    <!--U. / bez.-->    <td style="text-align: right;">{{number_format($employee['revenue_per_hour_paid'], 2,",","")}}€</td>
                                    <!--U. / prod.-->   <td style="text-align: right;">{{number_format($employee['revenue_per_hour_productive'], 2,",","")}}€</td>
                                    <!--Kosten-->       <td style="text-align: right;">{{number_format($employee['pay_cost'], 2,",","")}}€</td>
                                    <!--U. Delta-->     <td style="text-align: right;">{{number_format($employee['revenue_delta'], 2,",","")}}€</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold; background-color: #ddd;">
                                    <!--Name-->         <td>Summe</td>
                                    <!--Std. bez.-->    <td>{{number_format($dataArray['sum']['work_hours'], 2,",",".")}}</td>
                                    <!--Std. prod.-->   <td>{{number_format($dataArray['sum']['productive_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['productive_percentage'], 2,",",".")}}%</td>
                                    <!--Pause-->        <td>{{number_format($dataArray['sum']['break_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['break_percentage'], 2,",",".")}}%</td>
                                    <!--Krank-->        <td>{{number_format($dataArray['sum']['sick_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['sick_percentage'], 2,",",".")}}%</td>
                                    <!--Std. SR-->      <td>{{number_format($dataArray['sum']['hours_speedretention'], 2,",",".")}}</td>
                                    <!--Summe Calls-->  <td>{{$dataArray['sum']['dsl_calls']}}</td>
                                    <!--Pro Std.-->     <td>{{number_format($dataArray['sum']['calls_per_hour'], 2,",",".")}}</td>
                                    <!--AHT-->          <td>{{number_format($dataArray['sum']['aht'], 0,",",".")}}</td>
                                    <!--GeVo Sales-->   <td>{{$dataArray['sum']['dsl_saves']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($dataArray['sum']['dsl_cr'], 2,",",".")}}%</td>
                                    <!--Kürü Sales-->   <td>{{$dataArray['sum']['dsl_kuerue']}}</td>
                                    <!--OptIn bez.-->   <td>{{$dataArray['sum']['optin_sum_payed']}}</td>
                                    <!--OptIn Summe-->  <td>{{$dataArray['sum']['optin_calls_new']}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['optin_percentage'], 2,",",".")}}%</td>
                                    <!--OptIn Möglich--><td>{{$dataArray['sum']['optin_calls_possible']}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['optin_possible_percentage'], 2,",",".")}}%</td>
                                    <!--SaS Summe-->    <td>{{$dataArray['sum']['sas_orders']}}</td>
                                    <!--in ‰-->         <td>{{number_format($dataArray['sum']['sas_promille'], 2,",",".")}}‰</td>
                                    <!--RLZ Quote-->    <td>{{number_format($dataArray['sum']['rlz_plus_percentage'], 2,",",".")}}%</td>
                                    <!--U. SR -->       <td style="text-align: right;">{{number_format($dataArray['sum']['revenue_speedretention'], 2,",",".")}}€</td>
                                    <!--U. Availbench--><td style="text-align: right;">{{number_format($dataArray['sum']['revenue_availbench'], 2,",",".")}}€</td>
                                    <!--U. OptIn -->    <td style="text-align: right;">{{number_format($dataArray['sum']['revenue_optin'], 2,",",".")}}€</td>
                                    <!--U. Sales-->     <td style="text-align: right;">{{number_format($dataArray['sum']['revenue_sales'], 2,",",".")}}€</td>
                                    <!--U. Gesamt-->    <td style="text-align: right;">{{number_format($dataArray['sum']['revenue_sum'], 2,",",".")}}€</td>
                                    <!--U. / bez.-->    <td style="text-align: right;">{{number_format($dataArray['sum']['revenue_per_hour_paid'], 2,",",".")}}€</td>
                                    <!--U. / prod.-->   <td style="text-align: right;">{{number_format($dataArray['sum']['revenue_per_hour_productive'], 2,",",".")}}€</td>
                                    <!--Kosten-->       <td style="text-align: right;">{{number_format($dataArray['sum']['pay_cost'], 2,",",".")}}€</td>
                                    <!--U. Delta-->     <td style="text-align: right;">{{number_format($dataArray['sum']['revenue_delta'], 2,",",".")}}€</td>
                                    </tr>
                            </tfoot>
                        </table>    
                    </div>
                </div>           
            </div>
        </div>
    </div>
    @endif     
<!-- END PROJECT: DSL -->

<!-- START PROJECT: MOBILE -->
@if($defaultVariablesArray['project'] == '1u1_mobile_ret')
    <div class="row">  
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="max-panel-title">
                    Projektmeldung 1u1 Mobile Retention
                </div>
                <div class="max-panel-content">
                    <div style="width: 100%;">
                        <table class="max-table" id="dslMaTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Std. Bezahlt</th>
                                    <th>Std. Produktiv</th>
                                    <th>← in %</th>
                                    <th>Std. Pause</th>
                                    <th>← in %</th>
                                    <th>Std. Krank</th>
                                    <th>← in %</th>
                                    <th>∑ Calls SSC</th>
                                    <th>∑ Calls BSC</th>
                                    <th>∑ Calls Portale</th>
                                    <th>∑ Calls</th>
                                    <th>← / Stunde</th>
                                    <th>AHT</th>
                                    <th>∑ GeVo Saves SSC</th>
                                    <th>← CR</th>
                                    <th>∑ GeVo Saves BSC</th>
                                    <th>← CR</th>
                                    <th>∑ GeVo Saves Portale</th>
                                    <th>← CR</th>
                                    <th>∑ KüRü</th>
                                    <th>∑ bez. OptIn</th>
                                    <th>∑ OptIn</th>
                                    <th>← in %</th>
                                    <th>∑ Mögliche OptIn</th>
                                    <th>← in %</th>
                                    <th>∑ SaS</th>
                                    <th>← in ‰</th>
                                    <th>RLZ+24 Quote</th>
                                    <th>€ Availbench</th>
                                    <th><abbr title="Call: {{number_format($defaultVariablesArray['optin_call'], 2, ',', '.')}}€&#010;Mail: {{number_format($defaultVariablesArray['optin_mail'], 2, ',', '.')}}€&#010;Print: {{number_format($defaultVariablesArray['optin_print'], 2, ',', '.')}}€&#010;SMS: {{number_format($defaultVariablesArray['optin_sms'], 2, ',', '.')}}€&#010;Verkehrsdaten: {{number_format($defaultVariablesArray['optin_traffic'], 2, ',', '.')}}€&#010;Nutzungsdaten: {{number_format($defaultVariablesArray['optin_usage'], 2, ',', '.')}}€">€ OptIn</abbr></th>
                                    <th><abbr title="GeVo: {{number_format($defaultVariablesArray['revenue_sale_dsl'], 2, ',', '.')}}€&#010;KüRü {{number_format($defaultVariablesArray['revenue_kuerue'], 2, ',', '.')}}€">€ Sales</abbr></th>
                                    <th>€ Gesamt</th>
                                    <th>€ / Std. bez.</th>
                                    <th>€ / Std. prod.</th>
                                    <th>€ MA Kosten</th>
                                    <th>€ Delta</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <tr>
                                    <!--Name-->         <td style="text-align: left;"></td>
                                    <!--Std. bez.-->    <td></td>
                                    <!--Std. prod.-->   <td></td>
                                    <!--in %-->         <td></td>
                                    <!--Pause-->        <td></td>
                                    <!--in %-->         <td></td>
                                    <!--Krank-->        <td></td>
                                    <!--in %-->         <td></td>
                                    <!--Calls SSC-->    <td></td>
                                    <!--Calls BSC-->    <td></td>
                                    <!--Calls Portal--> <td></td>
                                    <!--Summe Calls-->  <td></td>
                                    <!--Pro Std.-->     <td></td>
                                    <!--AHT-->          <td></td>
                                    <!--SSC Sales-->    <td></td>
                                    <!--GeVo CR-->      <td></td>
                                    <!--BSC Sales-->    <td></td>
                                    <!--GeVo CR-->      <td></td>
                                    <!--Portale Sales--><td></td>
                                    <!--GeVo CR-->      <td></td>
                                    <!--Kürü Sales-->   <td></td>
                                    <!--OptIn bez.-->   <td></td>
                                    <!--OptIn Summe-->  <td></td>
                                    <!--in %-->         <td></td>
                                    <!--OptIn Möglich--><td></td>
                                    <!--in %-->         <td></td>
                                    <!--SaS Summe-->    <td></td>
                                    <!--in ‰-->         <td></td>
                                    <!--RLZ Quote-->    <td></td>
                                    <!--U. Availbench--><td style="text-align: right;"></td>
                                    <!--U. OptIn -->    <td style="text-align: right;"></td>
                                    <!--U. Sales-->     <td style="text-align: right;"></td>
                                    <!--U. Gesamt-->    <td style="text-align: right;"></td>
                                    <!--U. / bez.-->    <td style="text-align: right;"></td>
                                    <!--U. / prod.-->   <td style="text-align: right;"></td>
                                    <!--Kosten-->       <td style="text-align: right;"></td>
                                    <!--U. Delta-->     <td style="text-align: right;"></td>
                                    </tr>
                                
                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold; background-color: #ddd;">
                                    <!--Name-->         <td>Summe</td>
                                    <!--Std. bez.-->    <td></td>
                                    <!--Std. prod.-->   <td></td>
                                    <!--in %-->         <td></td>
                                    <!--Pause-->        <td></td>
                                    <!--in %-->         <td></td>
                                    <!--Krank-->        <td></td>
                                    <!--in %-->         <td></td>
                                    <!--Calls SSC-->    <td></td>
                                    <!--Calls BSC-->    <td></td>
                                    <!--Calls Portal--> <td></td>
                                    <!--Summe Calls-->  <td></td>
                                    <!--Pro Std.-->     <td></td>
                                    <!--AHT-->          <td></td>
                                    <!--SSC Sales-->    <td></td>
                                    <!--GeVo CR-->      <td></td>
                                    <!--BSC Sales-->    <td></td>
                                    <!--GeVo CR-->      <td></td>
                                    <!--Portale Sales--><td></td>
                                    <!--GeVo CR-->      <td></td>
                                    <!--Kürü Sales-->   <td></td>
                                    <!--OptIn bez.-->   <td></td>
                                    <!--OptIn Summe-->  <td></td>
                                    <!--in %-->         <td></td>
                                    <!--OptIn Möglich--><td></td>
                                    <!--in %-->         <td></td>
                                    <!--SaS Summe-->    <td></td>
                                    <!--in ‰-->         <td></td>
                                    <!--RLZ Quote-->    <td></td>
                                    <!--U. Availbench--><td style="text-align: right;"></td>
                                    <!--U. OptIn -->    <td style="text-align: right;"></td>
                                    <!--U. Sales-->     <td style="text-align: right;"></td>
                                    <!--U. Gesamt-->    <td style="text-align: right;"></td>
                                    <!--U. / bez.-->    <td style="text-align: right;"></td>
                                    <!--U. / prod.-->   <td style="text-align: right;"></td>
                                    <!--Kosten-->       <td style="text-align: right;"></td>
                                    <!--U. Delta-->     <td style="text-align: right;"></td>
                                    </tr>
                            </tfoot>
                        </table>    
                    </div>
                </div>           
            </div>
        </div>
    </div>
    @endif     
<!-- END PROJECT: MOBILE -->

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
  $(document).ready(function(){
    let table = $('#dslMaTable').DataTable({
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Keinen Eintrag gefunden",
            "info": "Seite _PAGE_ von _PAGES_",
            "infoEmpty": "Keinen Eintrag gefunden",
            "infoFiltered": "(gefiltert von _MAX_ total Einträgen)",
            "loadingRecords": "Lädt...",
            "processing":     "Lädt...",
            "search":         "Suche:",
            "paginate": {
                "first":      "Erste",
                "last":       "Letzte",
                "next":       "Nächste",
                "previous":   "Zurück"
            },
        },
        "lengthMenu": [ [-1, 3, 5, 10, 25, 50, 100], ["alle", 3, 5, 10, 25, 50, 100] ],
        scrollX: true,
        scrollCollapse: true,
        fixedColumns: true,
        select: true,
    });
    table.rows().every( function () {
        var rowNode = this.node();
        var rowIndex = this.index();
        $(rowNode).attr( 'data-dt-row', rowIndex );
        $('tr').hover(function () {
            var thisNode = $( this );
            var rowIdx = thisNode.attr( 'data-dt-row' );
            $( "tr" ).removeClass("hoverRow"); // remove all shading
            $( "tr[data-dt-row='" + rowIdx + "']" ).addClass("hoverRow"); // shade only the hovered row
        });
    });
    document.getElementById('userListContainer').style.display = "block";
    $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
})
</script>
@endsection
