<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>Feierabendmail</title>
        <style>
            *{
                font-family: Calibri, sans-serif;
            }

            .FAM_title{
                border: 1px solid black;
                width: 600px;
                padding: 0.5rem;
                background-color: lightgray;
            }

            .FAM_title p{
                margin: 0;
                font-weight: bold;
            }

            .FAM_content{
                border: 1px solid black;
                width: 600px;
                padding: 0.5rem;
            }

            .FAM_content p{
                margin: 0;
            }

            .FAM_projekt{
                margin-top: 2rem;
                margin-bottom: 2rem;
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
            <p>anbei finden Sie die Feierabendmail vom @if(isset($data['mobile'])) {{Carbon\Carbon::parse($data['mobile']->created_at)->format('d.m.Y')}} @else {{Carbon\Carbon::parse($data['dsl']->created_at)->format('d.m.Y')}} @endif</p>
            @if(isset($data['mobile']))
            <div class="FAM_projekt">
                <div class="FAM_title">
                    <p>Projekt: RT Mobile</p>
                </div>
                <div class="FAM_content">
                    <p class="FAM_ueberschrift">Key Performance Indicator</p>
                    <table>
                        <tr>
                            <th>Bezeichnung</th>
                            <th>SOLL</th>
                            <th>IST</th>
                        </tr>
                        <tr>
                            <td>Krankenquote:</td>
                            <td>5%</td>
                            <td>{{$data['mobile']->krankenquote}}%</td>
                        </tr>
                        <tr>
                            <td>Service Level:</td>
                            <td>80%</td>
                            <td>{{$data['mobile']->servicelevel}}%</td>
                        </tr>
                        <tr>
                            <td>Erreichbarkeit:</td>
                            <td>100%</td>
                            <td>{{$data['mobile']->erreichbarkeit}}%</td>
                        </tr>
                        <tr>
                            <td>Abnahme FHR:</td>
                            <td>100%</td>
                            <td>{{$data['mobile']->abnahme}}%</td>
                        </tr>
                        <tr>
                            <td>IV Erfüllung:</td>
                            <td>28</td>
                            <td>{{$data['mobile']->iv_erfuellung}}</td>
                        </tr>
                        <tr>
                            <td>GeVo CR:</td>
                            <td>46%</td>
                            <td>{{$data['mobile']->gevocr}}%</td>
                        </tr>
                        <tr>
                            <td>SSC CR:</td>
                            <td>50%</td>
                            <td>{{$data['mobile']->ssccr}}%</td>
                        </tr>
                    </table>
                    <p class="FAM_ueberschrift">Service Performance</p>
                    <ol>
                        @foreach($data['mobile']->notes->where('type','service')->values() as $note)
                          <li>{{$note->note}}</li>
                        @endforeach
                    </ol>
                    <p class="FAM_ueberschrift">Sales Performance</p>
                    <ol>
                      @foreach($data['mobile']->notes->where('type','sales')->values() as $note)
                        <li>{{$note->note}}</li>
                      @endforeach
                    </ol>
                    <p class="FAM_ueberschrift">Sonstige Anmerkungen</p>
                    <ol>
                      @foreach($data['mobile']->notes->where('type','others')->values() as $note)
                        <li>{{$note->note}}</li>
                      @endforeach
                    </ol>
                </div>
            </div>
            @endif
            @if(isset($data['dsl']))
            <div class="FAM_projekt">
                <div class="FAM_title">
                    <p>Projekt: RT DSL</p>
                </div>
                <div class="FAM_content">
                    <p class="FAM_ueberschrift">Key Performance Indicator</p>
                    <table>
                        <tr>
                            <th>Bezeichnung</th>
                            <th>SOLL</th>
                            <th>IST</th>
                        </tr>
                        <tr>
                            <td>Krankenquote:</td>
                            <td>9%</td>
                            <td>{{$data['dsl']->krankenquote}}%</td>
                        </tr>
                        <tr>
                            <td>Service Level:</td>
                            <td>80%</td>
                            <td>{{$data['dsl']->servicelevel}}%</td>
                        </tr>
                        <tr>
                            <td>Erreichbarkeit:</td>
                            <td>100%</td>
                            <td>{{$data['dsl']->erreichbarkeit}}%</td>
                        </tr>
                        <tr>
                            <td>Abnahme FHR:</td>
                            <td>100%</td>
                            <td>{{$data['dsl']->abnahme}}%</td>
                        </tr>
                        <tr>
                            <td>IV Erfüllung:</td>
                            <td>28</td>
                            <td>{{$data['dsl']->iv_erfuellung}}</td>
                        </tr>
                        <tr>
                            <td>GeVo CR:</td>
                            <td>39%</td>
                            <td>{{$data['dsl']->iv_erfuellung}}%</td>
                        </tr>
                    </table>
                    <p class="FAM_ueberschrift">Service Performance</p>
                    <ol>
                      @foreach($data['dsl']->notes->where('type','service')->values() as $note)
                        <li>{{$note->note}}</li>
                      @endforeach
                    </ol>
                    <p class="FAM_ueberschrift">Sales Performance</p>
                    <ol>
                      @foreach($data['dsl']->notes->where('type','sales')->values() as $note)
                        <li>{{$note->note}}</li>
                      @endforeach
                    </ol>
                    <p class="FAM_ueberschrift">Sonstige Anmerkungen</p>
                    <ol>
                      @foreach($data['dsl']->notes->where('type','others')->values() as $note)
                        <li>{{$note->note}}</li>
                      @endforeach
                    </ol>
                </div>
            </div>
            @endif
            <p>Dies ist eine systemseitig generierte E-Mail.</p>
        </div>
    </body>
    <footer>

    </footer>
</html>
