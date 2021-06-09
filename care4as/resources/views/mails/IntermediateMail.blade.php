<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>automatisierter Zwischenstandsreport</title>
    </head>
    <body>
      <p>Sehr geehrte Damen und Herren, <br>
        Zwischenstand: {{$data['date']}}</p>
        <div class=""
        style="
          background: rgb(246,93,117);
          background: radial-gradient(circle, rgba(246,93,117,0.8211485277704832) 25%, rgba(188,36,60,0.75672275746236) 76%, rgba(204,24,52,1) 95%);
          color: white;
          font-size: 1.5em;
          width: auto;
          width: 25%;"
          >

          @if($data['isMobile'])
            <p style="text-align:left;"><b>Mobile SSC-CR: {{$data['ssccr']}}% | @if($data['bsccr']) BSC-CR: {{$data['bsccr']}}% @else Fehler BSC CR @endif| Portal-CR: @if($data['portalcr']) {{$data['portalcr']}}% @else Fehler Portal-CR @endif</b></p>
          @else

          <p style="text-align:left;"><b>DSL-CR: {{$data['dslcr']}}%</b></p>
        @endif
        </div>
        <div class="">
          @if($data['isMobile'])
            <h4><p><b>Mobile</b> </p> </h4>
            <table style="border: 1px solid black; color: #746e58;text-align:center; font-size: 1.2em">
              <tr>
                <th>Name</th>
                <th>SSC-GeVo-CR</th>
                <th>+-</th>
                <th>SSC Calls</th>
                <th>+-</th>
                <th>SSC-Saves</th>
                <th>+-</th>
                <th>BSC-GeVo CR</th>
                <th>Portal-GeVo CR</th>
                <th>Calls</th>
                <th>+-</th>
              </tr>
              @for($i = 0; $i < count($data['mobile']); $i++)
              <tr style="background-color: @if($i % 2 == 0) #D3D3D3 @else #fefdfa @endif; ">
                <td>{{$data['mobile'][$i]['name']}}</td>
                <td>{{$data['mobile'][$i]['SSC-CR']}}%</td>
                <td style="@if($data['mobile'][$i]['SSC-CR_diff'] > 0)color: grey; font-weight: 900;@elseif($data['mobile'][$i]['SSC-CR_diff'] < 0)color: red;font-weight: 900; @endif">{{$data['mobile'][$i]['SSC-CR_diff']}}</td>
                <td>{{$data['mobile'][$i]['SSC_Calls']}}</td>
                <td style="@if($data['mobile'][$i]['SSC_Calls_differ'] > 0)color: grey; font-weight: 900; @elseif($data['mobile'][$i]['SSC_Calls_differ'] < 0)color: red;font-weight: 900; @endif" >{{$data['mobile'][$i]['SSC_Calls_differ']}}</td>
                <td>{{$data['mobile'][$i]['SSC-Orders']}}</td>
                <td style="@if($data['mobile'][$i]['SSC-Orders_differ'] > 0) color: grey; font-weight: 900; @elseif($data['mobile'][$i]['SSC-Orders_differ'] < 0)color: red;font-weight: 900; @endif">{{$data['mobile'][$i]['SSC-Orders_differ']}}</td>
                <td>{{$data['mobile'][$i]['BSC_CR']}}%</td>
                <td>{{$data['mobile'][$i]['PortalCR']}}%</td>
                <td>{{$data['mobile'][$i]['Calls']}}</td>
                <td>{{$data['mobile'][$i]['Calls_differ']}}</td>
              </tr>
              @endfor
            </table>
            @else
            <h4><p><b>DSL</b> </p></h4>
            <table style="border: 1px solid black; color: #746e58;text-align:center; font-size: 1.2em">
              <tr>
                <th>Name</th>
                <th>CR</th>
                <th>+-</th>
                <th>Calls</th>
                <th>+-</th>
                <th>Saves</th>
                <th>+-</th>
                <th>Kürü</th>
              </tr>

              @for($i = 0; $i < count($data['dsl'])-1; $i++)
              <tr style="background-color: @if($i % 2 == 0) #ddf8e8 @else #fefdfa @endif; ">

                <td>{{$data['dsl'][$i]['name']}}</td>
                <td>{{$data['dsl'][$i]['dslcr']}}%</td>
                <td style="@if($data['dsl'][$i]['dslcr_differ'] > 0) background-color: green; color: white;@elseif($data['dsl'][$i]['dslcr_differ'] < 0)background-color: red; color: white; @endif">{{$data['dsl'][$i]['dslcr_differ']}}</td>
                <td >{{$data['dsl'][$i]['Calls']}}</td>
                <td style="@if($data['dsl'][$i]['Calls_differ'] > 0) background-color: green; color: white; @elseif($data['dsl'][$i]['Calls_differ'] < 0)background-color: red; color: white; @endif">{{$data['dsl'][$i]['Calls_differ']}}</td>

                <td>{{$data['dsl'][$i]['Orders']}}</td>
                <td style="@if($data['dsl'][$i]['Orders_differ'] > 0) background-color: green; color: white; @elseif($data['dsl'][$i]['Orders_differ'] < 0)background-color: red; color: white; @endif">{{$data['dsl'][$i]['Orders_differ']}}</td>

                <td>{{$data['dsl'][$i]['KüRü']}}</td>
              </tr>
              @endfor
            </table>
          @endif
        </div>
        <hr>

    </body>
    <footer>

    </footer>
</html>
