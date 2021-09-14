@extends('general_layout')
@section('pagetitle')
    Projektverwaltung: Userliste
@endsection
@section('content')

    <!-- Auswahl -->
    <div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('userlist')}}" method="get()"> 
                    @csrf
                    <div class="max-main-container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="max-panel">
                                    <div class="max-panel-title">Projekt</div>
                                    <div class="max-panel-content">
                                        <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px;">
                                            <label for="inputState" style="margin: auto;">Auswahl:</label>
                                            <select id="inputState" class="form-control" name="project" style="color:black;">
                                                <option value="10">1und1 DSL Retention</option>
                                                <option value="7">1und1 Mobile Retention</option>
                                                <option value="6">1und1 Kündigungsadministration</option>
                                                <option value="14">Telefonica</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="max-panel">
                                    <div class="max-panel-title">Zeitraum</div>
                                    <div class="max-panel-content">
                                        <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px; margin-bottom: 5px;">
                                            <label for="timeInputState" style="margin: auto;">Zeitraum:</label>
                                            <select id="timeInputState" class="form-control" name="project" style="color:black;" onchange="dateToggle(this.value)">
                                                <option value="current">Aktuell</option>
                                                <option value="filter">Begrenzt</option>
                                            </select>
                                        </div>
                                        <div id="collapseDate" class="collapse">
                                            <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 10px; row-gap: 5px; margin-bottom: 5px;">
                                                <p style="margin-left: auto; margin-top: auto; margin-bottom: auto;">Von:</p>
                                                <input type="date" id="dateFrom" name="startDate" class="form-control" placeholder="" value="" style="color: black;">
                                                <p style="margin-left: auto; margin-top: auto; margin-bottom: auto;">Bis:</p>
                                                <input type="date" id="dateTo" name="endDate" class="form-control" placeholder="" value="" style="color: black;">
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:flex; margin-top: 20px; margin-bottom: 20px;">
                                <button class="btn btn-primary" style="margin: auto;" type="submit">Userliste anzeigen</button>
                            </div>
                        </div>
                    </div>  
                </form>
            </div>    
        </div>
    </div>

    <!-- Einstellungen -->
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="max-panel">
                            Übersicht
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="max-panel">
                            Filter
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="max-panel">
                            Suche
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script>
        function dateToggle(option){
            if(option=="filter"){
                document.getElementById('collapseDate').className = 'collapse.show';
            }
            if(option=="current"){
                document.getElementById('collapseDate').className = 'collapse';
            }
        }
    </script>
@endsection