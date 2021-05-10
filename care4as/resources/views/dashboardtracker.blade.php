@extends('general_layout')

@section('additional_css')
<style>
    .header{
        position:sticky;
        top: 0 ;
    }
    .col
    {
      padding: 0px;
    }
    .row
    {
      margin-right: 0px !important;
      margin-left: 0px !important;
    }
    .col-designed
    {
      position: relative;
      width: 100%;
      flex: 0 0 30%;
      max-width:30%;
    }
    .bg-care4as-light
    {
      background-color: rgba(255,127,80, 0.2);
      opacity: 1;
    }
    .accordion
    {
      width: 100%;
    }
</style>
@endsection

@section('content')

<div class="container-fluid m-1" id="app">

  <div class="row bg-white shadow m-1" id="filtermenu">
    <div class="w-100" id="accordion">
      <div class="col-12 d-flex justify-content-center align-self-center">
        <h5><a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="cursor:pointer;">
          Filtermenü
          <span class="material-icons">
            expand_more
            </span>
        </a></h5>
      </div>
      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="col-12">
          <form class="mt-2 w-100" action="{{route('dashboard.admin')}}" method="get">
            <div class="row m-0 justify-content-center">
              <div class="col-6 p-0" style="">
                <div class="row m-2 justify-content-center">
                  <div class="col-4 ml-1 p-0">
                    <label for="department">Abteilung:</label>
                    <select class="form-control" name="department" id="department" style="width:218px;">
                      <option value="" selected disabled>Wähle die Abteilung</option>
                      <option value="1&1 DSL Retention">1&1 DSL Retention</option>
                      <option value="1&1 Mobile Retention" >1&1 Mobile Retention</option>
                    </select>
                  </div>
                  <div class="col-4 p-0 mr-2">
                    <label for="department">Welche MA:</label>
                    <select multiple class="form-control" name="employees[]" id="employees" style="height: 150px; overflow:scroll;">

                    </select>
                  </div>
                </div>
                <div class="row m-2 justify-content-center">
                  <button type="submit" name="button" class="btn-sm btn-success">Filter</button>
                </div>
              </div>
            </div>
        </div>
    </div>
    </form>
  </div>

  <div class="row bg-care4as-light p-2 justify-content-center  w-100">
      @foreach($users as $user)
      <div class="col-designed m-3 p-1 border bg-white rounded shadow">
        <h5>{{$user->wholeName()}}</h5>
      <trackchart :userid="{{$user->id}}"> </trackchart>
      </div>
  @endforeach
  </div>
</div>
<div class="modal fade" id="failModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-danger text-white" >
      <div class="modal-body">
        <h5>&#128577;&#128580;&#128560; Fehler aufgetreten &#128577;&#128580;&#128560;</h5>
        <p id="failFile"></p>
        <p id="failLine"></p>
        <p id="failContent"></p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('additional_js')
<script type="text/javascript">
  $('#department').change(function() {

    $('#employees').empty()
    let dep = this.value

    console.log(dep)

    var host = window.location.host;

    // axios.get('http://'+host+'/user/getUsersByDep/'+ dep)

    axios.get('http://'+host+'/user/getUsersByDep/'+ dep)
    // axios.get('http://'+host+'/care4as/care4as/public/user/getUsersByDep/'+ dep)
    .then(response => {
      console.log(response)
      let users = response.data

      users.forEach(function(user){
        let option = document.createElement("option");
        let name = user.surname + ' ' + user.lastname;

        option.value = user.id;
        option.innerHTML = name;

        $('#employees').append(option);
        // console.log(option)
        })

      })
    .catch(function (err) {

      $('#failContent').html('Fehler: '+ err.response.data.message)
      $('#failFile').html('Datei: '+ err.response.data.file)
      $('#failLine').html('Line: '+ err.response.data.line)
      $('#failModal').modal('show')
      console.log(err.response);
    })
  })
</script>
@endsection
