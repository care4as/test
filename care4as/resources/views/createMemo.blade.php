@extends('general_layout')

@section('additional_css')
<script src="//cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
@endsection

@section('content')
<div class="container-fluid bg-light text-dark mt-4" style="width: 75vw; font-size: 0.9em;">
  <div class="row w-100 p-2 center_items">
    <div class="col-md-12">
      <p>
        <h3>Verfasse eine Memoranda</h3>
      </p>
      <form class="w-100" action="{{route('memo.store')}}" method="post" enctype="multipart/form-data">
        @csrf
          <div class="row">
            <div class="col-md-5 m-1">
                <label for="to" style="margin: auto;">An:</label>
                <select id="to" class="form-control" name="to" style="color:black;">
                    <option value="" selected>Wähle</option>
                      <option value="all">Alle</option>
                      <optgroup label="Projekte">
                        @foreach(\DB::table('users')->where('status',1)->groupBy('project')->pluck('project') as $project)
                          <option value="{{$project}}">{{$project}}</option>
                        @endforeach
                      </optgroup>
                      <optgroup label="Teams">
                        @foreach(\DB::table('users')->where('status',1)->groupBy('team')->pluck('team') as $team)
                          <option value="{{$team}}">{{$team}}</option>
                        @endforeach
                      </optgroup>
                </select>
              </div>
            <div class="col-md-5 m-1">
                <label for="title" style="margin: auto;">Titel:</label>
                <input type="text" name="title" class="form-control" value="" id="title">
              </div>
              <div class="col-md-12 m-1">
                <textarea name="content" id="editor1" rows="10" cols="80">
                    Text zum editieren
                </textarea>
              </div>
              <div class="col-md-6 m-1">
                  <h5>Füge ein Bild hinzu</h5>
                  <div style="width: 100%; display: grid; grid-template-columns: auto 1fr; grid-column-gap: 25px; grid-row-gap: 5px;">
                  <input type="file" name="image" value="">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 m-1">
                <button type="submit" name="button">Absenden</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
@endsection

@section('additional_js')
<script>
  CKEDITOR.replace( 'editor1' );
</script>
@endsection
