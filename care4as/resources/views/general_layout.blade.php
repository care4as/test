<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="de">
<style>

#myVideo {
  position: absolute;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
}
</style>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Care4as Software-Tool</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=yes' name='viewport' />
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
  <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/popper.min.js')}}"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <!-- <script src="{{asset('css/now-ui-dashboard-master/assets/js/demos.js')}}"></script> -->

  <!--     Fonts and icons     -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" /> -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="{{asset('css/now-ui-dashboard-master/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('css/now-ui-dashboard-master/assets/css/now-ui-dashboard.css?v=1.5.0')}}" rel="stylesheet" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="{{asset('css/now-ui-dashboard-master/assets/demo/demo.css')}}" rel="stylesheet" /> -->
  <link href="{{asset('css/main.css')}}" rel="stylesheet" />
  @yield('additional_css')
</head>
<body class="bg-primary">

  <!-- <div class="toggler">
    <button type="button" name="button" class="unit-translucent" onclick="toggleMobileMenu()" style="">Menu</button>
  </div> -->

  <div class="wrapper ">
    <div class="sidebar " id='sidebar'>
      <div class="sidebar-wrapper bg-primary2" id="sidebar-wrapper" style="height: 100%">
        @php
          Auth()->user()->getRights();
        @endphp
        <div id="time-container" style="width: 100%">

        </div>
        <ul class="nav" style="margin-bottom: 15px;">
          <li><div class="logo bg-white m-2" style="border-radius: 20px;">
            <a href="text-muted" class="simple-text logo-normal">
              <img src="{{asset('images/Logo_Care4as_2 - Kopie.png')}}" alt="" style="max-width: 100%; margin-top: 10px; height: 12%">
            </a>
          </div>
        </li>
          <!-- Dashboard -->
          @if(in_array('dashboard',Auth()->user()->getRights()))
          <li class="">
            <a @if(Auth::User()->department == 'Agenten') href="{{route('dashboard')}} @else href="{{route('dashboard.admin')}}@endif">
              <i class="fas fa-table"></i>
              <p><b>Dashboard</b></p>
            </a>
          </li>
          @endif

          @if(in_array('write_memos',Auth()->user()->getRights()))
          <li class="">
            <a class="" data-toggle="collapse" href="#collapseMemoranda" role="button" aria-expanded="false" aria-controls="collapseMemoranda">
              <i class="fas fa-pen"></i>
              <p><b>Memoranda</b></p>
            </a>
            <div class="collapse" id="collapseMemoranda" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                @if(1)
                  <li><a href="{{route('memo.create')}}">

                    Memoranda verfassen</a>
                  </li>
                @endif
            </div>
          </li>
          @endif

          <!-- Mitarbeiterverwaltung -->
          @if(in_array('users_base',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseUser" role="button" aria-expanded="false" aria-controls="collapseUser">
              <i class="fas fa-users"></i>
              <p><b>Mitarbeiter</b></p>
            </a>
            <div class="collapse" id="collapseUser" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                @if(in_array('users_userlist',Auth()->user()->getRights()))
                  <li><a href="{{route('userlist')}}">Mitarbeiterliste</a></li>
                @endif
                <!-- {{-- @if(in_array('createUser',Auth()->user()->getRights()))
                  <li><a href="{{route('user.create')}}">User anlegen</a></li>
                  @if(Auth()->user()->role == "superadmin")
                    <li><a href="{{route('user.startEnd')}}">MA Daten</a></li>
                  @endif
                @endif
                  <li><a href="{{route('user.index')}}">User Index</a></li> --}} -->
              </ul>
            </div>
          </li>
          @endif
          <!-- 1u1 DSL Retention -->
          @if(in_array('1u1_dsl_base',Auth()->user()->getRights()))
            <li>
              <a class="" data-toggle="collapse" href="#collapse1u1DslRet" role="button" aria-expanded="false" aria-controls="collapseCancel">
                <i class="fas fa-project-diagram"></i>
                <p><b>1u1 DSL Ret</b></p>
              </a>
              <div class="collapse" id="collapse1u1DslRet" style="margin-left:50px;">
                <ul class="list-group list-group-flush" style="list-style-type: none;">
                @if(in_array('1u1_db',Auth()->user()->getRights()))
                  <li><a href="{{route('1u1_deckungsbeitrag')}}">Deckungsbeitrag</a></li>
                  <li><a href="{{route('feedback.showfeedback')}}">Feedbackgespräche</a> </li>
                  <li><a href="{{route('dsl.tracking.agents',['department' => 2])}}">Tracking DSL</a> </li>
                @endif
              </ul>
            </li>
          @endif
          <!-- 1u1 Mobile Retention -->
          @if(in_array('1u1_mobile_base',Auth()->user()->getRights()))
            <li>
              <a class="" data-toggle="collapse" href="#collapse1u1MobileRet" role="button" aria-expanded="false" aria-controls="collapseCancel">
                <i class="fas fa-project-diagram"></i>
                <p><b>1u1 Mobile Ret</b></p>
              </a>
              <div class="collapse" id="collapse1u1MobileRet" style="margin-left:50px;">
                <ul class="list-group list-group-flush" style="list-style-type: none;">
                  @if(in_array('1u1_db',Auth()->user()->getRights()))
                  <li><a href="{{route('1u1_deckungsbeitrag')}}">Deckungsbeitrag</a></li>
                  <li><a href="{{route('mobileTrackingDifference')}}">Tracking Differenz</a></li>
                  <li><a href="{{route('feedback.showfeedback')}}">Feedbackgespräche</a> </li>
                  <li><a href="{{route('mobile.tracking.admin')}}">Mobile Tracking Admin</a></li>
                  @endif
                  <li><a href="{{route('mobile.tracking.agents')}}">Mobile Tracking</a></li>
              </ul>
            </li>
          @endif
          <!-- Telefonica -->
          @if(in_array('telefonica_base',Auth()->user()->getRights()))
            <li>
              <a class="" data-toggle="collapse" href="#collapseTelefonica" role="button" aria-expanded="false" aria-controls="collapseCancel">
                <i class="fas fa-project-diagram"></i>
                <p><b>Telefonica</b></p>
              </a>
              <div class="collapse" id="collapseTelefonica" style="margin-left:50px;">
                <ul class="list-group list-group-flush" style="list-style-type: none;">
                <li><a href="{{route('pausetool')}}">Pausentool</b></a></li>
              </ul>
            </li>
          @endif
          <!-- Controlling -->
          @if(in_array('controlling_base',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseControlling" role="button" aria-expanded="false" aria-controls="collapseControlling">
              <i class="fas fa-file-contract"></i>
              <p><b>Controlling</b></p>
            </a>
            <div class="collapse" id="collapseControlling" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                @if(in_array('controlling_revenuereport',Auth()->user()->getRights()))
                  <li><a href="{{route('umsatzmeldung')}}">Umsatzmeldung</a></li>
                @endif
                @if(in_array('controlling_projectreport',Auth()->user()->getRights()))
                  <li><a href="{{route('projectReport')}}">Projektmeldung</a></li>
                @endif
                @if(in_array('controlling_attainment',Auth()->user()->getRights()))
                  <li><a href="{{route('attainment')}}">Bonusauswertung</a></li>
                @endif
              </ul>
            </div>
          </li>
          @endif
          @if(in_array('it_base',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseInventory" role="button" aria-expanded="false" aria-controls="collapseInventory">
              <i class="fas fa-server"></i>
              <b>IT</b>
            </a>
            <div class="collapse" id="collapseInventory" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                @if(in_array('it_scrum',Auth()->user()->getRights()))
                  <li><a href="{{route('scrum.itkanbanboard')}}">Scrum</a> </li>
                @endif
                @if(in_array('it_inventory',Auth()->user()->getRights()))
                  <li><a href="{{route('inventory.list')}}">HW Liste</a> </li>
                  <li><a href="{{route('inventory.add')}}">HW hinzufügen</a> </li>
                @endif
              </ul>
            </div>
          </li>
          @endif

          <!-- {{-- Alter Link zu DB
          @if(in_array('statistics',Auth()->user()->getRights()))
          <li>
            <a class="" href="{{route('1u1_deckungsbeitrag')}}">
              <i class="far fa-file-powerpoint"></i>
              <p><b>DB1</b></p>
            </a>
          </li>
          @endif
          -->
          <!-- @if(in_array('indexMabel',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseMable" role="button" aria-expanded="false" aria-controls="collapseUser">
              <i class="fas fa-hammer"></i>
              <p><b>Mabelgründe</b></p>
            </a>
            <div class="collapse" id="collapseMable" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                  <li><a href="{{route('mabelcause.create')}}">Mabelgrund aufnehmen</a></li>
                  <li><a href="{{route('mabelcause.index')}}">alle Mabelgründe</a></li>
              </ul>
            </div>
          </li>
          @endif --}} -->
          @if(in_array('reports_base',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseReport" role="button" aria-expanded="false" aria-controls="collapseCancel">
              <i class="fas fa-upload"></i>
              <p><b>Daten Import</b></p>
            </a>
            <div class="collapse" id="collapseReport" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                @if(in_array('reports_import',Auth()->user()->getRights()))
                <li><a href="{{route('reportImport')}}">Report Übersicht</a></li>
                <li><a href="{{route('reports.report')}}">Retention Details Report</a></li>

                <li><a href="{{route('reports.gevotracking')}}">GeVo Tracking Import</a></li>
                <li><a href="{{route('reports.reportHours.view')}}">Stundenreport</a></li>
                <li><a href="{{route('ssetracking.view')}}">SSE Tracking Import</a></li>
                  <!-- {{--
                <li><a href="{{route('excel.dailyAgent.import')}}">Daily Agent Import</a></li>
                <li><a href="{{route('reports.provision.view')}}">Provision</a></li>
                <li><a href="{{route('reports.SAS')}}">SAS Import</a></li>
                <li><a href="{{route('reports.OptIn')}}">OptIn Import</a></li>
                --}} -->
                <li><a href="{{route('reports.nettozeiten')}}">Nettozeiten Import</a></li>
                @endif
              </ul>
            </div>
          </li>
          @endif
          <!-- {{-- @if(in_array('importReports',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseEmail" role="button" aria-expanded="false" aria-controls="collapseCancel">
            <i class="fas fa-mail-bulk"></i>
              <p><b>Email Versand</b></p>
            </a>
            <div class="collapse" id="collapseEmail" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                <li><a href="{{route('eobmail')}}">Feierabendmail </a></li>
              <li><a href="">Top/Worst Report</a></li>
              </ul>
            </div>
          </li>
          @endif
          @if(in_array('indexSurvey',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseSurvey" role="button" aria-expanded="false" aria-controls="collapseSurvey">
              <i class="fas fa-poll-h"></i>
              <p><b>Mitarbeiterumfragen</b></p>
            </a>
            <div class="collapse" id="collapseSurvey" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                @if(Auth()->user()->role == 'overhead' or Auth()->user()->role == 'superadmin')
                <li><a href="{{route('question.create')}}">Frage erstellen</a></li>
                <li><a href="{{route('surveys.index')}}">Mitarbeiterumfragen Index</a></li>
                <li><a href="{{route('survey.create')}}">Mitarbeiterumfrage erstellen</a></li>
                <li><a href="{{route('reports.report')}}">Mitarbeiterumfrage auswerten</a></li>
                @else
                  <li><a href="{{route('survey.attend')}}">an der Mitarbeiterumfrage teilnehmen</a></li>
                @endif
              </ul>
            </div>
          </li>
          @endif -->
          <!-- @if(in_array('indexFeedback',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseFeedback" role="button" aria-expanded="false" aria-controls="collapseFeedback">
              <i class="far fa-comments"></i>
              <p><b>Feedbackgespräche</b></p>
            </a>
            <div class="collapse" id="collapseFeedback" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
              <li><a href="{{route('feedback.print')}}">Feedbackgespräche zum Ausdrucken</a> </li>
              <li><a href="{{route('feedback.view')}}">Feedbackgespräche zum Speichern</a> </li>
              <li><a href="{{route('feedback.myIndex')}}">geführte Feedbackgespräche</a> </li>
            </ul>
            </div>
          </li>
          @endif --}} -->
          @if(in_array('reports_send',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseReports" role="button" aria-expanded="false" aria-controls="collapseFeedback">
              <i class="material-icons">
                assessment
              </i>
              <b>Reporte</b>
            </a>
            <div class="collapse" id="collapseReports" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                <li><a href="{{route('reports.choose')}}">Top/Worst Report</a> </li>
                <li><a href="{{route('report.joyce')}}">Joyce Report</a> </li>
                <li><a href="{{route('reports.AHTdaily')}}">AHT Report</a> </li>
                <li><a href="{{route('reports.capacitysuite')}}">Capacity Report </a> </li>
                <li><a href="{{route('user.daDetex.index')}}">Nachverfolgung Dailyagent</a></li>
              </ul>
            </div>
          </li>
          @endif
          <!-- {{-- @if(in_array('1u1_deckungsbeitrag',Auth()->user()->getRights()))
            <li>
            <a class="" href="{{route('1u1_deckungsbeitrag')}}">
              <i class="far fa-file-powerpoint"></i>
              <p><b>Präsentation</b></p>
            </a>
          </li>
          @endif -->

          <!-- @if(in_array('changeConfig',Auth()->user()->getRights()))
          <li class="">
            <a class="" data-toggle="collapse" href="#collapseConfiguration" role="button" aria-expanded="false" aria-controls="collapseFeedback">
              <i class="material-icons">
                brightness_high
              </i>
              <b>Konfiguration</b>
            </a>
            <div class="collapse" id="collapseConfiguration" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
              <li><a href="{{route('roles.index')}}">Rollen</a> </li>
              <li><a href="{{route('feedback.view')}}">Rollen und Rechte</a> </li>
              <li><a href="{{route('config.view')}}">allgemeine Einstellungen</a> </li>
            </ul>
            </div>
          </li>
          @endif --}} -->
          @if(in_array('config_base',Auth()->user()->getRights()))
          <li class="">
            <a class="" data-toggle="collapse" href="#collapseConfiguration" role="button" aria-expanded="false" aria-controls="collapseFeedback">
              <i class="material-icons">
                brightness_high
              </i>
              <b>Konfiguration</b>
            </a>
            <div class="collapse" id="collapseConfiguration" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
              @if(in_array('config_create_role',Auth()->user()->getRights()))
                <li><a href="{{route('roles.index')}}">Rollen</a> </li>
              @endif
              <!-- {{--
              <li><a href="{{route('feedback.view')}}">Rollen und Rechte</a> </li>
              --}} -->
              <li><a href="{{route('config.view')}}">allgemeine Einstellungen</a> </li>
            </ul>
            </div>
          </li>
          @endif
          <!-- {{-- @if(in_array('trainings',Auth()->user()->getRights()))
          <li>
            <a class="" data-toggle="collapse" href="#collapseTrainings" role="button" aria-expanded="false" aria-controls="collapseFeedback">
              <i class="fas fa-running"></i>
              <p><b>Trainings</b></p>
            </a>
            <div class="collapse" id="collapseTrainings" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
              <li><a href="{{route('trainings')}}">Angebots Simulator</a> </li>
              @if(Auth()->user()->role != 'Agent')
                <li><a href="{{route('offers.create')}}">Angebote einspielen</a> </li>
              @endif
              <li><a href="{{route('feedback.myIndex')}}">geführte Feedbackgespräche</a> </li>
            </ul>
          </li>
          @endif -->
          <!-- @if(in_array('telefonicapause',Auth()->user()->getRights()))
          <li>
           <a class="" data-toggle="collapse" href="#collapseTelefonicaPause" role="button" aria-expanded="false" aria-controls="collapseFeedback">
            <a href="{{route('pausetool')}}">
              <i class="fas fa-running"></i>
              <p><b>Pausentool <br>Telefonica</b></p>
            </a>
          </li>
          @endif --}} -->

        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel" style="z-index: 500;">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute" id="navbar_max" style="box-shadow: black 1em 0px 1em -1em inset; height: 66.5px; z-index: 500;">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-collapse justify-content-end" id="navigation">
              <ul class="navbar-nav">
                <li class="nav-item" onclick="toggleNewSidebar()" onmouseover="mouseoverNewSidebar()" onmouseout="mouseoutNewSidebar()" id="newSidebarToggler">
                  <a class="nav-link" href="#pablo" id="linkNewSidebar">
                  <i class="now-ui-icons design_bullet-list-67" id="hoverNewSidebarToggler"></i>
                </a>
              </ul>
            </div>
          </div>
          <div id="pagetitle" style="font-weight: bold; color: white;">@yield("pagetitle")</div>
          <div class="navbar-wrapper">
          <!--<input type="checkbox" id="hamburg" onclick="showSidebar()">
              <label for="hamburg" class="hamburg">
                  <span class="line"></span>
                  <span class="line"></span>
                  <span class="line"></span>
              </label>
            </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button> -->
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <!--<form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form> -->
            <ul class="navbar-nav">
              <!--<li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">test1</a>
                  <a class="dropdown-item" href="#">test2</a>
                  <a class="dropdown-item" href="#">test3</a>
                </div>
              </li> -->
              <!-- <li class="nav-item dropdown m-2">
                <div class="row">
                    <a href="#" class="nav-link" onclick="showWTConsole()"><i class="fas fa-stopwatch fa-2x"></i></a>
                </div>
              </li>
              <li class="nav-item dropdown m-2" > -->
              <li class="nav-item dropdown center_items text-white mr-4" style="margin-right: 10px;cursor: pointer;">
                <a href="{{route('dashboard')}} " class="center_items">
                  <i class="far fa-bell" style="font-size: 1.5em !important;"></i>
                  <span class="badge badge-success" id="news"></span>
                  </a>
              </li>
              @if(in_array('controlling_base',Auth()->user()->getRights()))
              <?php $dataTables = \DB::table('datatables_timespan')->get() ?>
              <li class="nav-item dropdown" style="margin-right: 10px; cursor: pointer;">
                <a class="nav-link dropdown-toggle" id="dataDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i style="font-size: 25px; top: 4px; position: relative;" class="fas fa-tasks"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <div class="d-flex justify-content-center">
                    <p class="">Datenstand</p>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="dropdown-item" style="display: flex; justify-content: space-between;">
                    <div>
                      Vollständig:
                    </div>
                    <div style="margin-left: 5px;">
                      {{date('d.m.Y', strtotime($dataTables->max('min_date')))}} - {{date('d.m.Y', strtotime($dataTables->min('max_date')))}}
                    </div>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="dropdown-item" style="display: flex; justify-content: space-between;">
                    <div>
                      @if($dataTables->where('data_table', 'availbench_report')->min('max_date') && strtotime(date('Y-m-d', strtotime(' -1 day'))) == strtotime($dataTables->where('data_table', 'availbench_report')->min('max_date')))
                        <i class="fas fa-check-circle"></i>
                      @else
                        <i class="fas fa-times-circle"></i>
                      @endif
                      Availbench:
                    </div>
                    <div style="margin-left: 5px;">
                      <!-- @if($dataTables->where('data_table', 'availbench_report')->min('min_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'availbench_report')->min('min_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                      - -->
                      @if($dataTables->where('data_table', 'availbench_report')->min('max_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'availbench_report')->min('max_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                    </div>
                  </div>
                  <!-- Daily Agent -->
                  <div class="dropdown-item" style="display: flex; justify-content: space-between;">
                    <div>
                      @if($dataTables->where('data_table', 'dailyAgent_report')->min('max_date') && strtotime(date('Y-m-d', strtotime(' -1 day'))) == strtotime($dataTables->where('data_table', 'dailyAgent_report')->min('max_date')))
                        <i class="fas fa-check-circle"></i>
                      @else
                        <i class="fas fa-times-circle"></i>
                      @endif
                      Daily Agent:
                    </div>
                    <div style="margin-left: 5px;">
                      <!-- @if($dataTables->where('data_table', 'dailyAgent_report')->min('min_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'dailyAgent_report')->min('min_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                      - -->
                      @if($dataTables->where('data_table', 'dailyAgent_report')->min('max_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'dailyAgent_report')->min('max_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                    </div>
                  </div>
                  <!-- OptIn -->
                  <div class="dropdown-item" style="display: flex; justify-content: space-between;">
                    <div>
                      @if($dataTables->where('data_table', 'optin_report')->min('max_date') && strtotime(date('Y-m-d', strtotime(' -1 day'))) == strtotime($dataTables->where('data_table', 'optin_report')->min('max_date')))
                        <i class="fas fa-check-circle"></i>
                      @else
                        <i class="fas fa-times-circle"></i>
                      @endif
                      OptIn:
                    </div>
                    <div style="margin-left: 5px;">
                      <!-- @if($dataTables->where('data_table', 'optin_report')->min('min_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'optin_report')->min('min_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                      - -->
                      @if($dataTables->where('data_table', 'optin_report')->min('max_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'optin_report')->min('max_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                    </div>
                  </div>
                  <!-- RET Details -->
                  <div class="dropdown-item" style="display: flex; justify-content: space-between;">
                    <div>
                      @if($dataTables->where('data_table', 'details_report')->min('max_date') && strtotime(date('Y-m-d', strtotime(' -1 day'))) == strtotime($dataTables->where('data_table', 'details_report')->min('max_date')))
                        <i class="fas fa-check-circle"></i>
                      @else
                        <i class="fas fa-times-circle"></i>
                      @endif
                      Ret Details:
                    </div>
                    <div style="margin-left: 5px;">
                      <!-- @if($dataTables->where('data_table', 'details_report')->min('min_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'details_report')->min('min_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                      - -->
                      @if($dataTables->where('data_table', 'details_report')->min('max_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'details_report')->min('max_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                    </div>
                  </div>
                  <!-- SaS -->
                  <div class="dropdown-item" style="display: flex; justify-content: space-between;">
                    <div>
                      @if($dataTables->where('data_table', 'sas_report')->min('max_date') && strtotime(date('Y-m-d', strtotime(' -1 day'))) == strtotime($dataTables->where('data_table', 'sas_report')->min('max_date')))
                        <i class="fas fa-check-circle"></i>
                      @else
                        <i class="fas fa-times-circle"></i>
                      @endif
                      SaS:
                    </div>
                    <div style="margin-left: 5px;">
                      <!-- @if($dataTables->where('data_table', 'sas_report')->min('min_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'sas_report')->min('min_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                      - -->
                      @if($dataTables->where('data_table', 'sas_report')->min('max_date') != null)
                        <td>{{date('d.m.Y', strtotime($dataTables->where('data_table', 'sas_report')->min('max_date')))}}</td>
                      @else
                        <td>%</td>
                      @endif
                    </div>
                  </div>
                </div>
              </li>
              @endif
              <li class="nav-item dropdown" style="cursor: pointer;">
                <a class="nav-link dropdown-toggle" id="userDropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block"> </span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <div class="d-flex justify-content-center">
                    <p class="">{{Auth::user()->name}}</p>
                  </div>
                  <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Profileinstellungen</a>
                    <a class="dropdown-item" href="{{route('user.changePasswort.view')}}">Passwort ändern</a>
                    <a class="dropdown-item" href="{{route('user.logout')}}">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-lg" style="min-height: 100vh;">
        <!-- <canvas id="bigDashboardChart"></canvas> -->
        <!-- "Overflow-y: auto" entfernt. Overflow sollte in column-container stattfinden -->
        <div class="content bg-cool" style="position: relative; height: calc(100vh - 66.5px); margin-top: 66.5px; box-shadow: black 0em 1em 1em -1em inset; overflow-y: auto; overflow-x: hidden;">

        <!-- <video autoplay muted loop id="myVideo">
          <source src="{{asset('videos/OMSBG12.mov')}}" type="video/mp4">
        </video> -->

        @yield('content')
        </div>
        <!-- <div class="container bg-white">
          @if($errors->any())
          {{$errors->first()}}
          @endif
        </div> -->
      </div>
      <footer class="footer">
      </footer>
    </div>
  </div>

  @yield('additional_modal')
  <div class="modal show" id="errorModal" role="dialog" aria-labelledby="exampleModalLabel" style="overflow:hidden;">
    <div class="modal-dialog">
      <div class="modal-content bg-danger text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Error</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        {{$errors->first()}}
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-info text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">News</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <a class="text-white" href="#">Es gibt Neuigkeiten</a>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="failModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content bg-danger text-white" >
        <div class="modal-body">
          <h5>&#128577;&#128580;&#128560; Fehler aufgetreten &#128577;&#128580;&#128560;</h5>
          <p id="failFile"></p>
          <p id="failLine"></p>
          <p id="failContent"></p>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-success text-white" >
        <div class="modal-body">
          <h5>Triumph!</h5>
          <p id="smodaltext">Die Datei wurde erfolgreich hochgeladen &#129321;&#129321;&#129321;</p>
          <!-- <p id="smodaltext"></p> -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- <div class="" id="worktimeconsole">
  <timetracker> </timetracker>
</div> -->
</div>
</div>

  <!--   Core JS Files   -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>
  <!-- <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/bootstrap.min.js')}}"></script> -->
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
  <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script> -->
  <script src='bootstrap.bundle.min.js'></script>
  <!-- Chart JS -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/assets/js/plugins/chartjs.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript')}}"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{asset('js/app.js')}}"></script>

  <script type="text/javascript">

  function showWTConsole() {
    $('#worktimeconsole').toggle()

  }
  </script>
  @if($errors->any())
    <script>
      $('#errorModal').modal('show');
    </script>
  @endif
  <script>
    let host = window.location.host;
    // axios.get('http://'+host+'/care4as/care4as/public/memo/checkMeMos/')
    axios.get('http://'+host+'/memo/checkMeMos/')
    .then(response => {

      if(response.data > 0)
      {
        $('#news').html(response.data)
        $('#news').css('display','flex')
      }
      else {

        $('#news').css('display','none')
      }
    })
    .catch(function (err) {
      console.log('error Memocheck')
      console.log(err.response);
    });

    setInterval(function()
    {
      let host = window.location.host;
      // axios.get('http://'+host+'/care4as/care4as/public/memo/checkMeMos/')
      axios.get('http://'+host+'/memo/checkMeMos/')
      .then(response => {

        if(response.data > 0)
        {
          $('#news').html(response.data)
          $('#news').css('display','flex')
        }
        else {

          $('#news').css('display','none')
        }


      })
      .catch(function (err) {
        console.log('error Memocheck')
        console.log(err.response);
      });
    }, 1000*300);


    </script>

  @yield('additional_js')
</body>

</html>
