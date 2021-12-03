@extends('general_layout')

@section('additional_css')
<style media="screen">
  table.dataTable tbody tr
  {
    background-color: transparent !important;
  }
</style>
@endsection
@section('content')
<div class="container bg-light text-dark mt-4" style="width: 75vw; font-size: 0.9em;">
  <div class="row p-2">
    <div class="col-8-md">
      <p><small>Hallo</small> </p>
    </div>


  </div>

</div>

@endsection
@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script>
  $(document).ready(function() {

    let table = $('#retentiontable').DataTable({
      ordering: true,
      "order": [[ 0, "desc" ]],
    })

    $(function () {
    $('[data-toggle="popover"]').popover()
  })
  let element = document.getElementById('exampleFormControlSelect1');

  element.addEventListener("change", function(){
    if(element.value == "sonstige") {
      // console.log($('#button1').disabled)
      document.getElementById("button1").disabled = true;
      alert('gib bitte eine Beschreibung im Textfeld ein')
      let textarea = document.getElementById("cause");
      textarea.addEventListener("input", function(){
        document.getElementById("button1").disabled = false;
      }, false);
    }
    else {
      {
        document.getElementById("button1").disabled = false;
      }
    }
  }, false);
    // Javascript method's body can be found in assets/js/demos.js
    // demo.initDashboardPageCharts();
    $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {
    var data_division = '';
    var data_type = '';
    if (typeof $(this).data('division') !== 'undefined') {

      data_division = $(this).data('division');
      if(typeof $(this).data('type') !== 'undefined')
      {
        data_type = $(this).data('type')
      }
    }
    var data = data_division+'/'+data_type
    $('#type_division').val(data);
  })

  });
  function changeProvi(factor1,factor2,target,value)
  {
    // alert(factor1 + ' ' + factor2 +' '+ value)
    let newTotalProvi = 0
    let old_sscprovi = parseInt($('#ssc_provi').text())
    let old_bscprovi = parseInt($('#bsc_provi').text())
    let old_portalprovi =  parseInt($('#portal_provi').text())

    let provi = value * (factor1 +factor2)

    if(target == "ssc_provi")
    {
       newTotalProvi = provi + old_bscprovi + old_portalprovi
    }
    if(target == "bsc_provi")
    {
       newTotalProvi = old_sscprovi + provi + old_portalprovi
    }
    if(target == "portal_provi")
    {
       newTotalProvi = old_sscprovi + old_bscprovi + provi
    }

    $('#'+target).html(provi)
    $('#total_provision').html(newTotalProvi)
  }
</script>
@endsection
