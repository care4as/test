@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="container" style="position:absolute;top: 50%; left: 50%;transform: translate(-50%,-50%);">
    <div class="row justify-content-center" >
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <div style="display: flex; justify-content: center; margin: 30px 0;">
                    <img class="shadow p-2" src="{{asset('images/Logo_Care4as_2 - Kopie.png')}}" alt="" style="width: 80%; border-radius: 15px; background-color: transparent;">
                  </div>
                  <div style="text-align: center; font-size: large;">
                    Login
                  </div>
                </div>
                <div class="card-body" >
                    <form method="POST" action="{{ route('user.login.post') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('User:') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control text-dark @error('email') is-invalid @enderror" placeholder="m.mustermann" name="name" value="{{ old('username') }}" required autocomplete="email" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Passwort:') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="123456" class="form-control text-dark @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0" style="justify-content: center;">
                            <div>
                                <button type="submit" class="logbut" style="">
                                  <span class="material-icons" style="font-size: 1.5em; color: #fd7e14;">
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
@endsection
