@extends('general_layout')


@section('content')
<div class="container mt-4">
  <table class="table">
    @foreach($test1 as $key => $data)
    <tr>
      <td>{{$key}}</td>
      <td>insgesamt: {{count($data['date'])}}</td>
      <td>
        <table class="table table-borderless">
          @foreach($data['date'] as $date)
          <tr>
            <td>{{$date}}</td>
          </tr>
          @endforeach
        </table>

      </td>

    </tr>
    @endforeach
  </table>
</div>
@endsection
