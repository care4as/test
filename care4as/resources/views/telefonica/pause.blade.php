@extends('./general_layout')

@section('content')
<div class="container unit-translucent mt-4" id="app">
  <div class="row">
    <ptool> </ptool>
  </div>
  @if(in_array('telefonica_config',Auth()->user()->getRights()))
  <div class="row m-1 mt-4  center_items">
    <div class="col-md-10 p-0 m-2 center_items">
      <form class="w-50 unit-translucent p-2" action="{{route('telefonica.changePausePeople')}}" method="post">
        @csrf
        <div class="form-row mt-2">
          <div class="form-col-6">
            Maximale verfügbare Pausen: <input type="text" class="form-control" name="pip" value="{{$pip}}">
          </div>
        </div>
        <div class="form-row mt-2">
          <div class="form-col-6">
            <button type="submit" class="unit-translucent " name="button">Absenden</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endif
</div>
@endsection
