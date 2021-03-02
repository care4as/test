@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">
  <div class="row bg-light align-items-center"  style="border-radius: 15px;">
    <div class="col">
      <form action="{{route('create.user.post')}}" method="post">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Username</label>
            <input type="text" name="name" class="form-control" id="inputEmail4" placeholder="zB. anrob1984">
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Password</label>
            <input type="text" name="password" class="form-control" id="inputPassword4" placeholder="Password" value="Start#15">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputPassword4">CCU_ID</label>
            <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="">
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Person-ID</label>
            <input type="text" class="form-control" name="personid" id="inputPassword4" placeholder="" value="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="role">Rolle:</label><br>
            <select class="" name="role" id="role">
              <option value="overhead">Overhead</option>
              <option value="agent">Agent</option>
            </select>
            <!-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="Start#15"> -->
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Team</label><br>
            <select class="" name="team" id="Team">
              <option value="overhead">Liesa</option>
              <option value="agent">Jacha</option>
            </select>
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Create User</button>
      </form>

    </div>
  </div>
</div>
@endsection
