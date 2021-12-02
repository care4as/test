@extends('general_layout')
@section('pagetitle')
    Controlling: Projektmeldung
@endsection
@section('content')
@section('additional_css')
<style>
    .tracking_container{
        padding: 10px;
    }

    .tracking_description{
        font-size: 0.8em;
        text-align: center;
    }

    .btn-check {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
    }

    .btn-outline-primary:hover{
        color: white;
        background-color: orange;
    }

    .btn-check:checked + label{
    color: white;
    background-color: orange;
    }

    .first-btn-group-element{
        border-top-left-radius: 5px !important;
    }

</style>
@endsection

<div>
    <!-- START KPI-->
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container">
                KPI
            </div>
        </div>    
    </div>
    <!-- END KPI-->

    <!-- START TRACKING -->
    <div class="row">
        <!-- START CALLS -->
        <div class="col-md-3">
            <div class="max-main-container">
                <div class="tracking_title">
                    Calls
                </div>
                <div class="tracking_container">
                    SSC
                    <a class="btn btn-primary" href="#" role="button">-</a>
                    <a class="btn btn-primary" href="#" role="button">+</a>
                </div>
                <div class="tracking_container">
                    BSC
                    <a class="btn btn-primary" href="#" role="button">-</a>
                    <a class="btn btn-primary" href="#" role="button">+</a>
                </div>
                <div class="tracking_container">
                    Portale
                    <a class="btn btn-primary" href="#" role="button">-</a>
                    <a class="btn btn-primary" href="#" role="button">+</a>
                </div>
                <div class="tracking_container">
                    Sonstige
                    <a class="btn btn-primary" href="#" role="button">-</a>
                    <a class="btn btn-primary" href="#" role="button">+</a>
                </div>
            </div>
        </div>
        <!-- END CALLS -->
        <!-- START ORDERS -->
        <div class="col-md-3">
            <div class="max-main-container">
                <div class="tracking_title">
                    Saves
                </div>
                <div class="tracking_container">
                    <div class="tracking_description">Vertragsnummer</div>
                    <input type="text" class="form-control" name="contract_number">
                </div>
                <div class="tracking_container">
                    <div class="tracking_description">Produktgruppe</div>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="product_category" value="ssc" id="product_category1" autocomplete="off">
                        <label class="btn btn-outline-primary first-btn-group-element" for="product_category1">SSC</label>

                        <input type="radio" class="btn-check" name="product_category" value="bsc" id="product_category2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="product_category2">BSC</label>

                        <input type="radio" class="btn-check" name="product_category" value="portale" id="product_category3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="product_category3">Portal</label>
                    </div>
                </div>
                <div class="tracking_container">
                    <div class="tracking_description">Bearbeitung</div>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="event_category" value="save" id="event_category1" autocomplete="off">
                        <label class="btn btn-outline-primary first-btn-group-element" for="event_category1">Save</label>

                        <input type="radio" class="btn-check" name="event_category" value="cancel" id="event_category2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="event_category2">Cancel</label>

                        <input type="radio" class="btn-check" name="event_category" value="service" id="event_category3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="event_category3">Service</label>

                        <input type="radio" class="btn-check" name="event_category" value="kuerue" id="event_category4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="event_category4">KüRü</label>
                    </div>
                </div>
                <div class="tracking_container">
                    <div class="tracking_description">Zieltarif</div>
                    <input type="text" class="form-control" name="target_tariff">
                </div>
                <div class="tracking_container">
                    <div class="tracking_description">OptIn gesetzt</div>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="optin" value="1" id="optin1" autocomplete="off">
                        <label class="btn btn-outline-primary first-btn-group-element" for="optin1">Ja</label>

                        <input type="radio" class="btn-check" name="optin" value="0" id="optin2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="optin2">Nein</label>
                    </div>
                </div>
                <div class="tracking_container">
                    <div class="tracking_description">Restlaufzeit</div>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="runtime" value="1" id="runtime1" autocomplete="off">
                        <label class="btn btn-outline-primary first-btn-group-element" for="runtime1">Ja</label>

                        <input type="radio" class="btn-check" name="runtime" value="0" id="runtime2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="runtime2">Nein</label>
                    </div>
                </div>
                <div class="tracking_container">
                    <div class="tracking_description">An Nacharbeit</div>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="backoffice" value="1" id="backoffice1" autocomplete="off">
                        <label class="btn btn-outline-primary first-btn-group-element" for="backoffice1">Ja</label>

                        <input type="radio" class="btn-check" name="backoffice" value="0" id="backoffice2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="backoffice2">Nein</label>
                    </div>
                </div>
                <div class="tracking_container">
                    <input type="button" value="Speichern">
                </div>
            </div>
        </div>
        <!-- END ORDERS -->
        <!-- START HISTORY -->
        <div class="col-md-6">
            <div class="max-main-container">
                <div class="tracking_title">
                    Historie
                </div>     
            </div>
        </div>
        <!-- END HISTORY -->
    </div>
    <!-- END TRACKING -->
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

@endsection
