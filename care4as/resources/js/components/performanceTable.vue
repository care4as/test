<template>
    <div class="container-fluid ">
      <div class="p-0 readabilitysuperior">
      <div class="row ">
        <div class="col">
          <h4 class="text-center text-white "><u>Aktuelle Trackingdaten {{department}}</u></h4>
        </div>
      </div>
      <div class="row justify-content-center m-1" >
        <div class="col-4 mr-3 d-flex justify-content-center department align-items-center unit-translucent" @click="changeDepartment('Mobile')" style="background-color: rgba(0,0,0,0.2);">
          <p class="m-0" v-bind:style="[department == 'Mobile' ? {'color': 'white'} : {'color':'black'}]">Mobile</p>
        </div>
        <div class="col-4 ml-3 d-flex justify-content-center department align-items-center unit-translucent" @click="changeDepartment('DSL')" style="background-color: rgba(0,0,0,0.2);">
          <p class="m-0" v-bind:style="[department == 'DSL' ? {'color': 'white'} : {'color':'black'}]">DSL</p>
        </div>
      </div>
      <div class="row">
        <div class="col-6 p-1">
          <div class="row center_items">
            <h5 class="text-center text-white">Liveticker Agents</h5>
          </div>

          <div class="table-responsive ">
            <table class="table table-borderless text-white tablespacing" id="ptable" v-if="this.department == 'Mobile'">
              <tr class="unit-translucent">
                <th @click="sorted('name')" style="cursor:pointer" >User </th>
                <th @click="sorted('ssc_quota')" style="cursor:pointer">SSC-CR</th>
                <th @click="sorted('ssc_calls')" style="cursor:pointer">SSC-Calls</th>
                <th @click="sorted('ssc_orders')" style="cursor:pointer">SSC-Saves</th>
                <th @click="sorted('cr')" style="cursor:pointer">CR</th>
                <th @click="sorted('calls')" style="cursor:pointer">Calls</th>
                <th @click="sorted('orders')" style="cursor:pointer">Orders</th>
              </tr>
              <tr class="unit-translucent" v-for="user in sortedUsers">
                <td >{{user.surname}} {{user.lastname}}</td>
                <td>{{user.ssc_quota}}%</td>
                <td >{{user.ssc_calls}}</td>
                <td>{{user.ssc_orders}}</td>
                <td>{{user.cr}}%</td>
                <td>{{user.calls}}</td>
                <td>{{user.orders}}</td>
              </tr>

            </table>
            <table class="table table-borderless text-white tablespacing" v-else>
              <tr class="unit-translucent">
                <th @click="sorted('name')" style="cursor:pointer" >User </th>
                <th @click="sorted('dslqouta')" style="cursor:pointer">CR</th>
                <th @click="sorted('calls')" style="cursor:pointer">SSC_Calls</th>
                <th @click="sorted('orders')" style="cursor:pointer">SSC_Saves</th>

              </tr >
              <tr class="unit-translucent" v-for="user in sortedUsers">
                <td>{{user.surname}} {{user.lastname}}</td>
                <td>{{user.dslqouta}}%</td>
                <td>{{user.calls}}</td>
                <td>{{user.orders}}</td>
              </tr>

            </table>
          </div>
        </div>
        <div class="col-6 p-1">
          <div class="row center_items">
            <h5 class="text-center text-white">Liveticker Team</h5>
          </div>
          <div class="row">
            <table class="table table-borderless tablespacing " v-if="this.department == 'Mobile'">
              <tr class="unit-translucent">
                <th>GeVo-CR</th>
                <th>Calls</th>
                <th>Saves</th>
              </tr>
              <tr class="unit-translucent">
                <td>{{GeVoCr}}%</td>
                <td>{{calls}}</td>
                <td>{{saves}}</td>
              </tr>
              <tr class="unit-translucent">
                <th>SSC-GeVo-CR</th>
                <th>SSC-Calls</th>
                <th>SSC-Saves</th>
              </tr>
              <tr class="unit-translucent">
                <td>{{sscCR}}%</td>
                <td>{{sscCalls}}</td>
                <td>{{sscSaves}}</td>
              </tr>
              <tr class="unit-translucent">
                <th>BSC-CR</th>
                <th>BSC-Calls</th>
                <th>BSC-Saves</th>
              </tr>
              <tr class="unit-translucent">
                <td>{{bscCR}}%</td>
                <td>{{bscCalls}}</td>
                <td>{{bscSaves}}</td>
              </tr>
              <tr class="unit-translucent">
                <th>Portal-CR</th>
                <th>Portal-Calls</th>
                <th>Portal-Saves</th>
              </tr>
              <tr class="unit-translucent">
                <td>{{portalCR}}%</td>
                <td>{{portalCalls}}</td>
                <td>{{portalSaves}}</td>
              </tr>
            </table>

          <table class="table table-borderless tablespacing" v-else>
            <tr class="unit-translucent">
              <th>GeVo-CR</th>
              <th>Calls</th>
              <th>Saves</th>
            </tr>
            <tr class="unit-translucent">
              <td>{{GeVoCr}}%</td>
              <td>{{calls}}</td>
              <td>{{saves}}</td>
            </tr>
          </table>
          </div>
          <div class="row unit-translucent text-white center_items mb-0">
            <h5>Liveticker Tagesquote</h5>
            <div>
              <canvas id="dailyQuota" style="height: 300px; width: 90%;"></canvas>
            </div>
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

          axios.get('http://'+host+'/care4as/care4as/public/users/getTracking/'+department)
          // axios.get('http://'+host+'/users/getTracking/'+department)
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
            console.log('error Userdata')
            console.log(err.response);
          })
        },
        changeDepartment(dep)
        {
          this.department = dep

          this.getUserData(dep)

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
          let department = 'Mobile'

          axios.get
          ('http://'+host+'/care4as/care4as/public/kdw/getQuotas/'+department)
          // ('http://'+host+'/kdw/getQuotas/'+department)
          .then(response =>
          {
            // console.log('dailyQoutas')
            console.log(response.data)
            this.createChart('dailyQuota', response.data)
          })
          .catch(
            function (err) {
              console.log('error DQ')
              console.log(err.response);
            })
          },
        createChart(chartId, chartData) {
        // console.log('test')
        const ctx = document.getElementById(chartId);
        const myChart = new Chart(ctx, {
          type: 'bar',

          data: {
              datasets: [{
               type: 'line',
               label: 'CR',
               data: chartData[0],
               fill: false,
               backgroundColor: 'rgba(41, 241, 195, 1)',
               borderColor: 'rgba(41, 241, 195, 1)',
               borderWidth: 2
           },
           {
              label: 'SSC-CR',
              type: 'line',
              fill: false,
              data: chartData[1],
              backgroundColor: 'rgba(255, 99, 132)',
              borderColor: 'rgba(255, 99, 132, 1)',
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
             }
            ]}
           }
        });
      }
      }
    }
</script>

<style media="screen">

td,tr,table
{
  border-radius: 15px;
}
.table-striped>tbody>tr:nth-child(even) {
    background-color: #ddf8e8;
}
.department{
  cursor: pointer;
}
.department:hover{
  opacity: 0.5;
}

#dailyQuota
{
  height: 300px !important;
  color:white !important;
}
</style>
