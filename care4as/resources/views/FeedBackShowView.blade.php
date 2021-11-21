@extends('general_layout')
@section('pagetitle')
    Controlling: Projektmeldung
@endsection
@section('content')
@section('additional_css')
<style>
.A4Paper{
    width: 21cm;
    height: 29.7cm;
    background: white;
    margin: 20px auto;
    box-shadow: 0px 0px 20px 5px rgba(0,0,0,0.4);
    padding: 1cm;
    font-size: 10pt;
    font-family:'Segoe UI';
}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>

@endsection

<div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('feedback.showfeedback')}}" method="get()"> 
            @csrf
                <div class="max-main-container">
                    <div class="row">
                        <input type="button" onclick="PrintDiv()" value="print a div!" />
                    </div>
                </div>
            </form>  
        </div>    
    </div>

<!-- START FEEDBACKVIEW -->
<div style="width: 21cm; height: 29.7cm; margin: 0mm auto; box-shadow: 0px 0px 20px 5px rgba(0,0,0,0.4); padding: 1cm; font-size: 12pt; background-color: white;">


    <div id="divToPrint">
        <div id="header" style="display: flex">
            <div style="width: 60%; display: flex; flex-direction: column; font-family:Calibri;">
                <div id="title" style="font-weight: bold; font-size: 16pt">Feedbackgespräch</div>    
                <div id="project">1und1 DSL Retention</div> 
                <div id="date">18.11.2021</div>
            </div>
            <div id="image" style="width: 40%;">
            <img src="{{asset('images/Logo_Care4as_2 - Kopie.png')}}" style="max-width: 100%;">
            </div>
        </div>
        <div id="participants" style="width: 100%; display: flex; margin-top: 25pt; font-family:Calibri;">
            <div id="who" style="width: 50%; text-align: center;">
                <div style="font-size: 16pt;">Maximilian Steinberg</div>
                <div style="font-size: 12pt;">geführt mit</div>
            </div>
            <div id="width" style="width: 50%; text-align: center;">
                <div style="font-size: 16pt;">Carmen Erdmann</div>
                <div style="font-size: 12pt;">geführt von</div>
            </div>
        </div>
        <div id="salesperformance" style="font-family:Calibri; margin-top: 25pt;">
            <div style="font-size: 16pt">Salesperformance</div>
            <table style="width: 100%; border: 1px solid black; border-radius: 4pt; border-collapse: collapse;">
                <tbody style="text-align: center;">
                    <tr>
                        <td rowspan="2" colspan="2" style="border: 1px solid black;">2021</td>
                        <td colspan="2" style="border: 1px solid black;">KW 1</td>
                        <td colspan="2" style="border: 1px solid black;">KW 2</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; width: 20%">KB</td>
                        <td style="border: 1px solid black; width: 20%">Team</td>
                        <td style="border: 1px solid black; width: 20%">KB</td>
                        <td style="border: 1px solid black; width: 20%">Team</td>
                    </tr>
                    <!-- DSL START -->
                        <tr>
                            <td style="border: 1px solid black;">Calls</td>
                            <td style="border: 1px solid black;">DSL</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;">Saves</td>
                            <td style="border: 1px solid black;">DSL</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;">CR</td>
                            <td style="border: 1px solid black;">DSL</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                        </tr>
                    <!-- DSL END -->
                </tbody>
            </table>
        </div>
        <div id="qualitaetsformance" style="font-family:Calibri; margin-top: 25pt; margin-bottom: 25pt;">
            <div style="font-size: 16pt">Qualitätsperformance</div>
            <table style="width: 100%; border: 1px solid black; border-radius: 4pt; border-collapse: collapse;">
                <tbody style="text-align: center;">
                    <tr>
                        <td rowspan="2" colspan="1" style="border: 1px solid black;">2021</td>
                        <td colspan="2" style="border: 1px solid black;">KW 1</td>
                        <td colspan="2" style="border: 1px solid black;">KW 2</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; width: 20%">KB</td>
                        <td style="border: 1px solid black; width: 20%">Team</td>
                        <td style="border: 1px solid black; width: 20%">KB</td>
                        <td style="border: 1px solid black; width: 20%">Team</td>
                    </tr>
                    <!-- DSL START -->
                        <tr>
                            <td style="border: 1px solid black; text-align: left;">OptIn Quote</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: left;">RLZ+24 Quote</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: left;">AHT</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                            <td style="border: 1px solid black;">X</td>
                        </tr>
                    <!-- DSL END -->
                </tbody>
            </table>
        </div>
    </div>
    <div style="height: 200px;">
        <canvas id="myChart"></canvas>
    </div>


    <div id="divToPrint2">
        <div id="qualitaetsformance" style="font-family:Calibri; margin-top: 25pt;">
            <div style="font-size: 16pt">Kommentar</div>
            
        </div>
    </div>
</div>
<!-- END FEEDBACKVIEW -->
    

</div>
@endsection

@section('additional_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script type="text/javascript">     
    function PrintDiv() {    
        var canvas = document.getElementById("myChart");
        var img    = canvas.toDataURL("image/png");
        var divToPrint = document.getElementById('divToPrint');
        var divToPrint2 = document.getElementById('divToPrint2');
        var popupWin = window.open('', '_blank', 'width=730,height=900');
        popupWin.document.open();
        popupWin.document.write('<html<style type="text/css" media="print"></style><body onload="window.print()">' + divToPrint.innerHTML + '<img src="'+img+'"/>' + divToPrint2.innerHTML + '</html>');
        popupWin.document.close();
    }
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['01.11.2021', '02.11.2021', '03.11.2021', '04.11.2021', '05.11.2021', '06.11.2021', '07.11.2021', '08.11.2021', '09.11.2021', '10.11.2021', '11.11.2021', '12.11.2021', '13.11.2021', '14.11.2021'],
            datasets: [{
                data: [40, 43, 38, 52, 26, 41, 19, 28, 19, 34, 52, 28, 46, 47],
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'CR in %'
                }
            }]
        },
        tooltips: {
            enabled: false
         },
        },
        devicePixelRatio: 3,
    });
</script>
@endsection