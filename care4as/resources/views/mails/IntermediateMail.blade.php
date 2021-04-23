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

            <h4><p><b>Mobile</b> </p> </h4>
            <table style="border: 1px solid black; color: #746e58;text-align:center; font-size: 1.2em">
              <tr>
                <th>Name</th>
                <th>Calls</th>
                <th>+-</th>
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
              @for($i = 0; $i < count($data['mobile'])-1; $i++)
              <tr style="background-color: @if($i % 2 == 0) #ddf8e8 @else #fefdfa @endif; ">
                <td>{{$data['mobile'][$i]['name']}}</td>

                <td>{{$data['mobile'][$i]['Calls']}}</td>
                <td style="@if($data['mobile'][$i]['Calls_differ'] > 0) background-color: green; color: white; @elseif($data['mobile'][$i]['Calls_differ'] < 0)background-color: red; color: white; @endif">{{$data['mobile'][$i]['Calls_differ']}}</td>

                <td>{{$data['mobile'][$i]['SSC_Calls']}}</td>
                <td style="@if($data['mobile'][$i]['SSC_Calls_differ'] > 0) background-color: green; color: white; @elseif($data['mobile'][$i]['SSC_Calls_differ'] < 0)background-color: red; color: white; @endif" >{{$data['mobile'][$i]['SSC_Calls_differ']}}</td>
                <td>{{$data['mobile'][$i]['BSC_Calls']}}</td>
                <td style="@if($data['mobile'][$i]['BSC_Calls_differ'] > 0) background-color: green; color: white; @elseif($data['mobile'][$i]['BSC_Calls_differ'] < 0)background-color: red; color: white;@endif">{{$data['mobile'][$i]['BSC_Calls_differ']}}</td>

                <td>{{$data['mobile'][$i]['Portal_Calls']}}</td>
                <td style="@if($data['mobile'][$i]['Portal_Calls_differ'] > 0) background-color: green; color: white;@elseif($data['mobile'][$i]['Portal_Calls_differ'] < 0)background-color: red; color: white; @endif">{{$data['mobile'][$i]['Portal_Calls_differ']}}</td>

                <td>{{$data['mobile'][$i]['PTB_Calls']}}</td>
                <td>{{$data['mobile'][$i]['KüRü']}}</td>
                <td>{{$data['mobile'][$i]['Orders']}}</td>

                <td>{{$data['mobile'][$i]['SSC-Orders']}}</td>
                <td style="@if($data['mobile'][$i]['SSC-Orders_differ'] > 0) background-color: green; color: white;@elseif($data['mobile'][$i]['SSC-Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data['mobile'][$i]['SSC-Orders_differ']}}</td>

                <td>{{$data['mobile'][$i]['BSC-Orders']}}</td>
                <td style="@if($data['mobile'][$i]['BSC-Orders_differ'] > 0) background-color: green; color: white;@elseif($data['mobile'][$i]['BSC-Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data['mobile'][$i]['BSC-Orders_differ']}}</td>

                <td>{{$data['mobile'][$i]['Portal-Orders']}}</td>
                <td style="@if($data['mobile'][$i]['Portal-Orders_differ'] > 0) background-color: green; color: white;@elseif($data['mobile'][$i]['Portal-Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data['mobile'][$i]['Portal-Orders_differ']}}</td>

              </tr>
              @endfor
            </table>
            <h4><p><b>DSL</b> </p></h4>
            <table style="border: 1px solid black; color: #746e58;text-align:center; font-size: 1.2em">
              <tr>
                <th>Name</th>
                <th>Calls</th>
                <th>+-</th>
                <th>Saves</th>
                <th>+-</th>
                <th>Kürü</th>
              </tr>
              @for($i = 0; $i < count($data['dsl'])-1; $i++)
              <tr style="background-color: @if($i % 2 == 0) #ddf8e8 @else #fefdfa @endif; ">
                <td>{{$data['dsl'][$i]['name']}}</td>

                <td >{{$data['dsl'][$i]['Calls']}}</td>
                <td style="@if($data['dsl'][$i]['Calls_differ'] > 0) background-color: green; color: white; @elseif($data['dsl'][$i]['Calls_differ'] < 0)background-color: red; color: white; @endif">{{$data['dsl'][$i]['Calls_differ']}}</td>

                <td>{{$data['dsl'][$i]['Orders']}}</td>
                <td style="@if($data['dsl'][$i]['Orders_differ'] > 0) background-color: green; color: white; @elseif($data['dsl'][$i]['Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data['dsl'][$i]['Orders_differ']}}</td>

                <td>{{$data['dsl'][$i]['KüRü']}}</td>
              </tr>
              @endfor
            </table>
        </div>
        <hr>
        <div class="" style="background-color: lightblue; color: white; font-size: 1.5em; width: auto;">
          <p><b>DSL CR: {{$data['dslcr']}}</b> </p>
          <hr>
          <p><b>Mobile SSC-CR: {{$data['ssccr']}} </b> </p>
        </div>
    </body>
    <footer>

    </footer>
</html>
