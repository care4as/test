@extends('general_layout')

@section('additional_css')
<style media="screen">
  table.dataTable tbody tr
  {
    background-color: transparent !important;
  }
  *{
   scrollbar-width: thin;
  }
  ::-webkit-scrollbar {
  width: 9px;
}
::-webkit-scrollbar-track {
  background: transparent;
}
::-webkit-scrollbar-thumb {
  background-color: rgba(155, 155, 155, 0.5);
  border-radius: 20px;
  border: transparent;
}
.modal-backdrop
{
  background-color: rgba(0, 0, 0, 0.7) !important;
}
  .active
  {
    display: block;
  }
  .inactive
  {
    display: none;
  }
  .thumbimg
  {
    border-radius: 15px;
    height: 40px;
    border: 2px solid white;
    object-fit: cover;
  }
  .thumbnails
  {
    height: 35%;
  }
  .thumbitem
  {
    margin: 15px;
    height: 75px;
    border: 5px solid rgba(0,0,0,0.2);
    border-radius: 15px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset;
    cursor: pointer;
    font-size: 0.6em;
  }
  .thumbitem:hover
  {
    box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px inset;
    border: 2px solid rgba(0,0,0,0.2);
  }
  .newscontent
  {
    margin: 15px;
    height: 90%;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset;
    border-radius: 15px;
  }
  .contentimg
  {
    border-radius: 15px;
    /* border: 2px solid black; */
    object-fit: contain;
    padding: 12px;
    height:100%;
    border-right: 3px solid white;
    border-bottom: 3px solid white;
    /* margin: 15px; */
    /* max-width: 80%; */
    /* max-height: 80%; */
  }
  .btn-check {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
    }

    .btn-outline-primary:hover{
        color: white;
        background-color: #f96332;;
    }

    .btn-check:checked + label{
    color: white;
    background-color: #f96332;;
    border: 1px solid #f96332;
    }

    .first-btn-group-element{
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
    }

    .last-btn-group-element{
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }

    .btn-group > .btn:not(:first-child){
        margin-left: -2px;
    }

    .btn{
        padding: 5px 10px !important;
        margin-top: 0;
        margin-bottom: 0;
        min-width: 100px;
    }

    .btn-group-container{
        display: flex;
        justify-content: center;
    }
