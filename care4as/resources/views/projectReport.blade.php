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
        width: 65px;
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
    .dataTables_filter{
        width: 300px;
    }

    .dataTables_length{
        width: max-content;
    }

    .page-item:hover{
        border-color: #FA7A50;
    }

    .page-link{
        margin: 5px !important;
    }

    .paginate_button:hover{
        border: none !important;
    }
    
    .page-link:hover{
        border-color: #FA7A50;
    }

    .pagination{
        width: min-content;
        margin: 5px auto;
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
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="max-panel">
                                <div class="max-panel-title">Auswahl</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <label for="projectSelection" style="margin: auto 0 auto auto;">Projekt:</label>
                                        <select id="projectSelection" class="form-control" style="color:black;" name="project" onchange="updateTeamSelection()">
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
                                        <label for="teamSelection" style="margin: auto 0 auto auto;">Team:</label>
                                        <select id="teamSelection" class="form-control" style="color:black;" name="team">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="max-panel">
                                <div class="max-panel-title">Zeitraum</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <p style="margin: auto 0 auto auto;">Von:</p>
                                        <input type="date" id="datefrom" name="startDate" class="form-control" placeholder="" style="color:black;" value="{{$defaultVariablesArray['startDate']}}">
                                        <p style="margin: auto 0 auto auto;">Bis:</p>
                                        <input type="date" id="datefrom" name="endDate" class="form-control" placeholder="" style="color:black;" value="{{$defaultVariablesArray['endDate']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6" style="display:flex; margin-top: 20px; margin-bottom: 20px;">
                            <button class="btn btn-primary" style="margin: auto;" type="submit">Bericht erzeugen</button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6" style="display:flex; flex-direction: column; margin-top: 20px; margin-bottom: 20px; row-gap: 20px;">
                            <button class="btn btn-primary" style="margin: auto;">Einstellungen</button>
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
                                    <th style="border-right: 0px;">Name</th>
                                    <th><abbr title="Alle vom Unternehmen bezahlten Stunden inkl. Krank und Urlaub">Std. MGM Bezahlt</abbr></th>
                                    <th><abbr title="Summe Anmeldezeit in der CCU abzüglich Mittagspause">Std. CCU angemeldet</abbr></th>
                                    <th><abbr title="Stunden in Produktiven Status in der CCU:&#010;- Available&#010;- In Call&#010;- On Hold&#010;- Wrap Up&#010;- Outbound (Nur Speedretention)">Std. Produktiv</abbr></th>
                                    <th><abbr title="'Std. Produktiv' in Relation zu 'Std. MGM Bezahlt'">← in % Brutto</abbr></th>
                                    <th><abbr title="'Std. Produktiv' in Relation zu 'Std. CCU angemeldet'">← in % Netto</abbr></th>
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
                                    <th><abbr title="Pro Std.: {{number_format($defaultVariablesArray['revenue_hour_speedretention'], 2, ',', '.')}}€">€ Speedretention</abbr></th>
                                    <th>€ Availbench</th>
                                    <th><abbr title="Call: {{number_format($defaultVariablesArray['optin_call'], 2, ',', '.')}}€&#010;Mail: {{number_format($defaultVariablesArray['optin_mail'], 2, ',', '.')}}€&#010;Print: {{number_format($defaultVariablesArray['optin_print'], 2, ',', '.')}}€&#010;SMS: {{number_format($defaultVariablesArray['optin_sms'], 2, ',', '.')}}€&#010;Verkehrsdaten: {{number_format($defaultVariablesArray['optin_traffic'], 2, ',', '.')}}€&#010;Nutzungsdaten: {{number_format($defaultVariablesArray['optin_usage'], 2, ',', '.')}}€">€ OptIn</abbr></th>
                                    <th><abbr title="GeVo: {{number_format($defaultVariablesArray['revenue_sale_dsl'], 2, ',', '.')}}€&#010;KüRü {{number_format($defaultVariablesArray['revenue_kuerue_dsl'], 2, ',', '.')}}€">€ Sales</abbr></th>
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
                                    <!--Std. angeme.--> <td>{{number_format($employee['ccu_hours'], 2,",",".")}}</td>
                                    <!--Std. prod.-->   <td>{{number_format($employee['productive_hours'], 2,",",".")}}</td>
                                    <!--in % B-->       <td>{{number_format($employee['productive_percentage_brutto'], 2,",",".")}}%</td>
                                    <!--in % N-->       <td>{{number_format($employee['productive_percentage_netto'], 2,",",".")}}%</td>
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
                                    <!--Name-->         <td style="border-right: 0px;">Summe</td>
                                    <!--Std. bez.-->    <td>{{number_format($dataArray['sum']['work_hours'], 2,",",".")}}</td>
                                    <!--Std. angeme.--> <td>{{number_format($dataArray['sum']['ccu_hours'], 2,",",".")}}</td>
                                    <!--Std. prod. B--> <td>{{number_format($dataArray['sum']['productive_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['productive_percentage_brutto'], 2,",",".")}}%</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['productive_percentage_netto'], 2,",",".")}}%</td>
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
                                    <th style="border-right: 0px;">Name</th>
                                    <th><abbr title="Alle vom Unternehmen bezahlten Stunden inkl. Krank und Urlaub">Std. MGM Bezahlt</abbr></th>
                                    <th><abbr title="Summe Anmeldezeit in der CCU abzüglich Mittagspause">Std. CCU angemeldet</abbr></th>
                                    <th><abbr title="Stunden in Produktiven Status in der CCU:&#010;- Available&#010;- In Call&#010;- On Hold&#010;- Wrap Up&#010;- Outbound (Nur Speedretention)">Std. Produktiv</abbr></th>
                                    <th><abbr title="'Std. Produktiv' in Relation zu 'Std. MGM Bezahlt'">← in % Brutto</abbr></th>
                                    <th><abbr title="'Std. Produktiv' in Relation zu 'Std. CCU angemeldet'">← in % Netto</abbr></th>
                                    <th>Std. Pause</th>
                                    <th>← in %</th>
                                    <th>Std. Krank</th>
                                    <th>← in %</th>
                                    <th>Std. Speedretention</th>
                                    <th>∑ Calls</th>
                                    <th>← / Stunde</th>
                                    <th>AHT</th>
                                    <th>∑ Calls SSC</th>
                                    <th>∑ GeVo Saves SSC</th>
                                    <th>← CR</th>
                                    <th>∑ Calls BSC</th>
                                    <th>∑ GeVo Saves BSC</th>
                                    <th>← CR</th>
                                    <th>∑ Calls Portale</th>
                                    <th>∑ GeVo Saves Portale</th>
                                    <th>← CR</th>
                                    <th>∑ KüRü</th>
                                    <th>∑ Saves</th>
                                    <th>∑ bez. OptIn</th>
                                    <th>∑ OptIn</th>
                                    <th>← in %</th>
                                    <th>∑ Mögliche OptIn</th>
                                    <th>← in %</th>
                                    <th>∑ SaS</th>
                                    <th>← in ‰</th>
                                    <th>RLZ+24 Quote</th>
                                    <th><abbr title="Pro Std.: {{number_format($defaultVariablesArray['revenue_hour_speedretention'], 2, ',', '.')}}€">€ Speedretention</abbr></th>
                                    <th>€ Availbench</th>
                                    <th><abbr title="Call: {{number_format($defaultVariablesArray['optin_call'], 2, ',', '.')}}€&#010;Mail: {{number_format($defaultVariablesArray['optin_mail'], 2, ',', '.')}}€&#010;Print: {{number_format($defaultVariablesArray['optin_print'], 2, ',', '.')}}€&#010;SMS: {{number_format($defaultVariablesArray['optin_sms'], 2, ',', '.')}}€&#010;Verkehrsdaten: {{number_format($defaultVariablesArray['optin_traffic'], 2, ',', '.')}}€&#010;Nutzungsdaten: {{number_format($defaultVariablesArray['optin_usage'], 2, ',', '.')}}€">€ OptIn</abbr></th>
                                    <th><abbr title="SSC: {{number_format($defaultVariablesArray['revenue_sale_mobile_ssc'], 2, ',', '.')}}€&#010;BSC: {{number_format($defaultVariablesArray['revenue_sale_mobile_bsc'], 2, ',', '.')}}€&#010;Portale: {{number_format($defaultVariablesArray['revenue_sale_mobile_ssc'], 2, ',', '.')}}€&#010;KüRü {{number_format($defaultVariablesArray['revenue_kuerue_mobile'], 2, ',', '.')}}€">€ Sales</abbr></th>
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
                                    <!--Std. angeme.--> <td>{{number_format($employee['ccu_hours'], 2,",",".")}}</td>
                                    <!--Std. prod.-->   <td>{{number_format($employee['productive_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($employee['productive_percentage_brutto'], 2,",",".")}}%</td>
                                    <!--in %-->         <td>{{number_format($employee['productive_percentage_netto'], 2,",",".")}}%</td>
                                    <!--Pause-->        <td>{{number_format($employee['break_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($employee['break_percentage'], 2,",",".")}}%</td>
                                    <!--Krank-->        <td>{{number_format($employee['sick_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($employee['sick_percentage'], 2,",",".")}}%</td>
                                    <!--Std. SR-->      <td>{{number_format($employee['hours_speedretention'], 2,",",".")}}</td>
                                    <!--Summe Calls-->  <td>{{$employee['mobile_calls_sum']}}</td>
                                    <!--Pro Std.-->     <td>{{number_format($employee['calls_per_hour'], 2,",",".")}}</td>
                                    <!--AHT-->          <td>{{number_format($employee['aht'], 0,",","")}}</td>
                                    <!--Calls SSC-->    <td>{{$employee['mobile_calls_ssc']}}</td>
                                    <!--SSC Sales-->    <td>{{$employee['mobile_saves_ssc']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($employee['mobile_cr_ssc'], 2,",",".")}}%</td>
                                    <!--Calls BSC-->    <td>{{$employee['mobile_calls_bsc']}}</td>
                                    <!--BSC Sales-->    <td>{{$employee['mobile_saves_bsc']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($employee['mobile_cr_bsc'], 2,",",".")}}%</td>
                                    <!--Calls Portal--> <td>{{$employee['mobile_calls_portale']}}</td>
                                    <!--Portale Sales--><td>{{$employee['mobile_saves_portale']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($employee['mobile_cr_portale'], 2,",",".")}}%</td>
                                    <!--Kürü Sales-->   <td>{{$employee['mobile_kuerue']}}</td>
                                    <!--Alle Sales-->   <td>{{$employee['mobile_saves_sum']}}</td>
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
                                    <!--Name-->         <td style="border-right: 0px;">Summe</td>
                                    <!--Std. bez.-->    <td>{{number_format($dataArray['sum']['work_hours'], 2,",",".")}}</td>
                                    <!--Std. angeme.--> <td>{{number_format($dataArray['sum']['ccu_hours'], 2,",",".")}}</td>
                                    <!--Std. prod.-->   <td>{{number_format($dataArray['sum']['productive_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['productive_percentage_brutto'], 2,",",".")}}%</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['productive_percentage_netto'], 2,",",".")}}%</td>
                                    <!--Pause-->        <td>{{number_format($dataArray['sum']['break_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['break_percentage'], 2,",",".")}}%</td>
                                    <!--Krank-->        <td>{{number_format($dataArray['sum']['sick_hours'], 2,",",".")}}</td>
                                    <!--in %-->         <td>{{number_format($dataArray['sum']['sick_percentage'], 2,",",".")}}%</td>
                                    <!--Std. SR-->      <td>{{number_format($dataArray['sum']['hours_speedretention'], 2,",",".")}}</td>
                                    <!--Summe Calls-->  <td>{{$dataArray['sum']['mobile_calls_sum']}}</td>
                                    <!--Pro Std.-->     <td>{{number_format($dataArray['sum']['calls_per_hour'], 2,",",".")}}</td>
                                    <!--AHT-->          <td>{{number_format($dataArray['sum']['aht'], 0,",",".")}}</td>
                                    <!--Calls SSC-->    <td>{{$dataArray['sum']['mobile_calls_ssc']}}</td>
                                    <!--SSC Sales-->    <td>{{$dataArray['sum']['mobile_saves_ssc']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($dataArray['sum']['mobile_cr_ssc'], 2,",",".")}}%</td>
                                    <!--Calls BSC-->    <td>{{$dataArray['sum']['mobile_calls_bsc']}}</td>
                                    <!--BSC Sales-->    <td>{{$dataArray['sum']['mobile_saves_bsc']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($dataArray['sum']['mobile_cr_bsc'], 2,",",".")}}%</td>
                                    <!--Calls Portal--> <td>{{$dataArray['sum']['mobile_calls_portale']}}</td>
                                    <!--Portale Sales--><td>{{$dataArray['sum']['mobile_saves_portale']}}</td>
                                    <!--GeVo CR-->      <td>{{number_format($dataArray['sum']['mobile_cr_portale'], 2,",",".")}}%</td>
                                    <!--Kürü Sales-->   <td>{{$dataArray['sum']['mobile_kuerue']}}</td>
                                    <!--Alle Sales-->   <td>{{$dataArray['sum']['mobile_saves_sum']}}</td>
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
            "search":         "<p style='margin-bottom: 0; margin-right: 5px;'>Suche:</p>",
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
        dom: 'Blfrtip',
            buttons: [{
                    extend: 'csv',
                    text: 'CSV Export',
                    className: 'btn btn-primary',
                    footer: 'true',
                    title: null,
                    filename: 'Projektmeldung_Export',
                },
                {
                    extend: 'excel',
                    text: 'Excel Export',
                    className: 'btn btn-primary',
                    footer: 'true',
                    title: null,
                    sheetName: 'Export',
                    filename: 'Projektmeldung_Export',
                    autoFilter: 'true',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                data = $('<p>' + data + '</p>').text();
                                return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                            },
                            footer: function(data, row, column, node) {
                                data = $('<p>' + data + '</p>').text();
                                return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                            }
                        }
                    },
                },
            ],
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
<script>
    $(document).ready(function() {
        updateTeamSelection()
    });
    var teamList = <?php echo json_encode($defaultVariablesArray['projectData']) ?>;
    var selectedTeam = 
        <?php 
            if(isset($defaultVariablesArray['team'])){
                echo $defaultVariablesArray['team'];
            }
            else {
                echo 0;
            }
        ?>;

    function updateTeamSelection(){
        selectedProject = document.getElementById('projectSelection').value;
        teamSelection = document.getElementById('teamSelection');
        
        var child = teamSelection.lastElementChild;
        while (child){
            teamSelection.removeChild(child);
            child = teamSelection.lastElementChild;
        }

        var newOption = document.createElement('option');
            newOption.value = 'all';
            newOption.innerHTML = 'Alle';
            teamSelection.appendChild(newOption);

        for(var i = 0; i < Object.keys(teamList[selectedProject]['teams']).length; i++){
            var newOption = document.createElement('option');
            newOption.value = teamList[selectedProject]['teams'][i]['ds_id'];
            newOption.innerHTML = teamList[selectedProject]['teams'][i]['bezeichnung'];

            if(teamList[selectedProject]['teams'][i]['ds_id'] == selectedTeam){
                newOption.selected = true;
            }

            teamSelection.appendChild(newOption);
        }        
    }
</script>

@endsection
