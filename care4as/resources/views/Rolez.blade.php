
@extends('general_layout')

@section('content')

<div class="container-fluid p-2" style="width: 75vw;height: 95vh;">
  <div class="row h-100">
    <div class="col h-100 text-center text-dark " style="border-radius: 15px;">
      <h5></h5>
      <form class="h-100" action="{{route('role.update', ['id' => 0])}}" method="post">
        @csrf

          <embed src="{{asset('pdfs/Anwenderdokumentation Softwaretool.pdf')}}" width="100%" height="100%"
          type="application/pdf">


      </form>

    </div>
  </div>

</div>


@endsection
