@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">

  <div class="row ">
    <h3></h3>
    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Kunde</th>
            <th>Zeitraum</th>
            <th>Notiz</th>
            <th>Status</th>
            <th>Kundenberater</th>
            <th>Optionen</th>
          <tr>
              </thead>
                <tbody>
                  @foreach($callbacks as $callback)
                    <tr>
                      <td>{{$callback->customer}}</td>
                      <td>{{$callback->time}}</td>
                      <td style="max-width: 100px;">{{$callback->cause}}</td>

                      <td>@if($callback->directed_to == null) offen @else in Bearbeitung @endif</td>
                      <td> @if(!$callback->directed_to == null) {{directed_to}} @endif</td>
                      <td>
                        <div class="dropdown">
                          <a  class="btn btn-secondary dropdown-toggle" href="#" role="button" id="users" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                          </a>

                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach($users as $user)
                              <a class="dropdown-item" href="route('callback.user.set', ['id' => $user->id])">{{$user->name}}</a>
                            @endforeach
                          </div>
                        </div>
                      </td>
                    <tr>
                  @endforeach
                </tbody>
            </table>


          </div>
      </div>
    </div>

    </div>

  </div>
</div>

@endsection
