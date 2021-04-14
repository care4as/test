
@extends('general_layout')

@section('content')

<div class="container-fluid" style="width: 75vw;">
  <div class="row ">
    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
      <table class="table table-hover">
        <tr>
          <th>#</th>
          <th>Rolle</th>
          <th>Rechte ansehen/bearbeiten</th>
          <th>Rolle löschen</th>
        </tr>
          @foreach($roles as $role)
          <tr>
            <td>{{$role->id}}</td>
            <td>{{$role->name}}</td>
            <td><a href="{{route('role.show', ['id' => $role->id])}}">link</a></td>
            <td><a href="{{route('role.delete', ['id' => $role->id])}}">löschen</a></td>
          </tr>
          @endforeach
      </table>
    </div>
  </div>
  <div class="row">
    <button type="button" class="btn-primary" data-toggle="modal" data-target="#RoleRightsModal">Neue Rolle erstellen</button>
  </div>
</div>
<div class="modal fade" id="RoleRightsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="text-center">Neue Rolle erstellen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col text-center text-white bg-light" style="border-radius: 15px;">
            <form class="w-100 text-dark" action="{{route('role.save')}}" method="post" style="">
              @csrf
              <div class="form-group text-dark">
                <label for="case">Rollenname</label>
                <input type="text" class="form-control" name="rolename" id="case" aria-describedby="case" Placeholder="z.B. Superadmin">
              </div>
              <div class="form-group text-dark">
                <span> Welche Rechte hat die Rolle?</span>
              </div>
              <table class="table">
                @foreach($rights as $right)
                <tr>
                  <td><input type="checkbox" name="rights[]" value="{{$right->id}}"> </td>
                  <td>{{$right->name}}</td>
                </tr>
                @endforeach
              </table>
                <button type="submit" class="btn btn-primary">Daten absenden</button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
