@extends('general_layout')
@section('pagetitle')
    Controlling: Umsatzmeldung
@endsection
@section('additional_css')

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
                                                <option value="0">Januar</option>
                                        </select>
                                        <label for="year" style="margin: auto 0 auto auto;">Jahr:</label>
                                        <select id="year" class="form-control" style="color:black;" name="year">
                                                <option value="0">Januar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="max-panel">
                                <div class="max-panel-title">Funktionen</div>
                                <div class="max-panel-content" style="display: flex; justify-content: space-around;">
                                    <form action="" method="">
                                        <button type="submit" class="btn btn-primary btn-small" style="padding-top: 8px; padding-bottom: 8px; margin-top: 0; margin-bottom: 0;">Liste anzeigen</button>
                                    </form>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                            </tr>
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
    @endif

</div>
@endsection

@section('additional_js')

@endsection