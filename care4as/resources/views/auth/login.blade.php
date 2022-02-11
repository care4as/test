@section('additional_css')
<style>
  input:-webkit-autofill,
  input:-webkit-autofill:hover,
  input:-webkit-autofill:focus,
  input:-webkit-autofill:active {
      -webkit-box-shadow: 0 0 0px 1000px white inset !important;
  }
</style>
@endsection

@extends('layouts.app')
@section('content')




<div class="background" style="position:fixed; top:0px; left:0px; height:100vh; width:100vw; background:radial-gradient(at center, #ffad36, #ff512f)">
</div>


<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="container" style="position:absolute;top: 50%; left: 50%;transform: translate(-50%,-50%);">
    <div class="row justify-content-center" >
        <div class="col-md-8">
            <div class="card" style="box-shadow: 0px 0px 40px 1px #525252;">
                <div class="card-header">
                  <div style="display: flex; justify-content: center; margin: 30px 0;">
                    <img src="{{asset('images/Logo_Care4as_2 - Kopie.png')}}" alt="" style="width: 80%; background-color: transparent;">
                  </div>
                  <div style="text-align: center; font-size: xx-large">
                    Software Tool
                  </div>
                  <hr>
                  <div style="text-align: center; font-size: large;">
                    Login
                  </div>
                </div>
                <div class="card-body" >
                    <form method="POST" action="{{ route('user.login.post') }}">
                        @csrf
                        <div class="form-group" style="display:grid; grid-template-columns: 30% 40% 30%;">
                            <label for="email" class="col-form-label" style="text-align: right; margin-right:10px">{{ __('Benutzername:') }}</label>
                            <div>
                                <input id="name" type="text" style="background:transparent;" class="form-control @error('email') is-invalid @enderror" placeholder="m.mustermann" name="name" value="{{ old('username') }}" required autocomplete="email" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group" style="display:grid; grid-template-columns: 30% 40% 30%;">
                            <label for="password" class="col-form-label" style="text-align: right; margin-right:10px">{{ __('Kennwort:') }}</label>
                            <div>
                                <input id="password" style="background:transparent;" type="password" placeholder="123456" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0" style="justify-content: center;">
                            <div>
                                <button type="submit" class="logbut" style="border-radius: 7px; font-size: 1.1rem">
                                  <span class="material-icons" style="font-size: 1.5em; color: #fd7e14; vertical-align:top;">
                                    login
                                    </span>
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
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

<script>
  $(document).mousemove(function(event) {
  windowWidth = $(window).width();
  windowHeight = $(window).height();
  
  mouseXpercentage = Math.round(event.pageX / windowWidth * 100);
  mouseYpercentage = Math.round(event.pageY / windowHeight * 100);
  
  $('.background').css('background', 'radial-gradient(at ' + mouseXpercentage + '% ' + mouseYpercentage + '%, #ffad36, #ff512f)');
});
</script>

@endsection

@section('additional_js')

@endsection