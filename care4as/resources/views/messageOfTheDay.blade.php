@extends('layouts.app')

@section('content')
<style media="screen">


</style>

<div class="container" style="position:absolute;top:25%; left: 25%; width: 50%;">
    <div class="row justify-content-center" >
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <div class="card-img">
                    <img src="{{asset('images/Logo_Care4as_2 - Kopie.png')}}" alt="">
                  </div>
                  <hr>
                </div>
                <div class="card-body" >
                  <div class="textwrapper" style="width: 100%; margin: 0px; display: flex; justify-content: center;">
                    <span style='color: red; text-align: center;'> &#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;</span>
                  </div>
                  <marquee behavior="scroll" direction="left"  style="width: 100%; margin-top: 25px;"> <h3><b>Ihr seid die Besten, Keiner ist so toll wie ihr, Nur mit euch schafft man das, HDGDL</b></h3>   </marquee>
                  <div class="textwrapper" style="width: 100%; margin: 0px; display: flex; justify-content: center;">
                    <span style='color: red; text-align: center;'> &#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;&#10084;</span>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
@endsection
