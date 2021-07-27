@extends('./general_layout')

@section('content')
<div class="container bg-light" id="app">
  <div class="row">
    <ptool> </ptool>
  </div>


  @if(in_array('telefonica_config',Auth()->user()->getRights()))
  <div class="row mt-4">
    <form class="" action="{{route('telefonica.changePausePeople')}}" method="post">
      @csrf
      Maximale Pausenleute: <input type="text" name="pip" value="{{$pip}}">
      <button type="submit" name="button" class="btn-primary">Ändern!</button>
    </form>
  </div>

  @endif
</div>
@endsection
