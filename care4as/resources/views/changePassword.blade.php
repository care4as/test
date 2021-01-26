@extends('general_layout')

@section('content')
<div class="container-fluid bg-light" style="width: 75vw;">
  <div class="row justify-content-center">
    <div class="col-6">
      <h5>Vergebe dein neues Passwort</h5>
      <form class="" action="{{route('user.changePasswort')}}" method="post">
        @csrf
        <div class="form-row">
          <div class="form-col-sm-6">
            <label for="newPassword">Neues Passwort</label>
            <input type="password" class="form-control" name="newpassword" value="">
          </div>
          <div class="form-col-sm-6">
            <label for="confirm_newPassword"> Bestätige dein neues Passwort</label>
            <input type="password" class="form-control" name="confirm_newpassword" value="">
          </div>
          </div>
          <div class="form-row mt-2">
            <button type="submit" name="button" class="btn btn-primary">Passwort ändern</button>
          </div>

      </form>
    </div>
  </div>
</div>
@endsection
