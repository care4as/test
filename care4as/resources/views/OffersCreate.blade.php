@extends('general_layout')

@section('content')

<div class="container bg-light">
  <h4>Angebote erstellen</h4>
  <form class="row g-3" action="{{route('offers.store')}}" method="post">
    @csrf
  <div class="col-md-4">
    <label for="inputEmail4" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="inputEmail4">
  </div>
  <div class="col-md-4">
    <label for="price" class="form-label">Preis</label>
    <div class="input-group">

      <input type="text" name="price" class="form-control" id="price">
      <span class="input-group-text">€</span>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
    <label for="exampleFormControlSelect1">Datenvolumen</label>
      <select class="form-control" name="volume" id="exampleFormControlSelect1">
        <option value="5">5GB</option>
        <option value="10">10GB</option>
        <option value="20">20GB</option>
        <option value="40">40GB</option>
        <option value="100">100GB</option>
      </select>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
    <label for="exampleFormControlSelect1">Telefonie</label>
      <select class="form-control" name="telefon" id="exampleFormControlSelect1">
        <option value="Flat">Flat</option>
        <option value="300 Freiminuten">300 FM</option>
        <option value="100 Freiminuten">100FM</option>
      </select>
    </div>
  </div>
  <div class="col-12">
    <div class="form-group">
      <label for="exampleFormControlSelect2">Kategorie</label>
      <select multiple name="Categories[]" class="form-control" id="exampleFormControlSelect2">
        <option value="NK">Neukunde</option>
        <option value="BK">Bestandskunde</option>
        <option value="Special">Spezialkunde</option>
        <option value="Cyber">Cyberangebote</option>
        <option value="Beginner">Einsteigerangebote</option>
      </select>
    </div>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Speichern</button>
  </div>
</div>
@endsection
