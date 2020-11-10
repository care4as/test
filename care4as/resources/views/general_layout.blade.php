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
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>{{ config('app.name', 'Care4as') }}</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=yes' name='viewport' />
  <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/popper.min.js')}}"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <!-- <script src="{{asset('css/now-ui-dashboard-master/assets/js/demos.js')}}"></script> -->

  <!--     Fonts and icons     -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" /> -->
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
  <!-- CSS Files -->
  <link href="{{asset('css/now-ui-dashboard-master/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('css/now-ui-dashboard-master/assets/css/now-ui-dashboard.css?v=1.5.0')}}" rel="stylesheet" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="{{asset('css/now-ui-dashboard-master/assets/demo/demo.css')}}" rel="stylesheet" /> -->
  <link href="{{asset('css/main.css')}}" rel="stylesheet" />
  @yield('additional_css')
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="" class="simple-text logo-normal">
          <img src="{{asset('images/Logo_Care4as_2 - Kopie.png')}}" alt="" style="max-width: 190px; margin: 25px; margin-bottom: 0px; margin-top: 10px;">
        </a>

      </div>
      <div class="sidebar-wrapper " id="sidebar-wrapper">
        <ul class="nav">
          @if(Auth()->user()->role == 'superadmin' or Auth()->user()->role == 'overhead' or Auth()->user()->role == 'agent')
          <li class="">
            <a href="{{route('dashboard')}}">
              <i class="now-ui-icons education_atom"></i>
              <p><b>Dashboard</b></p>
            </a>

          </li>
          @endif

            <li>
              <a class="" data-toggle="collapse" href="#collapseCancel" role="button" aria-expanded="false" aria-controls="collapseCancel">
                <i class="now-ui-icons education_atom"></i>
                <p><b>Cancelliste</b></p>
              </a>
              <div class="collapse" id="collapseCancel" style="margin-left:50px;">
                <ul class="list-group list-group-flush" style="list-style-type: none;">
                <li><a href="{{route('cancelcauses')}}">Cancelgründe</a></li>
                <li><a href="{{route('agent.cancels', ['id' => Auth()->user()->id])}}">meine Cancels</a></li>
                @if(Auth()->user()->role == 'overhead' or Auth()->user()->role == 'superadmin')
                <li><a href="{{route('cancels.index')}}">Cancelgründe auswerten</a></li>
                <li><a href="{{route('cancels.callback')}}">Rückrufliste</a></li>
                @endif
              </ul>
            </li>
          @if(Auth()->user()->role == 'superadmin')
          <li>
            <a class="" data-toggle="collapse" href="#collapseUser" role="button" aria-expanded="false" aria-controls="collapseUser">
              <i class="now-ui-icons users_single-02"></i>
              <p><b>Usermenü</b></p>
            </a>
            <div class="collapse" id="collapseUser" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
                <li><a href="{{route('user.create')}}">User anlegen</a></li>
                <li><a href="{{route('user.index')}}">User Index</a></li>
                <li><a href="#">User xyz</a></li>
              </ul>

            </div>
          </li>
          @endif
          @if(Auth()->user()->role == 'superadmin')
          <li>
            <a class="" data-toggle="collapse" href="#collapseReport" role="button" aria-expanded="false" aria-controls="collapseCancel">
              <i class="now-ui-icons education_atom"></i>
              <p><b>Reporting</b></p>
            </a>
            <div class="collapse" id="collapseReport" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
              <li><a href="{{route('reports.report')}}">Retention Details Report</a></li>
              <li><a href="{{route('reports.capacitysuitreport')}}">Capacity Suit Report</a></li>
            </ul>
          </li>
          @endif
          @if(Auth()->user()->role == 'superadmin')
          <li>
            <a class="" data-toggle="collapse" href="#collapseEmail" role="button" aria-expanded="false" aria-controls="collapseCancel">
              <i class="now-ui-icons education_atom"></i>
              <p><b>Email Versand</b></p>
            </a>
            <div class="collapse" id="collapseEmail" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
              <li><a href="{{route('reports.report')}}">Email xyz</a></li>
              <li><a href="{{route('reports.report')}}">Email xyz2</a></li>
            </ul>
          </li>
          @endif
          @if(Auth()->user()->role == 'agent' or Auth()->user()->role == 'overhead' or Auth()->user()->role == 'superadmin')
          <li>
            <a class="" data-toggle="collapse" href="#collapseSurvey" role="button" aria-expanded="false" aria-controls="collapseSurvey">
              <i class="now-ui-icons education_atom"></i>
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
          </li>
          @endif
          @if(Auth()->user()->role == 'superadmin' or Auth()->user()->role == 'overhead')
          <li>
            <a class="" data-toggle="collapse" href="#collapseFeedback" role="button" aria-expanded="false" aria-controls="collapseFeedback">
              <i class="now-ui-icons education_atom"></i>
              <p><b>Feedbackgespräche</b></p>
            </a>
            <div class="collapse" id="collapseFeedback" style="margin-left:50px;">
              <ul class="list-group list-group-flush" style="list-style-type: none;">
              <li><a href="{{route('feedback.view')}}">Feedbackgespräche</a> </li>
              <li><a href="{{route('feedback.myIndex')}}">geführte Feedbackgespräche</a> </li>
            </ul>
          </li>
          @endif
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Test</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="{{Auth()->user()->role}}">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
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
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item dropdown">
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
                    <a class="dropdown-item" href="{{route('user.logout')}}">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-lg" style="height: 200em; overflow: scroll;">
        <!-- <canvas id="bigDashboardChart"></canvas> -->
        <div class="content" style="height: 60vh;">
          @yield('content')
        </div>
        <div class="container bg-white">
          @if($errors->any())
          {{$errors->first()}}
          @endif
        </div>
      </div>
      <footer class="footer">
      </footer>
    </div>
  </div>
  <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  <!--   Core JS Files   -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/popper.min.js')}}"></script>
  <!-- <script src="{{asset('css/now-ui-dashboard-master/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script> -->

  <!-- <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/bootstrap.min.js')}}"></script> -->
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
  <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script> -->

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script> -->
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js'></script>
  <!-- Chart JS -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/assets/js/plugins/chartjs.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('css/now-ui-dashboard-master/assets/assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript')}}"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->

  <script src="{{asset('js/app.js')}}"></script>
  @if($errors->any())
  <script>
    $('#errorModal').modal('show');
  </script>

  @endif
  @if($news = 0 == 1)
  <script>
    $('#newsModal').modal('show');
  </script>

  @endif

  @yield('additional_js')




</body>

</html>
