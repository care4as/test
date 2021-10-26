@extends('general_layout')

@section('additional_css')
<style media="screen">
.m1{
  margin: 10px;
}
*{
  font-size: 1.1em;
}
</style>

@endsection
@section('content')
<div class="container p-2">
  <div class="row">
    <div class="col-12 m1">
      <h5>Zeitraum</h5>
      <button type="button" name="button">Gestern</button>
      <button type="button" name="button">Letzte Woche</button>
    </div>
    <div class="col-12 m1">
      <h5>Mitarbeiter</h5>
      <button type="button" name="button">Gestern</button>
      <button type="button" name="button">Letzte Woche</button>
    </div>
    <div class="col-12 m1">
      <h5>Daten</h5>
      <div class="max-panel-content m-0">
          <div style="width: 100%;">
              <table class="max-table" id="xxx" style="width: 100%;">
                <thead>
                  <tr>
                    <th>MA</th>
                    <th>Saves</th>
                    <th>CR</th>
                    <th>SSC CR</th>
                    <th>BSC CR</th>
                    <th>Portal CR</th>
                    <th>Umsatz</th>
                    <th>Produktivqoute</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $users = array(1,2,3,4);
                  @endphp
                  @foreach($users as $user)
                  <tr>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
