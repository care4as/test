@extends('general_layout')

@section('additional_css')
<style media="screen">
.max-table
{
  text-align: center;
}
</style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row bg-light m-2" id="content">
      <div class="col-12 text-center">
        <h4>Projekt-Report Mobile Retention {{Carbon\Carbon::today()->subDays(1)->format('d.m.Y')}}</h4>
      </div>
      <hr>
      <div class="col-md-6">

        <div class="row m-2">
          <h5>Performance</h5>
          <hr>
        </div>
        <div class="row m-2">
          <div class="col bg-white shadow rounded">
            <div class="max-main-container">
                <div class="max-panel-content">
                    <div style="width: 100%;">
                        <table class="max-table" id="xxx" style="width: 100%;">
                            <tr>
                              <th>Saves</th>
                              <th>199</th>
                            </tr>
                            <tr>
                              <td>-SSC</td>
                              <td>129</td>
                            </tr>
                            <tr>
                              <td>-BSC</td>
                              <td>29</td>
                            </tr>
                            <tr>
                              <td>-Portale</td>
                              <td>29</td>
                            </tr>
                            <tr>
                              <th>Calls</th>
                              <th>199</th>
                            </tr>
                            <tr>
                              <td>-SSC</td>
                              <td>129</td>
                            </tr>
                            <tr>
                              <td>-BSC</td>
                              <td>29</td>
                            </tr>
                            <tr>
                              <td>-Portale</td>
                              <td>29</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row m-2">
          <h5>Quoten</h5>
          <hr>
        </div>
        <div class="row m-2">
          <div class="col bg-white shadow rounded">
            <div class="max-main-container">
                <div class="max-panel-content">
                    <div style="width: 100%;">
                        <table class="max-table" id="xxx" style="width: 100%;">
                            <tr>
                              <th>CR</th>
                              <th>50%</th>
                            </tr>
                            <tr>
                              <th>SSC</th>
                              <th>53%</th>
                            </tr>
                            <tr>
                              <th>BSC</th>
                              <th>21%</th>
                            </tr>
                            <tr>
                              <th>Portale</th>
                              <th>83%</th>
                            </tr>
                            <tr>
                              <th>Optins</th>
                              <th>11%</th>
                            </tr>
                            <tr>
                              <td>RLZ+</td>
                              <td>89%</td>
                            </tr>
                            <tr>
                              <th>KQ</th>
                              <th>23%</th>
                            </tr>
                            <tr>
                              <th>Produktivität</th>
                              <th>87%</th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