</style>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12" style="height: calc(100vh - 66.5px)">
    <div class="col-md-12">
      <div class="max-main-container" style="text-align: center; padding: 10px;">
        <div>
          Hallo {{$surname= Auth()->user()->surname}} {{Auth()->user()->lastname}},
        </div>
        <div>
          @php
          $hearts = mb_convert_encoding('&#128150;&#128150;&#128150;','UTF-16','HTML-ENTITIES').$surname.mb_convert_encoding('&#128150;&#128150;&#128150;','UTF-16','HTML-ENTITIES');
          $htmlHearts = mb_convert_encoding($hearts,'utf-8', 'utf-16');

          $greetings = array('Schön dass du da bist!',
          'Wir haben dich vermisst!',
          'Ohne dich ist es nur halb so lustig!',
          'Du bist der/die Beste, dass sag ich nicht zu jedem ',
          $htmlHearts
          );
          $image =false;
          @endphp
          {{$greetings[rand(0,count($greetings)-1)]}}
        </div>
      </div>
    </div>
    <div class="col-md-12" style="height: calc(100% - 139.6px)">
      <div class="max-main-container" style="height:100%">
        <div style="margin:10px">
          <i class="far fa-newspaper"></i>
          Neuigkeiten
        </div>
        <div class="row" style="height: 80%; ">
          <div id="memo-sidebar " class="col-sm-12 col-lg-4 h-100" style="overflow:hide;">
            <div id="memo-toggle" class="btn-group-container">
              <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="backoffice" onclick="showNewMemos(1)" value="1" id="backoffice1" autocomplete="off" checked>
                <label class="btn btn-outline-primary first-btn-group-element" for="backoffice1">Neu</label>
                <input type="radio" class="btn-check" name="backoffice" value="0" onclick="showNewMemos(2)" id="backoffice2" autocomplete="off">
                <label class="btn btn-outline-primary last-btn-group-element" for="backoffice2">Gelesen</label>
              </div>
            </div>
            <div id="memo-search">
              <input type="text" class="form-control" style="max-width: 200px; margin: 0 auto;" placeholder="Suche...">
            </div>
            <div id="memo-new" style="overflow-y:scroll;">
              @foreach($unread as $memo)
                <div class="row thumbitem" onclick="showMemo({{$memo->id}})">
                  @if($memo->has_image)
                    <div class="col-4 p-1 h-100 center_items">
                      <img class="thumbimg" src="{{asset($memo->path)}}" alt="Bild">
                    </div>
                  @endif
                  <div class="  @if($memo->has_image) col-8 @else col-12 @endif h-100">
                    <div class="row m-0 h-25 ">
                      <h5 class="text-truncate">{{$memo->title}}</h5>
                    </div>
                    <hr class="w-50 m-2 mt-3">
                    <div class="row m-0 h-25 ">
                      <p class="text-truncate">{{ strip_tags(html_entity_decode($memo->content))}}</p>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            <div id="memo-old" class="inactive h-100" style="overflow-y: scroll;">
            @foreach($read as $memo)
              <div class="row thumbitem" onclick="showMemo({{$memo->id}})">
                @if($memo->has_image)
                  <div class="col-4 p-1 h-100 center_items">
                    <img class="thumbimg" src="{{asset($memo->path)}}" alt="Bild">
                  </div>
                @endif
                <div class="  @if($memo->has_image) col-8 @else col-12 @endif h-100">
                  <div class="row m-0 h-25">
                    <h5 class="text-truncate">{{$memo->title}}</h5>
                  </div>
                  <hr class="w-50 m-2 mt-3">
                  <div class="row m-0 h-25">
                    <p class="text-truncate">{{ strip_tags(html_entity_decode($memo->content))}}</p>
                  </div>
                </div>
              </div>
            @endforeach
            </div>
          </div>
          <div id="memo-content w-100" class="col-sm-12 col-lg-7 h-100" style="position:relative; height: 70vh; overflow-x: hidden; overflow-y:scroll;">
          @foreach($unread->merge($read) as $memo)
            <div class="inactive" id="memoContent{{$memo->id}}" style="position: absolute;width:100%; height: 100%; top: 0%; left: 0%;">
              <div class="row center_items bg-secondary text-white" style="">
                @if($memo->has_image)
                <div class="col-4 p-2 h-100 center_items position-relative" onClick="enlargeIMG('{{ (asset($memo->path)) }}')">
                  <img class="contentimg" src="{{asset($memo->path)}}" alt="Bild">
                  <div class="position-absolute" style="background: rgba(255,255,255, 0.5);">
                    <h5 class="text-dark text-bold">klicken zum vergrößern</h5>
                  </div>
                </div>
                @endif
                <div class="col-8 p-0 h-100">
                  <div class="row center_items">
                    <h3 class="text-center">{{$memo->title}}</h3>
                  </div>
                  <div class="row center_items">
                    @if($memo->creator)
                      <div class="col-6 d-flex justify-content-start">
                        <small><span class="">{{$memo->creator->surname}} {{$memo->creator->lastname}}</span></small>
                        <!-- <small><span class="">test123</span></small> -->
                      </div>
                      <div class="col-6 d-flex justify-content-end">
                        <small> <span class="align-self-end">erstellt: {{$memo->created_at}}</span></small>
                      </div>
                    @else
                      <small>erstellt von:Ersteller nicht gefunden {{$memo->created_at}}</small>
                    @endif
                  </div>
                </div>
              </div>
              <hr class="w-50">
              <div class="row center_items">
                <div class="col-12" >
                  {!!$memo->content !!}
                </div>
              </div>
            </div>
          @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>






