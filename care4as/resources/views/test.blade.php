<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Care4as Software-Tool</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=yes' name='viewport' />
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
  <!-- <script src="{{asset('css/now-ui-dashboard-master/assets/js/core/popper.min.js')}}"></script> -->
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
  <!-- <script src="//cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script> -->
  <script src="{{asset('js/nicEdit.js')}}"></script>

  <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>

  <style media="screen">
    body
    {
      font-size: 2.5em;
      font-weight: 900;
    }
    .max-table
    {
      text-align: center;

    }
    #app
    {
      position:fixed;
      height: 100vh;
      width: 100vw;
      margin: 0px;
      background-color: white;
    }
    .col-md-5
    {
      height: 45%;
      border-radius: 25px;
    }
  </style>
</head>
<body class="bg-primary" >
  <div class="row text-dark h-100 justify-content-center" id="app">
    <div class="col-md-5 h-100">
      <textarea name="content" id="editor1" style="width: 100%; height: 100%;">
          Text zum editieren
      </textarea>
    </div>
    <div class="col-md-5 h-100 center_items" id="">
      <dbMonitor></dbMonitor>
    </div>
  </div>
  <script src="{{asset('js/app.js')}}"></script>
  <script>

    // new nicEditor({iconsPath : '../nicEditorIcons.gif'}).panelInstance('editor1');

  </script>
  <script type="text/javascript">
    new nicEditor({fullPanel : true}).panelInstance('editor1');
  </script>
</body>
