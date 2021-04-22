<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>automatisierter Zwischenstandsreport</title>
    </head>
    <body>
      <div class="">

      </div>
        <div class="">
            <p>Sehr geehrte Damen und Herren, <br>
              Zwischenstand: {{$data['date']}}</p>
            <table style="border: 1px solid black; color: #746e58;text-align:center; font-size: 1.2em">
              <tr>
                <th>Name</th>
                <th>SSC Calls</th>
                <th>+-</th>
                <th>BSC Calls</th>
                <th>+-</th>
                <th>Portal Calls</th>
                <th>+-</th>
                <th>PTB Calls</th>
                <th>Kürü</th>
                <th>Saves</th>
                <th>SSC-Saves</th>
                <th>+-</th>
                <th>BSC-Saves</th>
                <th>+-</th>
                <th>Portal-Saves</th>
                <th>+-</th>
              </tr>
              @for($i = 0; $i < count($data)-3; $i++)
              <tr style="background-color: @if($i % 2 == 0) #ddf8e8 @else #fefdfa @endif; ">
                <td>{{$data[$i]['name']}}</td>
                <td>{{$data[$i]['SSC_Calls']}}</td>

                <td style="@if($data[$i]['SSC_Calls_differ'] > 0) background-color: green; color: white; @elseif($data[$i]['SSC_Calls_differ'] < 0)background-color: red; color: white; @endif" >{{$data[$i]['SSC_Calls_differ']}}</td>
                <td>{{$data[$i]['BSC_Calls']}}</td>

                <td style="@if($data[$i]['BSC_Calls_differ'] > 0) background-color: green; color: white; @elseif($data[$i]['BSC_Calls_differ'] < 0)background-color: red; color: white;@endif">{{$data[$i]['BSC_Calls_differ']}}</td>
                <td>{{$data[$i]['Portal_Calls']}}</td>

                <td style="@if($data[$i]['Portal_Calls_differ'] > 0) background-color: green; color: white;@elseif($data[$i]['Portal_Calls_differ'] < 0)background-color: red; color: white; @endif">{{$data[$i]['Portal_Calls_differ']}}</td>
                <td>{{$data[$i]['PTB_Calls']}}</td>
                <td>{{$data[$i]['KüRü']}}</td>
                <td>{{$data[$i]['Orders']}}</td>
                <td>{{$data[$i]['SSC-Orders']}}</td>

                <td style="@if($data[$i]['SSC-Orders_differ'] > 0) background-color: green; color: white;@elseif($data[$i]['SSC-Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data[$i]['SSC-Orders_differ']}}</td>
                <td>{{$data[$i]['BSC-Orders']}}</td>

                <td style="@if($data[$i]['BSC-Orders_differ'] > 0) background-color: green; color: white;@elseif($data[$i]['BSC-Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data[$i]['BSC-Orders_differ']}}</td>
                <td>{{$data[$i]['Portal-Orders']}}</td>

                <td style="@if($data[$i]['Portal-Orders_differ'] > 0) background-color: green; color: white;@elseif($data[$i]['Portal-Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data[$i]['Portal-Orders_differ']}}</td>
              </tr>
              @endfor
            </table>
        </div>
        <hr>
        <div class="" style="background-color: lightblue; color: white; font-size: 1.5em;">
          <p><b>DSL CR: {{$data['dslcr']}}</b> </p>
          <hr>
          <p><b>Mobile SSC-CR: {{$data['ssccr']}} </b> </p>
        </div>
    </body>
    <footer>

    </footer>
</html>
