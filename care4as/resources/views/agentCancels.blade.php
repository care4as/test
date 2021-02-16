@extends('general_layout')

@section('content')
<div class="container-fluid" style="width: 75vw;">

  <div class="row ">

    <div class="col text-center text-white bg-light" style="border-radius: 15px;">
      <div class="card card-nav-tabs card-plain">
      <div class="card-header card-header-danger">
          <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
          <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                  <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#home" data-toggle="tab">Deine Cancelliste</a>
                  </ul>
              </div>
          </div>
      </div><div class="card-body ">
          <div class="tab-content text-center">
            {{$cancels->links()}}
              <div class="tab-pane active" id="home">
                <table class="table table-striped">
                <thead>
                  <tr>
                  <th>Kundenummer</th>
                    <th>Kategorie</th>
                    <th>Angebot</th>
                    <th>Bemerkung</th>
                    <th>erstellt am</th>
                    <th>Optionen</th>
                  <tr>
                </thead>
                <tbody>
                  @foreach($cancels as $cancel)
                    <tr>
                      <td>{{$cancel->Customer}}</td>
                      <td>{{$cancel->Category}}</td>
                      <td>{{$cancel->Offer}}</td>
                      <td style="max-width: 100px;">{{$cancel->Notice}}</td>
                      <td>{{$cancel->created_at}}</td>
                      <td>
                        <button class="btn btn-danger btn-fab btn-icon btn-round">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                      </td>
                    <tr>
                  @endforeach
                </tbody>
            </table>
              </div>
              <div class="tab-pane" id="doku">

              </div>
              <div class="tab-pane" id="history">
                  <p> I think that&#x2019;s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus. I think that&#x2019;s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at.</p>
              </div>
          </div>
      </div>
    </div>

    </div>

  </div>
</div>

@endsection
