<template>
  <div class="container-fluid f2 bg-light m-2" style="margin-top: -1.5rem;">
    <div class="row justify-content-center">
      <div class="col-5 m-2 center_items bg-white shadow">
        <div class="row m-0 center_items" v-if="department=='Mobile'">
           <div class="col-md-5 rotated  m-2 p-2" v-bind:class= "[this.sscCR > 51.7 ? 'bg-success' : 'bg-danger text-white']">
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
            <div class="col-md-5 m-2 rotated bg-light p-2" v-bind:class= "[this.bscCR > 20 ? 'bg-success' : 'bg-danger text-white']">
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
            <div class="col-md-5 m-2 rotated bg-light p-2 " v-bind:class= "[this.portalCR > 60 ? 'bg-success' : 'bg-danger text-white']">
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
            <div class="col-md-5 m-2 rotated bg-light p-2 " v-bind:class= "[this.optinQuota > 15 ? 'bg-success' : 'bg-danger text-white']">
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
                <p>Calls: {{calls}} / {{optin}}: </p>
              </div>
            </div>
            </div>
          </div>
          <div class="col-5 shadow bg-white m-2">
          <div class="row center_items">
              <div class="max-panel-content">
                <div style="width: 100%;">
                  <table class="max-table text-dark" style="width: 100%;" id="ptable" v-if="this.department == 'Mobile'">
                    <tr class="">
                      <th @click="sorted('name')" style="cursor:pointer" >User </th>
                      <th @click="sorted('ssccr')" style="cursor:pointer">SSC-CR</th>
                      <th @click="sorted('ssc_calls')" style="cursor:pointer">SSC-Calls</th>
                      <th @click="sorted('ssc_orders')" style="cursor:pointer">SSC-Saves</th>
                      <th @click="sorted('cr')" style="cursor:pointer">BSC-CR</th>
                      <th @click="sorted('calls')" style="cursor:pointer">BSC-Calls</th>
                      <th @click="sorted('orders')" style="cursor:pointer">BSC-Saves</th>
                      <th @click="sorted('online')" style="cursor:pointer">online</th>
                    </tr>
                    <tr class="" v-bind:class= "[user.ssccr > 50 ? 'bg-success' : 'bg-danger text-white']" v-for="user in sortedUsers">
                      <td>{{user.surname}} {{user.lastname}}</td>
                      <td>{{user.ssccr}}%</td>
                      <td>{{user.ssc_calls}}</td>
                      <td>{{user.ssc_orders}}</td>
                      <td>{{user.bsccr}}%</td>
                      <td>{{user.bsc_calls}}</td>
                      <td>{{user.bsc_orders}}</td>
                      <td class="bg-white center_items" v-if="checkIfOnline(user.online_till)"><div class="dot-green"></div></td>
                      <td class="bg-white center_items" v-else><div class="dot-red"></div></td>
                    </tr>
                  </table>

                  </div>
                </div>
              </div>
              </div>
            </div>
              <div class="row mt-4 center_items " style>
                <div class="col-11 bg-light center_items " style="border-radius: 5px;">
                  <div class="col-md bg-white shadow" style="margin: 15px; border-radius: 5px;">
                    <div class="row center_items">
                      <div style="margin-top: 15px; font-family: 'Radio Canada', sans-serif; font-size: 1.6rem; font-weight: bold">Liveticker (Daten noch aus KDW Tool)</div>
                    </div>
                    <div class="row center_items">
                      <div class="d-flex center_items " id="chartcontainer" style="width: 100%; height: 400px; margin:15px;">
                        <canvas id="dailyQuota" style="width: 100%; height: 100% !important"></canvas>
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
          currentSort:'ssc_cr',
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
          optin: 0,
          department: 'Mobile',
          timer: null,
          testdata: [[0,15.38,30.3,33.33,36.25,40.91,45.99,45.18,49.48],[0,0,25,36.11,35,37.35,42.31,43.9,47.59],["08:01","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00"]],
          agl0stk: 0,
          agl1stk: 0,
          agl2stk: 0,
          agl3stk: 0,
          agl4stk: 0,
          agl5stk: 0,
          aglAllStk: 0,
          top5user: [],
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
            return Math.round((this.optin*100/this.calls)*100)/100
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
        // reload() {
        //   this.state = false;
        //   this.value++;
        //   this.$nextTick(() => this.state = true);
        // },
        sorted(s) {
          //if s == current sort, reverse
          if(s === this.currentSort) {
            this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
          }
          this.currentSort = s;
        },
        getUserData(dep){

          var host = window.location.host;
          var department = this.department;
          // var team = document.getElementById('team_selection').value;

          // var parameters = [];
          // parameters.push({
          //   "project" : department,
          //   "team" : team
          // });
          // parameters = JSON.stringify(parameters);

          // console.log(parameters);
          var currentdate = new Date();
          let timestamp = "Last Sync: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/"
                + currentdate.getFullYear() + " @ "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();

          axios.get
          // ('http://'+host+'/care4as/care4as/public/users/getTrackingAlt/'+dep)
          // ('http://'+host+'/care4as/care4as/public/users/getTracking/'+parameters)
          // ('http://'+host+'/users/getTracking/'+parameters)
          ('http://'+host+'/users/getTrackingAlt/'+dep)
          .then(response => {
            // console.log(response.data)
            if(response.data)
            {
              // console.log(response.data)
              var currentdate = new Date();
              console.log('update: '+timestamp)
              if(this.department == 'Mobile')
              {
                // console.log(response.data[1])
                this.users = response.data[0]
                this.sscCalls = response.data[1]['ssc_calls']
                this.sscSaves = response.data[1]['ssc_saves']
                this.bscSaves = response.data[1]['bsc_saves']
                this.bscCalls = response.data[1]['bsc_calls']
                this.portalCalls = response.data[1]['portal_calls']
                this.portalSaves = response.data[1]['portal_saves']
                this.calls = response.data[1]['calls']
                this.saves = response.data[1]['orders']
                this.optin = response.data[1]['optins']
                // this.agl0stk = response.data[2]['al_0']
                // this.agl1stk = response.data[2]['al_1']
                // this.agl2stk = response.data[2]['al_2']
                // this.agl3stk = response.data[2]['al_3']
                // this.agl4stk = response.data[2]['al_4']
                // this.agl5stk = response.data[2]['al_5']
                // this.top5user = response.data[3]


              }
              console.log("User:")
              console.log(this.users)
              // this.createAglChart();

            }
            else
            {
              console.log('No Data avaiable')
            }
            })
          .catch(function (err) {
            console.log('Error fetching Performance Table data')
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
          // console.log(this.department)
        },
        getDailyQouta(dep){
          var host = window.location.host;
          let department = dep
          // let testarray = [[0,15.38,30.3,33.33,36.25,40.91,45.99,45.18,49.48],[0,0,25,36.11,35,37.35,42.31,43.9,47.59],["08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00"]]
          // this.createChart('dailyQuota', testarray)
          // axios.get('http://'+host+'/care4as/care4as/public/kdw/getQuotas/'+department) // Richtige Daten
          axios.get('http://'+host+'/kdw/getQuotas/'+department)
          .then(response =>
          {
            // console.log('dailyQoutas')
            // console.log(response.data)
            this.createChart('dailyQuota', response.data)
          })
          .catch(
            function (err) {
              console.log('Error fetching Daily Quota:')
              console.log(err.response);
            })
          },
        createChart(chartId, chartData) {
        let chart = document.getElementById(chartId);
        if (typeof chart != 'undefined' || chart != null )
        {
          document.getElementById(chartId).remove()
          $('#chartcontainer').append('<canvas id="'+chartId+'" width="" height="" style="max-width: 100%;"></canvas>')
          // console.log('test')
        }
        const ctx = document.getElementById(chartId);
        let myChart = new Chart(ctx, {
          type: 'line',
          data: {
            datasets: [{
              label: 'CR',
              type: 'line',
              fill: true,
              data: chartData[0],
              backgroundColor: 'rgba(41, 241, 195, 0.5)',
              borderColor: 'rgba(41, 241, 195, 1)',
              borderWidth: 2,
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
          labels: chartData[2],
          },
          options: {
            maintainAspectRatio: false,
            devicePixelRatio: 2,
            animation: {
              duration: 0,
            },
            scales: {
              yAxes: [{
                id: 'A',
                type:'linear',
                position: 'left',
                color: 'rgb(255,255,255)',
                ticks: {
                  beginAtZero: true,
                  min: 0,
                  max: 100,
                },
                scaleLabel: {
                  display: true,
                  labelString: 'CR',
                }
              }],
              xAxes:[{
                id:'B',
                beginAtZero: true,
              }]
            }
          }
        });
      },
      checkIfOnline(online_till)
      {
        let onlinetill = online_till

        if(onlinetill)
        {
          var t2 = onlinetill.split(/[- :]/);
          let onlinetill2 = new Date(t2[0],t2[1]-1,t2[2],t2[3]||0,t2[4]||0,t2[5]||0);
          if(  Date.now() <  Date.parse(onlinetill2))
          {
            // console.log('alles gut');
            return true;
          }
          else {
            // console.log(online_since);
              return false
          }
        }
        else {
             // console.log('online_till fehler')
            return false;
          }
        },
      }
    }
</script>

<style media="screen">
.dot-green, .dot-red {
    height: 30px;
    width: 30px;
    /* background-color: green; */
    border-radius: 5px;
    /* display: inline-block; */
}
.dot-green{
  background-color: green;
}
.dot-red{
  background-color: red;
}

.app{
  width: 100%;
}


tr:hover {
    background-color: #4ca1af;
    border-radius: 0;
    border-collapse: collapse;
}


</style>
