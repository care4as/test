@extends('general_layout')

@section('additional_css')

@endsection


@section('content')
<div class="container bg-light">
  @foreach($users as $user)
    @if($user->offlineTracking->first())
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <td><button class="btn btn-link" onclick="hideTable('{{$user->name}}')">Agent {{$user->wholeName()}}</button></td>
            <td>Gevo</td>
            <td>KüRü</td>
            <td>Negativ/Cancel</td>
            <td>Nicht erreicht</td>
            <td>Nicht erreicht --> Retention Offline</td>
          </tr>
        </thead>
          <tbody id="{{$user->name}}" style="display:none;">
            <tr>
              <td>8 - 9</td>
              <td>{{$user->offlineTracking->where('timespan','8 - 9')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','8 - 9')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','8 - 9')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','8 - 9')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','8 - 9')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>9 - 10</td>
              <td>{{$user->offlineTracking->where('timespan','9 - 10')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','9 - 10')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','9 - 10')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','9 - 10')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','9 - 10')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>10 - 11</td>
              <td>{{$user->offlineTracking->where('timespan','10 - 11')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','10 - 11')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','10 - 11')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','10 - 11')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','10 - 11')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>11 - 12</td>
              <td>{{$user->offlineTracking->where('timespan','11 - 12')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','11 - 12')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','11 - 12')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','11 - 12')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','11 - 12')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>12 - 13</td>
              <td>{{$user->offlineTracking->where('timespan','12 - 13')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','12 - 13')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','12 - 13')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','12 - 13')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','12 - 13')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>13 - 14</td>
              <td>{{$user->offlineTracking->where('timespan','13 - 14')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','13 - 14')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','13 - 14')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','13 - 14')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','13 - 14')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>14 - 15</td>
              <td>{{$user->offlineTracking->where('timespan','14 - 15')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','14 - 15')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','14 - 15')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','14 - 15')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','14 - 15')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>15 - 16</td>
              <td>{{$user->offlineTracking->where('timespan','15 - 16')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','15 - 16')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','15 - 16')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','15 - 16')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','15 - 16')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>16 - 17</td>
              <td>{{$user->offlineTracking->where('timespan','16 - 17')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','16 - 17')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','16 - 17')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','16 - 17')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','16 - 17')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>17 - 18</td>
              <td>{{$user->offlineTracking->where('timespan','17 - 18')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','17 - 18')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','17 - 18')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','17 - 18')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','17 - 18')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>18 - 19</td>
              <td>{{$user->offlineTracking->where('timespan','18 - 19')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','18 - 19')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','18 - 19')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','18 - 19')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','18 - 19')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
            <tr>
              <td>19 - 20</td>
              <td>{{$user->offlineTracking->where('timespan','19 - 20')->where('category','GeVo')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','19 - 20')->where('category','KüRü')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','19 - 20')->where('category','Negativ/Cancel')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','19 - 20')->where('category','Nicht erreicht')->count()}}</td>
              <td>{{$user->offlineTracking->where('timespan','19 - 20')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
            </tr>
          </tbody>
      </table>
      @endif
  @endforeach
</div>

<div class="container bg-light">
  <div class="row m-2">
    <h2 class="text-center">Heutiges Offlinetracking</h2>
  </div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Zeitspanne</th>
        <th>Gevo</th>
        <th>KüRü</th>
        <th>Negativ/Cancel</th>
        <th>Nicht erreicht</th>
        <th>Nicht erreicht --> Retention Offline</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>8-9</td>
        <td>{{$trackings->where('timespan','8 - 9')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','8 - 9')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','8 - 9')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','8 - 9')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','8 - 9')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>9-10</td>
        <td>{{$trackings->where('timespan','9 - 10')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','9 - 10')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','9 - 10')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','9 - 10')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','9 - 10')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      <tr>
        <td>10-11</td>
        <td>{{$trackings->where('timespan','10 - 11')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','10 - 11')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','10 - 11')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','10 - 11')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','10 - 11')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>11-12</td>
        <td>{{$trackings->where('timespan','11 - 12')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','11 - 12')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','11 - 12')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','11 - 12')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','11 - 12')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>12-13</td>
        <td>{{$trackings->where('timespan','12 - 13')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','12 - 13')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','12 - 13')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','12 - 13')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','12 - 13')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>13-14</td>
        <td>{{$trackings->where('timespan','13 - 14')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','13 - 14')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','13 - 14')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','13 - 14')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','13 - 14')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>14-15 </td>
        <td>{{$trackings->where('timespan','14 - 15')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','14 - 15')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','14 - 15')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','14 - 15')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','14 - 15')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>15-16</td>
        <td>{{$trackings->where('timespan','15 - 16')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','15 - 16')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','15 - 16')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','15 - 16')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','15 - 16')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>16-17</td>
        <td>{{$trackings->where('timespan','16 - 17')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','16 - 17')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','16 - 17')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','16 - 17')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','16 - 17')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>17-18</td>
        <td>{{$trackings->where('timespan','17 - 18')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','17 - 18')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','17 - 18')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','17 - 18')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','17 - 18')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>18-19</td>
        <td>{{$trackings->where('timespan','18 - 19')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','18 - 19')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','18 - 19')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','18 - 19')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','18 - 19')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>
      <tr>
        <td>19-20</td>
        <td>{{$trackings->where('timespan','19 - 20')->where('category','KüRü')->count()}}</td>
        <td>{{$trackings->where('timespan','19 - 20')->where('category','GeVo')->count()}}</td>
        <td>{{$trackings->where('timespan','19 - 20')->where('category','Negativ/Cancel')->count()}}</td>
        <td>{{$trackings->where('timespan','19 - 20')->where('category','Nicht erreicht')->count()}}</td>
        <td>{{$trackings->where('timespan','19 - 20')->where('category','Nicht erreicht --> Retention Offline')->count()}}</td>
      </tr>

    </tbody>
  </table>
</div>
@endsection


@section('additional_js')
<script type="text/javascript">
function hideTable(tableid) {
  $('#' + tableid).toggle()
}
</script>
@endsection
