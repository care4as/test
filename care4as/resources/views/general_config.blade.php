@extends('general_layout')

@section('additional_css')
<style media="screen">

  .table-striped>tbody>tr:hover {
    transition: none;
    font-size: 1em;
    opacity: 1;
  }
</style>
@endsection

@section('content')

<div class="container-fluid bg-light" style="width: 75vw; border-radius: 15px;">

  <div class="row" id="mainrow">
    <div class="col" id="maincol">
      <table class="table table-striped table-hover w-50">
        <tr>
          <th>Prozess</th>
          <th>Status/Optionen</th>
          <th>Beschreibung</th>
        </tr>
        <tr>
          <td>Automatische Zwischenstandsmail</td>
          <td>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(1) checked @endif>
              <label class="custom-control-label" for="customSwitch1">Aktiv</label>
            </div>
          </td>
          <td>test</td>
        </tr>
      </table>
    </div>
  </div>
</div>

@endsection
