
@extends('general_layout')

@section('content')

<div class="container-fluid" style="width: 75vw;">
  <div class="row ">
    <div class="col text-center text-dark bg-light" style="border-radius: 15px;">
      <h5>{{$role->name}}</h5>
      <form class="" action="{{route('role.update', ['id' => $role->id])}}" method="post">
        @csrf
        <table class="table table-hover">
          <tr>
            <th>#</th>
            <th>Recht</th>
            <th>Beschreibung</th>
          </tr>
            @foreach($rights as $right)
            <tr>
              <td>
                <!-- <input type="checkbox" id="scales" name="scales" >
               -->
               <div class="custom-control custom-checkbox">
                 <input type="checkbox" name="rights[]" class="custom-control-input" id="{{$right->name}}" value="{{$right->id}}" @if($role->name == 'superadmin' ) disabled @endif @if($role->rights->contains($right->name)) checked @endif>
                 <label class="custom-control-label" for="{{$right->name}}"></label>
             </div>
              </td>
              <td>{{$right->name}}</td>
              <td>{{$right->description}}</td>
            </tr>
            @endforeach
        </table>
        <button type="submit" class="btn-primary">Rolle ändern!</button>
      </form>

    </div>
  </div>

</div>


@endsection
