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
            <label for="surname">Vorname</label>
            <input type="text" name="surname" class="form-control" id="surname" placeholder="">
          </div>
          <div class="form-group col-md-6">
            <label for="lastname">Nachname</label>
            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="" value="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="ccuid">CCU_ID</label>
            <input type="text" class="form-control" id="agentid" placeholder="" name="agentid" value="">
          </div>
          <div class="form-group col-md-6">
            <label for="personid">Person-ID</label>
            <input type="text" class="form-control" name="personid" id="personid" placeholder="" value="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="role">Rolle:</label><br>
            <select class="form-control" name="role" id="role" required>
              <option value="" selected disabled>Wähle die Rolle</option>
              @foreach(App\Role::where('name','!=','superadmin')->get('name') as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>
              @endforeach
            </select>
            <!-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="Start#15"> -->
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Team</label><br>
            <select class="form-control" name="team" id="Team">
              <option value="" selected disabled>Wähle das Team</option>
              <option value="Liesa">Liesa</option>
              <option value="Jacha">Jacha</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="role">Abteilung:</label><br>
            <select class="form-control" name="department" id="department" style="width:218px;">
              <option value="" selected disabled>Wähle die Abteilung</option>
              <option value="1&1 DSL Retention">1&1 DSL Retention</option>
              <option value="1&1 Mobile Retention">1&1 Mobile Retention</option>
              <option value="Telefonica">Telefonica</option>
            </select>
            <!-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="Start#15"> -->
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">zukünftige Werte</label><br>
            <select class="" name="" id="">
              <option value="test">test1</option>
              <option value="test">test2</option>
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