<!-- <div class="container bg-white text-dark mt-4" style="width: 75vw; height: 85vh; font-size: 1.2em;">
  <div class="row p-2 center_items h-25">
    <div class="col-12-md">
      <p>
        <h3>&#128075; &#128075; &#128075; Hallo {{Auth()->user()->surname}} {{Auth()->user()->lastname}}, &#128075;&#128075;&#128075;</h3>
      </p>

        <p class="text-center"id="weLoveU">
          @php
          $greetings = array('Schön dass du da bist!!',
          'Herzlich Willkommen, wir haben dich vermisst!',
          'Ohne dich ist es nur halb so lustig',
          );
          $image =false;
          @endphp
          <b>&#127881;	&#127881;	&#127881; {{$greetings[rand(0,count($greetings)-1)]}}	&#127881;	&#127881;	&#127881;</b>
      </p>
    </div>
  </div>
  <div class="row m-1 h-75">
    <div class="col-3 p-2 h-100">
      <span>Ungelesen</span>
      <div class="row thumbnails d-block" style="overflow-y:scroll;">
        @foreach($unread as $memo)
          <div class="row thumbitem" onclick="showMemo({{$memo->id}})">
            @if($memo->has_image)
              <div class="col-4 p-1 h-100 center_items">
                <img class="thumbimg" src="{{asset($memo->path)}}" alt="Bild">
              </div>
            @endif
            <div class="  @if($memo->has_image) col-8 @else col-12 @endif h-100">
              <div class="row m-0 h-25 ">
                <h5 class="text-truncate">{{$memo->title}}</h5>
              </div>
              <hr class="w-50 m-2 mt-3">
            <div class="row m-0 h-25 ">
                   <p>{!!$memo->content !!}</p>
                  <p class="text-truncate">{{ strip_tags(html_entity_decode($memo->content))}}</p>
              </div>
          </div>
        </div>
        @endforeach
      </div>
      <hr class="w-50">
      <h5>Gelesen</h5>
      <div class="row thumbnails d-block" style="overflow-y:scroll;">
        @foreach($read as $memo)
          <div class="row thumbitem" onclick="showMemo({{$memo->id}})">
            @if($memo->has_image)
              <div class="col-4 p-1 h-100 center_items">
                <img class="thumbimg" src="{{asset($memo->path)}}" alt="Bild">
              </div>
            @endif
            <div class="  @if($memo->has_image) col-8 @else col-12 @endif h-100">
              <div class="row m-0 h-25">
                <h5 class="text-truncate">{{$memo->title}}</h5>
              </div>
              <hr class="w-50 m-2 mt-3">
            <div class="row m-0 h-25">
                   <p>{!!$memo->content !!}</p>
                  <p class="text-truncate">{{ strip_tags(html_entity_decode($memo->content))}}</p>
              </div>
          </div>
        </div>
        @endforeach
    </div>
    </div>
    <div class="col-9 p-2 h-100">
      <div class="newscontent" style="overflow-y:scroll;">
        @foreach($unread->merge($read) as $memo)
        <div class="inactive" id="memoContent{{$memo->id}}">
          <div class="row m-0 center_items">
            <h5>{{$memo->title}}</h5>
          </div>
          @if($memo->has_image)
          <div class="row m-0 center_items">
            <img class="contentimg" src="{{asset($memo->path)}}" alt="Bild">
          </div>
            @endif
          <hr style="width: 50%;">
          <div class="row m-0 center_items p-2">
            <p>
              <p>{!!$memo->content !!}</p>
            </p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div> -->
@endsection

@section('additional_modal')
<div class="modal" id="pictureModal" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content" style="background: none;">
      <div class="modal-body position-relative">
        <button type="button " class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" onClick="closePicModal()">X</button>
        <img src="" class="img-fluid w-100" alt="vergrößertes Bild" id="biggerPic">
      </div>
    </div>
  </div>
</div>
@endsection
@section('additional_js')
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
<script>
function enlargeIMG(src)
{
  console.log(src)
  $('#pictureModal').toggle()
  $('<div class="modal-backdrop"></div>').appendTo(document.body);
  $('#biggerPic').attr('src',src)
}
function closePicModal()
{
  $('#pictureModal').toggle()
  $('.modal-backdrop').remove()
}

function showMemo(id)
{
  let host = window.location.host;
  // axios.get('http://'+host+'/care4as/care4as/public/memo/read/'+id)
  axios.get('http://'+host+'/memo/read/'+id)
  .then(response => {

  })
  .catch(function (err) {
    console.log('error Memo')
    console.log(err.response);
  });

  let element = $('#memoContent'+ id)

  if( element.attr('class') == 'inactive')
  {

    var all = $(".active").each(function() {
     $(this).removeClass('active');
     $(this).addClass('inactive');
    })

    element.removeClass('inactive')
    element.addClass('active')


    // console.log(element.attr('class'))
  }
  else
  {
    element.removeClass('active')
    element.addClass('inactive')

  }

}
function showNewMemos(mode)
{
  if(mode== 1)
  {
    $('#memo-new').toggle()
    $('#memo-old').toggle()
  }
  else {
    $('#memo-new').toggle()
    $('#memo-old').toggle()
  }

}
  $(document).ready(function() {
    $('#weLoveU').hide();
    setTimeout(function(){
    $('#weLoveU').fadeIn('slow');
  }, 3000);


  })

</script>
@endsection
