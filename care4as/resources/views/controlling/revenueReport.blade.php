@extends('general_layout')
@section('pagetitle')
    Controlling: Umsatzmeldung
@endsection

@section('additional_css')
<style>
    .umsatz{
        display: none;
        background-color:#8ccded;
    }

    .availbench{
        display: none;
        background-color:aliceblue;
    }

    .cpo{
        display: none;
        background-color:aliceblue;
    }

    .optin{
        display: none;
        background-color:aliceblue;
    }

    .heads{
        display: none;
        background-color:aliceblue;
    }

    .fte{
        display: none;
        background-color:aliceblue;
    }

    tr:hover td{
        background-color: #ddd !important;
    }
</style>
@endsection

@section('content')
<div>
    <form action="{{route('revenuereport.master')}}" method="get">
    @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Projekt</div>
                                <div class="max-panel-content">
                                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                        <label for="project" style="margin: auto 0 auto auto;">Projekt:</label>
                                        <select id="project" class="form-control" style="color:black;" name="project">
                                                <option selected value="10">1u1 DSL Retention</option>
                                                <option value="7">1u1 Mobile Retention</option>
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
                                        <label for="month" style="margin: auto 0 auto auto;">Monat:</label>
                                        <select id="month" class="form-control" style="color:black;" name="month">
                                                <option value="february">Februar</option>
                                                <option value="march">März</option>
                                        </select>
                                        <label for="year" style="margin: auto 0 auto auto;">Jahr:</label>
                                        <select id="year" class="form-control" style="color:black;" name="year">
                                                <option value="2022">2022</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Funktionen</div>
                                <div class="max-panel-content" style="display: flex; justify-content: space-around; flex-direction: column; gap: 5px">
                                    <button type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Liste anzeigen</button>
                                    <button class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Sonderposten hinzufügen</button>
                                    <button class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Werte anpassen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>    
        </div>
    </form>

    @if($param['comp'] == true)
    <div class="row">
            <div class="col-md-12">
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="max-panel">
                                <div class="max-panel-title">Auswertung</div>
                                <div class="max-panel-content">
                                    <table class="max-table" id="datatable" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Datum</th>
                                                <th><abbr title="Nur bezahlte MA ohne: Krank o.Lfz, Elternzeit, Beschäftigungsverbot, Krank Quarantäne">FTE Bestand <button onclick="changeDisplay('fte', 'fte_button')"><i id="fte_button" class="fas fa-caret-right"></i></button></abbr></th>
                                                    <th class="fte">KB</th>
                                                    <th class="fte">OVH</th>
                                                <th><abbr title="Nur bezahlte MA ohne: Krank o.Lfz, Elternzeit, Beschäftigungsverbot, Krank Quarantäne">Köpfe Bestand <button onclick="changeDisplay('heads', 'heads_button')"><i id="heads_button" class="fas fa-caret-right"></i></button></abbr></th>
                                                    <th class="heads">KB</th>
                                                    <th class="heads">OVH</th>
                                                <th>Std. bezahlt</th>
                                                <th>Umsatz IST <button onclick="changeDisplay('umsatz', 'umsatz_ist_button')"><i id="umsatz_ist_button" class="fas fa-caret-right"></i></button></th>
                                                    <th class="umsatz">CPO <button onclick="changeDisplay('cpo', 'cpo_button')"><i id="cpo_button" class="fas fa-caret-right"></i></button></th>
                                                        @if($param['project'] == 10)
                                                            <th class="cpo">DSL</hd>
                                                        @endif
                                                        @if($param['project'] == 7)
                                                            <th class="cpo">SSC</th>
                                                            <th class="cpo">BSC</th>
                                                            <th class="cpo">Portale</th>
                                                        @endif
                                                        <th class="cpo">KüRü</th>
                                                    <th class="umsatz">Availbench <button onclick="changeDisplay('availbench', 'availbench_button')"><i id="availbench_button" class="fas fa-caret-right"></i></button></th>
                                                        <th class="availbench">Total Cost Per Interval</th>
                                                        <th class="availbench">← inkl. Malus</th>
                                                        <th class="availbench">Malus Incentive</th>
                                                        <th class="availbench">AHT Zielmangement</th>
                                                    <th class="umsatz">Optin  <button onclick="changeDisplay('optin', 'optin_button')"><i id="optin_button" class="fas fa-caret-right"></i></button></th>
                                                        <th class="optin">Call</th>
                                                        <th class="optin">E-Mail</th>
                                                        <th class="optin">Print</th>
                                                        <th class="optin">SMS</th>
                                                        <th class="optin">Verkehrsdaten</th>
                                                        <th class="optin">Nutzungsdaten</th>
                                                    <th class="umsatz">SaS</th>
                                                    <th class="umsatz">Speedretention</th>
                                                <th>Umsatz / bez. Std.</th>
                                                <th>Umsatz SOLL</th>
                                                <th>Deckung</th>
                                                <th>Zielerreichung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['daily'] as $key => $entry)
                                            <tr>
                                                <td>{{date('d.m.Y', strtotime($key))}}</td>
                                                <td>FTE Bestand</td>
                                                    <td class="fte">KB</td>
                                                    <td class="fte">OVH</td>
                                                <td>FTE Köpfe</td>
                                                    <td class="heads">KB</td>
                                                    <td class="heads">OVH</td>
                                                <td>Std.bezahlt</td>
                                                <td>Umsatz IST</td>
                                                    <td class="umsatz" style="text-align: right;">{{number_format($entry['details']['revenue'],2, ',', '.')}} €</td>
                                                        @if($param['project'] == 10)    
                                                            <td class="cpo">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['dsl_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['dsl_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($param['project'] == 7)
                                                            <td class="cpo">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['ssc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['ssc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['bsc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['bsc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$entry['details']['portale_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($entry['details']['portale_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        <td class="cpo">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$entry['details']['kuerue_orders']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($entry['details']['kuerue_revenue'], 2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                    <td class="umsatz" style="text-align: right;">{{number_format($entry['availbench']['revenue'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;">{{number_format($entry['availbench']['total_costs_per_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;">-{{number_format($entry['availbench']['malus_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;">{{number_format($entry['availbench']['malus_incentive'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;">{{number_format($entry['availbench']['aht_zielmanagement'],2, ',', '.')}} €</td>
                                                    <td class="umsatz">Optin</td>
                                                        <td class="optin">Call</td>
                                                        <td class="optin">E-Mail</td>
                                                        <td class="optin">Print</td>
                                                        <td class="optin">SMS</td>
                                                        <td class="optin">Verkehrsdaten</td>
                                                        <td class="optin">Nutzungsdaten</td>
                                                    <td class="umsatz">SaS</td>
                                                    <td class="umsatz">
                                                        <div style="display:flex">
                                                            <div style="margin-right: 15px;">[{{number_format($entry['speedretention']['duration'],2, ',', '.')}}]</div>
                                                            <div style="margin-left:auto">{{number_format($entry['speedretention']['revenue'], 2, ',', '.')}} €</div>
                                                        </div>
                                                    </td>
                                                <td>Umsatz / bez. Std.</td>
                                                <td>Umsatz SOLL</td>
                                                <td>Deckung</td>
                                                <td>Zielerreichung</td>
                                            </tr>
                                            @endforeach
                                            <!-- <tr>
                                                <td>Sonderposten</td>
                                                <td colspan="2">Praxischeck</td>
                                                <td>4.000 €</td>
                                                <td colspan="100%"></td>
                                            </tr>
                                            <tr>
                                                <td>Sonderposten</td>
                                                <td colspan="2">E-Mail Verifikation</td>
                                                <td>6.500 €</td>
                                                <td colspan="100%"></td>
                                            </tr> -->
                                        </tbody>
                                        <tfoot>
                                            <tr style="font-weight: bold; background-color: #ddd;">
                                                <td>Summe</td>
                                                <td><abbr title="Zeitgewichteter Mittelwert">FTE Bestand</abbr></td>
                                                    <td class="fte">KB</td>
                                                    <td class="fte">OVH</td>
                                                <td><abbr title="Zeitgewichteter Mittelwert">FTE Köpfe</abbr></td>
                                                    <td class="heads">KB</td>
                                                    <td class="heads">OVH</td>
                                                <td>Std.bezahlt</td>
                                                <td>Umsatz IST</td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['details']['revenue'],2, ',', '.')}} €</td>
                                                        @if($param['project'] == 10)    
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['dsl_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['dsl_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($param['project'] == 7)
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['ssc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['ssc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['bsc_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['bsc_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                            <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                                <div style="display:flex">
                                                                    <div style="margin-right: 15px;">[{{$data['sum']['details']['portale_orders']}}]</div>
                                                                    <div style="margin-left:auto">{{number_format($data['sum']['details']['portale_revenue'], 2, ',', '.')}} €</div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        <td class="cpo" style="text-align: right;background-color: #ddd;">
                                                            <div style="display:flex">
                                                                <div style="margin-right: 15px;">[{{$data['sum']['details']['kuerue_orders']}}]</div>
                                                                <div style="margin-left:auto">{{number_format($data['sum']['details']['kuerue_revenue'], 2, ',', '.')}} €</div>
                                                            </div>
                                                        </td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['revenue'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['total_costs_per_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">-{{number_format($data['sum']['availbench']['malus_interval'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['malus_incentive'],2, ',', '.')}} €</td>
                                                        <td class="availbench" style="text-align: right;background-color: #ddd;">{{number_format($data['sum']['availbench']['aht_zielmanagement'],2, ',', '.')}} €</td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">Optin</td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">Call</td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">E-Mail</td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">Print</td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">SMS</td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">Verkehrsdaten</td>
                                                        <td class="optin" style="text-align: right;background-color: #ddd;">Nutzungsdaten</td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">SaS</td>
                                                    <td class="umsatz" style="text-align: right;background-color: #ddd;">
                                                        <div style="display:flex">
                                                            <div style="margin-right: 15px;">[{{number_format($data['sum']['speedretention']['duration'],2, ',', '.')}}]</div>
                                                            <div style="margin-left:auto">{{number_format($data['sum']['speedretention']['revenue'], 2, ',', '.')}} €</div>
                                                        </div>
                                                    </td>
                                                <td>Umsatz / bez. Std.</td>
                                                <td>Umsatz SOLL</td>
                                                <td>Deckung</td>
                                                <td>Zielerreichung</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@section('additional_js')
<script>
    function changeDisplay(classname, buttonId){
        var collection = document.getElementsByClassName(classname);
        status = window.getComputedStyle(collection[0]).display;

        if (status == 'table-cell'){
            for(i = 0; i<collection.length; i++){
                collection[i].style.display = 'none';
            }
        } else {
            for(i = 0; i<collection.length; i++){
                collection[i].style.display = 'table-cell';
            }
        }

        button = document.getElementById(buttonId);
        
        if (button.className == 'fas fa-caret-right'){
            button.className = 'fas fa-caret-left'
        } else {
            button.className = 'fas fa-caret-right';
        }
    }
</script>
@endsection