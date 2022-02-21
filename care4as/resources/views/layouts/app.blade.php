<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Login') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{asset('css/now-ui-dashboard-master/assets/js/demos.js')}}"></script>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="{{asset('css/now-ui-dashboard-master/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/now-ui-dashboard-master/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/now-ui-dashboard-master/assets/css/now-ui-dashboard.css?v=1.5.0')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{asset('css/now-ui-dashboard-master/assets/demo/demo.css')}}" rel="stylesheet" />

    <style media="screen" >

      input:-webkit-autofill,
      input:-webkit-autofill:hover,
      input:-webkit-autofill:focus,
      input:-webkit-autofill:active {
          -webkit-box-shadow: 0 0 0px 1000px white inset !important;
      }
      .goldentext
      {
        color: #D5AD6D;
        background: -webkit-linear-gradient(transparent, transparent), -webkit-linear-gradient(top, rgba(213,173,109,1) 0%, rgba(213,173,109,1) 26%, rgba(226,186,120,1) 35%, rgba(163,126,67,1) 45%, rgba(145,112,59,1) 61%, rgba(213,173,109,1) 100%);
            background-clip: border-box, border-box;
        background: -o-linear-gradient(transparent, transparent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      }

      .logbut
      {
        padding: 6px 40px;
        font-size: 1.4rem;
        border-radius: 25px;
        background-color: white;
        border: 2px #fd7e14 solid;
      }
      .logbut:hover
      {
        background: #fd7e14;
        color: white !important;
      }
      .logbut:hover
      {
        background: #fd7e14;
      }
      .logbut:hover span
      {
        color: white !important;
      }
    </style>

</head>
<body>
    <div id="app">
          <main class="py-4">
            @yield('content')
        </main>
    </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/bootstrap.min.js')}}"></script>
    @if($errors->first())
    <script type="text/javascript">
      $('#exampleModal').modal('show')
    </script>


    @endif

</body>
</html>
