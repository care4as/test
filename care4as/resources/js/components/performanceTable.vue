<template>
  <div class="container-fluid p-2 f2" style="height: 100vh;">
    <div class="row center_items mt-2">
      <div class="col-10 p-0">
        <div class="row m-0" v-if="department=='Mobile'">
          <div class="col-md rotated  p-2" v-bind:class= "[this.sscCR > 50 ? 'bg-success' : 'bg-danger text-white']">
            <div class="row m-1 text-center">
              SSC-CR:
            </div>
            <div class="row m-1">
              <div class="col-6">
                <p>{{sscCR}}% <i class="fa-solid fa-arrow-trend-down"></i></p>
              </div>
              <div class="col-6 p-0">
                <p><i class="fa-solid fa-arrow-trend-up"></i></p>
              </div>
            </div>
            <div class="row m-1">
              <p>Calls: {{sscCalls}} / Saves: {{sscSaves}}</p>
            </div>
          </div>
          <div class="col-md rotated bg-light p-2" v-bind:class= "[this.bscCR > 20 ? 'bg-success' : 'bg-danger text-white']">
            <div class="row m-1">
              BSC-CR:
            </div>
            <div class="row m-1">
              <div class="col-6 p-0">
                <p>{{bscCR}}% <i class="fa-solid fa-arrow-trend-down"></i></p>
              </div>
              <div class="col-6 p-0">
                <p><i class="fa-solid fa-arrow-trend-up"></i></p>
              </div>
            </div>
            <div class="row m-1">
              <p>Calls: {{bscCalls}} / Saves: {{bscSaves}}</p>
            </div>
          </div>
          <div class="col-md rotated bg-light p-2 " v-bind:class= "[this.portalCR > 60 ? 'bg-success' : 'bg-danger text-white']">
            <div class="row m-1">
              Portal-CR:
            </div>
            <div class="row m-1">
              <div class="col-6 p-0">
                <p>{{portalCR}}% <i class="fa-solid fa-arrow-trend-down"></i></p>
              </div>
              <div class="col-6 p-0">
                <p><i class="fa-solid fa-arrow-trend-up"></i></p>
              </div>
            </div>
            <div class="row m-1">
              <p>Calls: {{portalCalls}} / Saves: {{portalSaves}}</p>
            </div>
          </div>
          <div class="col-md rotated bg-light p-2 " v-bind:class= "[this.optinQuota > 15 ? 'bg-success' : 'bg-danger text-white']">
            <div class="row m-1">
              Optinquote:
            </div>
            <div class="row m-1">
              <div class="col-6 p-0">
                <p>{{optinQuota}}% <i class="fa-solid fa-arrow-trend-down"></i></p>
              </div>
              <div class="col-6 p-0">
                <p><i class="fa-solid fa-arrow-trend-up"></i></p>
              </div>
            </div>
            <div class="row m-1">
              <p>Calls: {{calls}} / {{optins}}: </p>
            </div>
          </div>
        </div>
        <div class="row m-0" v-else>
          <div class="col-md-5 rotated bg-light p-2 " v-bind:class= "[this.optinQuota > 15 ? 'bg-success' : 'bg-danger text-white']">
            <div class="row m-1">
              CR:
            </div>
            <div class="row m-1">
              <div class="col-6 p-0">
                <p>{{GeVoCr}}% <i class="fa-solid fa-arrow-trend-down"></i></p>
              </div>
              <div class="col-6 p-0">
                <p><i class="fa-solid fa-arrow-trend-up"></i></p>
              </div>
            </div>
            <div class="row m-1">
              <p>Calls: {{calls}} / {{saves}}: </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4 center_items " style="">
      <div class="col-10 p-0 bg-light center_items " style="min-height: 50vh;border-radius: 25px;">
        <div class="row m-0" style="min-height: 45vh;">
          <div class="col-md bg-white shadow " style="transform: rotateY(-15deg);">
            <div class="row center_items">
              <h5>Liveticker Teamquote</h5>
            </div>
            <div class="row">
              <div class="col-12 center_items" id="chartcontainer" style="width: 90%;">
                <canvas id="dailyQuota" style="height: 90%; width: 90%;"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md bg-white shadow " style="transform: rotateY(15deg);">
            <div class="row center_items">
              <h5>Performance</h5>
            </div>
            <div class="row center_items">
            <div class="max-panel-content">
              <div style="width: 100%;">
                <table class="max-table text-dark" style="width: 100%;" id="ptable" v-if="this.department == 'Mobile'">
                  <tr class="">
                    <th @click="sorted('name')" style="cursor:pointer" >User </th>
                    <th @click="sorted('ssc_quota')" style="cursor:pointer">SSC-CR</th>
                    <th @click="sorted('ssc_calls')" style="cursor:pointer">SSC-Calls</th>
                    <th @click="sorted('ssc_orders')" style="cursor:pointer">SSC-Saves</th>
                    <th @click="sorted('cr')" style="cursor:pointer">CR</th>
                    <th @click="sorted('calls')" style="cursor:pointer">Calls</th>
                    <th @click="sorted('orders')" style="cursor:pointer">Orders</th>
                  </tr>
                  <tr class="" v-bind:class= "[user.ssc_quota > 50 ? 'bg-success' : 'bg-danger text-white']" v-for="user in sortedUsers">
                    <td>{{user.name}}</td>
                    <td>{{user.ssc_quota}}%</td>
                    <td>{{user.ssc_calls}}</td>
                    <td>{{user.ssc_orders}}</td>
                    <td>{{user.cr}}%</td>
                    <td>{{user.calls}}</td>
                    <td>{{user.orders}}</td>
                  </tr>
                </table>
                <table class="max-table" style="width: 100%;"v-else>
                  <tr class="">
                    <th @click="sorted('name')" style="cursor:pointer" >User </th>
                    <th @click="sorted('dslqouta')" style="cursor:pointer">CR</th>
                    <th @click="sorted('calls')" style="cursor:pointer">SSC_Calls</th>
                    <th @click="sorted('orders')" style="cursor:pointer">SSC_Saves</th>
                  </tr >
                  <tr class="unit-translucent" v-for="user in sortedUsers">
                    <td>{{user.name}}</td>
                    <td>{{user.dslqouta}}%</td>
                    <td>{{user.calls}}</td>
                    <td>{{user.orders}}</td>
                  </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="row mt-4 center_items">
    <div class="btn-group dropend">
      <button type="button" class="btn btn-secondary dropdown-toggle rounded-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bars fa-3x"></i>
      </button>
      <div class="dropdown-menu">
        <div class="d-flex center_items m-2">
          <button type="button" name="button" class="p-2 m-2 iconbutton" @click="changeDepartment('Mobile')"><i class="fas fa-mobile-alt fa-7x"></i></button>
          <button type="button" name="button" class="p-2 m-2 iconbutton" @click="changeDepartment('DSL')"><i class="fas fa-yin-yang fa-7x"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
    export default {
      data(){
        return{
          users: [1,2,3],
          timer: '',
          currentSort:'ssc_quota',
          currentSortDir:'desc',
          SscGeVoCr: 0,
          sscCalls: 0,
          bscCalls: 0,
          bscSaves: 0,
          portalCalls: 0,
          portalSaves: 0,
          sscSaves: 0,
          calls:0,
          saves:0,
          optins: 0,
          department: 'Mobile',
          timer: null,
        }
      },
      mounted() {
        var self = this;
        console.log('ptable Component mounted.')

        self.getUserData('Mobile')
        self.getDailyQouta('Mobile')

        this.timer =
        setInterval(function()
        {
          self.getUserData('Mobile')
          self.getDailyQouta('Mobile')
        }, 60000);

      },
      computed:{
        sortedUsers:function() {
          return this.users.sort((a,b) => {
            let modifier = 1;
            if(this.currentSortDir === 'desc') modifier = -1;
            if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
            if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
            return 0;
          });
        },
        GeVoCr: function(){
          if (this.calls != 0) {
            return Math.round((this.saves*100/this.calls)*100)/100
          }
          else {
            // return this.saves
            return 0
          }
        },
        optinQuota: function(){
          if (this.calls != 0) {
            return Math.round((this.optins*100/this.calls)*100)/100
          }
          else {
            // return this.saves
            return 0
          }
        },
        bscCR: function(){
          if (this.bscCalls != 0) {
            return Math.round((this.bscSaves*100/this.bscCalls)*100)/100
          }
          else {
            return 0
          }
        },
        portalCR: function(){
          if (this.portalCalls != 0) {
            return Math.round((this.portalSaves*100/this.portalCalls)*100)/100
          }
          else {
            return 0
          }

        },
        sscCR: function(){
          if (this.sscCalls != 0) {

            return Math.round((this.sscSaves*100/this.sscCalls)*100)/100
          }
          else {
            return 0
          }
        },
      },
      methods:{
        sorted(s) {
          //if s == current sort, reverse
          if(s === this.currentSort) {
            this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
          }
          this.currentSort = s;
        },
        getUserData(dep){

          var host = window.location.host;
          var department = this.department
          var currentdate = new Date();
          let timestamp = "Last Sync: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/"
                + currentdate.getFullYear() + " @ "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();

          axios.get
          // ('http://'+host+'/care4as/care4as/public/users/getTracking/'+department)
          ('http://'+host+'/users/getTracking/'+department)
          .then(response => {
            if(response.data)
            {
              // console.log(response.data)
              var currentdate = new Date();
              console.log('update: '+timestamp)

              if(this.department == 'Mobile')
              {
                this.users = response.data[0]
                this.sscCalls = response.data[1]['ssc_calls']
                this.sscSaves = response.data[1]['ssc_saves']
                this.bscSaves = response.data[1]['bsc_saves']
                this.bscCalls = response.data[1]['bsc_calls']
                this.portalCalls = response.data[1]['portal_calls']
                this.portalSaves = response.data[1]['portal_saves']
                this.calls = response.data[1]['calls']
                this.saves = response.data[1]['orders']
                this.optins = response.data[1]['optins']
              }
              else {
                this.users = response.data[0]
                this.calls = response.data[1]['calls']
                this.saves = response.data[1]['orders']
              }
            }
            else
            {
              console.log('No Data avaiable')
            }
            })
          .catch(function (err) {
            console.log('error Userdata Ptable')
            console.log(err.response);
          })
        },
        changeDepartment(dep)
        {
          this.department = dep
          this.getUserData(dep)
          this.getDailyQouta(dep)
          clearInterval(this.timer)
          this.timer =
          setInterval(function()
          {
            this.getUserData(dep)
            this.getDailyQouta(dep)
          }.bind(this), 60000);

        },
        getDailyQouta(dep){
          var host = window.location.host;
          let department = dep

          // axios.get('http://'+host+'/care4as/care4as/public/kdw/getQuotas/'+department)
          axios.get('http://'+host+'/kdw/getQuotas/'+department)
          .then(response =>
          {
            // console.log('dailyQoutas')
            // console.log(response.data)
            this.createChart('dailyQuota', response.data)
          })
          .catch(
            function (err) {
              console.log('error DQ')
              console.log(err.response);
            })
          },
        createChart(chartId, chartData) {
        let chart = document.getElementById(chartId);
        if (typeof chart != 'undefined' || chart != null )
        {
          document.getElementById(chartId).remove()
          $('#chartcontainer').append('<canvas id="'+chartId+'" width="" height=""style="height: 60vh; max-width: 90%;"></canvas>')
          // console.log('test')
        }
        const ctx = document.getElementById(chartId);
        const myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              datasets: [{
               label: 'CR',
               type: 'line',
               fill: true,
               data: chartData[0],
               backgroundColor: 'rgba(41, 241, 195, 0.5)',
               borderColor: 'rgba(41, 241, 195, 1)',
               borderWidth: 2
           },
           {
              label: 'SSC-CR',
              type: 'line',
              fill: true,
              data: chartData[1],
              backgroundColor: 'rgba(255, 99, 132,0.2)',
              borderColor: 'rgba(255, 99, 132, 0.5)',
              borderWidth: 2
            }],
        labels:chartData[2],
         },
         options: {
             scales: {
               yAxes: [{
                 id: 'A',
                 type:'linear',
                 position: 'left',
                 color: 'rgb(255,255,255)',
                 ticks: {
                   beginAtZero: true,
                   min: 30,
                   max: 75,
               }
             }],
             xAxes:[{
               id:'B',
               beginAtZero: true,
             }]
           }
           }
        });
      }
      }
    }
</script>

<style media="screen">


</style>
