<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>Agentenreport</title>
        <style>
            *{
                font-family: Calibri, sans-serif;
            }

            .FAM_title{
                border: 1px solid black;
                width: 100%;
                padding: 0.5rem;
                background-color: lightgray;
            }

            .FAM_title p{
                margin: 0;
                font-weight: bold;
            }

            .FAM_content{
                border: 1px solid black;
                width: 100%;
                padding: 0.5rem;
            }

            .FAM_content p{
                margin: 0;
            }

            .FAM_projekt{
                margin-top: 2rem;
                margin-bottom: 2rem;
                width: 75%;
            }

            .FAM_ueberschrift{
                font-weight: bold;
                padding-top: 2rem;
            }

            .FAM_content ul{
               margin: 0;
            }

            .FAM_content .FAM_ueberschrift:first-child{
                padding-top: 0;
            }

            .FAM_content table{
                border-collapse: collapse;
            }

            .FAM_content table, th, td{
                border: 1px solid black;
            }

            .FAM_content th{
                width: 60px;
            }

            .FAM_content th:first-child{
                width: auto;
            }

            .FAM_content tr td:first-child{
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                text-align: right;
            }

            .FAM_content tr td{
                text-align: center;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

        </style>
    </head>
    <body>
        <div class="FAM_container">
            <p>Sehr geehrte Damen und Herren,</p>
            <p>anbei finden Sie den Report über die 3 besten/schlechtesten Agents im Zeitraum vom <b>{{Carbon\Carbon::parse($data['from'])->format('d.m.Y')}}</b> bis zum <b>{{Carbon\Carbon::parse($data['to'])->format('d.m.Y')}}</b></p>
            <div class="FAM_projekt">
                <div class="FAM_title">
                    <p>@if($data['best'] > 1) {{$data['best']}} Beste Agents @else Bester Agent @endif</p>
                </div>
                <div class="FAM_content">
                    <table >
                      <thead>
                        <tr>
                          <td>Agent</td>
                          <td>CR</td>
                        </tr>
                      </thead>
                      @foreach($data['bestusers'] as $user)
                        <tr>
                          <td>{{$user['name']}}</td>
                          <td>{{round($user['performance'],2)}}%</td>
                        </tr>
                      @endforeach
                    </table>
                    <!-- {{$data['bestusers'][0]}} -->
                    @foreach($data['bestusers'] as $user)
                      <p class="FAM_ueberschrift">{{$user['name']}}</p>
                        <table style="width: 100%;  overflow-y: scroll;  display: block;">
                          <thead>
                            <tr>
                              <td>Tag</td>
                              @foreach($user['dailyPerformance'] as $date)
                              <td>{{Carbon\Carbon::parse($date['call_date'])->format('d.m')}}</td>
                              @endforeach
                            </tr>
                            <tr>
                              <td>CR</td>
                              @foreach($user['dailyPerformance'] as $date)
                              <td>{{round(($date['orders'] / $date['calls'])*100,2)}}%</td>
                              @endforeach
                            </tr>
                          </thead>
                        </table>
                    @endforeach
                </div>
            </div>
            <div class="FAM_projekt">
                <div class="FAM_title">
                    <p>@if($data['worst'] > 1) {{$data['worst']}} Schlechteste Agents @else Schlechtester Agent @endif</p>
                </div>
                <div class="FAM_content">
                  <table >
                    <thead>
                      <tr>
                        <td>Agent</td>
                        <td>CR</td>
                      </tr>
                    </thead>
                    @foreach($data['worstusers'] as $user)
                      <tr>
                        <td>{{$user['name']}}</td>
                        <td>{{round($user['performance'],2)}}%</td>
                      </tr>
                    @endforeach
                  </table>
                  @foreach($data['worstusers'] as $user)
                    <p class="FAM_ueberschrift">{{$user['name']}}</p>
                      <table style="width: 100%;  overflow-y: scroll;  display: block;">
                        <thead>
                          <tr>
                            <td>Tag</td>
                            @foreach($user['dailyPerformance'] as $date)
                            <td>{{Carbon\Carbon::parse($date['call_date'])->format('d.m')}}</td>
                            @endforeach
                          </tr>
                          <tr>
                            <td>CR</td>
                            @foreach($user['dailyPerformance'] as $date)
                            <td>{{round(($date['orders'] / $date['calls'])*100,2)}}%</td>
                            @endforeach
                          </tr>
                        </thead>
                      </table>
                  @endforeach
              </div>
            </div>
          </div>
            <p>Dies ist eine systemseitig generierte E-Mail.</p>
        </div>
    </body>
    <footer>

    </footer>
</html>
