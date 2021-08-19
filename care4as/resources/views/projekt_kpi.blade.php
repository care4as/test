@extends('general_layout')
@section('pagetitle')
    Controlling: Projekt KPI
@endsection
@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="max-panel">
                            <div class="max-panel-title">Projekt</div>
                            <div class="max-panel-content">
                                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                    <label for="inputState" style="margin: auto;">Auswahl:</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>1u1 DSL Retention</option>
                                        <option>1u1 Mobile Retention</option>
                                        <option>1u1 Kündigungsadministration</option>
                                        <option>Telefonica Outbound</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="max-panel">
                            <div class="max-panel-title">Zeitraum</div>
                            <div class="max-panel-content">
                                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px;">
                                    <p style="margin: auto;">Von:</p>
                                    <input type="date" id="datefrom" name="from" class="form-control" placeholder="">
                                    <p style="margin: auto;">Bis:</p>
                                    <input type="date" id="datefrom" name="from" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="max-panel">
                            <div class="max-panel-title">Darstellung</div>
                            <div class="max-panel-content">
                                <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                    <label for="inputState" style="margin: auto;">Auswahl:</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Kumuliert</option>
                                        <option>Monat</option>
                                        <option>Woche</option>
                                        <option>Tag</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="display:flex; margin-top: 20px; margin-bottom: 20px;">
                        <button class="btn btn-primary" style="margin: auto;">Bericht erzeugen</button>
                    </div>
                </div>
            </div>  
        </div>    
    </div>
    <div class="row">  
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="card card-nav-tabs card-plain">
                    <div class="card-header card-header-danger">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#project" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Projekt</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#team" data-toggle="tab" style="font-size: 16px; font-weight: bold;"style="font-size: 16px; font-weight: bold;">Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#employee" data-toggle="tab" style="font-size: 16px; font-weight: bold;">Kundenberater</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><div class="card-body ">
                        <div class="tab-content text-center">
                            <div class="tab-pane active" id="project">
                                
                            </div>
                            <div class="tab-pane" id="team">
                                
                            </div>
                            <div class="tab-pane" id="employee">
                                test            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
@endsection