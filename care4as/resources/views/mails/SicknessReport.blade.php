<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>Agentenreport</title>
        <style>
            *{
                font-family: Calibri, sans-serif;
                Margin: 5px;
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
                width: auto;
                padding: 5px;
            }

              th, td
              {
                font-size: 1.15vw;
                text-align: center;
                margin: 0;
                border: 1px solid black;
                border-collapse: collapse;
                color: #746e58;
                white-space: nowrap;

              }
        </style>
    </head>
    <body>
        <div class="FAM_container">
            <p>Sehr geehrte Damen und Herren,</p>
            <p>anbei erhalten Sie die Krankendaten</p>

            <div class="FAM_projekt">
                <div class="FAM_title">
                    <p></p>
                </div>
                <div class="FAM_content" >
                  <div class="" style="margin: 5px;">
                    <p><b>Index</b></p>
                    <table >
                      <thead>
                        <tr>
                          <td>name</td>
                          <td>heute</td>
                          <td>morgen</td>
                          <td>Art</td>
                          <td>Kommentar</td>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data as $user)
                        <tr>
                          <td>{{$user->agent_id}}</td>
                          <td>X</td>
                          <td>@if(Carbon\Carbon::createFromFormat('Y-m-d', $user->date_end) > Carbon\Carbon::today()->addDays(1))X @endif</td>
                          <td>@if($user->state_id == 1) krank @elseif($user->state_id == 8) krank??? @elseif($user->state_id == 13) Krank o.Lfz  @elseif($user->state_id == 14)unbezahlt Krank @endif</td>
                          <td>{{$user->history_notes}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

            <p>Dies ist eine automatisch generierte E-Mail.</p>
        </div>
    </body>
    <footer>

    </footer>
</html>
