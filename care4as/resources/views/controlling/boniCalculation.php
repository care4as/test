@extends('general_layout')
@section('pagetitle')
    Controlling: Bonusberechnung
@endsection
@section('content')


<div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('projectReport')}}" method="get()"> 
            @csrf
                <div class="max-main-container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
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
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
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

</script>
@endsection
