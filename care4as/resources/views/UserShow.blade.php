@extends('general_layout')

@section('content')
<style>
.centered
{
  max-height:250px;
  overflow: scroll;
}
</style>

<div class="container-fluid" style="width: 75vw;">
  <div class="row bg-light align-items-center"  style="border-radius: 15px;">
    <div class="col overflow-scroll centered">
        <h3 class="text-center">{{$user->name}}</h3>
      <div class="row">
        <div class="col">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQMAAADCCAMAAAB6zFdcAAAAQlBMVEX///+hoaGenp6amprHx8f39/fOzs7j4+P7+/uYmJjT09OlpaXv7+/29va6urq1tbWvr6/AwMDn5+fd3d2xsbGqqqp20Q+8AAACjklEQVR4nO3b6XLCIBSG4QQ0qzHG5f5vtY1byEaiZMY5Z97nX1ukwydSOKFRBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADq7av9hqrs1+P5wjG3mzKHX4/oY5mNt2V2vx7SxzJDBv8ZmA0/wokRmsGG3ZEBGbTIQH4GVVJfm3NYd8IzKKz5Z+ugvxKyMyiemyVzCulOdAb7917JFgHdic6g6PaLt4DuRGfQdBmE7BvJQHgGSZdBGdCd6AwO7zP0wiAy7ywRnYHzYfAOssnzxvNj2RlER9umYGJvHeho/DsI4RlEl1Nsyp13Fjw2Up5hSs+g/crf+LVo2HSuhYIMFpTvdbOaaaE+g27ZNNeZJtozuDgl6LmRKs+g6lWg7XShQXkGt34VfnpHrTuD3eBBhKmnWqnOIB09j5qsM2jOYD/xOMpO7Cg1ZXAejO80+Uhu/Do9GVSltVd3zUsmIzDH0SvVZJCV7cnIKamdZx5Oj5cENRkc7++6aZw2M0aXDbRk8Kqy28vzG/V8BsP6q5IMDt2p4HEySjzXNMygoKIkg7LL4F4sOXhvqrwny4OODJwC8+NkVM4H4EyWJxUZXHrvuk2fC6Qng96SoCGDajji6Z1BLwR30BoyuA2HvOLKVu5U1hRkMDwcruMco+VnkObfROAW28Vn8PVdRZO8uhCfwfXr+5rvypr0DJb/BHhkrz5EZzB3OFzlVVmTnUG2sB9c8DxGy85g/nC4cibcj9GiMyiC7/Dfr25IzsB/OFw3EdrKmuAMsvh+QTNMXojO4JBuQnQGm5GaQZxsp5aaQfhS0JH4/0zRBothT9B15x8577aVLP9KAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABDuD7d6G0PBTSbxAAAAAElFTkSuQmCC" alt="">
        </div>
        <div class="col align-items-top" >
          <div class="table-responsive w-100">
            <table class="table-hover table-bordered w-100">
              <tr>
                <td>Username:</td>
                <td>{{$user->name}}</td>
              </tr>
              <tr>
                <td>Tesdaten:</td>
                <td>Beispielwert</td>
              </tr>
              <tr>
                <td>Tesdaten:</td>
                <td>Beispielwert</td>
              </tr>
              <tr>
                <td>Tesdaten:</td>
                <td>Beispielwert</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col overflow-scroll centered">
      <h3>Änderbare Daten</h3>
      <div class="row">
        <form action="{{route('change.user.post')}}" method="post">
          @csrf

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputPassword4">CCU_ID</label>
              <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="test">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="role">Rolle</label>
              <select class="form-control" name="role" id="role">
                <option value="overhead" @if($user->role == 'overhead') @endif selected>Overhead</option>
                <option value="agent" @if($user->role == 'agent') @endif selected>Agent</option>
              </select>
              <!-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="Start#15"> -->
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Test-Daten</label>
              <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="testwert">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Test-Daten</label>
              <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="testwert">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Test-Daten</label>
              <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="testwert">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Userdaten ändern</button>
        </form>
      </div>
      <div>
  </div>
</div>
<div class="container-fluid bg-white mt-4" style="width: 75vw;">
  <div class="row">
    <div class="col-12">
      <h3>Statistiken Tracking</h3>
    </div>
    <div class="col">

    </div>
  </div>
</div>
@endsection
